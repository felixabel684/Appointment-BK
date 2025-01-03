@extends('layouts.patient') {{-- berfungsi utk halaman web yang sedang dibuat akan mengikuti struktur dan tampilan yang sudah ditentukan,
    Dalam konteks ini, layouts.admin mengacu pada file layout yang berada di dalam folder layouts dengan nama file admin.blade.php --}}

@section('content')
    {{-- apapun yang terdapat dalamm section(id) kontennya akan di tampilkan dalam yield(id) sebelumnya --}}

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Data Booking Pemeriksaan</h1>
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
                <form action="{{ route('examination_patients.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="rmNumber">No RM Pasien</label>
                        <!-- Menampilkan RM Number pasien yang sedang login -->
                        <input type="text" class="form-control" name="rmNumber"
                            value="{{ Auth::guard('patient')->user()->rmNumber }}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="clinics_id">Poli</label>
                        <select class="form-control" id="clinics_id" name="clinics_id">
                            <option value="" disabled selected>Pilih Poli</option>
                            @foreach ($clinics as $clinic)
                                <option value="{{ $clinic->id }}">{{ $clinic->clinicName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="appointment_schedules_id">Jadwal</label>
                        <select class="form-control" id="appointment_schedules_id" name="appointment_schedules_id" disabled>
                            <option value="" disabled selected>Pilih Jadwal</option>
                            {{-- Jadwal akan diisi melalui JavaScript --}}
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="complaint">Keluhan</label>
                        <textarea name="complaint" rows="5" class="d-block w-100 form-control">{{ old('complaint') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Save
                    </button>
                </form>
            </div>
        </div>

        <script>
            document.getElementById('clinics_id').addEventListener('change', function() {
                const clinicId = this.value;
                const scheduleDropdown = document.getElementById('appointment_schedules_id');

                scheduleDropdown.innerHTML = '<option value="" disabled selected>Memuat jadwal...</option>';
                scheduleDropdown.disabled = true;

                fetch(`/api/schedules/${clinicId}`)
                    .then(response => response.json())
                    .then(data => {
                        scheduleDropdown.innerHTML = '<option value="" disabled selected>Pilih Jadwal</option>';
                        data.forEach(schedule => {
                            const optionText =
                                `${schedule.doctor} | ${schedule.appointmentDay} | ${schedule.appointmentStart} - ${schedule.appointmentEnd}`;
                            scheduleDropdown.innerHTML +=
                                `<option value="${schedule.id}">${optionText}</option>`;
                        });
                        scheduleDropdown.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        scheduleDropdown.innerHTML =
                            '<option value="" disabled selected>Error memuat jadwal</option>';
                    });
            });
        </script>

    </div>
    <!-- /.container-fluid -->
@endsection