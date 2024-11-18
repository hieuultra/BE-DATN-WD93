<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'specialty_id',
        'title',
        'experience_years',
        'position',
        'workplace',
        'min_age',
        'examination_fee',
        'bio'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }
    public function clinic()
    {
        return $this->hasMany(Clinic::class);
    }
    public function appoinment()
    {
        return $this->hasMany(Appoinment::class);
    }
    public function timeSlot()
    {
        return $this->hasMany(AvailableTimeslot::class);
    }
    public function appoinmentHistory()
    {
        return $this->hasMany(AppoinmentHistory::class);
    }
    public function review()
    {
        return $this->hasMany(Review::class);
    }
    public function doctorAchievement()
    {
        return $this->hasMany(doctorAchievement::class);
    }
}
