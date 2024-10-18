<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_product',
        'id_variant',
        'quantity',
        'price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function variantPackage()
    {
        return $this->belongsTo(VariantPackage::class);
    }
}
