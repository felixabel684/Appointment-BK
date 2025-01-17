@extends('layouts.patient') {{-- berfungsi utk halaman web yang sedang dibuat akan mengikuti struktur dan tampilan yang sudah ditentukan,
    Dalam konteks ini, layouts.admin mengacu pada file layout yang berada di dalam folder layouts dengan nama file admin.blade.php --}}

@section('content')
    {{-- apapun yang terdapat dalamm section(id) kontennya akan di tampilkan dalam yield(id) sebelumnya --}}

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Bayar Pemeriksaan Tanggal {{ \Carbon\Carbon::parse($payments->examinationDate)->format('d-m-Y H:i') }}</h1>
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
                <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="examinations_id" value="{{ $payments->id }}">
                    
                    <div class="form-group">
                        <label for="price">Total Harga</label>
                        <input type="text" class="form-control" name="price" disabled value="Rp {{ number_format($payments->price, 0, ',', '.') }}">
                    </div>

                    <div class="form-group">
                        <label for="imagePayment">Unggah Foto Bukti Pembayaran</label>
                        <div class="image-preview mb-2">
                            {{-- Pratinjau gambar default --}}
                            <img id="imagePaymentPreview" src="{{ asset('img/default-image.png') }}" 
                                alt="Pratinjau Gambar" class="img-thumbnail" 
                                style="width: 400px; height: 400px; object-fit: cover;">
                        </div>
                        <input type="file" class="form-control" name="imagePayment" id="imagePayment" 
                            onchange="previewImage(event, 'imagePaymentPreview')" placeholder="Unggah Foto Bukti Pembayaran">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Save
                    </button>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    <script>
        function previewImage(event, previewId) {
            const output = document.getElementById(previewId);
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src); // Bebaskan memory
            }
        }
    </script>
@endsection
