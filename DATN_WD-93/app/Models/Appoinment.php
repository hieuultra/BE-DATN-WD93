<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appoinment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'doctor_id',
        'available_timeslot_id',
        'appointment_date',
        'notes',
        'status_appoinment',
        'status_payment_method',
    ];
    const status_appoinment = [
        'cho_xac_nhan' => 'Chờ xác nhận',
        'da_xac_nhan' => 'Đã xác nhận',
        'dang_kham' => 'Đang khám',
        'kham_hoan_thanh' => 'Khám hoàn thành',
        'can_tai_kham' => 'Cần tái khám',
        'benh_nhan_khong_den' => 'Bệnh nhân không đến',
        'yeu_cau_huy' => "Yêu cầu hủy lịch",
        'da_huy' => 'Cuộc hẹn đã hủy',
    ];

    const status_payment_method = [
        'chua_thanh_toan' => 'Chưa thanh toán',
        'thanh_toan_tai_benh_vien' => 'Thanh toán tại bệnh viên',
        'da_thanh_toan' => 'Đã thanh toán',
    ];
    const CHO_XAC_NHAN = 'cho_xac_nhan';
    const DA_XAC_NHAN = 'da_xac_nhan';
    const DANG_KHAM = 'dang_kham';
    const KHAM_HOAN_THANH = 'kham_hoan_thanh';
    const CAN_TAI_KHAM = 'can_tai_kham';
    const BENH_NHAN_KHONG_DEN = 'benh_nhan_khong_den';
    const DA_HUY = 'da_huy';
    const YEU_CAU_HUY = 'yeu_cau_huy';
    const CHUA_THANH_TOAN = 'chua_thanh_toan';
    const THANH_TOAN_TAI_BENH_VIEN = 'thanh_toan_tai_benh_vien';
    const DA_THANH_TOAN = 'da_thanh_toan';
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // thiết lập mối quan hệ một-nhiều (one-to-many) giữa bảng categories và bảng products.
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id'); // thiết lập mối quan hệ một-nhiều (one-to-many) giữa bảng categories và bảng products.
    }
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id'); // thiết lập mối quan hệ một-nhiều (one-to-many) giữa bảng categories và bảng products.
    }
    public function timeSlot()
    {
        return $this->belongsTo(AvailableTimeslot::class, 'available_timeslot_id');
    }
    public function appoinmentHistory()
    {
        return $this->hasMany(AppoinmentHistory::class);
    }
    public function review()
    {
        return $this->hasMany(Review::class);
    }
}
