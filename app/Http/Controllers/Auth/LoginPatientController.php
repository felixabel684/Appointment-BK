<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginPatientController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/patient'; // Sesuaikan dengan rute setelah login

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.patient-login'); // Buat form login untuk pasien
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required', // NIK atau Nomor RM
        ]);

        $patient = Patient::where('nik', $request->identifier)
            ->orWhere('rmNumber', $request->identifier)
            ->first();

        if ($patient) {
            Auth::guard('patient')->login($patient);

            // Redirect ke dashboard pasien
            return redirect()->route('dashboard-patient');
        }

        return back()->withErrors(['identifier' => 'Invalid credentials.']);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        auth()->guard('patient')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login-patient'); // Redirect ke halaman login pasien
    }
}