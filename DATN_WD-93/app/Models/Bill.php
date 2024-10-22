<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable = [
        'billCode',
        'addressUser',
        'phoneUser',
        'nameUser',
        'emailUser',
        'totalPrice',
        'user_id',
        'status_bill',
        'status_payment_method',
        'moneyProduct',
        'moneyShip'
    ];

    const status_bill = [
        'cho_xac_nhan' => 'Chờ xác nhận',
        'da_xac_nhan' => 'Đã xác nhận',
        'dang_chuan_bi' => 'Đang chuẩn bị',
        'dang_van_chuyen' => 'Đang vận chuyển',
        'da_giao_hang' => 'Đã giao hàng',
        'da_huy' => 'Đơn hàng đã hủy',
    ];
    const status_payment_method = [
        'chua_thanh_toan' => 'Chưa thanh toán',
        'da_thanh_toan' => 'Đã thanh toán',
    ];
    const CHO_XAC_NHAN = 'cho_xac_nhan';
    const DA_XAC_NHAN = 'da_xac_nhan';
    const DANG_CHUAN_BI = 'dang_chuan_bi';
    const DANG_VAN_CHUYEN = 'dang_van_chuyen';
    const DA_GIAO_HANG = 'da_giao_hang';
    const DA_HUY = 'da_huy';
    const CHUA_THANH_TOAN = 'chua_thanh_toan';
    const DA_THANH_TOAN = 'da_thanh_toan';
    public function user()
    {
        return $this->belongsTo(User::class); //$this đại diện cho thể hiện hiện tại của lớp Product
        //Phương thức belongsTo của Eloquent ORM được sử dụng để xác định mối quan hệ "belongs to" (thuộc về) giữa mô hình Product và mô hình Category.
    }
    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
