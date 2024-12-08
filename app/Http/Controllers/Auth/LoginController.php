<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected function authenticated($request, $user)
    {
        if ($user->roles === 'ADMIN') {
            return redirect('/admin'); // Redirect ke dashboard admin
        } elseif ($user->roles === 'DOCTOR') {
            return redirect('/doctor'); // Redirect ke dashboard doctor
        }

        // Jika role tidak dikenali, arahkan ke halaman default
        return redirect('/');
    }

    public function username()
    {
        return 'username'; // Ganti dengan nama kolom yang digunakan untuk username di tabel users
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/doctor';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
