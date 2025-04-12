<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'user_id',
        'name',
        'email',
        'question',
        'answer',
        'is_answered',
        'answered_at',
        'answered_by',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function answeredBy()
    {
        return $this->belongsTo(User::class, 'answered_by');
    }
}
