@extends('layouts.patient') {{-- berfungsi utk halaman web yang sedang dibuat akan mengikuti struktur dan tampilan yang sudah ditentukan,
    Dalam konteks ini, layouts.admin mengacu pada file layout yang berada di dalam folder layouts dengan nama file admin.blade.php --}}

@section('content')
    {{-- apapun yang terdapat dalamm section(id) kontennya akan di tampilkan dalam yield(id) sebelumnya --}}

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Pembayaran</h1>
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
                        <td>{{ $payment_patients->list_clinic->schedule_appointment->doctor_appointment->clinic->clinicName }}
                    </tr>
                    <tr>
                        <th>Nama Dokter</th>
                        <td>{{ $payment_patients->list_clinic->schedule_appointment->doctor_appointment->doctorName }}</td>
                    </tr>
                    <tr>
                        <th>Hari Booking</th>
                        <td>{{ $payment_patients->list_clinic->schedule_appointment->appointmentDay }}</td>
                    </tr>
                    <tr>
                        <th>Waktu Mulai</th>
                        <td>{{ $payment_patients->list_clinic->schedule_appointment->appointmentStart }}</td>
                    </tr>
                    <tr>
                        <th>Waktu Selesai</th>
                        <td>{{ $payment_patients->list_clinic->schedule_appointment->appointmentEnd }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Pemeriksaan</th>
                        <td>
                            {{ \Carbon\Carbon::parse($payment_patients->examinationDate)->format('d-m-Y H:i') }}
                        </td>
                    </tr>
                    <tr>
                        <th>Total Biaya</th>
                        <td>
                            @php
                                $priceClass = 'text-danger'; // Default warna merah jika belum ada pembayaran
                                if ($payment_patients->payment_examination->isNotEmpty()) {
                                    $priceClass = ''; // Jika ada data, tampilkan normal
                                }
                            @endphp
                            <span class="{{ $priceClass }}" style="font-size: 1.2rem; font-weight: bold;">
                                Rp {{ number_format($payment_patients->price, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Status Pembayaran</th>
                        <td>
                            @php
                                $status = 'Belum melakukan pembayaran';
                                $statusClass = 'text-danger'; // Default warna merah untuk belum membayar

                                if ($payment_patients->payment_examination->isNotEmpty()) {
                                    $status = $payment_patients->payment_examination->first()->status;

                                    if ($status === 'pending') {
                                        $status = 'Menunggu konfirmasi admin';
                                        $statusClass = 'text-warning'; // Warna kuning untuk pending
                                    } elseif ($status === 'paid') {
                                        $status = 'Pembayaran berhasil';
                                        $statusClass = 'text-success'; // Warna hijau untuk berhasil
                                    } else {
                                        $status = 'Pembayaran gagal';
                                        $statusClass = 'text-dark';
                                    }
                                }
                            @endphp
                            <span class="{{ $statusClass }}" style="font-size: 1.2rem; font-weight: bold;">
                                {{ $status }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Bukti Pembayaran</th>
                        <td>
                            @if (
                                $payment_patients->payment_examination->isNotEmpty() &&
                                    $payment_patients->payment_examination->first()->imagePayment)
                                <a href="{{ asset('storage/' . $payment_patients->payment_examination->first()->imagePayment) }}"
                                    download>Download Bukti Pembayaran</a><br>
                                <img src="{{ asset('storage/' . $payment_patients->payment_examination->first()->imagePayment) }}"
                                    alt="Foto Pembayaran" width="350">
                            @else
                                <span class="text-danger" style="font-size: 1.2rem; font-weight: bold;">Belum melakukan
                                    pembayaran</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
