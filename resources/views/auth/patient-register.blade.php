@extends('layouts.auth')

@section('content')

<div class="page-content page-auth" id="register">
    <div class="section-store-auth">
        <div class="container">
            <div class="row align-items-center justify-content-center row-login">
                <div class="col-lg-4">
                    <h2>
                        Buat Akun Pasien untuk<br />
                        Pemeriksaan Poliklinik
                    </h2>
                    <form class="mt-3" method="POST" action="{{ route('patient.register') }}">
                        @csrf

                        <div class="form-group">
                            <label>NIK</label>
                            <input 
                                v-model="nik"
                                @change="checkForNIKAvailability()"
                                id="nik" 
                                type="text" 
                                class="form-control @error('nik') is-invalid @enderror" 
                                :class="{ 'is-invalid': this.nik_unavailable }"
                                name="nik" 
                                value="{{ old('nik') }}" 
                                required 
                                autocomplete="nik"
                            >
                            @error('nik')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Nama</label>
                            <input 
                                id="patientName" 
                                type="text" 
                                class="form-control @error('patientName') is-invalid @enderror" 
                                name="patientName" 
                                required 
                                autocomplete="new-patientName"
                            >
                            @error('patientName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <input 
                                id="address" 
                                type="text" 
                                class="form-control @error('address') is-invalid @enderror" 
                                name="address" 
                                required 
                                autocomplete="new-address"
                            >
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>No HP</label>
                            <input 
                                id="phone" 
                                type="text" 
                                class="form-control @error('phone') is-invalid @enderror" 
                                name="phone" 
                                required 
                                autocomplete="new-phone"
                            >
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <button
                            type="submit"
                            class="btn btn-success btn-block mt-4"
                            :disabled="this.nik_unavailable"
                        >
                            Sign Up Now
                        </button>
                        <a href="{{ route('patient.login.form') }}" class="btn btn-signup btn-block mt-2">
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
            checkForNIKAvailability: function () {
                var self = this;
                axios.get('{{ route('api-register-patient-check') }}', {
                        params: {
                            nik: this.nik
                        }
                    })
                    .then(function (response) {
                        if(response.data == 'Available') {
                            self.$toasted.show(
                                "NIK anda tersedia! Silahkan lanjut langkah selanjutnya!", {
                                    position: "top-center",
                                    className: "rounded",
                                    duration: 1000,
                                }
                            );
                            self.nik_unavailable = false;
                        } else {
                            self.$toasted.error(
                                "Maaf, tampaknya NIK sudah terdaftar pada sistem kami.", {
                                    position: "top-center",
                                    className: "rounded",
                                    duration: 1000,
                                }
                            );
                            self.nik_unavailable = true;
                        }
                        // handle success
                        console.log(response.data);
                    })
            }
        },
      });
    </script>
@endpush
