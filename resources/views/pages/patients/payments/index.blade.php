@extends('layouts.patient') {{-- berfungsi utk halaman web yang sedang dibuat akan mengikuti struktur dan tampilan yang sudah ditentukan,
    Dalam konteks ini, layouts.admin mengacu pada file layout yang berada di dalam folder layouts dengan nama file admin.blade.php --}}

@section('content')
    {{-- apapun yang terdapat dalamm section(id) kontennya akan di tampilkan dalam yield(id) sebelumnya --}}

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Pembayaran</h1>
            {{-- <a href="{{ route('examination_patients.create') }}" class="btn btn-sm btn-primary shadow sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Booking Pemeriksaan
            </a> --}}
            {{-- <form method="GET" action="{{ route('examinations.index') }}" class="form-inline">
                <input type="text" name="search" class="form-control mr-2" placeholder="Cari..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form> --}}
        </div>

        <!-- Alert Pesan -->
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Poli</th>
                                <th>Dokter</th>
                                <th>Tanggal Pemeriksaan</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1; // Variabel penghitung untuk nomor urut
                            @endphp

                            @forelse ($payment_patients as $payment_patient)
                                @php
                                    $paymentStatus = 'Belum Bayar';
                                    $badgeClass = 'badge-danger'; // Warna default merah untuk belum bayar

                                    if ($payment_patient->payment_examination->isNotEmpty()) {
                                        $payment = $payment_patient->payment_examination->first();

                                        if ($payment->status === 'Pending') {
                                            $paymentStatus = 'Pending';
                                            $badgeClass = 'badge-warning'; // Warna kuning untuk pending
                                        } elseif ($payment->status === 'Failed') {
                                            $paymentStatus = 'Failed';
                                            $badgeClass = 'badge-dark'; // Warna gelap untuk failed
                                        } elseif ($payment->status === 'Paid') {
                                            $paymentStatus = 'Sudah Bayar';
                                            $badgeClass = 'badge-success'; // Warna hijau untuk sudah bayar
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $payment_patient->list_clinic->schedule_appointment->doctor_appointment->clinic->clinicName }}
                                    </td>
                                    <td>{{ $payment_patient->list_clinic->schedule_appointment->doctor_appointment->doctorName }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($payment_patient->examinationDate)->format('d-m-Y H:i') }}
                                    </td>
                                    <td>Rp {{ number_format($payment_patient->price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $badgeClass }}">{{ $paymentStatus }}</span>
                                    </td>

                                    {{-- @dd($paymentStatus) --}}
                                    @php
                                        // Memeriksa apakah pasien sudah memiliki relasi pemeriksaan di clinic_examinations
                                        $hasPayment = $payment_patient->payment_examination()->first();
                                    @endphp

                                    <td>
                                        @if ($hasPayment)
                                            <a href="{{ route('payments.edit', ['id' => $hasPayment->id]) }}"
                                                class="btn btn-warning">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        @else
                                            <!-- Jika pasien belum diperiksa, tampilkan tombol periksa -->
                                            <a href="{{ route('payments.create', ['id' => $payment_patient->id]) }}"
                                                class="btn btn-info">
                                                <i class="fas fa-dollar-sign"></i>
                                            </a>
                                        @endif

                                        <a href="{{ route('payments.show', $payment_patient->id) }}"
                                            class="btn btn-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
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
