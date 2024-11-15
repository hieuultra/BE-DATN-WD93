<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description','image', 'classification'];
    public function doctor()
    {
        return $this->hasMany(Doctor::class);
    }
}
