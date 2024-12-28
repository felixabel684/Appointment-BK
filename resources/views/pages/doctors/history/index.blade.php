@extends('layouts.doctor') {{-- berfungsi utk halaman web yang sedang dibuat akan mengikuti struktur dan tampilan yang sudah ditentukan,
    Dalam konteks ini, layouts.admin mengacu pada file layout yang berada di dalam folder layouts dengan nama file admin.blade.php --}}

@section('content')
    {{-- apapun yang terdapat dalamm section(id) kontennya akan di tampilkan dalam yield(id) sebelumnya --}}

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Riwayat Pasien</h1>

            <form action="{{ route('history.index') }}" method="GET" class="form-inline my-2 my-lg-0">
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
                                <th>NIK</th>
                                <th>Nama Pasien</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th>No RM</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($patients as $patient)
                                <tr>
                                    <td>{{ $patient->id }}</td>
                                    <td>{{ $patient->nik }}</td>
                                    <td>{{ $patient->patientName }}</td>
                                    <td>{{ $patient->address }}</td>
                                    <td>{{ $patient->phone }}</td>
                                    <td>{{ $patient->rmNumber }}</td>
                                    <td>
                                        @php
                                            // Periksa apakah ada setidaknya satu pemeriksaan yang sudah diperiksa
                                            $hasExamined = $patient->patient_clinic->contains(function (
                                                $patient_clinic,
                                            ) {
                                                return $patient_clinic->isExamined();
                                            });
                                        @endphp

                                        @if ($hasExamined)
                                            <a href="{{ route('history.show', $patient->id) }}" class="btn btn-primary">
                                                <i class="fa fa-eye"> Detail Periksa</i>
                                            </a>
                                        @else
                                            <span class="text-danger">Belum Diperiksa</span>
                                        @endif
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
