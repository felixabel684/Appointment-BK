@extends('layouts.admin')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Obat {{ $item->medicineName }}</h1>
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
                <form action="{{ route('medicines.update', $item->id) }}" method="POST">
                    @method('PUT') {{-- Kalau ubah data pakainya PUT --}}
                    @csrf
                    <div class="form-group">
                        <label for="medicineName">Nama Obat</label>
                        <input type="text" class="form-control" name="medicineName" placeholder="Nama Obat"
                            value="{{ $item->medicineName }}">
                    </div>

                    <div class="form-group">
                        <label for="packaging">Kemasan</label>
                        <input type="text" class="form-control" name="packaging" placeholder="Kemasan"
                            value="{{ $item->packaging }}">
                    </div>

                    <div class="form-group">
                        <label for="price">Harga</label>
                        <input type="text" class="form-control" name="price" placeholder="Harga"
                            value="{{ $item->price }}">
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
