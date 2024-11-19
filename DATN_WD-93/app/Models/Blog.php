<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'short_content',
        'image',
        'content',
        'topic_id',
    ]; //Thuộc tính fillable khai báo các cột trong bảng mà có thể được gán giá trị một cách hàng loạt

    protected $cast = [
    ];
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
