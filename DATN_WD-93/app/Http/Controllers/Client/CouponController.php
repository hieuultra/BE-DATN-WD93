<?php

namespace App\Http\Controllers\Client;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    public function applyCoupon(Request $request)
    {
        $code = $request->input('coupon_code');

        // Kiểm tra mã giảm giá
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return back()->with('error', 'Mã giảm giá không tồn tại.');
        }

        // Kiểm tra tính hợp lệ của mã giảm giá
        if (!$coupon->isValid()) {
            return back()->with('error', 'Mã giảm giá đã hết hạn hoặc không hợp lệ.');
        }

        // Kiểm tra điều kiện áp dụng (nếu có)
        $totalOrderValue = $request->input('total_order_value', 0); // Giá trị đơn hàng
        if ($coupon->min_order_value && $totalOrderValue < $coupon->min_order_value) {
            return back()->with('error', 'Mã giảm giá chỉ áp dụng cho đơn hàng từ '
                . number_format($coupon->min_order_value, 0, ',', '.') . ' VND trở lên.');
        }

        // Lưu mã giảm giá vào session
        session([
            'coupon' => [
                'code' => $coupon->code,
                'type' => $coupon->type, // 'percentage' hoặc 'fixed'
                'value' => $coupon->value, // Giá trị giảm
                'min_order_value' => $coupon->min_order_value, // Giá trị tối thiểu
                'description' => $coupon->description, // Mô tả mã giảm giá (nếu có)
            ]
        ]);

        return back()->with('success', 'Mã giảm giá đã được áp dụng!');
    }
}
