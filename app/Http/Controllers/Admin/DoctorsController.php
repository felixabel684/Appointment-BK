<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class DoctorsController extends Controller
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
            $doctors = Doctor::with(['clinic'])
            ->whereHas('clinic', function ($query) use ($search) {
                $query->where('clinicName', 'LIKE', '%' . $search . '%');
            })
                ->orWhere('doctorName', 'LIKE', '%' . $search . '%')
                ->get();
        } else {
            // If no search term, retrieve all Doctor
            $doctors = Doctor::with(['clinic'])->get();
        }

        return view('pages.admin.doctors.index', [
            'doctors' => $doctors,
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
        $clinics = Clinic::all();
        return view('pages.admin.doctors.create', [
            'clinics' => $clinics
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
            'doctorName' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'clinics_id' => 'required|integer|exists:clinics,id',
        ]);

        // Tambahkan data ke tabel users
        $user = User::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'roles' => 'DOCTOR', // Set role sebagai dokter
        ]);

        // Tambahkan data ke tabel dokters
        Doctor::create([
            'users_id' => $user->id,
            'clinics_id' => $validated['clinics_id'],
            'doctorName' => $validated['doctorName'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
        ]);

        return redirect()->route('doctors.index');
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
        $doctors = Doctor::findOrFail($id);
        $clinics = Clinic::all();

        return view('pages.admin.doctors.edit', [
            'doctors' => $doctors,
            'clinics' => $clinics
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'doctorName' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $data = $request->all();

        $item = Doctor::findOrFail($id);

        $item->update($data);

        return redirect()->route('doctors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Doctor::findOrFail($id);
        $item->delete();

        return redirect()->route('doctors.index');
    }
}
