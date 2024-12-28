@extends('layouts.patient') {{-- berfungsi utk halaman web yang sedang dibuat akan mengikuti struktur dan tampilan yang sudah ditentukan,
    Dalam konteks ini, layouts.admin mengacu pada file layout yang berada di dalam folder layouts dengan nama file admin.blade.php --}}

@section('content')
    {{-- apapun yang terdapat dalamm section(id) kontennya akan di tampilkan dalam yield(id) sebelumnya --}}

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Pemeriksaan</h1>
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
                        <th>Nama Poli</th>
                        <td>{{ $examination_patient->schedule_appointment->doctor_appointment->clinic->clinicName }}
                    </tr>
                    <tr>
                        <th>Nama Dokter</th>
                        <td>{{ $examination_patient->schedule_appointment->doctor_appointment->doctorName }}</td>
                    </tr>
                    <tr>
                        <th>Hari Booking</th>
                        <td>{{ $examination_patient->schedule_appointment->appointmentDay }}</td>
                    </tr>
                    <tr>
                        <th>Waktu Mulai</th>
                        <td>{{ $examination_patient->schedule_appointment->appointmentStart }}</td>
                    </tr>
                    <tr>
                        <th>Waktu Selesai</th>
                        <td>{{ $examination_patient->schedule_appointment->appointmentEnd }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Antrian</th>
                        <td class="queue-number-text">{{ $examination_patient->queueNumber }}</td>
                    </tr>

                    @if ($isExamined)
                        <tr>
                            <th>Tanggal Pemeriksaan</th>
                            <td>
                                @if ($examination_patient->clinic_examination->isNotEmpty())
                                    {{-- Pastikan examinationDate diubah menjadi objek Carbon --}}
                                    {{ \Carbon\Carbon::parse($examination_patient->clinic_examination->first()->examinationDate)->format('d-m-Y H:i') }}
                                @else
                                    No examination data
                                @endif
                            </td>

                        </tr>
                        <tr>
                            <th>Obat yang Diberikan</th>
                            <td>
                                @if ($examination_patient->clinic_examination->isNotEmpty())
                                    @php
                                        $examination = $examination_patient->clinic_examination->first();
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
                                {{ number_format($examination_patient->clinic_examination->first()->price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
