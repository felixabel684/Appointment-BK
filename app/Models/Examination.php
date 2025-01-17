<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examination extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'examinationDate', 'note', 'price',
        'list_clinics_id',
    ];

    protected $hidden = [

    ];

    public function list_clinic()
    {
        return $this->belongsTo(ListClinic::class, 'list_clinics_id', 'id');
    }

    public function clinic_patients()
    {
        return $this->belongsToMany(Patient::class, 'list_clinics', 'examinations_id', 'patients_id');
    }

    public function examination_medicines()
    {
        return $this->belongsToMany(Medicine::class, 'examination_details', 'examinations_id', 'medicines_id')->withTimestamps();
    }

    public function examination_doctors()
    {
        return $this->hasOneThrough(
            Doctor::class,               // Model target akhir
            AppointmentSchedule::class,  // Model perantara
            'id',                        // Foreign key di AppointmentSchedule
            'id',                        // Foreign key di Doctor
            'list_clinics_id',           // Foreign key di Examination
            'doctors_id'                 // Foreign key di AppointmentSchedule
        );
    }

    public function payment_examination()
    {
        return $this->hasMany(Payment::class, 'examinations_id', 'id');
    }

    public function isPayment()
    {
        // Periksa apakah ada pembayaran terkait dengan examinations_id ini
        return $this->payment_examination()->exists(); // Menggunakan exists() untuk cek ada data atau tidak
    }

    // use HasFactory;
}
