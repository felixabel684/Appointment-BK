<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'doctorName', 'address',
        'phone', 'clinics_id',
        'users_id'
    ];

    protected $hidden = [];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinics_id', 'id');
    }

    public function appointment()
    {
        return $this->hasMany(AppointmentSchedule::class, 'doctors_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
