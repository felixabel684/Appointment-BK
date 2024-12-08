@extends('layouts.admin') {{-- berfungsi utk halaman web yang sedang dibuat akan mengikuti struktur dan tampilan yang sudah ditentukan,
    Dalam konteks ini, layouts.admin mengacu pada file layout yang berada di dalam folder layouts dengan nama file admin.blade.php --}}

@section('content')
    {{-- apapun yang terdapat dalamm section(id) kontennya akan di tampilkan dalam yield(id) sebelumnya --}}

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Pasien {{ $item->patientName }}</h1>
        </div>

        @if ($errors->any())
            {{-- jika ada permasalahan atau error maka akan munculin div error di bawah --}}
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
                <form action="{{ route('patients.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" name="nik" placeholder="NIK"
                            value="{{ $item->nik }}">
                    </div>

                    <div class="form-group">
                        <label for="patientName">Nama Pasien</label>
                        <input type="text" class="form-control" name="patientName" placeholder="Nama Pasien"
                            value="{{ $item->patientName }}">
                    </div>

                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea class="form-control" name="address" placeholder="Alamat" rows="5">{{ $item->address }}
                                </textarea>
                    </div>

                    <div class="form-group">
                        <label for="phone">No Telepon</label>
                        <input type="text" class="form-control" name="phone" placeholder="No Telepon"
                            value="{{ $item->phone }}">
                    </div>

                    <div class="form-group">
                        <label for="rmNumber">No RM</label>
                        <input type="text" class="form-control" name="rmNumber" placeholder="No RM"
                            value="{{ $item->rmNumber }}" disabled>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Edit
                    </button>
                </form>

            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
