@extends('layouts.master')
@section('title')
    Riwayat Transaksi
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Bengkel
        @endslot
        @slot('title')
            Riwayat Transaksi
        @endslot
    @endcomponent


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Pesanan Bengkel</h4>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 20px;">
                                        <div class="form-check font-size-16">
                                            <input type="checkbox" class="form-check-input" id="customCheck1">
                                            <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>Kode Pesanan</th>
                                    <th>Nama Customer</th>
                                    <th>Kendala</th>
                                    <th>Plat Nomor</th>
                                    <th>Tanggal</th>
                                    <th>Mekanik</th>
                                    <th>Status</th>
                                    <th class="text-center align-middle">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($transactions)
                                    @foreach ($transactions as $trx)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input type="checkbox" class="form-check-input" id="customCheck2">
                                                    <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td><a href="javascript: void(0);"
                                                    class="text-body fw-bold">#MK{{ $trx->id }}</a> </td>
                                            <td>{{ $trx->user()->get()->implode('name') }}</td>
                                            <td>
                                                {{ $trx->kendala }}
                                            </td>
                                            <td>
                                                {{ $trx->plat_nomor }}
                                            </td>
                                            <td>
                                                {{ $trx->created_at->translatedFormat('l, j M Y H:i') }}
                                            </td>
                                            <td>
                                                {{ optional($trx->mekanik()->first())->nama ?? '-' }}
                                            </td>
                                            <td>
                                                @if ($trx->status == 'pending')
                                                    <span
                                                        class="badge rounded-pill bg-warning-subtle text-warning font-size-12">{{ $trx->status }}</span>
                                                @elseif ($trx->status == 'process')
                                                    <span
                                                        class="badge rounded-pill bg-primary-subtle text-primary font-size-12">{{ $trx->status }}</span>
                                                @elseif ($trx->status == 'canceled')
                                                    <span
                                                        class="badge rounded-pill bg-danger-subtle text-danger font-size-12">{{ $trx->status }}</span>
                                                @elseif ($trx->status == 'success')
                                                    <span
                                                        class="badge rounded-pill bg-success-subtle text-success font-size-12">{{ $trx->status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <button type="button"
                                                    class="btn btn-primary btn-sm btn-rounded waves-effect waves-light me-2t"
                                                    data-bs-toggle="modal" data-bs-target=".detail{{ $trx->id }}">
                                                    Lihat
                                                    Detail</button>
                                                <!--  Large modal example -->
                                                <div class="modal fade detail{{ $trx->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content text-start">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myLargeModalLabel">Detail
                                                                    Transaksi #MK{{ $trx->id }}
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div class="invoice-title">
                                                                                    <h4 class="float-end font-size-16">
                                                                                        Invoice #MK{{ $trx->id }}
                                                                                        @if ($trx->status == 'success')
                                                                                            <span
                                                                                                class="badge bg-success font-size-12 ms-2">{{ $trx->status }}</span>
                                                                                        @elseif($trx->status == 'canceled')
                                                                                            <span
                                                                                                class="badge bg-danger font-size-12 ms-2">{{ $trx->status }}</span>
                                                                                        @endif
                                                                                    </h4>
                                                                                </div>
                                                                                <div class="mb-4">
                                                                                    <img src="{{ URL::asset('assets/images/eam-logo.png') }}"
                                                                                        alt="logo" height="20"
                                                                                        class="logo-dark" />
                                                                                    <img src="{{ URL::asset('assets/images/eam-logo.png') }}"
                                                                                        alt="logo" height="20"
                                                                                        class="logo-light" />
                                                                                </div>
                                                                                <hr class="my-4">

                                                                                <div class="row align-items-center">
                                                                                    <div class="text-muted">
                                                                                        <div>
                                                                                            <h5 class="font-size-16 mb-1">
                                                                                                Pelanggan:</h5>
                                                                                            <p>{{ optional($trx->user()->first())->name ?? '-' }}
                                                                                            </p>
                                                                                        </div>
                                                                                        <div>
                                                                                            <h5 class="font-size-16 mb-1">
                                                                                                Tanggal:</h5>
                                                                                            <p>{{ $trx->created_at->translatedFormat('l, j M Y H:i') }}
                                                                                            </p>
                                                                                        </div>
                                                                                        <div>
                                                                                            <h5 class="font-size-16 mb-1">
                                                                                                Foto Transaksi:</h5>
                                                                                                @if($trx->gambar != null)
                                                                                                    <img src="{{ asset($trx->gambar) }}"
                                                                                                    alt="tran-img"
                                                                                                    title="tran-img"
                                                                                                    class="avatar-xl mb-2">
                                                                                                @else
                                                                                                <p>
                                                                                                    Foto tidak ditemukan
                                                                                                </p>
                                                                                                @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>


                                                                                <div class="py-2">
                                                                                    <h5 class="font-size-15">Transaksi
                                                                                        Service
                                                                                    </h5>

                                                                                    <div class="table-responsive">
                                                                                        <table
                                                                                            class="table table-nowrap table-centered mb-0">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th
                                                                                                        style="width: 70px;">
                                                                                                        No.</th>
                                                                                                    <th>Kendala</th>
                                                                                                    <th>Plat Nomor</th>
                                                                                                    <th>Jenis Kendaraan</th>
                                                                                                    <th class="text-end"
                                                                                                        style="width: 120px;">
                                                                                                        Pembayaran</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <th scope="row">01
                                                                                                    </th>
                                                                                                    <td>
                                                                                                        <h5
                                                                                                            class="font-size-15 mb-1">
                                                                                                            {{ $trx->kendala }}

                                                                                                        </h5>
                                                                                                        <ul
                                                                                                            class="list-inline mb-0">
                                                                                                            <li
                                                                                                                class="list-inline-item">
                                                                                                                {{ $trx->deskripsi }}
                                                                                                            </li>
                                                                                                        </ul>
                                                                                                    </td>
                                                                                                    <td>{{ $trx->plat_nomor }}
                                                                                                    </td>
                                                                                                    <td>{{ $trx->jenis_kendaraan }}
                                                                                                    </td>
                                                                                                    <td class="text-end">
                                                                                                        COD</td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                    <div class="d-print-none mt-4">
                                                                                        <div class="float-end">
                                                                                            <a href="javascript:window.print()"
                                                                                                class="btn btn-success waves-effect waves-light me-1"><i
                                                                                                    class="fa fa-print"></i></a>
                                                                                            <button
                                                                                                class="btn btn-primary w-md waves-effect waves-light"
                                                                                                data-bs-dismiss="modal">Close</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
@endsection
