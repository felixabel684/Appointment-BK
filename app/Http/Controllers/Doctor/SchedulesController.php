<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\SchedulesRequest;
use App\Models\AppointmentSchedule;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil ID dokter yang sedang login
        $doctorId = auth()->user()->doctor->id; // Asumsi: 'doctor' adalah relasi pada model 'User' yang mengarah ke model 'Doctor'

        // Ambil jadwal dokter yang sedang login
        $schedules = AppointmentSchedule::with(['doctor_appointment'])  // Menggunakan relasi 'doctor_appointment' jika ada
            ->where('doctors_id', $doctorId)  // Filter berdasarkan ID dokter yang sedang login
            ->get();

        return view('pages.doctors.schedules.index', [
            'schedules' => $schedules,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = Doctor::all();
        return view('pages.doctors.schedules.create', [
            'doctors' => $doctors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchedulesRequest $request)
    {
        // Ambil data dokter yang sedang login
        $doctor = auth()->user()->doctor;

        // Ambil hari ini dalam bahasa Inggris
        $today = Carbon::now()->locale('en')->format('l'); // Format: Monday, Tuesday, Wednesday, dll.

        // Konversi hari perangkat (dalam bahasa Inggris) menjadi bahasa Indonesia
        $daysInIndonesian = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        $todayInIndonesian = $daysInIndonesian[$today];

        // Tentukan hari yang digunakan di form (hari dalam format bahasa Indonesia atau bahasa Inggris)
        $appointmentDay = $request->appointmentDay;

        // Cek apakah ada penambahan hari yang sama, dokter hanya boleh memiliki 1 jadwal di hari yang sama
        $overlap = AppointmentSchedule::where('doctors_id', $doctor->id)
            ->where('appointmentDay', $appointmentDay) // Menggunakan appointmentDay yang berupa string
            ->exists();

        // Jika ada jadwal aktif pada hari yang sama, kirim pesan error
        if ($overlap) {
            return back()->withErrors(['appointmentDay' => 'Dalam 1 hari hanya boleh ada 1 jadwal']);
        }

        // Cek apakah hari yang dipilih sama dengan hari ini dalam bahasa Indonesia atau bahasa Inggris
        if (strtolower($appointmentDay) == strtolower($todayInIndonesian) || strtolower($appointmentDay) == strtolower($today)) {
            // Jika ada jadwal aktif pada hari yang sama, maka tidak bisa menambahkan jadwal baru
            $overlap = AppointmentSchedule::where('doctors_id', $doctor->id)
                ->where('appointmentDay', $appointmentDay) // Menggunakan appointmentDay yang berupa string
                ->where('appointmentStatus', 'ACTIVE') // Hanya jadwal aktif
                ->exists();

            // Jika ada jadwal aktif pada hari yang sama, kirim pesan error
            if ($overlap) {
                return back()->withErrors(['appointmentDay' => 'Anda tidak bisa menambahkan jadwal pada hari H yang sudah ada jadwal aktif.']);
            }

            // Ambil waktu saat ini
            $currentTime = Carbon::now();

            // Cek apakah waktu mulai yang diberikan minimal 1,5 jam dari waktu sekarang hanya jika untuk hari ini
            $appointmentStart = Carbon::parse($request->appointmentStart);

            // Hitung waktu minimum yang diizinkan untuk waktu mulai
            $minimumStartTime = $currentTime->copy()->addHours(1)->addMinutes(30); // Waktu saat ini + 1,5 jam

            // Cek apakah waktu mulai lebih awal dari waktu minimum
            if ($appointmentStart->lt($minimumStartTime)) {
                return back()->withErrors(['appointmentStart' => 'Waktu mulai harus minimal 1,5 jam dari waktu terkini.']);
            }
        }

        // Cek apakah ada jadwal aktif yang bentrok dengan jadwal yang baru **hanya pada hari yang sama**
        $overlap = AppointmentSchedule::where('doctors_id', $doctor->id)
            ->where('appointmentDay', $appointmentDay) // Menggunakan appointmentDay yang berupa string
            ->where('appointmentStatus', 'ACTIVE') // Hanya jadwal aktif
            ->where(function ($query) use ($request) {
                // Mengecek waktu tumpang tindih
                $query->whereBetween('appointmentStart', [$request->appointmentStart, $request->appointmentEnd])
                    ->orWhereBetween('appointmentEnd', [$request->appointmentStart, $request->appointmentEnd])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('appointmentStart', '<=', $request->appointmentStart)
                            ->where('appointmentEnd', '>=', $request->appointmentEnd);
                    });
            })
            ->exists();

        // Jika ada bentrok jadwal pada hari yang sama
        if ($overlap) {
            return back()->withErrors(['appointmentStart' => 'Jadwal ini bentrok dengan jadwal lain yang aktif pada hari yang sama.']);
        }

        // Cek jadwal aktif sebelumnya dan nonaktifkan jika ada
        $activeSchedule = AppointmentSchedule::where('doctors_id', $doctor->id)
            ->where('appointmentStatus', 'ACTIVE')
            ->first(); // Ambil jadwal aktif pertama

        if ($activeSchedule) {
            // dd($activeSchedule); // Debug data jadwal aktif sebelum diubah
            $activeSchedule->appointmentStatus = 'INACTIVE';
            $activeSchedule->save();
        } else {
            // dd('No active schedule found'); // Debug jika tidak ada jadwal aktif
        }

        // Ambil data dari request dan tambahkan doctors_id serta set status ACTIVE
        $data = $request->all();
        $data['doctors_id'] = $doctor->id;
        $data['appointmentStatus'] = 'ACTIVE';

        // Simpan ke database
        AppointmentSchedule::create($data);

        return redirect()->route('schedules.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $schedules = AppointmentSchedule::findOrFail($id);

        return view('pages.doctors.schedules.edit', [
            'schedules' => $schedules,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SchedulesRequest $request, $id)
    {
        $data = $request->all();

        // Temukan jadwal yang sedang diupdate
        $item = AppointmentSchedule::findOrFail($id);

        // Ambil hari ini (hari H) menggunakan Carbon dalam bahasa Inggris
        $today = Carbon::now()->locale('en')->format('l'); // Format: Monday, Tuesday, Wednesday, dll.

        // Konversi hari perangkat (dalam bahasa Inggris) menjadi bahasa Indonesia
        $daysInIndonesian = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        $todayInIndonesian = $daysInIndonesian[$today];

        // Logika untuk memeriksa jika hari ini adalah hari yang sama dengan jadwal yang sedang diupdate
        if (strtolower($item->appointmentDay) == strtolower($todayInIndonesian)) {
            // Jika hari jadwal sama dengan hari ini, tidak boleh diubah harinya dan waktunya
            if (
                strtolower($data['appointmentDay']) != strtolower($item->appointmentDay) ||
                $data['appointmentStart'] != $item->appointmentStart ||
                $data['appointmentEnd'] != $item->appointmentEnd
            ) {
                return back()->withErrors([
                    'appointmentDay' => 'Hari dan waktu jadwal yang sama dengan hari ini tidak dapat diubah.',
                ]);
            }
        }

        // Logika untuk memeriksa jika hari ini adalah hari yang sama dengan yang ingin diubah
        if (strtolower($data['appointmentDay']) == strtolower($todayInIndonesian)) {
            // Ambil waktu sekarang
            $now = Carbon::now();

            // Konversi waktu mulai jadwal ke objek Carbon
            $appointmentStart = Carbon::parse($data['appointmentStart']);

            // Jika statusnya aktif dan diubah menjadi nonaktif, maka tidak diizinkan
            if ($item->appointmentStatus == 'ACTIVE' && $data['appointmentStatus'] != 'ACTIVE') {
                return back()->withErrors(['appointmentStatus' => 'Jadwal aktif pada hari ini tidak dapat diubah menjadi nonaktif.']);
            }

            // Periksa apakah waktu mulai lebih dari 5 jam dari waktu sekarang
            if ($data['appointmentStatus'] == 'ACTIVE') {
                $allowedTime = $now->addHours(5); // Tambahkan 3 jam ke waktu sekarang

                if ($appointmentStart <= $allowedTime) { // Bandingkan waktu mulai jadwal dengan batas waktu
                    return back()->withErrors(['appointmentStart' => 'Jadwal hanya dapat diaktifkan jika waktu mulai lebih dari 3 jam dari sekarang.']);
                }
            }
        }

        // Validasi bentrokan jika hari berubah
        // Jika hari berubah (appointmentDay baru), pastikan tidak ada jadwal aktif yang bentrok di hari tersebut
        if ($data['appointmentDay'] != $item->appointmentDay) {
            // Cek jika ada jadwal aktif di hari baru yang bentrok dengan waktu yang baru
            $activeSchedule = AppointmentSchedule::where('doctors_id', $item->doctors_id)
                ->where('appointmentStatus', 'ACTIVE')
                ->where('appointmentDay', $data['appointmentDay'])  // Hari baru yang dipilih
                ->where(function ($query) use ($data) {
                    // Mengecek apakah jadwal baru tumpang tindih dengan jadwal yang ada
                    $query->whereBetween('appointmentStart', [$data['appointmentStart'], $data['appointmentEnd']])
                        ->orWhereBetween('appointmentEnd', [$data['appointmentStart'], $data['appointmentEnd']])
                        ->orWhere(function ($query) use ($data) {
                            $query->where('appointmentStart', '<=', $data['appointmentStart'])
                                ->where('appointmentEnd', '>=', $data['appointmentEnd']);
                        });
                })
                ->exists();

            // Jika ada jadwal aktif yang bentrok, kirim pesan error
            if ($activeSchedule) {
                return back()->withErrors(['appointmentStart' => 'Jadwal ini bentrok dengan jadwal lain pada hari yang sama.']);
            }
        }

        // Jika statusnya ingin diubah menjadi ACTIVE pada hari yang sama
        if ($data['appointmentStatus'] == 'ACTIVE' && $data['appointmentDay'] == $item->appointmentDay) {
            // Cek jadwal aktif lain yang ada di hari yang sama dan waktu yang bentrok
            $activeSchedule = AppointmentSchedule::where('doctors_id', $item->doctors_id)
                ->where('appointmentStatus', 'ACTIVE')
                ->where('appointmentDay', $data['appointmentDay'])  // Pastikan hanya di hari yang sama
                ->where('id', '!=', $item->id)  // Pastikan tidak memeriksa jadwal yang sedang diupdate
                ->where(function ($query) use ($data) {
                    // Mengecek apakah jadwal baru tumpang tindih dengan jadwal yang ada
                    $query->whereBetween('appointmentStart', [$data['appointmentStart'], $data['appointmentEnd']])
                        ->orWhereBetween('appointmentEnd', [$data['appointmentStart'], $data['appointmentEnd']])
                        ->orWhere(function ($query) use ($data) {
                            $query->where('appointmentStart', '<=', $data['appointmentStart'])
                                ->where('appointmentEnd', '>=', $data['appointmentEnd']);
                        });
                })
                ->exists();

            // Jika ada jadwal aktif yang bentrok, kirim pesan error
            if ($activeSchedule) {
                return back()->withErrors(['appointmentStart' => 'Jadwal ini bentrok dengan jadwal lain pada hari yang sama.']);
            }

            // Nonaktifkan jadwal aktif lainnya jika ada dan hanya jika hari yang sama
            $previousActiveSchedule = AppointmentSchedule::where('doctors_id', $item->doctors_id)
                ->where('appointmentStatus', 'ACTIVE')
                // ->where('appointmentDay', $data['appointmentDay'])
                ->where('id', '!=', $item->id)  // Pastikan tidak memeriksa jadwal yang sedang diupdate
                ->first();
            if ($previousActiveSchedule) {
                $previousActiveSchedule->update(['appointmentStatus' => 'INACTIVE']);
            }
        }

        // Update jadwal yang sedang diupdate
        $item->update($data);

        return redirect()->route('schedules.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $item = AppointmentSchedule::findOrFail($id);
        // $item->delete();

        // return redirect()->route('schedules.index');
    }
}
