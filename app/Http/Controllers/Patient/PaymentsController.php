<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\PaymentRequest;
use App\Models\Examination;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil ID pasien yang sedang login
        $patientId = auth('patient')->id();

        // Ambil data ListClinic berdasarkan ID pasien yang sedang login
        $payment_patients = Examination::with(['list_clinic', 'payment_examination'])
            ->whereHas('list_clinic', function ($query) use ($patientId) {
                $query->where('patients_id', $patientId);
            })->get();

        // dd($payment_patients->schedule_clinic, $payment_patients->schedule_appointment);

        return view('pages.patients.payments.index', [
            'payment_patients' => $payment_patients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        // Ambil semua data poli yang ada
        $payments = Examination::findOrFail($id);

        return view('pages.patients.payments.create', compact('payments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $request)
    {
        // Menangkap data dari form
        $data = $request->all();

        // Menyimpan ID examination yang diterima dari form
        $examinationId = $data['examinations_id']; // Pastikan nama sesuai dengan input hidden di form

        // Mendapatkan file gambar dari request
        if ($request->hasFile('imagePayment')) {
            $originalFileName = $request->file('imagePayment')->getClientOriginalName();
            $data['imagePayment'] = $request->file('imagePayment')->storeAs(
                'uploads/imagePayment',
                $originalFileName,
                'public'
            );
        }

        // Simpan data pembayaran termasuk ID pemeriksaan yang sesuai
        $data['examinations_id'] = $examinationId; // Menyimpan ID pemeriksaan yang sesuai

        // Membuat pembayaran baru
        Payment::create($data);

        // Redirect dengan pesan sukses
        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Ambil ID pasien yang sedang login
        $patientId = auth('patient')->id();

        $payment_patients = Examination::with(['list_clinic', 'payment_examination'])
            ->where('id', $id)
            ->whereHas('list_clinic', function ($query) use ($patientId) {
                $query->where('patients_id', $patientId);
            })->firstOrFail();

        // dd($payment_patients);

        return view('pages.patients.payments.detail', compact('payment_patients'));
    }

    public function edit($id)
    {
        // Ambil data pembayaran berdasarkan ID
        $payments = Payment::with(['payment'])->findOrFail($id);

        // $payments = Examination::findOrFail($id);

        // dd($payments);

        // Kirim data pembayaran ke view untuk di-edit
        return view('pages.patients.payments.edit', compact('payments'));
    }
    public function update(PaymentRequest $request, $id)
    {
        // Ambil data pembayaran berdasarkan ID
        $payments = Payment::findOrFail($id);

        // Ambil semua data dari request
        $data = $request->all();

        // Cek jika ada gambar baru yang diupload
        if ($request->hasFile('imagePayment')) {
            // Hapus gambar lama jika ada
            if ($payments->imagePayment && Storage::exists('public/' . $payments->imagePayment)) {
                Storage::delete('public/' . $payments->imagePayment);
            }

            // Simpan gambar baru
            $originalFileName = $request->file('imagePayment')->getClientOriginalName();
            $data['imagePayment'] = $request->file('imagePayment')->storeAs(
                'uploads/imagePayment',  // Direktori tujuan
                $originalFileName,       // Nama asli file
                'public'                 // Disk penyimpanan
            );
        }

        // Perbarui data pembayaran dengan data baru
        $payments->update($data);

        // Redirect dengan pesan sukses
        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil diperbarui.');
    }
}
