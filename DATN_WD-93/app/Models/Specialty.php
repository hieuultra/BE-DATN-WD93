<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;
<<<<<<< Updated upstream
    protected $fillable = ['name', 'description','image'];
=======
    protected $fillable = ['name', 'image', 'description', 'faculty'];
>>>>>>> Stashed changes
    public function doctor()
    {
        return $this->hasMany(Doctor::class);
    }
    
}
