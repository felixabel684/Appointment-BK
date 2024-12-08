<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class RegisterPatientController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/patient'; // Sesuaikan rute setelah registrasi berhasil

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nik' => ['required', 'digits:16', 'unique:patients,nik'], // NIK harus unik dan 16 digit
            'patientName' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
        ]);
    }

    /**
     * Create a new patient instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Patient
     */
    protected function create(array $data)
    {
        // Ambil tahun dan bulan saat ini
        $yearMonth = Carbon::now()->format('Ym'); // format: 202411

        // Ambil jumlah pasien yang terdaftar untuk bulan tersebut
        $patientCount = Patient::where('rmNumber', 'like', $yearMonth . '%')->count();

        // Generate No RM dengan format tahun-bulan-urutan
        $newRmNumber = $yearMonth . '-' . str_pad($patientCount + 1, 3, '0', STR_PAD_LEFT);

        return Patient::create([
            'nik' => $data['nik'],
            'patientName' => $data['patientName'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'rmNumber' => $newRmNumber,
        ]);
    }

    /**
     * Show the registration form for patients.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.patient-register');
    }
}