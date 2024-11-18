<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;

    protected $table = 'clinics'; // Tên bảng trong database

    // Định nghĩa các cột có thể gán hàng loạt
    protected $fillable = [
        'doctor_id',
        'clinic_name',
        'city',
        'address',
    ];

    /**
     * Thiết lập quan hệ với model Doctor (giả sử có bảng và model Doctor).
     * Một phòng khám thuộc về một bác sĩ.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
