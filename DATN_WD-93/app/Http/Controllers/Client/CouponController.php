<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Specialty;
use App\Models\UserCoupon;
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
        $spe = Specialty::whereIn('classification', ['chuyen_khoa', 'kham_tu_xa'])
            ->orderBy('name', 'asc')
            ->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        $coupons = UserCoupon::join('coupons', 'user_coupons.coupon_id', '=', 'coupons.id')
            ->where('user_coupons.user_id', Auth::id()) // Lọc theo user_id
            ->where('user_coupons.quantity', '>', 0) // Kiểm tra số lượng còn lại
            ->whereDate('coupons.expiry_date', '>=', Carbon::today()) // Kiểm tra thời gian còn hạn (>= ngày hôm nay)
            ->orderBy('coupons.updated_at', 'asc') // Sắp xếp theo ngày cập nhật của coupon
            ->get(); // Chỉ lấy các trường từ bảng coupons
        return view('client.coupons.list', compact('coupons', 'orderCount', 'categories', 'spe'));
    }
    public function showCoupons()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $spe = Specialty::whereIn('classification', ['chuyen_khoa', 'kham_tu_xa'])
            ->orderBy('name', 'asc')
            ->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        $score = 0;
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
            $score = $user->score;
        }

        $coupons = Coupon::where('expiry_date', '>=', now()) // Lọc mã giảm giá chưa hết hạn
            ->where('usage_limit', '>', 0) // Lọc mã giảm giá còn giới hạn sử dụng
            ->where('is_active', '=', 1)
            ->orderBy('updated_at', 'asc')
            ->get();

        return view('client.coupons.show', compact('coupons', 'orderCount', 'categories', 'spe', 'score'));
    }
    public function getCoupons(Request $request)
    {
        $coupon = Coupon::findOrFail($request->coupon_id);
        if ($coupon->min_order_value == 0 && $coupon->expiry_date < now()) {
            return back()->with('errors', 'Mã đã hết!');
        }
        $score = Auth::user();
        if ($score->score < $request->points_required) {
            return back()->with('error', 'Điểm của bạn không đủ!');
        }
        $userCoupon = UserCoupon::where('user_id', $score->id)
            ->where('coupon_id', $coupon->id)
            ->first(); // Lấy bản ghi đầu tiên nếu có

        if ($userCoupon) {
            return back()->with('error', 'Bạn chỉ có thể đổi mã này 1 lần!');
        } else {
            UserCoupon::create([
                'user_id' => $score->id,
                'coupon_id' => $coupon->id,
                'quantity' => 1,
            ]);
        }
        $score->score -= $request->points_required;
        $score->save();
        $coupon->decrement('usage_limit');
        $coupon->save();
        return back()->with('success', 'Đổi mã thành công!');
    }
}
