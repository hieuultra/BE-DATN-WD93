<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'value', 'min_order_value', 'expiry_date', 'is_active', 'usage_limit'];

    // /**
    //  * Kiểm tra tính hợp lệ của mã giảm giá
    //  *
    //  * @return bool
    //  */
    // public function isValid()
    // {
    //     // Kiểm tra ngày hết hạn
    //     if ($this->expiry_date && Carbon::now()->greaterThan($this->expiry_date)) {
    //         return false;
    //     }

    //     // Kiểm tra số lần sử dụng
    //     if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
    //         return false;
    //     }

    //     return true;
    // }
}
