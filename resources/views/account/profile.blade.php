@extends('layouts.master')
@section('title')
    Profile
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Account
        @endslot
        @slot('title')
            Profile
        @endslot
    @endcomponent

    <div class="row mb-4">
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-center">
                        <div>

                            <img src="{{ Auth::user()->image ? URL::asset(Auth::user()->image) : URL::asset('/assets/images/users/avatar-4.jpg') }}"
                                alt="" class="avatar-lg rounded-circle img-thumbnail">

                        </div>
                        <h5 class="mt-3 mb-1">{{ Auth::user()->name }}</h5>
                        <p class="text-muted">
                            @if (Auth::user()->role == 'ADMIN_GUDANG')
                                ADMIN GUDANG
                            @endif
                            @if (Auth::user()->role == 'ADMIN_MEKANIK')
                                ADMIN MEKANIK
                            @endif
                        </p>
                    </div>

                    <hr class="my-4">

                    <div class="text-muted">
                        <h5 class="font-size-16">Tentang</h5>
                        <p>
                            @if (Auth::user()->role == 'ADMIN_GUDANG')
                                Sebagai Admin Gudang Edie Arta Motor Team
                            @endif
                            @if (Auth::user()->role == 'ADMIN_MEKANIK')
                                Sebagai Admin Mekanik Edie Arta Motor Team
                            @endif
                        </p>
                        <div class="table-responsive mt-4">
                            <div>
                                <p class="mb-1">Nama :</p>
                                <h5 class="font-size-16">{{ Auth::user()->name }}</h5>
                            </div>
                            <div class="mt-4">
                                <p class="mb-1">Mobile :</p>
                                <h5 class="font-size-16">{{ Auth::user()->nohp }}</h5>
                            </div>
                            <div class="mt-4">
                                <p class="mb-1">E-mail :</p>
                                <h5 class="font-size-16">{{ Auth::user()->email }}</h5>
                            </div>
                            <div class="mt-4">
                                <p class="mb-1">Location :</p>
                                <h5 class="font-size-16">{{ Auth::user()->alamat }}</h5>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card mb-0">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#profile" role="tab">
                            <i class="uil uil-user-circle font-size-20"></i>
                            <span class="d-none d-sm-block">Account</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#password" role="tab">
                            <i class="uil uil-lock font-size-20"></i>
                            <span class="d-none d-sm-block">Password</span>
                        </a>
                    </li>
                </ul>
                <!-- Tab content -->
                <div class="tab-content p-4">
                    <div class="tab-pane active" id="profile" role="tabpanel">
                        <h4 class="card-title">Account Setting</h4>
                        <p class="card-title-desc">Silahkan Update Profile Anda</p>

                        <form class="custom-validation" method="POST" action="{{ route('profile') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control"
                                    required placeholder="Nama" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div>
                                    <input type="email" class="form-control" required parsley-type="email" name="email"
                                        value="{{ Auth::user()->email }}" placeholder="Enter a valid e-mail" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mobile</label>
                                <div>
                                    <input data-parsley-type="number" type="text" class="form-control" required
                                        name="nohp" value="{{ Auth::user()->nohp }}" placeholder="Enter only numbers" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <div>
                                    <input type="text" class="form-control" parsley-type="text" name="alamat"
                                        value="{{ Auth::user()->alamat }}" placeholder="Alamat" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Photo Profile</label>
                                <div>
                                    <input type="file" class="form-control" name="image" />
                                </div>
                            </div>
                            <div>
                                <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light me-1">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane " id="password" role="tabpanel">
                        <h4 class="card-title">Password Setting</h4>
                        <p class="card-title-desc">Silahkan Update Password Anda</p>

                        <form class="custom-validation" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current_pass" class="form-control" required
                                    placeholder="Current Password" />
                                @error('current_pass')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_password" class="form-control" required
                                    placeholder="New Password" />
                                @error('new_password')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" required
                                    placeholder="Confirm Password" />
                                @error('confirm_password')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light me-1">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    {{-- SweetAlert2 --}}
    @if (Session::has('message'))
        <script>
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "{{ Session::get('message') }}",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif
@endsection
