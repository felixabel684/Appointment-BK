@extends('layouts.admin') {{-- berfungsi utk halaman web yang sedang dibuat akan mengikuti struktur dan tampilan yang sudah ditentukan,
    Dalam konteks ini, layouts.admin mengacu pada file layout yang berada di dalam folder layouts dengan nama file admin.blade.php --}}

@section('content')
    {{-- apapun yang terdapat dalamm section(id) kontennya akan di tampilkan dalam yield(id) sebelumnya --}}

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Pemeriksaan Pasien {{ $examination_admin->patient->patientName }}</h1>
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
                <table class="table table-bordered">
                    <tr>
                        <th>No Rekam Medis</th>
                        <td>{{ $examination_admin->patient->rmNumber }}
                    </tr>
                    <tr>
                        <th>Nama Pasien</th>
                        <td>{{ $examination_admin->patient->patientName }}</td>
                    </tr>
                    <tr>
                        <th>Nama Dokter</th>
                        <td>{{ $examination_admin->schedule_appointment->doctor_appointment->doctorName }}</td>
                    </tr>
                    <tr>
                        <th>Nama Poli</th>
                        <td>{{ $examination_admin->schedule_appointment->doctor_appointment->clinic->clinicName }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Booking</th>
                        <td>{{ $examination_admin->schedule_appointment->appointmentDate }}</td>
                    </tr>
                    <tr>
                        <th>Hari Booking</th>
                        <td>{{ $examination_admin->schedule_appointment->appointmentDay }}</td>
                    </tr>
                    <tr>
                        <th>Waktu Mulai</th>
                        <td>{{ $examination_admin->schedule_appointment->appointmentStart }}</td>
                    </tr>
                    <tr>
                        <th>Waktu Selesai</th>
                        <td>{{ $examination_admin->schedule_appointment->appointmentEnd }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Antrian</th>
                        <td class="queue-number-text">{{ $examination_admin->queueNumber }}</td>
                    </tr>

                    @if ($isExamined)
                        <tr>
                            <th>Tanggal Pemeriksaan</th>
                            <td>
                                @if ($examination_admin->clinic_examination->isNotEmpty())
                                    {{-- Pastikan examinationDate diubah menjadi objek Carbon --}}
                                    {{ \Carbon\Carbon::parse($examination_admin->clinic_examination->first()->examinationDate)->format('d-m-Y H:i') }}
                                @else
                                    No examination data
                                @endif
                            </td>

                        </tr>
                        <tr>
                            <th>Obat yang Diberikan</th>
                            <td>
                                @if ($examination_admin->clinic_examination->isNotEmpty())
                                    @php
                                        $examination = $examination_admin->clinic_examination->first();
                                    @endphp
                                    @if ($examination->examination_medicines->isEmpty())
                                        Tidak ada obat
                                    @else
                                        <ul>
                                            @foreach ($examination->examination_medicines as $medicine)
                                                <li>{{ $medicine->medicineName }} ({{ $medicine->packaging }})</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @else
                                    No examination data
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Total Biaya</th>
                            <td class="price-text">Rp
                                {{ number_format($examination_admin->clinic_examination->first()->price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection