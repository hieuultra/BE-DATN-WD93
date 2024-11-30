<?php

namespace App\Http\Controllers\Client;

use App\Models\DiscountCode;
use Illuminate\Http\Request;
use App\Mail\DiscountCodeMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscriptions,email',
        ]);

        // Tạo mã giảm giá
        $discountCode = strtoupper(uniqid('DISCOUNT_'));

        // Lưu vào bảng discount_codes (hoặc bảng riêng cho subscriptions nếu cần)
        DiscountCode::create([
            'code' => $discountCode,
            'discount_amount' => 100000,
            'expires_at' => now()->addDays(30),
            'user_id' => null, // Không liên kết với user (đây là subscription)
        ]);

        // Gửi email
        Mail::to($request->email)->send(new DiscountCodeMail($discountCode));

        return back()->with('success', 'Đăng ký thành công! Kiểm tra email của bạn để biết mã giảm giá.');
    }
}
