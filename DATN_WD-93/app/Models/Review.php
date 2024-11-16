<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'product_id',
        'bill_id',
        'rating',
        'comment',
    ];
    protected $dates = ['deleted_at'];
    public function user()
    {
        return $this->belongsTo(User::class); // thiết lập mối quan hệ một-nhiều (one-to-many) giữa bảng categories và bảng products.
    }
    public function product()
    {
        return $this->belongsTo(Product::class); // thiết lập mối quan hệ một-nhiều (one-to-many) giữa bảng categories và bảng products.
    }
}
