@extends('layouts.patient') {{-- berfungsi utk halaman web yang sedang dibuat akan mengikuti struktur dan tampilan yang sudah ditentukan,
    Dalam konteks ini, layouts.admin mengacu pada file layout yang berada di dalam folder layouts dengan nama file admin.blade.php --}}

@section('content')
    {{-- apapun yang terdapat dalamm section(id) kontennya akan di tampilkan dalam yield(id) sebelumnya --}}

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Periksa</h1>
            <a href="{{ route('examination_patients.create') }}" class="btn btn-sm btn-primary shadow sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Booking Pemeriksaan
            </a>
            {{-- <form method="GET" action="{{ route('examinations.index') }}" class="form-inline">
                <input type="text" name="search" class="form-control mr-2" placeholder="Cari..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form> --}}
        </div>

        <!-- Alert Pesan -->
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Poli</th>
                                <th>Dokter</th>
                                <th>Hari</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Antrian</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1; // Variabel penghitung untuk nomor urut
                            @endphp

                            @forelse ($examination_patients as $examination_patient)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $examination_patient->schedule_appointment->doctor_appointment->clinic->clinicName }}
                                    </td>
                                    <td>{{ $examination_patient->schedule_appointment->doctor_appointment->doctorName }}
                                    </td>
                                    <td>{{ $examination_patient->schedule_appointment->appointmentDay }}</td>
                                    <td>{{ $examination_patient->schedule_appointment->appointmentStart }}</td>
                                    <td>{{ $examination_patient->schedule_appointment->appointmentEnd }}</td>
                                    <td>{{ $examination_patient->queueNumber }}</td>
                                    <td>
                                        @if ($examination_patient->isExamined())
                                            <span class="badge badge-success">Sudah Periksa</span>
                                        @else
                                            <span class="badge badge-danger">Belum Periksa</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('examination_patients.show', $examination_patient->id) }}"
                                            class="btn btn-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Data Kosong</td>
                                </tr>
                            @endforelse
                            {{-- @foreach ($examination_patients as $examination_patient)
                                @php
                                    dd($examination_patient->schedule_clinic);
                                @endphp
                            @endforeach --}}

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
