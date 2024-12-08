@extends('layouts.doctor') {{-- berfungsi utk halaman web yang sedang dibuat akan mengikuti struktur dan tampilan yang sudah ditentukan,
    Dalam konteks ini, layouts.admin mengacu pada file layout yang berada di dalam folder layouts dengan nama file admin.blade.php --}}

@section('content')
    {{-- apapun yang terdapat dalamm section(id) kontennya akan di tampilkan dalam yield(id) sebelumnya --}}

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Periksa Pasien</h1>
            <form action="{{ route('examinations.index') }}" method="GET" class="form-inline my-2 my-lg-0">
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
                                {{-- <th>No</th> --}}
                                <th>No Urut</th>
                                <th>Nama Pasien</th>
                                <th>Keluhan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($examinations as $examination)
                                <tr>
                                    {{-- <td>{{ $examination->id }}</td> --}}
                                    <td>{{ $examination->queueNumber }}</td>
                                    <td>{{ $examination->patient->patientName }}</td>
                                    <td>{{ $examination->complaint }}</td>
                                    <td>
                                        @php
                                            // Memeriksa apakah pasien sudah memiliki relasi pemeriksaan di clinic_patients
                                            $hasChecked = $examination->clinic_examination()->first(); // Memeriksa apakah ada relasi
                                            // dd($hasChecked->id);
                                        @endphp

                                        

                                        @if ($hasChecked)
                                            <!-- Jika pasien sudah diperiksa, tampilkan tombol edit -->
                                            <a href="{{ route('examinations.edit', ['id' => $hasChecked->id]) }}"
                                                class="btn btn-warning">
                                                <i class="fa fa-pencil-alt"> Edit</i>
                                            </a>
                                        @else
                                            <!-- Jika pasien belum diperiksa, tampilkan tombol periksa -->
                                            <a href="{{ route('examinations.create', ['id' => $examination->id]) }}"
                                                class="btn btn-info">
                                                <i class="fas fa-stethoscope"> Periksa</i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Data Kosong</td>
                                </tr>
                            @endforelse

                            {{-- @foreach ($examinations as $examination)
                                @php
                                    dd($examination->clinic_patients);
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
