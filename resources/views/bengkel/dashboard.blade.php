@extends('layouts.master')
@section('title')
    Dashboard
@endsection
<!-- plugin css -->
<link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/assets/libs/magnific-popup/magnific-popup.min.css') }}" rel="stylesheet" type="text/css" />
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Bengkel
        @endslot
        @slot('title')
            Dashboard
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-end mt-2">
                        {{-- <div id="total-revenue-chart" data-colors='["--bs-primary"]'></div> --}}
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{ $data['total_pesanan'] }}</span></h4>
                        <p class="text-muted mb-0">Total Pesanan</p>
                    </div>
                </div>
            </div>
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-end mt-2">
                        {{-- <div id="orders-chart" data-colors='["--bs-success"]'> </div> --}}
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{ $data['proses'] }}</span></h4>
                        <p class="text-muted mb-0">Pesanan Dalam Proses</p>
                    </div>
                </div>
            </div>
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-end mt-2">
                        {{-- <div id="customers-chart" data-colors='["--bs-primary"]'> </div> --}}
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{ $data['success'] }}</span></h4>
                        <p class="text-muted mb-0">Pesanan Selesai</p>
                    </div>
                </div>
            </div>
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">

            <div class="card">
                <div class="card-body">
                    <div class="float-end mt-2">
                        {{-- <div id="growth-chart" data-colors='["--bs-warning"]'></div> --}}
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{ $data['today'] }}</span></h4>
                        <p class="text-muted mb-0">Pesanan Hari ini</p>
                    </div>
                </div>
            </div>
        </div> <!-- end col-->
    </div> <!-- end row-->


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
                                    <th>Alamat</th>
                                    <th>Mekanik</th>
                                    <th>Tanggal</th>
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
                                                {{ $trx->alamat }}
                                            </td>

                                            <td>
                                                {{ optional($trx->mekanik()->first())->nama ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $trx->created_at->translatedFormat('l, j M Y H:i') }}
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
                                                @if ($trx->status == 'pending')
                                                    <button type="button"
                                                        class="btn btn-success btn-sm btn-rounded waves-effect waves-light me-2"
                                                        data-bs-toggle="modal" data-bs-target="#modal{{ $trx->id }}">
                                                        Terima
                                                    </button>
                                                    <form action="{{ route('trx-bengkel.update') }}" method="POST"
                                                        class="d-inline" id="tolakForm{{ $trx->id }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $trx->id }}">
                                                        <input type="hidden" name="status" value="canceled">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm btn-rounded waves-effect waves-light show_confirm">
                                                            Tolak
                                                        </button>
                                                    </form>
                                                @endif
                                                @if ($trx->status == 'process')
                                                    <form action="{{ route('trx-bengkel.update') }}" method="POST"
                                                        class="d-inline" id="selesaiForm{{ $trx->id }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $trx->id }}">
                                                        <input type="hidden" name="status" value="success">
                                                        <input type="hidden" name="mekanik"
                                                            value="{{ $trx->mekanik_id }}">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light confirm_done">
                                                            Selesai
                                                        </button>
                                                    </form>
                                                @endif
                                                <div class="modal fade" id="modal{{ $trx->id }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    role="dialog" aria-labelledby="staticBackdropLabel"
                                                    aria-hidden="true">
                                                    <form action="{{ route('trx-bengkel.update') }}" method="POST">
                                                        @csrf
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="staticBackdropLabel">
                                                                        Silahkan
                                                                        Pilih
                                                                        Mekanik
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body text-start">
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $trx->id }}">
                                                                    <input type="hidden" name="status" value="process">
                                                                    <div class="col-md-12">
                                                                        <label class="col-md-2 col-form-label">Kode Pesanan
                                                                            #MK{{ $trx->id }}</label>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label class="col-md-2 col-form-label">Pilh
                                                                            Mekanik</label>
                                                                        <select class="form-control select2"
                                                                            name="mekanik" required>
                                                                            <option value="" disabled selected>Pilih
                                                                                Mekanik</option>
                                                                            @foreach ($mekanik as $mk)
                                                                                <option value="{{ $mk->id }}">
                                                                                    {{ $mk->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Simpan</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
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
    {{-- SweetAlert2 --}}
    @if (Session::has('success'))
        <script>
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "{{ Session::get('success') }}",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif
    <!-- end row -->
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
        // DeleteConfirm
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.show_confirm').click(function(e) {
                e.preventDefault();

                var form = $(this).closest("form");
                Swal.fire({
                        title: 'Tolak Transaksi?',
                        text: "Transaksi akan ditolak!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Tolak!'
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                            Swal.fire(
                                'Success',
                                'Transaksi Ditolak!',
                                'success'
                            )

                        }
                    })
            });

            $('.confirm_done').click(function(e) {
                e.preventDefault();

                var form = $(this).closest("form");
                Swal.fire({
                        title: 'Apakah Transaksi Sudah Selesai?',
                        text: "Transaksi yang sudah terselesaikan tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Selesai!'
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                            Swal.fire(
                                'Success',
                                'Transaksi Selesai!',
                                'success'
                            )

                        }
                    })
            });


        });
    </script>
@endsection
