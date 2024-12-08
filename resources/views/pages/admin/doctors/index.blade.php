@extends('layouts.admin') {{-- berfungsi utk halaman web yang sedang dibuat akan mengikuti struktur dan tampilan yang sudah ditentukan,
    Dalam konteks ini, layouts.admin mengacu pada file layout yang berada di dalam folder layouts dengan nama file admin.blade.php --}}

@section('content')
    {{-- apapun yang terdapat dalamm section(id) kontennya akan di tampilkan dalam yield(id) sebelumnya --}}

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-0 text-gray-800 mb-4">Data Dokter</h1>

        <div class="d-sm-flex align-items-center justify-content-between">
            <form method="GET" action="{{ route('doctors.index') }}" class="form-inline">
                <input type="text" name="search" class="form-control mr-2" placeholder="Cari Dokter..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>

            <a href="{{ route('doctors.create') }}" class="btn btn-sm btn-primary shadow sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Dokter
            </a>
        </div>

        <div class="row">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Dokter</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th>Poli</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($doctors as $doctor)
                                <tr>
                                    <td>{{ $doctor->id }}</td>
                                    <td>{{ $doctor->doctorName }}</td>
                                    <td>{{ $doctor->address }}</td>
                                    <td>{{ $doctor->phone }}</td>
                                    <td>{{ $doctor->clinic->clinicName }}</td>
                                    <td>
                                        <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-info">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
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
