@extends('layouts.admin') {{-- berfungsi utk halaman web yang sedang dibuat akan mengikuti struktur dan tampilan yang sudah ditentukan,
    Dalam konteks ini, layouts.admin mengacu pada file layout yang berada di dalam folder layouts dengan nama file admin.blade.php --}}

@section('content')
    {{-- apapun yang terdapat dalamm section(id) kontennya akan di tampilkan dalam yield(id) sebelumnya --}}
    
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Data Dokter</h1>
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
                <form action="{{ route('doctors.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Username"
                            value="{{ old('username') }}"> {{-- fungsi old berfungsi ketika user mungkin salah input data dan ternyata input error maka data tidak akan hilang --}}
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password"
                            value="{{ old('password') }}"> {{-- fungsi old berfungsi ketika user mungkin salah input data dan ternyata input error maka data tidak akan hilang --}}
                    </div>

                    <div class="form-group">
                        <label for="clinics_id">Nama Poli</label>
                        <select name="clinics_id" required class="form-control">
                            <option value="">Pilih Poli</option>
                            @foreach ($clinics as $clinic )
                                <option value="{{ $clinic->id }}">
                                    {{ $clinic->clinicName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="doctorName">Nama Dokter</label>
                        <input type="text" class="form-control" name="doctorName" placeholder="Nama Dokter"
                            value="{{ old('doctorName') }}"> {{-- fungsi old berfungsi ketika user mungkin salah input data dan ternyata input error maka data tidak akan hilang --}}
                    </div>

                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea name="address" rows="5" class="d-block w-100 form-control">{{ old('address') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="phone">No HP</label>
                        <input type="text" class="form-control" name="phone" placeholder="No HP"
                            value="{{ old('phone') }}">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Save
                    </button>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
