@extends('layouts.master')
@section('title')
    Edit Sparepart
@endsection
@section('css')
    <!-- plugin css -->
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/magnific-popup/magnific-popup.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Sparepart
        @endslot
        @slot('title')
            Edit Sparepart
        @endslot
    @endcomponent
    <div class="col-12">
        <div class="card">
            <form action="{{ route('product.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">

                    <h4 class="card-title">Form Sparepart</h4>
                    <p class="card-title-desc">Silahkan lengkapi data sparepart berikut</p>

                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">Kode</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="kode" value="{{ $product->kode }}"
                                placeholder="Masukkan Kode Barang" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">Nama Barang</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="nama" value="{{ $product->nama }}"
                                placeholder="Masukkan Nama Barang" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Multiple Select</label>
                        <div class="col-md-10">
                            <select class="select2 form-control select2-multiple" multiple="multiple"
                                data-placeholder="Pilih Varian" name="varian[]" required>
                                @foreach (json_decode($product->varian) as $varian)
                                    <option value="{{ $varian }}" selected>{{ $varian }}</option>
                                @endforeach
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
                            <input class="form-control" type="number" value="{{ $product->harga }}" placeholder="Rp"
                                name="harga" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Status Ketersediaan</label>
                        <div class="col-md-10">
                            <select class="form-control select2" name="status" required>
                                <option>Pilih Ketersediaan</option>
                                <option value="Ready" {{ $product->status == 'Ready' ? 'selected' : '' }}>Ready</option>
                                <option value="Pre-Order" {{ $product->status == 'Pre-Order' ? 'selected' : '' }}>Pre Order
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-md-2 col-form-label">Jumlah Stok</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number" value="{{ $product->stok }}"
                                placeholder="Jumlah Stok Barang" name="stok" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-md-2 col-form-label">Thumbnail Barang</label>
                        <div class="col-md-10 product-desc-color">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="image-popup-no-margins" href="{{ URL::asset($product->thumbnail) }}">
                                        <img class="img-fluid" alt="" src="{{ URL::asset($product->thumbnail) }}"
                                            width="75" class="avatar-md">
                                    </a>
                                </li>
                            </ul>
                            <input class="form-control" type="file" name="thumbnail">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-md-2 col-form-label">Photo Barang</label>
                        <div class="col-md-10 product-desc-color">
                            <ul class="list-inline">
                                @foreach ($images as $image)
                                    <li class="list-inline-item">
                                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ $product->nama }}">
                                            <div class="product-color-item">
                                                <img src="{{ URL::asset($image->url) }}" alt=""
                                                    class="avatar-md">
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <input class="form-control" type="file" name="images[]" multiple>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-email-input" class="col-md-2 col-form-label">Deskripsi</label>
                        <div class="col-md-10">
                            <textarea required class="form-control" rows="5" name="deskripsi" placeholder="Masukkan Deskripsi Barang">{{ $product->deskripsi }}</textarea>
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
