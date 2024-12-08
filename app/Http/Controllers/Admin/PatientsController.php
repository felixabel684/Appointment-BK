<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PatientsRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::all(); //karena akan mengambil semua data travel package

        return view('pages.admin.patients.index', [
            'patients' => $patients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil tahun dan bulan saat ini
        $yearMonth = Carbon::now()->format('Ym'); // format: 202411

        // Ambil jumlah pasien yang terdaftar untuk bulan tersebut
        $patientCount = Patient::where('rmNumber', 'like', $yearMonth . '%')->count();

        // Generate No RM dengan format tahun-bulan-urutan
        $newRmNumber = $yearMonth . '-' . str_pad($patientCount + 1, 3, '0', STR_PAD_LEFT);

        return view('pages.admin.patients.create', compact('newRmNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientsRequest $request)
    {
        $data = $request->all(); //berfungsi memanggil semua data form dan memasukan ke variable $data

        Patient::create($data);

        return redirect()->route('patients.index');
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
        $item = Patient::findOrFail($id); //findOrFail berfungsi jika data ada maka dimunculin, jika tidak ada maka akan return 404 atau data tidak ketemu

        return view('pages.admin.patients.edit', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientsRequest $request, $id)
    {
        $data = $request->all();

        $item = Patient::findOrFail($id);

        $item->update($data);

        return redirect()->route('patients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Patient::findOrFail($id);
        $item->delete();

        return redirect()->route('patients.index');
    }
}
