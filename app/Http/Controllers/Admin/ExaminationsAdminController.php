<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\ListClinic;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ExaminationsAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the search term from the request
        $search = $request->input('search');

        // If there is a search term, filter the Doctor
        if ($search) {
            $examination_admin = ListClinic::with(['patient', 'schedule_appointment' ,'schedule_appointment.doctor_appointment', 'schedule_clinic'])
                ->whereHas('patient', function ($query) use ($search) {
                    $query->where('rmNumber', 'LIKE', '%' . $search . '%');
                    $query->where('patientName', 'LIKE', '%' . $search . '%');
                })
                ->whereHas('schedule_appointment', function ($query) use ($search) {
                    $query->where('appointmentDate', 'LIKE', '%' . $search . '%');
                })
                ->whereHas('schedule_appointment.doctor_appointment', function ($query) use ($search) {
                    $query->where('doctorName', 'LIKE', '%' . $search . '%');
                })
                ->whereHas('schedule_clinic', function ($query) use ($search) {
                    $query->where('clinicName', 'LIKE', '%' . $search . '%');
                })
                ->orWhere('complaint', 'LIKE', '%' . $search . '%')
                ->get();
        } else {
            // If no search term, retrieve all Doctor
            $examination_admin = ListClinic::with(['patient', 'schedule_appointment', 'schedule_appointment.doctor_appointment', 'schedule_clinic'])->get();
        }

        // dd($examination_admin);

        return view('pages.admin.examinations_admin.index', [
            'examination_admin' => $examination_admin,
            'search' => $search // Pass the search term to the view if needed
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        // Ambil data ListClinic berdasarkan ID pasien yang sedang login
        $examination_admin = ListClinic::with([
            'patient',
            'schedule_clinic',             // Relasi ke clinic (schedule_clinic sudah benar)
            'schedule_appointment',        // Relasi ke appointment schedule
            'clinic_examination',          // Relasi ke clinic_examination
            'clinic_examination.examination_medicines', // Relasi ke examination_medicines
            // 'clinic_examination.examination_details', // Relasi ke examination_details
            // 'clinic_examination.examination_details.medicine', // Relasi ke medicine
        ])
            ->where('id', $id)
            ->firstOrFail();

        $isExamined = $examination_admin->clinic_examination()->exists(); // Cek apakah sudah diperiksa
        $examination_details = $isExamined ? $examination_admin->clinic_examination : null;

        // dd($examination_admin);

        return view('pages.admin.examinations_admin.detail', compact('examination_admin', 'isExamined', 'examination_details'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
}
