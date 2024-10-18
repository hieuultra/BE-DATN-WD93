<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantPackageProduct extends Model
{
    use HasFactory;
    protected $fillable = ['name']; 
    protected $table = 'variant_packages';

    protected $cast = [
        'status' => 'boolean',
    ];


    //dn khoa chinh/khoa ngoai
    public function products()
    {
        return $this->hasMany(Product::class); // thiết lập mối quan hệ một-nhiều (one-to-many) giữa bảng categories và bảng products.
    }
}
