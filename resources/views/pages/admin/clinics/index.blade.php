@extends('layouts.admin')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-0 text-gray-800 mb-4">Data Poli</h1>

        <div class="d-sm-flex align-items-center justify-content-between">
            <form action="{{ route('clinics.index') }}" method="GET" class="form-inline my-2 my-lg-0">
                <input type="text" name="search" class="form-control mr-sm-2" placeholder="Cari Poli..."
                    aria-label="Search">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>

            <a href="{{ route('clinics.create') }}" class="btn btn-sm btn-primary shadow sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Poli
            </a>
        </div>

        <div class="row">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Poli</th>
                                <th>Deskripsi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clinics as $clinic)
                                <tr>
                                    <td>{{ $clinic->id }}</td>
                                    <td>{{ $clinic->clinicName }}</td>
                                    <td>{{ $clinic->description }}</td>
                                    <td>
                                        <a href="{{ route('clinics.edit', $clinic->id) }}" class="btn btn-info">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('clinics.destroy', $clinic->id) }}" method="POST"
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
