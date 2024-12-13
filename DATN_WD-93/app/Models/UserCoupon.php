<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCoupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coupon_id',
        'quantity'
    ];

    // Quan hệ với bảng User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với bảng Coupon
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    public function isValid()
    {
        // Kiểm tra trạng thái hoạt động của mã giảm giá
        if (!$this->is_active) {
            return false; // Mã không hoạt động
        }

        // Kiểm tra ngày hết hạn
        if ($this->expiry_date && Carbon::parse($this->expiry_date)->isPast()) {
            return false; // Mã đã hết hạn
        }

        // Kiểm tra số lần sử dụng (nếu được giới hạn)
        return true; // Mã giảm giá hợp lệ
    }
}
