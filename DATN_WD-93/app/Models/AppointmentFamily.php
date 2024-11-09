<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentFamily extends Model
{
    use HasFactory;

    // Define table name if different from default convention
    protected $table = 'appointments_family';

    // Define fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'doctor_id',
        'available_timeslot_id',
        'name',
        'email',
        'phone',
        'address',
        'notes',
        'status_appoinment',
        'status_payment_method',
        'gender',
        'year_of_birth',
    ];

    // Define default constants for status fields
    public const CHO_XAC_NHAN = 'Chờ xác nhận';
    public const CHUA_THANH_TOAN = 'Chưa thanh toán';

    // Define relationships (if any)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function availableTimeslot()
    {
        return $this->belongsTo(AvailableTimeslot::class);
    }
}
