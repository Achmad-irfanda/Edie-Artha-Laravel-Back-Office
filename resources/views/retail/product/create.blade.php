@extends('layouts.master')
@section('title')
    Tambah Sparepart
@endsection
<!-- plugin css -->
<link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Sparepart
        @endslot
        @slot('title')
            Tambah Sparepart
        @endslot
    @endcomponent
    <div class="col-12">
        <div class="card">
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <h4 class="card-title">Form Sparepart</h4>
                    <p class="card-title-desc">Silahkan lengkapi data sparepart berikut</p>

                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">Kode</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="kode" placeholder="Masukkan Kode Barang"
                                required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">Nama Barang</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="nama" placeholder="Masukkan Nama Barang"
                                required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Multiple Select</label>
                        <div class="col-md-10">
                            <select class="select2 form-control select2-multiple" multiple="multiple"
                                data-placeholder="Pilih Varian" name="varian[]" required>
                                <optgroup label="Pilih Varian Warna">
                                    <option value="Hitam">Hitam</option>
                                    <option value="Putih">Putih</option>
                                    <option value="Merah">Merah</option>
                                    <option value="Biru">Biru</option>
                                </optgroup>
                                <optgroup label="Pilih Varian Kendaraan">
                                    <option value="Matic">Matic</option>
                                    <option value="Manual">Manual</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-md-2 col-form-label">Harga</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number" placeholder="Rp" name="harga" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Status Ketersediaan</label>
                        <div class="col-md-10">
                            <select class="form-control select2" name="status" required>
                                <option>Pilih Ketersediaan</option>
                                <option value="Ready">Ready</option>
                                <option value="Pre-Order">Pre Order</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-md-2 col-form-label">Jumlah Stok</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number" placeholder="Jumlah Stok Barang" name="stok"
                                required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-md-2 col-form-label">Thumbnail Barang</label>
                        <div class="col-md-10">
                            <input class="form-control" type="file" name="thumbnail" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-md-2 col-form-label">Photo Barang</label>
                        <div class="col-md-10">
                            <input class="form-control" type="file" name="images[]" multiple>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-email-input" class="col-md-2 col-form-label">Deskripsi</label>
                        <div class="col-md-10">
                            <textarea required class="form-control" rows="5" name="deskripsi" placeholder="Masukkan Deskripsi Barang"></textarea>
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
