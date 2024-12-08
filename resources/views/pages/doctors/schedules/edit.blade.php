@extends('layouts.doctor') {{-- berfungsi utk halaman web yang sedang dibuat akan mengikuti struktur dan tampilan yang sudah ditentukan,
    Dalam konteks ini, layouts.admin mengacu pada file layout yang berada di dalam folder layouts dengan nama file admin.blade.php --}}

@section('content')
    {{-- apapun yang terdapat dalamm section(id) kontennya akan di tampilkan dalam yield(id) sebelumnya --}}

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Jadwal {{ $schedules->doctor_appointment->doctorName }}</h1>
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
                <form action="{{ route('schedules.update', $schedules->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="form-group">
                        <label for="appointmentDay">Hari Jadwal</label>
                        <select class="form-control" name="appointmentDay">
                            <option value="Senin"
                                {{ old('appointmentDay', $schedules->appointmentDay) == 'Senin' ? 'selected' : '' }}>Senin
                            </option>
                            <option value="Selasa"
                                {{ old('appointmentDay', $schedules->appointmentDay) == 'Selasa' ? 'selected' : '' }}>Selasa
                            </option>
                            <option value="Rabu"
                                {{ old('appointmentDay', $schedules->appointmentDay) == 'Rabu' ? 'selected' : '' }}>Rabu
                            </option>
                            <option value="Kamis"
                                {{ old('appointmentDay', $schedules->appointmentDay) == 'Kamis' ? 'selected' : '' }}>Kamis
                            </option>
                            <option value="Jumat"
                                {{ old('appointmentDay', $schedules->appointmentDay) == 'Jumat' ? 'selected' : '' }}>Jumat
                            </option>
                            <option value="Sabtu"
                                {{ old('appointmentDay', $schedules->appointmentDay) == 'Sabtu' ? 'selected' : '' }}>Sabtu
                            </option>
                            <option value="Minggu"
                                {{ old('appointmentDay', $schedules->appointmentDay) == 'Minggu' ? 'selected' : '' }}>Minggu
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="appointmentStart">Waktu Mulai</label>
                        <input type="time" class="form-control" name="appointmentStart"
                            value="{{ $schedules->appointmentStart }}">
                    </div>

                    <div class="form-group">
                        <label for="appointmentEnd">Waktu Selesai</label>
                        <input type="time" class="form-control" name="appointmentEnd"
                            value="{{ $schedules->appointmentEnd }}">
                    </div>

                    <div class="form-group">
                        <label for="appointmentStatus">Status</label>
                        <select class="form-control" name="appointmentStatus">
                            <option value="ACTIVE" @if ($schedules->appointmentStatus == 'ACTIVE') selected @endif>ACTIVE</option>
                            <option value="INACTIVE" @if ($schedules->appointmentStatus == 'INACTIVE') selected @endif>INACTIVE</option>
                        </select>
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
