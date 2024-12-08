@extends('layouts.doctor')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Pemeriksaan Pasien {{ $patient->patientName }}
            </h1>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-body">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Periksa</th>
                            <th>Nama Pasien</th>
                            <th>Nama Dokter</th>
                            <th>Keluhan</th>
                            <th>Catatan</th>
                            <th>Obat</th>
                            <th>Biaya Periksa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1; // Variabel penghitung untuk nomor urut
                        @endphp

                        @foreach ($patient->patient_clinic as $clinic)
                            @foreach ($clinic->clinic_examination as $examination)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $examination->examinationDate }}</td>
                                    <td>{{ $patient->patientName }}</td>
                                    <td>{{ $examination->list_clinic->schedule_appointment->doctor_appointment->doctorName }}
                                    </td>
                                    <td>{{ $clinic->complaint }}</td>
                                    <td>{{ $examination->note }}</td>
                                    <td>
                                        @if ($examination->examination_medicines->isEmpty())
                                            Tidak ada obat
                                        @else
                                            <ul>
                                                @foreach ($examination->examination_medicines as $medicine)
                                                    <li>{{ $medicine->medicineName }} ({{ $medicine->packaging }})</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td>{{ number_format($examination->price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
