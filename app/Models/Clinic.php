<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'clinicName', 'description',
    ];

    protected $hidden = [

    ];

    public function doctors_clinics()
    {
        return $this->hasMany(Doctor::class, 'clinics_id', 'id');
    }

    // use HasFactory;
}
