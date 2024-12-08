@extends('layouts.doctor') {{-- berfungsi utk halaman web yang sedang dibuat akan mengikuti struktur dan tampilan yang sudah ditentukan,
    Dalam konteks ini, layouts.admin mengacu pada file layout yang berada di dalam folder layouts dengan nama file admin.blade.php --}}

@section('content')
    {{-- apapun yang terdapat dalamm section(id) kontennya akan di tampilkan dalam yield(id) sebelumnya --}}

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Update Profile</h1>
        </div>

        @if ($errors->any()) {{--jika ada permasalahan atau error maka akan munculin div error di bawah --}}
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
                <form action="{{ route('profile.update', 'profile.index') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Username"
                            value="{{ $doctors->user->username }}">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>

                    <div class="form-group">
                        <label for="doctorName">Nama Dokter</label>
                        <input type="text" class="form-control" name="doctorName" placeholder="Nama Dokter"
                            value="{{ $doctors->doctorName }}">
                    </div>

                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea class="form-control" name="address" placeholder="Alamat" rows="5">{{ $doctors->address }}
                                </textarea>
                    </div>

                    <div class="form-group">
                        <label for="phone">No HP</label>
                        <input type="text" class="form-control" name="phone" placeholder="No HP"
                            value="{{ $doctors->phone }}">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Update Profile
                    </button>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
