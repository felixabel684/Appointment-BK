<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\AppointmentSchedule;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\ListClinic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        $timezone = 'Asia/Jakarta';
        $now = Carbon::now($timezone);  // Mendapatkan waktu sekarang di Jakarta

        // Validasi booking hanya bisa dilakukan setiap 3 hari sekali
        $patientId = auth('patient')->id();
        $lastBooking = ListClinic::where('patients_id', $patientId)
        ->orderBy('created_at', 'desc') // Ambil booking terakhir berdasarkan tanggal
            ->first();

        if ($lastBooking) {
            $lastBookingDay = Carbon::parse($lastBooking->created_at)->setTimezone($timezone);
            $differenceInDays = $lastBookingDay->diffInDays($now);

            Log::info("Last Booking: {$lastBookingDay}, Now: {$now}, Difference in Days: {$differenceInDays}");

            if ($differenceInDays < 3) {
                return redirect()->back()->withErrors('Anda hanya dapat melakukan booking pemeriksaan setiap 3 hari sekali.');
            }
        }

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

        // Validasi hari pada jadwal
        $scheduleDayEnglish = $daysInEnglish[$appointmentSchedule->appointmentDay] ?? null;
        if (!$scheduleDayEnglish) {
            return redirect()->back()->withErrors('Hari pada jadwal tidak valid.');
        }

        // Validasi booking hanya bisa dilakukan setiap 3 hari sekali
        $patientId = auth('patient')->id();
        $lastBooking = ListClinic::where('patients_id', $patientId)
        ->orderBy('created_at', 'desc') // Ambil booking terakhir berdasarkan tanggal
            ->first();

        if ($lastBooking) {
            $lastBookingDay = Carbon::parse($lastBooking->created_at)->setTimezone($timezone);
            $differenceInDays = $lastBookingDay->diffInDays($now);

            Log::info("Last Booking: {$lastBookingDay}, Now: {$now}, Difference in Days: {$differenceInDays}");

            if ($differenceInDays < 3) {
                return redirect()->back()->withErrors('Anda hanya dapat melakukan booking pemeriksaan setiap 3 hari sekali.');
            }
        }

        // Tentukan queueNumber
        $latestQueue = ListClinic::where('appointment_schedules_id', $appointmentSchedule->id)
            ->orderBy('queueNumber', 'desc') // Urutkan berdasarkan queueNumber terbesar
            ->first();

        $queueNumber = $latestQueue ? $latestQueue->queueNumber + 1 : 1;

        // Simpan data ke ListClinic
        $listClinic = ListClinic::create([
            'complaint' => $request->complaint,
            'queueNumber' => $queueNumber,
            'patients_id' => $patientId,
            'appointment_schedules_id' => $appointmentSchedule->id,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('examination_patients.index')->with('success', 'Booking berhasil disimpan.');
    }

    // public function store(Request $request)
    // {
    //     // Set timezone ke Jakarta
    //     $timezone = 'Asia/Jakarta';
    //     $now = Carbon::now($timezone); // Mendapatkan waktu sekarang di Jakarta

    //     // Validasi input
    //     $request->validate([
    //         'appointment_schedules_id' => 'required|exists:appointment_schedules,id',
    //         'complaint' => 'required|string|max:255',
    //     ]);

    //     // Ambil jadwal berdasarkan ID
    //     $appointmentSchedule = AppointmentSchedule::findOrFail($request->appointment_schedules_id);

    //     // Cek apakah sudah ada booking hari ini
    //     $hasBookedToday = ListClinic::where('patients_id', $patientId)
    //         ->whereDate('created_at', Carbon::today())
    //         ->exists();

    //     // Cek apakah sudah ada booking minggu ini
    //     $hasBookedThisWeek = ListClinic::where('patients_id', $patientId)
    //         ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
    //         ->exists();

    //     // Jika sudah booking hari ini, tampilkan pesan error
    //     if ($hasBookedToday) {
    //         return redirect()->back()->withErrors('Anda sudah melakukan booking hari ini. Silakan mencoba lagi besok.');
    //     }

    //     // Jika sudah booking minggu ini, tampilkan pesan error
    //     if ($hasBookedThisWeek) {
    //         return redirect()->back()->withErrors('Anda hanya bisa melakukan booking sekali dalam seminggu.');
    //     }

    //     // Daftar konversi hari Indonesia ke Inggris
    //     $daysInEnglish = [
    //         'Senin' => 'Monday',
    //         'Selasa' => 'Tuesday',
    //         'Rabu' => 'Wednesday',
    //         'Kamis' => 'Thursday',
    //         'Jumat' => 'Friday',
    //         'Sabtu' => 'Saturday',
    //         'Minggu' => 'Sunday',
    //     ];

    //     // Pastikan booking hanya bisa dilakukan 1 hari sebelumnya
    //     $scheduleDayEnglish = $daysInEnglish[$appointmentSchedule->appointmentDay] ?? null;
    //     if (!$scheduleDayEnglish) {
    //         return redirect()->back()->withErrors('Hari pada jadwal tidak valid.');
    //     }

    //     // Gunakan Carbon untuk menggabungkan hari dan waktu jadwal
    //     $scheduleDay = Carbon::parse($scheduleDayEnglish)->setTimezone($timezone); // Pastikan timezone disesuaikan
    //     $scheduleStartTime = $scheduleDay->copy()->setTimeFromTimeString($appointmentSchedule->appointmentStart);

    //     // Waktu maksimal booking (1 hari sebelumnya)
    //     $bookingDeadline = $scheduleStartTime->subDay();

    //     // Validasi apakah sudah melewati batas booking
    //     if ($now->greaterThanOrEqualTo($bookingDeadline)) {
    //         return redirect()->back()->withErrors('Booking hanya dapat dilakukan maksimal 1 hari sebelum jadwal.');
    //     }

    //     // Cek queueNumber terbesar berdasarkan appointment_schedule_id pada hari yang sama
    //     $latestQueue = ListClinic::where('appointment_schedules_id', $appointmentSchedule->id)
    //         ->orderBy('queueNumber', 'desc') // Urutkan berdasarkan queueNumber terbesar
    //         ->first();

    //     // Tentukan queueNumber
    //     $queueNumber = $latestQueue ? $latestQueue->queueNumber + 1 : 1;

    //     // Simpan data ke ListClinic
    //     $listClinic = ListClinic::create([
    //         'complaint' => $request->complaint,
    //         'queueNumber' => $queueNumber,
    //         'patients_id' => auth('patient')->id(), // Ambil ID pasien yang login
    //         'appointment_schedules_id' => $appointmentSchedule->id,
    //     ]);

    //     // Redirect dengan pesan sukses
    //     return redirect()->route('examination_patients.index')->with('success', 'Booking berhasil disimpan.');
    // }

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

        $examination = $examination_patient->clinic_examination->first(); // Ambil pertama jika banyak

        // dd($examination_patient);

        return view('pages.patients.examination_patients.detail', compact('examination_patient', 'isExamined', 'examination_details', 'examination'));
    }
}