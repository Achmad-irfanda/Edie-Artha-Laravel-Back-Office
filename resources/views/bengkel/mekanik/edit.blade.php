@extends('layouts.master')
@section('title')
    Edit Mekanik
@endsection
<!-- plugin css -->
<link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/assets/libs/magnific-popup/magnific-popup.min.css') }}" rel="stylesheet" type="text/css" />
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Mekanik
        @endslot
        @slot('title')
            Edit Mekanik
        @endslot
    @endcomponent
    <div class="col-12">
        <div class="card">
            <form action="{{ route('mekanik.update', $mekanik) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">

                    <h4 class="card-title">Form Mekanik</h4>
                    <p class="card-title-desc">Silahkan lengkapi data mekanik berikut</p>

                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">Nama</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="nama" value="{{ $mekanik->nama }}"
                                placeholder="Masukkan Nama Mekanik" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">No Hp</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number" name="nohp" value="{{ $mekanik->nohp }}"
                                placeholder="Masukkan No Hp" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">Alamat</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="alamat" value="{{ $mekanik->alamat }}"
                                placeholder="Masukkan Alamat" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">Jabatan</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="jabatan" value="{{ $mekanik->jabatan }}"
                                placeholder="Masukkan Jabatan" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Cabang</label>
                        <div class="col-md-10">
                            <select class="form-control select2" name="cabang" required>
                                <option>Pilih Cabang Edie Arta Motor</option>
                                <option value="Edie Arta Motor Bungkulan"
                                    {{ $mekanik->cabang == 'Edie Arta Motor Bungkulan' ? 'selected' : '' }}>Edie Arta Motor
                                    Bungkulan</option>
                                <option value="Edie Arta Motor Bengkala"
                                    {{ $mekanik->cabang == 'Edie Arta Motor Bengkala' ? 'selected' : '' }}>Edie Arta Motor
                                    Bengkala</option>
                                <option value="Edie Arta Motor Imam Bonjol"
                                    {{ $mekanik->cabang == 'Edie Arta Motor Imam Bonjol' ? 'selected' : '' }}>Edie Arta
                                    Motor Imam Bonjol</option>
                                <option value="Edie Arta Motor Sukasada"
                                    {{ $mekanik->cabang == 'Edie Arta Motor Sukasada' ? 'selected' : '' }}>Edie Arta Motor
                                    Sukasada</option>
                                <option value="Edie Arta Motor Tangguwisia"
                                    {{ $mekanik->cabang == 'Edie Arta Motor Tangguwisia' ? 'selected' : '' }}>Edie Arta
                                    Motor Tangguwisia</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-md-2 col-form-label">Photo</label>
                        <div class="col-md-10  product-desc-color">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="image-popup-no-margins" href="{{ URL::asset($mekanik->image) }}">
                                        <img class="img-fluid" alt="" src="{{ URL::asset($mekanik->image) }}"
                                            width="75" class="avatar-md">
                                    </a>
                                </li>
                            </ul>
                            <input class="form-control" type="file" name="image">
                        </div>
                    </div>
                    <div>
                        <div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light me-1">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
    <!-- Magnific Popup-->
    <script src="{{ URL::asset('/assets/libs/magnific-popup/magnific-popup.min.js') }}"></script>
    <!-- lightbox init js-->
    <script src="{{ URL::asset('/assets/js/pages/lightbox.init.js') }}"></script>
    <script>
        // Select2
        $(".select2").select2({
            tags: []
        });
    </script>
@endsection
