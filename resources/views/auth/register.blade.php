@extends('layouts.auth')

@section('content')

<div class="page-content page-auth" id="register">
    <div class="section-store-auth">
        <div class="container">
            <div class="row align-items-center justify-content-center row-login">
                <div class="col-lg-4">
                    <h2>
                        Buat Akun Dokter untuk<br />
                        Pemeriksaan Poliklinik
                    </h2>
                    <form class="mt-3" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <label>Username</label>
                            <input 
                                v-model="username"
                                @change="checkForUsernameAvailability()"
                                id="username" 
                                type="username" 
                                class="form-control @error('username') is-invalid @enderror" 
                                :class="{ 'is-invalid': this.username_unavailable }"
                                name="username" 
                                value="{{ old('username') }}" 
                                required 
                                autocomplete="username"
                            >
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input 
                                id="password" 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                name="password" 
                                required 
                                autocomplete="new-password"
                            >
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input 
                                id="password-confirm" 
                                type="password" 
                                class="form-control" 
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password"
                            >
                        </div>
                        
                        <button
                            type="submit"
                            class="btn btn-success btn-block mt-4"
                            :disabled="this.username_unavailable"
                        >
                            Sign Up Now
                        </button>
                        <a href="{{ route('login') }}" class="btn btn-signup btn-block mt-2">
                            Back to Sign In
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
      Vue.use(Toasted);

      var register = new Vue({
        el: "#register",
        mounted() {
          AOS.init();
       
        },
        methods: {
            checkForUsernameAvailability: function () {
                var self = this;
                axios.get('{{ route('api-register-check') }}', {
                        params: {
                            username: this.username
                        }
                    })
                    .then(function (response) {
                        if(response.data == 'Available') {
                            self.$toasted.show(
                                "username anda tersedia! Silahkan lanjut langkah selanjutnya!", {
                                    position: "top-center",
                                    className: "rounded",
                                    duration: 1000,
                                }
                            );
                            self.username_unavailable = false;
                        } else {
                            self.$toasted.error(
                                "Maaf, tampaknya username sudah terdaftar pada sistem kami.", {
                                    position: "top-center",
                                    className: "rounded",
                                    duration: 1000,
                                }
                            );
                            self.username_unavailable = true;
                        }
                        // handle success
                        console.log(response.data);
                    })
            }
        },
      });
    </script>
@endpush
