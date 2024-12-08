<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Gunakan Authenticatable
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $fillable = [
        'nik', 'patientName', 'address',
        'phone', 'rmNumber',
    ];

    protected $hidden = [

    ];

    public function patient_examination()
    {
        return $this->belongsToMany(Examination::class, 'list_clinics', 'patients_id', 'examinations_id');
    }

    public function patient_clinic()
    {
        return $this->hasMany(ListClinic::class, 'patients_id', 'id');
    }

    // use HasFactory;
}
