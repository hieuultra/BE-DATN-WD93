<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'doctor_id',
        'product_id',
        'rating',
        'comment',
    ];
    public function user()
    {
        return $this->belongsTo(User::class); // thiết lập mối quan hệ một-nhiều (one-to-many) giữa bảng categories và bảng products.
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class); // thiết lập mối quan hệ một-nhiều (one-to-many) giữa bảng categories và bảng products.
    }
    public function product()
    {
        return $this->belongsTo(Product::class); // thiết lập mối quan hệ một-nhiều (one-to-many) giữa bảng categories và bảng products.
    }
    public function appoinment()
    {
        return $this->belongsTo(Appoinment::class);
    }
}
