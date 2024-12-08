<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListClinic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'complaint',
        'queueNumber',
        'patients_id',
        'appointment_schedules_id',
    ];

    protected $hidden = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patients_id', 'id');
    }

    public function schedule_clinic()
    {
        return $this->hasOneThrough(
            Clinic::class,                // Model target akhir (Clinic)
            Doctor::class,                // Model perantara (Doctor)
            'id',                 // Foreign key di Doctor mengacu ke Clinic (clinics_id di Doctors)
            'id',                         // Foreign key di Clinic
            'id',   // Foreign key di ListClinic mengacu ke AppointmentSchedule
            'id'                  // Foreign key di AppointmentSchedule mengacu ke Doctor
        );
    }

    public function schedule_appointment()
    {
        return $this->belongsTo(AppointmentSchedule::class, 'appointment_schedules_id', 'id');
    }

    public function clinic_examination()
    {
        return $this->hasMany(Examination::class, 'list_clinics_id', 'id');
    }

    public function isExamined()
    {
        // Periksa apakah ada pemeriksaan terkait dengan list_clinics_id ini
        return $this->clinic_examination()->exists(); // Menggunakan exists() untuk cek ada data atau tidak
    }

    // use HasFactory;
}
