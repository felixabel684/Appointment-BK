<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Examination;
use App\Models\ListClinic;
use App\Models\Medicine;
use Illuminate\Http\Request;

class ExaminationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil ID dokter yang sedang login
        $doctorId = auth()->user()->doctor->id; // Sesuaikan jika ada relasi dokter

        // Ambil kata kunci pencarian dari request
        $search = $request->input('search');

        // Jika ada kata kunci pencarian, filter data berdasarkan pencarian dan ID dokter
        if ($search) {
            $examinations = ListClinic::with(['clinic_examination', 'patient', 'schedule_appointment'])
                ->whereHas('schedule_appointment', function ($query) use ($doctorId) {
                    $query->where('doctors_id', $doctorId); // Filter berdasarkan dokter yang sedang login
                })
                // Pencarian berdasarkan keluhan atau nama pasien
                ->where(function ($query) use ($search) {
                    $query->whereHas('clinic_examination', function ($query) use ($search) {
                        $query->where('complaint', 'LIKE', '%' . $search . '%');
                    })
                        ->orWhereHas('patient', function ($query) use ($search) {
                            $query->where('patientName', 'LIKE', '%' . $search . '%');
                        });
                })
                ->get();
        } else {
            $examinations = ListClinic::with(['clinic_examination', 'patient', 'schedule_appointment'])
                ->whereHas('schedule_appointment', function ($query) use ($doctorId) {
                    $query->where('doctors_id', $doctorId); // Filter berdasarkan dokter yang sedang login
                })
                ->get();
        }

        // dd($examinations);

        return view('pages.doctors.examinations.index', [
            'examinations' => $examinations,
            'search' => $search // Pass kata kunci pencarian ke view
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $id)
    {
        // Fetch patient data
        $examinations = ListClinic::with('patient')->findOrFail($id);

        // Fetch medicines
        $medicines = Medicine::all();

        return view('pages.doctors.examinations.create', compact('examinations', 'medicines'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $medicines = Medicine::where('medicineName', 'like', "%$query%")
            ->orWhere('packaging', 'like', "%$query%")
            ->select('id', 'medicineName', 'packaging', 'price')
            ->limit(10)
            ->get();

        return response()->json($medicines);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'list_clinics_id' => 'required|exists:list_clinics,id', // Pastikan list_clinics_id wajib ada dan valid
            'examinationDate' => 'required|date',
            'note' => 'nullable|string',
            'medicines' => 'required|array', // Wajib array
            'medicines.*' => 'exists:medicines,id', // Validasi bahwa setiap ID obat ada di tabel medicines
        ]);

        // Simpan data ke tabel examinations
        $examination = Examination::create([
            'list_clinics_id' => $request->input('list_clinics_id'),
            'examinationDate' => $request->input('examinationDate'),
            'note' => $request->input('note'),
            'price' => str_replace(',', '', $request->input('price')), // Menghapus format angka pada harga
        ]);

        // Simpan data ke tabel pivot (examination_details)
        $medicines = $request->input('medicines'); // Ambil array ID obat dari form
        foreach ($medicines as $medicineId) {
            $examination->examination_medicines()->attach($medicineId);
        }

        // Redirect dengan pesan sukses
        return redirect()->route('examinations.index')->with('success', 'Data pemeriksaan berhasil disimpan.');
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
        // Ambil data examination berdasarkan id yang diminta
        $examinations = Examination::with(['examination_medicines', 'list_clinic.patient'])->findOrFail($id);

        // Ambil data pasien melalui relasi listClinic
        $examinations_patient = $examinations->list_clinic;

        // Kembalikan ke view
        return view('pages.doctors.examinations.edit', compact('examinations', 'examinations_patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'examinationDate' => 'required|date',
            'note' => 'nullable|string',
            'list_clinics_id' => 'required|exists:list_clinics,id', // Validasi untuk list_clinics_id
            'medicines' => 'nullable|array',
            'medicines.*' => 'exists:medicines,id', // Validasi bahwa ID obat ada di database
        ]);

        // Temukan pemeriksaan yang akan diupdate
        $examination = Examination::findOrFail($id);

        // Update data pemeriksaan
        $examination->examinationDate = $request->input('examinationDate');
        $examination->note = $request->input('note');
        $examination->list_clinics_id = $request->input('list_clinics_id'); // Mengupdate list_clinics_id
        $examination->price = floatval(str_replace(',', '', $request->input('price'))); // Menyimpan harga baru jika diperlukan
        $examination->save();

        // Mengupdate hubungan many-to-many dengan obat-obatan
        if ($request->has('medicines')) {
            $examination->examination_medicines()->sync($request->input('medicines'));
        }

        // dd($request->all());

        // Redirect kembali ke halaman daftar pemeriksaan dengan pesan sukses
        return redirect()->route('examinations.index')->with('success', 'Pemeriksaan berhasil diupdate.');
    }
}
