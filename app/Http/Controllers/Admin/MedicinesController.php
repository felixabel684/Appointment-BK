<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MedicinesRequest; // akan menggunakan request dari TransactionRequest yang telah dibuat
use App\Models\Medicine;
use Illuminate\Http\Request;

use Illuminate\Support\Str; //memakai library atau fungsi string dari laravel

class MedicinesController extends Controller
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
            $medicines = Medicine::where('medicineName', 'LIKE', '%' . $search . '%')
                ->orWhere('packaging', 'LIKE', '%' . $search . '%')
                ->get();
        } else {
            // If no search term, retrieve all payments
            $medicines = Medicine::all();
        }

        return view('pages.admin.medicines.index', [
            'medicines' => $medicines,
            'search' => $search // Pass the search term to the view
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicines = Medicine::all();
        return view('pages.admin.medicines.create', [
            'medicines' => $medicines
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicinesRequest $request)
    {
        $data = $request->all(); //berfungsi memanggil semua data form dan memasukan ke variable $data

        Medicine::create($data);
        return redirect()->route('medicines.index');
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
        $item = Medicine::findOrFail($id); //findOrFail berfungsi jika data ada maka dimunculin, jika tidak ada maka akan return 404 atau data tidak ketemu

        return view('pages.admin.medicines.edit', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicinesRequest $request, $id)
    {
        $data = $request->all();

        $item = Medicine::findOrFail($id);

        $item->update($data);

        return redirect()->route('medicines.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Medicine::findOrFail($id);
        $item->delete();

        return redirect()->route('medicines.index');
    }
}
