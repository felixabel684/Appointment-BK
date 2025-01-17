@extends('layouts.patient')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Pembayar Pemeriksaan Tanggal {{ \Carbon\Carbon::parse($payments->examinationDate)->format('d-m-Y H:i') }}</h1>
        </div>

        @if ($errors->any())
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
                <!-- Form Update Pembayaran -->
                <form action="{{ route('payments.update', $payments->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Gunakan metode PUT untuk update -->

                    <!-- Input ID Pembayaran -->
                    <input type="hidden" name="examinations_id" value="{{ $payments->payment->id }}">

                    <!-- Total Harga (disabled) -->
                    <div class="form-group">
                        <label for="price">Total Harga</label>
                        <input type="text" class="form-control" name="price" disabled value="Rp {{ number_format($payments->payment->price, 0, ',', '.') }}">
                    </div>

                    <!-- Unggah Foto Bukti Pembayaran -->
                    <div class="form-group">
                        <label for="imagePayment">Unggah Foto Bukti Pembayaran</label>
                        <div class="image-preview mb-2">
                            <img id="imagePaymentPreview" src="{{ asset($payments->imagePayment ? 'storage/'.$payments->imagePayment : 'img/default-image.png') }}" 
                                alt="Pratinjau Gambar" class="img-thumbnail" 
                                style="width: 400px; height: 400px; object-fit: cover;">
                        </div>
                        <input type="file" class="form-control" name="imagePayment" id="imagePayment" 
                            onchange="previewImage(event, 'imagePaymentPreview')" placeholder="Unggah Foto Bukti Pembayaran">
                    </div>

                    <!-- Button Submit -->
                    <button type="submit" class="btn btn-primary btn-block">Save</button>
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