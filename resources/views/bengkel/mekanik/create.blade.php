@extends('layouts.master')
@section('title')
    Tambah Mekanik
@endsection
<!-- plugin css -->
<link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Mekanik
        @endslot
        @slot('title')
            Tambah Mekanik
        @endslot
    @endcomponent
    <div class="col-12">
        <div class="card">
            <form action="{{ route('mekanik.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <h4 class="card-title">Form Mekanik Baru</h4>
                    <p class="card-title-desc">Silahkan lengkapi data mekanik berikut</p>

                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">Nama</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="nama" placeholder="Masukkan Nama Mekanik"
                                required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">No Hp</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number" name="nohp" placeholder="Masukkan No Hp" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">Alamat</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="alamat" placeholder="Masukkan Alamat"
                                required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">Jabatan</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="jabatan" placeholder="Masukkan Jabatan"
                                required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Cabang</label>
                        <div class="col-md-10">
                            <select class="form-control select2" name="cabang" required>
                                <option>Pilih Cabang Edie Arta Motor</option>
                                <option value="Edie Arta Motor Bungkulan">Edie Arta Motor Bungkulan</option>
                                <option value="Edie Arta Motor Bengkala">Edie Arta Motor Bengkala</option>
                                <option value="Edie Arta Motor Imam Bonjol">Edie Arta Motor Imam Bonjol</option>
                                <option value="Edie Arta Motor Sukasada">Edie Arta Motor Sukasada</option>
                                <option value="Edie Arta Motor Tangguwisia">Edie Arta Motor Tangguwisia</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-md-2 col-form-label">Photo</label>
                        <div class="col-md-10">
                            <input class="form-control" type="file" name="image" required>
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
    <script>
        // Select2
        $(".select2").select2({
            tags: []
        });
    </script>
@endsection
