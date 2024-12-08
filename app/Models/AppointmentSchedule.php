<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentSchedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'appointmentDay',
        'appointmentStart',
        'appointmentEnd',
        'appointmentStatus',
        'doctors_id',
    ];

    protected $hidden = [];

    public function doctor_appointment()
    {
        return $this->belongsTo(Doctor::class, 'doctors_id', 'id');
    }

    public function schedule()
    {
        return $this->hasMany(ListClinic::class, 'appointment_schedules_id', 'id');
    }

    // use HasFactory;
}
