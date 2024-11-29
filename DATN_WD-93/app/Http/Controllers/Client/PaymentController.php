<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function processVNPay(Request $request)
    {
        $vnp_TmnCode = "K40TZFB2"; // Mã Website của bạn trên VNPay
        $vnp_HashSecret = "O1S887RUKCIODDINIWXN3QHF8I1OTVKQ"; // Chuỗi bí mật từ VNPay
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"; // Địa chỉ VNPay API
        $vnp_Returnurl = route('payments.return'); // Route trả về sau thanh toán

        $orderId = rand(1, 10000); // Tạo mã đơn hàng
        $amount = $request->input('totalPrice'); // Lấy tổng giá trị
        $orderInfo = "Thanh toán đơn hàng: $orderId"; 

        $vnp_Params = [
            "vnp_Version" => "2.1.0",
            "vnp_Command" => "pay",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $amount * 100, // VNPay tính theo đơn vị VND x100
            "vnp_CurrCode" => "VND",
            "vnp_TxnRef" => $orderId,
            "vnp_OrderInfo" => $orderInfo,
            "vnp_OrderType" => "billpayment",
            "vnp_Locale" => "vn",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_IpAddr" => $request->ip(),
        ];

        ksort($vnp_Params);
        $query = http_build_query($vnp_Params);
        $hashdata = urldecode($query);
        $vnpSecureHash = hash_hmac("sha512", $hashdata, $vnp_HashSecret);
        $vnp_Url .= "?" . $query . "&vnp_SecureHash=" . $vnpSecureHash;

        // Kiểm tra URL cuối cùng
        // dd($vnp_Url); 

        return redirect($vnp_Url);
    }

    public function paymentReturn(Request $request)
    {
        $vnp_HashSecret = "O1S887RUKCIODDINIWXN3QHF8I1OTVKQ"; // Chuỗi bí mật
        $inputData = $request->all();
        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? null;

        if ($vnp_SecureHash) {
            unset($inputData['vnp_SecureHash']);
            unset($inputData['vnp_SecureHashType']);

            ksort($inputData);
            $hashdata = urldecode(http_build_query($inputData));
            $secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

            if ($secureHash === $vnp_SecureHash) {
                if ($inputData['vnp_ResponseCode'] == '00') {
                    return redirect()->route('orders.success')->with('success', 'Thanh toán thành công!');
                } else {
                    return redirect()->route('orders.fail')->with('error', 'Thanh toán thất bại!');
                }
            } else {
                return redirect()->route('orders.fail')->with('error', 'Dữ liệu không hợp lệ!');
            }
        } else {
            return redirect()->route('orders.fail')->with('error', 'Dữ liệu không hợp lệ!');
        }
    }
}