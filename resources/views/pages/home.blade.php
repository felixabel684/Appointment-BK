@extends('layouts.app')

@section('title', 'Poliklinik UDINUS')

@section('content')
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="{{ asset('frontend/images/logopoliklinik.png') }}" alt="Logo Poliklinik">
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <!-- Box 1 -->
        <div class="box box1">
            <h1>Sistem Temu Janji Poliklinik</h1>
            <p>Universitas Dian Nuswantoro</p>
        </div>

        <!-- Box 2 and 3 -->
        <div class="login-container">
            <div class="box box2">
                <div class="icon">
                    <img src="{{ asset('frontend/images/doctor-patient.png') }}" alt="Pasien Icon">
                </div>
                <h3>Login Sebagai Pasien</h3>
                <p>Apabila Anda adalah seorang Pasien, silahkan Login terlebih dahulu untuk melakukan pendaftaran sebagai Pasien!</p>
                <form action="{{ route('patient.login.form') }}" method="GET">
                    <button type="submit" class="button">Silahkan Login</button>
                </form>
            </div>
            <div class="box box3">
                <div class="icon">
                    <img src="{{ asset('frontend/images/doctor-patient.png') }}" alt="Dokter Icon">
                </div>
                <h3>Login Sebagai Dokter</h3>
                <p>Apabila Anda adalah seorang Dokter, silahkan Login terlebih dahulu untuk memulai melayani Pasien!</p>
                <form action="{{ route('login') }}" method="GET">
                    <button type="submit" class="button">Silahkan Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection
