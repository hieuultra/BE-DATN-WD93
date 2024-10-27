<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doctorAchievement extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'type',
        'description',
        'year'
    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class); //$this đại diện cho thể hiện hiện tại của lớp Product
        //Phương thức belongsTo của Eloquent ORM được sử dụng để xác định mối quan hệ "belongs to" (thuộc về) giữa mô hình Product và mô hình Category.
    }
}
