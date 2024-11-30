<?php

namespace App\Http\Controllers\Client;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CartItem;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');
        $coupon = Coupon::where('code', $couponCode)->first();

        if (!$coupon || !$coupon->isValid()) {
            return back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn!');
        }

        // Lấy giỏ hàng và các item trong giỏ
        $cart = Cart::where('user_id', Auth::id())->with('items')->first();
        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // Tính tổng phụ (subTotal)
        $subTotal = $cart->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Kiểm tra giá trị đơn hàng tối thiểu
        if ($subTotal < $coupon->min_order_value) {
            return back()->with('error', 'Đơn hàng không đủ giá trị tối thiểu để áp dụng mã giảm giá!');
        }

        // Tính giá trị giảm giá (dựa trên % hoặc giá trị cụ thể)
        // $discount = $subTotal * ($coupon->value / 100);

        // Áp dụng giảm giá lên từng CartItem
        foreach ($cart->items as $item) {
            $itemDiscount = $discount * ($item->price * $item->quantity / $subTotal);
            $item->total -= $itemDiscount; // Cập nhật total sau giảm giá
            $item->save();
        }

        // Cập nhật tổng tiền (sau khi giảm giá) nếu cần tính tổng
        $shipping = 40000;
        $totalAfterDiscount = $subTotal - $discount + $shipping;

        // Giảm số lần sử dụng của mã giảm giá (nếu có)
        if ($coupon->usage_limit !== null) {
            $coupon->decrement('usage_limit');
        }

        return back()->with('success', 'Áp dụng mã giảm giá thành công!');
    }
    public function listCoupons()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        $coupons = Coupon::orderBy('updated_at', 'asc')
            ->get();

        return view('client.coupons.list', compact('coupons', 'orderCount', 'categories'));
    }
}
