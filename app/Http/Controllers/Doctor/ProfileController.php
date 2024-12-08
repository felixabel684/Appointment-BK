<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\ProfileRequest;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan data dokter yang login
        $doctors = auth()->user()->doctor;

        return view('pages.doctors.profile.index', [
            'doctors' => $doctors,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, $redirect)
    {
        // Mendapatkan data dokter yang login
        $doctors = auth()->user()->doctor;

        // Update data user terkait (username dan password jika ada)
        $user = $doctors->user;

        $updateData = [
            'username' => $request->username,
        ];

        // Hanya update password jika field password diisi
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        // Update data dokter
        $doctors->update($request->only('doctorName', 'address', 'phone'));

        return redirect()->route($redirect);
    }
}
