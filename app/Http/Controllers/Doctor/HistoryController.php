<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Examination;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil ID dokter yang sedang login
        $doctorId = auth()->user()->doctor->id;

        // Ambil kata kunci pencarian dari request
        $search = $request->input('search');

        // Ambil data pasien hanya untuk dokter yang sedang login
        $patients = Patient::whereHas('patient_clinic.clinic_examination', function ($query) use ($doctorId) {
            // Filter berdasarkan dokter yang login
            $query->whereHas('list_clinic.schedule_appointment', function ($q) use ($doctorId) {
                $q->where('doctors_id', $doctorId);
            });
        })
        ->with([
            'patient_clinic' => function ($query) use ($doctorId) {
                $query->whereHas('schedule_appointment', function ($q) use ($doctorId) {
                    $q->where('doctors_id', $doctorId);
                })
                    ->with('clinic_examination'); // Eager load pemeriksaan
            },
        ])
        ->when($search, function ($query) use ($search) {
            // Filter pencarian
            $query->where('patientName', 'LIKE', '%' . $search . '%')
                ->orWhere('nik', 'LIKE', '%' . $search . '%')
                ->orWhere('rmNumber', 'LIKE', '%' . $search . '%');
        })
        ->get();

        // Kirim data ke view
        return view('pages.doctors.history.index', [
            'patients' => $patients,
            'search' => $search,
        ]);
    }

    // public function index(Request $request)
    // {
    //     // Ambil ID dokter yang sedang login
    //     $doctorId = auth()->user()->doctor->id; // Sesuaikan jika ada relasi dokter

    //     // Ambil kata kunci pencarian dari request
    //     $search = $request->input('search');

    //     // Jika ada kata kunci pencarian, filter data berdasarkan pencarian dan ID dokter
    //     if ($search) {
    //         $patients = Patient::with(['patient_examination', 'patient_clinic', 'patient_clinic.schedule_appointment', 'patient_clinic.clinic_examination'])
    //         ->whereHas('patient_clinic.schedule_appointment', function ($query) use ($doctorId) {
    //             $query->where('doctors_id', $doctorId); // Filter berdasarkan dokter yang sedang login
    //         })
    //             ->whereHas('patient_clinic.clinic_examination', function ($query) use ($search) {
    //                 $query->whereHas('patient', function ($query) use ($search) {
    //                     $query->where('patientName', 'LIKE', '%' . $search . '%'); // Pencarian berdasarkan nama pasien
    //                 });
    //                 $query->where('complaint', 'LIKE', '%' . $search . '%'); // Pencarian berdasarkan keluhan
    //             })
    //             ->get();
    //     } else {
    //         // Jika tidak ada pencarian, ambil semua data berdasarkan dokter yang sedang login
    //         Patient::with(['patient_examination', 'patient_clinic', 'patient_clinic.schedule_appointment', 'patient_clinic.clinic_examination'])
    //         ->whereHas('patient_clinic.schedule_appointment', function ($query) use ($doctorId) {
    //             $query->where('doctors_id', $doctorId); // Filter berdasarkan dokter yang sedang login
    //         })
    //             ->get();
    //     }

    //     return view('pages.doctors.history.index', [
    //         'patients' => $patients,
    //         'search' => $search, // Pass kata kunci pencarian ke view
    //     ]);
    // }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $patient = Patient::with(['patient_clinic', 'patient_clinic.clinic_examination' , 'patient_clinic.clinic_examination.examination_doctors', 'patient_clinic.clinic_examination.examination_medicines'])->findOrFail($id);

        // foreach ($patient->patient_clinic as $clinic) {
        //     foreach ($clinic->clinic_examination as $examination) {
        //         dd($examination->examination_doctors);
        //     }
        // }

        // Debug hasil relasi
        // dd($historys->list_clinic, $historys->list_clinic->patient);

        return view('pages.doctors.history.detail', compact('patient'));
    }

    // public function show($id)
    // {
    //     // Ambil pasien berdasarkan ID dengan relasi lengkap
    //     $patient = Patient::with([
    //         'patient_clinic' => function ($query) {
    //             $query->with(['schedule_appointment', 'clinic_examination']);
    //         }
    //     ])->findOrFail($id);

    //     // Periksa apakah ada data pemeriksaan
    //     $examinations = $patient->patient_clinic
    //         ->flatMap(function ($clinic) {
    //             return $clinic->clinic_examination; // Ambil data dari relasi examination
    //         });

    //     if ($examinations->isEmpty()) {
    //         return redirect()->route('history.index')
    //         ->with('error', 'Tidak ada data pemeriksaan untuk pasien ini.');
    //     }

    //     return view('pages.doctors.history.detail', [
    //         'patient' => $patient,
    //         'examinations' => $examinations,
    //     ]);
    // }
}
