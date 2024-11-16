<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'idProduct',
        'name',
        'img',
        'description',
        'price',
        'discount',
        'content',
        'quantity',
        'category_id',
        'is_type',
        'is_new',
        'is_hot',
        'is_hot_deal',
        'is_show_home',
    ]; //Thuộc tính fillable khai báo các cột trong bảng mà có thể được gán giá trị một cách hàng loạt

    protected $cast = [
        'is_type' => 'boolean',
        'is_new' => 'boolean',
        'is_hot' => 'boolean',
        'is_hot_deal' => 'boolean',
        'is_show_home' => 'boolean',
    ];
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
