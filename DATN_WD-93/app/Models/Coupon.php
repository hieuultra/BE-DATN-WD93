<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'value', 'min_order_value', 'expiry_date', 'is_active', 'usage_limit', 'type', 'max_discount'];
    /**
     * Kiểm tra xem mã giảm giá có hợp lệ hay không
     *
     * @return bool
     */
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
        if ($this->usage_limit !== null && $this->usage_limit <= 0) {
            return false; // Mã đã sử dụng hết
        }

        return true; // Mã giảm giá hợp lệ
    }
}
