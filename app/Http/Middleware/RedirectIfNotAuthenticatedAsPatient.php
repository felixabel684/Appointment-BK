<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthenticatedAsPatient
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('patient')->check()) {
            return redirect()->route('patient.login.form'); // Redirect ke form login pasien
        }

        return $next($request);
    }
}
