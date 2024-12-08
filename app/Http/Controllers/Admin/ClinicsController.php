<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClinicsRequest;
use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the search term from the request
        $search = $request->input('search');

        // If there is a search term, filter the payments
        if ($search) {
            $clinics = Clinic::where('clinicName', 'LIKE', '%' . $search . '%')
                ->get();
        } else {
            // If no search term, retrieve all payments
            $clinics = clinic::all();
        }

        return view('pages.admin.clinics.index', [
            'clinics' => $clinics,
            'search' => $search // Pass the search term to the view
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clinics = Clinic::all();
        return view('pages.admin.clinics.create', [
            'clinics' => $clinics
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClinicsRequest $request)
    {
        $data = $request->all(); //berfungsi memanggil semua data form dan memasukan ke variable $data

        Clinic::create($data);

        return redirect()->route('clinics.index');
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
        $item = Clinic::findOrFail($id); //findOrFail berfungsi jika data ada maka dimunculin, jika tidak ada maka akan return 404 atau data tidak ketemu

        return view('pages.admin.clinics.edit', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClinicsRequest $request, $id)
    {
        $data = $request->all();

        $item = Clinic::findOrFail($id);

        $item->update($data);

        return redirect()->route('clinics.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Clinic::findOrFail($id);
        $item->delete();

        return redirect()->route('clinics.index');
    }
}
