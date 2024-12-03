<?php

namespace App\Http\Controllers\Client;

use App\Models\Bill;
use App\Models\Cart;
use App\Models\Coupon;
use App\Mail\OrderConfirm;
use Illuminate\Http\Request;
use App\Models\VariantProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        DB::beginTransaction();
        try {
            $total = $request->input('totalPrice');
            $cart = Cart::where('user_id', Auth::id())->with('items')->first();

            $moneyShip = $request->moneyShip;
            if ($moneyShip !== 0) {
                if ($cart->coupon_code !== null) {
                    $couponTable = Coupon::where('code', $cart->coupon_code)->first();
                    if ($couponTable->usage_limit !== null) {
                        $couponTable->decrement('usage_limit');
                        $couponTable->save();
                    }
                    $cart->coupon_code = null;
                    $cart->save();
                }
            }
            // Tạo đơn hàng
            $bill = Bill::create([
                'billCode' => uniqid('ORDER_'),
                'user_id' => Auth::id(),
                'totalPrice' => $total,
                'status_payment_method' => Bill::CHUA_THANH_TOAN,
                'addressUser' => Auth::user()->address,
                'phoneUser' => Auth::user()->phone,
                'nameUser' => Auth::user()->name,
                'emailUser' => Auth::user()->email,
                'moneyProduct' => $cart->items->sum(function ($item) {
                    return $item->price * $item->quantity;
                }),
                'status_bill' => Bill::CHO_XAC_NHAN,
                'moneyShip' => $moneyShip,
            ]);

            // Lưu chi tiết đơn hàng
            foreach ($cart->items as $item) {
                // Kiểm tra tồn kho
                $variant = VariantProduct::find($item->variant_id);
                if ($variant->quantity < $item->quantity) {
                    throw new \Exception('Sản phẩm ' . $variant->product->name . ' không đủ số lượng');
                }

                $bill->order_detail()->create([
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'quantity' => $item->quantity,
                    'unitPrice' => $item->price,
                    'totalMoney' => $item->price * $item->quantity
                ]);

                // Cập nhật tồn kho
                $variant->quantity -= $item->quantity;
                $variant->save();
            }

            DB::commit();

            // Cấu hình thanh toán VNPay
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = route('payments.return');
            $vnp_TmnCode = "K40TZFB2";
            $vnp_HashSecret = "O1S887RUKCIODDINIWXN3QHF8I1OTVKQ";

            $vnp_TxnRef = $bill->billCode;
            $vnp_OrderInfo = "Thanh toán đơn hàng: " . $bill->billCode;
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $total * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode = "NCB";
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }

            return redirect($vnp_Url);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function handlePaymentReturn(Request $request)
    {
        $vnp_HashSecret = "O1S887RUKCIODDINIWXN3QHF8I1OTVKQ";
        $inputData = $request->all();
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);

        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= '&' . urlencode($key) . '=' . urlencode($value);
        }
        $hashData = ltrim($hashData, '&');
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash === $vnp_SecureHash) {
            if ($inputData['vnp_ResponseCode'] == '00') {
                $orderId = $inputData['vnp_TxnRef'];
                $bill = Bill::where('billCode', $orderId)->first();

                if ($bill && $bill->status_payment_method !== Bill::DA_THANH_TOAN) {
                    DB::beginTransaction();
                    try {
                        $bill->status_payment_method = Bill::DA_THANH_TOAN;
                        $bill->save();

                        // Xóa giỏ hàng
                        $cart = Cart::where('user_id', Auth::id())->first();
                        if ($cart) {
                            $cart->items()->delete();
                        }

                        // Gửi email xác nhận
                        Mail::to($bill->emailUser)->queue(new OrderConfirm($bill));

                        DB::commit();
                        return redirect()->route('orders.index')
                            ->with('success', 'Thanh toán thành công');
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return redirect()->route('orders.index')
                            ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
                    }
                }
            }
        }

        return redirect()->route('orders.index')
            ->with('error', 'Thanh toán thất bại hoặc dữ liệu không hợp lệ');
    }
}
