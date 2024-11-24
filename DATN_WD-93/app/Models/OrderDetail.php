<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'bill_id',
        'product_id',
        'variant_id',
        'unitPrice',
        'quantity',
        'totalMoney'
    ];
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function productVariant()
    {
        return $this->belongsTo(VariantProduct::class, 'variant_id');
    }
}
