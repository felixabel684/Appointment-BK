<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppointmentSchedule;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\ListClinic;
use App\Models\Medicine;
use App\Models\Patient;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin_dash(Request $request)
    {
        // Menghitung total pasien yang belum diperiksa
        $patientsNotExamined = ListClinic::doesntHave('clinic_examination')->count(); // ListClinic yang tidak memiliki relasi pemeriksaan (examination)

        // Menghitung total pasien yang sudah diperiksa
        $patientsExamined = ListClinic::has('clinic_examination')->count(); // ListClinic yang memiliki relasi pemeriksaan (examination)

        return view('pages.admin.dashboard', [
            'doctors' => Doctor::count(),
            'patients' => Patient::count(),
            'clinics' => Clinic::count(),
            'medicines' => Medicine::count(),
            'patientsNotExamined' => $patientsNotExamined,
            'patientsExamined' => $patientsExamined,
        ]);
    }

    public function doctor_dash(Request $request)
    {
        // Ambil dokter yang sedang login
        $doctorId = auth()->user()->doctor->id; // Sesuaikan kolom ID sesuai database Anda

        // Hitung jumlah jadwal aktif (ACTIVE) untuk dokter yang sedang login
        $activeSchedulesCount = AppointmentSchedule::where('appointmentStatus', 'ACTIVE')
        ->where('doctors_id', $doctorId) // Filter berdasarkan ID dokter
            ->count();

        // Hitung jumlah pasien yang berobat ke dokter yang login
        $patientsCount = ListClinic::whereHas('schedule_appointment', function ($query) use ($doctorId) {
            $query->where('doctors_id', $doctorId);
        })->count();

        $unexaminedPatientsCount = ListClinic::whereHas('schedule_appointment', function ($query) use ($doctorId) {
            $query->where('doctors_id', $doctorId);
        })->doesntHave('clinic_examination')->count();

        $examinedPatientsCount = ListClinic::whereHas('schedule_appointment', function ($query) use ($doctorId) {
            $query->where('doctors_id', $doctorId);
        })->has('clinic_examination')->count();

        // dd($doctorId);

        return view('pages.doctors.dashboard', [
            'schedule' => $activeSchedulesCount,
            'patients' => $patientsCount,
            'unexaminedPatientsCount' => $unexaminedPatientsCount,
            'cliexaminedPatientsCountnics' => $examinedPatientsCount,
        ]);
    }

    public function patient_dash(Request $request)
    {
        $patientId = auth('patient')->id();
        return view('pages.patients.dashboard', [
            'examination_patient' => ListClinic::where('patients_id', $patientId)->count()
        ]);
    }
}
