<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\SchedulesRequest;
use App\Models\AppointmentSchedule;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\ListClinic;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExaminationPatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil ID pasien yang sedang login
        $patientId = auth('patient')->id();

        // Ambil data ListClinic berdasarkan ID pasien yang sedang login
        $examination_patients = ListClinic::with(['schedule_clinic', 'schedule_appointment'])
            ->where('patients_id', $patientId)  // Filter berdasarkan ID pasien
            ->get();

        // dd($examination_patients->schedule_clinic, $examination_patients->schedule_appointment);

        return view('pages.patients.examination_patients.index', [
            'examination_patients' => $examination_patients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua data poli yang ada
        $clinics = Clinic::all();

        return view('pages.patients.examination_patients.create', compact('clinics'));
    }

    public function getSchedulesByClinic($clinicId)
    {
        // Ambil semua dokter berdasarkan clinicId
        $doctors = Doctor::where('clinics_id', $clinicId)->get();

        // Ambil jadwal dengan status ACTIVE berdasarkan doctor_id yang sudah ditemukan
        $schedules = AppointmentSchedule::whereIn('doctors_id', $doctors->pluck('id'))
            ->where('appointmentStatus', 'ACTIVE')
            ->get();

        // Format data untuk ditampilkan di frontend
        $scheduleData = $schedules->map(function ($schedule) {
            $doctor = $schedule->doctor_appointment;  // Ambil relasi dokter
            return [
                'id' => $schedule->id,
                'doctor' => $doctor ? $doctor->doctorName : 'Unknown Doctor',
                'appointmentDay' => $schedule->appointmentDay,
                'appointmentStart' => $schedule->appointmentStart,
                'appointmentEnd' => $schedule->appointmentEnd,
            ];
        });

        return response()->json($scheduleData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Set timezone ke Jakarta
        $timezone = 'Asia/Jakarta';
        $now = Carbon::now($timezone);  // Mendapatkan waktu sekarang di Jakarta

        // Validasi input
        $request->validate([
            'appointment_schedules_id' => 'required|exists:appointment_schedules,id',
            'complaint' => 'required|string|max:255',
        ]);

        // Ambil jadwal berdasarkan ID
        $appointmentSchedule = AppointmentSchedule::findOrFail($request->appointment_schedules_id);

        // Daftar konversi hari Indonesia ke Inggris
        $daysInEnglish = [
            'Senin' => 'Monday',
            'Selasa' => 'Tuesday',
            'Rabu' => 'Wednesday',
            'Kamis' => 'Thursday',
            'Jumat' => 'Friday',
            'Sabtu' => 'Saturday',
            'Minggu' => 'Sunday',
        ];

        // Pastikan booking hanya bisa dilakukan 1 hari sebelumnya
        $scheduleDayEnglish = $daysInEnglish[$appointmentSchedule->appointmentDay] ?? null;
        if (!$scheduleDayEnglish) {
            return redirect()->back()->withErrors('Hari pada jadwal tidak valid.');
        }

        // Gunakan Carbon untuk menggabungkan hari dan waktu jadwal
        $scheduleDay = Carbon::parse($scheduleDayEnglish)->setTimezone($timezone);  // Pastikan timezone disesuaikan
        $scheduleStartTime = $scheduleDay->copy()->setTimeFromTimeString($appointmentSchedule->appointmentStart);

        // Waktu maksimal booking (1 hari sebelumnya)
        $bookingDeadline = $scheduleStartTime->subDay();

        // Validasi apakah sudah melewati batas booking
        if ($now->greaterThanOrEqualTo($bookingDeadline)) {
            return redirect()->back()->withErrors('Booking hanya dapat dilakukan maksimal 1 hari sebelum jadwal.');
        }

        // Menggunakan startOfDay dan endOfDay untuk membandingkan tanggal saja
        $startOfDay = $scheduleDay->startOfDay(); // Jam 00:00:00
        $endOfDay = $scheduleDay->endOfDay(); // Jam 23:59:59

        // Cek queueNumber terbesar berdasarkan appointment_schedule_id pada hari yang sama
        $latestQueue = ListClinic::where('appointment_schedules_id', $appointmentSchedule->id)
            // ->whereBetween('created_at', [$startOfDay, $endOfDay])  // Cek antara jam 00:00 sampai 23:59
            ->orderBy('queueNumber', 'desc') // Urutkan berdasarkan queueNumber terbesar
            ->first();

        // Tentukan queueNumber
        if ($latestQueue) {
            // Mengecek jika sudah lebih dari 1 minggu dari entri terakhir, reset queueNumber ke 1
            $lastCreated = Carbon::parse($latestQueue->created_at)->setTimezone($timezone);

            // Jika sudah lebih dari 1 minggu, reset queueNumber
            if ($lastCreated->diffInWeeks($now) >= 1) {
                $queueNumber = 1; // Reset queueNumber
            } else {
                // Tambahkan queueNumber terakhir dengan 1
                $queueNumber = $latestQueue->queueNumber + 1;
            }
        } else {
            // Jika tidak ada data sebelumnya, mulai dengan queueNumber 1
            $queueNumber = 1;
        }

        // Simpan data ke ListClinic
        $listClinic = ListClinic::create([
            'complaint' => $request->complaint,
            'queueNumber' => $queueNumber,
            'patients_id' => auth('patient')->id(), // Ambil ID pasien yang login
            'appointment_schedules_id' => $appointmentSchedule->id,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('examination_patients.index')->with('success', 'Booking berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Ambil ID pasien yang sedang login
        $patientId = auth('patient')->id();

        // Ambil data ListClinic berdasarkan ID pasien yang sedang login
        $examination_patient = ListClinic::with([
            'schedule_clinic',             // Relasi ke clinic (schedule_clinic sudah benar)
            'schedule_appointment',        // Relasi ke appointment schedule
            'clinic_examination',          // Relasi ke clinic_examination
            'clinic_examination.examination_medicines', // Relasi ke examination_medicines
            // 'clinic_examination.examination_details', // Relasi ke examination_details
            // 'clinic_examination.examination_details.medicine', // Relasi ke medicine
        ])
            ->where('id', $id)
            ->where('patients_id', $patientId) // Pastikan hanya data milik pasien yang login
            ->firstOrFail();

        $isExamined = $examination_patient->clinic_examination()->exists(); // Cek apakah sudah diperiksa
        $examination_details = $isExamined ? $examination_patient->clinic_examination : null;

        // dd($examination_patient);

        return view('pages.patients.examination_patients.detail', compact('examination_patient', 'isExamined', 'examination_details'));
    }
}
