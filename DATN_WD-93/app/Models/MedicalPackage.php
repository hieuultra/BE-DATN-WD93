<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalPackage extends Model
{
    use HasFactory;

    // Define the table name if it does not follow Laravel's naming convention
    protected $table = 'medical_packages';

    // Define fillable fields
    protected $fillable = [
        'package_id',
        'category',
        'name',
        'description',
    ];

    /**
     * Define a relationship to the Package model
     */
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
