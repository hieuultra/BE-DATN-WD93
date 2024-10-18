<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantPackage extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $table = 'variant_packages';

    //dn khoa chinh/khoa ngoai
    public function variantProduct()
    {
        return $this->hasMany(VariantProduct::class); // thiết lập mối quan hệ một-nhiều (one-to-many) giữa bảng categories và bảng products.
    }
}
