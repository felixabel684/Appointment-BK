@extends('layouts.admin') {{-- berfungsi utk halaman web yang sedang dibuat akan mengikuti struktur dan tampilan yang sudah ditentukan,
    Dalam konteks ini, layouts.admin mengacu pada file layout yang berada di dalam folder layouts dengan nama file admin.blade.php --}}

@section('content')
    {{-- apapun yang terdapat dalamm section(id) kontennya akan di tampilkan dalam yield(id) sebelumnya --}}

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Riwayat Janji Temu</h1>

            <form action="{{ route('examinations_admin.index') }}" method="GET" class="form-inline my-2 my-lg-0">
                <input type="text" name="search" class="form-control mr-sm-2" placeholder="Cari Pasien..."
                    aria-label="Search">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>

        <div class="row">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No RM</th>
                                <th>Nama Pasien</th>
                                <th>Nama Dokter</th>
                                <th>Tanggal Temu</th>
                                <th>Poli</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @forelse ($examination_admin as $examination)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $examination->patient->rmNumber }}</td>
                                    <td>{{ $examination->patient->patientName }}</td>
                                    <td>{{ $examination->schedule_appointment->doctor_appointment->doctorName }}</td>
                                    <td>{{ $examination->schedule_appointment->appointmentDate }}</td>
                                    <td>{{ $examination->schedule_appointment->doctor_appointment->clinic->clinicName }}</td>
                                    <td>
                                        @if ($examination->isExamined())
                                            <span class="badge badge-success">Sudah Periksa</span>
                                        @else
                                            <span class="badge badge-danger">Belum Periksa</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('examinations_admin.show', $examination->id) }}" class="btn btn-primary">
                                            <i class="fa fa-eye"> Detail Periksa</i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Data Kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
