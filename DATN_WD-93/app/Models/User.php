<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    const ROLE_ADMIN = 'Admin';
    const ROLE_USER = 'User';
    const ROLE_DOCTOR = 'Doctor';
    const ROLE_PHARMACIST = 'Pharmacist';
    const ROLE_GUEST = 'Guest';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
        'password',
        'image',
        'role',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function review()
    {
        return $this->hasMany(Review::class);
    }
    public function doctor()
    {
        return $this->hasMany(Doctor::class);
    }
    public function bill()
    {
        return $this->hasMany(Bill::class);
    }
    public function appoinment()
    {
        return $this->hasMany(Appoinment::class);
    }
    public function appoinmentHistory()
    {
        return $this->hasMany(AppoinmentHistory::class);
    }
}
