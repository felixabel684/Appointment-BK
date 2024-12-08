@extends('layouts.auth')

@section('content')
<div class="page-content page-auth">
    <div class="section-store-auth">
        <div class="container">
            <div class="row align-items-center row-login">
                <div class="col-lg-6 text-center">
                    <img
                    src="{{ url('frontend/images/bg-login.png') }}"
                    alt=""
                    class="w-50 mb-4 mb-lg-none"
                    />
                </div>
                <div class="col-lg-5">
                    <h2>
                        Login Poliklinik <br>
                        Sebagai Dokter
                    </h2>
                    <form method="POST" action="{{ route('login') }}" class="mt-3">
                        @csrf
                        <div class="form-group">
                            <label>Username</label>
                            <input id="username" type="text" class="form-control w-75 @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                            
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input id="password" type="password" class="form-control w-75 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button
                            type="submit"
                            class="btn btn-success btn-block w-75 mt-4"
                        >
                            Sign In
                        </button>
                        <a
                            href="{{ route('register') }}"
                            class="btn btn-signup btn-block w-75 mt-2"
                        >
                            Sign Up
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
