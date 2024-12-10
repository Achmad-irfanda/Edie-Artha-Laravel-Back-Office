@extends('layouts.master-without-nav')
@section('title')
    Login
@endsection
@section('content')
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <a href="{{ url('index') }}" class="mb-5 d-block auth-logo">
                            <img src="{{ URL::asset('/assets/images/eam.png') }}" alt="" height="200"
                                class="logo logo-dark">
                            <img src="{{ URL::asset('/assets/images/eam.png') }}" alt="" height="200"
                                class="logo logo-light">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="card-body p-4">
                            @error('message')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="uil uil-user-circle me-2"></i>
                                    {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">

                                    </button>
                                </div>
                            @enderror
                            <div class="text-center mt-2">
                                <h5 class="text-success">Selamat Datang di Edie Arta Motor</h5>
                                <p class="text-muted">Silahkan Login</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email', '') }}" id="email"
                                            placeholder="Masukkan Email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="userpassword">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            name="password" id="userpassword" placeholder="Masukkan password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    <div class="mt-3 text-end">
                                        <button class="btn btn-success w-sm waves-effect waves-light" type="submit">Log
                                            In</button>
                                    </div>


                                </form>
                            </div>

                        </div>
                    </div>

                    <div class="mt-5 text-center text-white">
                        <p>©
                            <script>
                                document.write(new Date().getFullYear())
                            </script> EAM. Crafted with <i class="mdi mdi-heart text-danger"></i> by
                            Edie Arta Motor
                        </p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
@endsection
