@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Retail
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
                    <h4 class="card-title mb-4">Pesanan Produk</h4>
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
                                    <th>Produk</th>
                                    <th>Nama Customer</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>View Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $trx)
                                    <tr>
                                        <td>
                                            <div class="form-check font-size-16">
                                                <input type="checkbox" class="form-check-input" id="customCheck2">
                                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td><a href="javascript: void(0);"
                                                class="text-body fw-bold">#EAM{{ $trx->id }}</a> </td>
                                        <td>
                                            @foreach ($trx->items as $product)
                                                <li>
                                                    <img src="{{ asset($product->product()->get()->implode('thumbnail')) }}"
                                                        alt="" class="avatar-xs rounded-circle me-2">
                                                    <a href="#"
                                                        class="text-body">{{ Str::limit($product->product()->get()->implode('nama'), 25) }}</a>
                                                </li>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $trx->user()->get()->implode('name') }}
                                        </td>
                                        <td>
                                            {{ $trx->created_at->translatedFormat('l, j M Y H:i') }}
                                        </td>
                                        <td>
                                            @currency($trx->total)

                                        </td>
                                        <td>
                                            <i class="fas fa-money-bill me-1"></i> {{ $trx->pembayaran }}
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
                                        <td>
                                            <button type="button"
                                                class="btn btn-primary btn-sm btn-rounded waves-effect waves-light me-2t"
                                                data-bs-toggle="modal" data-bs-target=".detail{{ $trx->id }}">
                                                Lihat
                                                Detail</button>
                                            <!--  Large modal example -->
                                            <div class="modal fade detail{{ $trx->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content text-start">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myLargeModalLabel">Detail
                                                                Transaksi #MK{{ $trx->id }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="card checkout-order-summary">
                                                                                <div class="card-body">
                                                                                    <div class="p-3 bg-light mb-4">
                                                                                        <h5 class="font-size-16 mb-0">Detail
                                                                                            Transaksi <span
                                                                                                class="float-end ms-2">#MK{{ $trx->id }}4</span>
                                                                                        </h5>
                                                                                    </div>
                                                                                    <div class="table-responsive">
                                                                                        <table
                                                                                            class="table table-centered mb-0 table-nowrap">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th class="border-top-0"
                                                                                                        style="width: 110px;"
                                                                                                        scope="col">
                                                                                                        Produk</th>
                                                                                                    <th class="border-top-0"
                                                                                                        scope="col">
                                                                                                        Detail</th>
                                                                                                    <th class="border-top-0"
                                                                                                        scope="col">Harga
                                                                                                    </th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                @foreach ($trx->items as $product)
                                                                                                    <tr>
                                                                                                        <th scope="row">
                                                                                                            <img src="{{ asset($product->product()->get()->implode('thumbnail')) }}"
                                                                                                                alt="product-img"
                                                                                                                title="product-img"
                                                                                                                class="avatar-md">
                                                                                                        </th>
                                                                                                        <td>
                                                                                                            <h5
                                                                                                                class="font-size-14 text-truncate">
                                                                                                                <a href="ecommerce-product-detail"
                                                                                                                    class="text-reset">{{ $product->product()->get()->implode('nama') }}</a>
                                                                                                            </h5>
                                                                                                            <p
                                                                                                                class="text-muted mb-0">
                                                                                                                @currency($product->harga)
                                                                                                                x
                                                                                                                {{ $product->kuantitas }}
                                                                                                            </p>
                                                                                                        </td>
                                                                                                        <td> @currency($product->total)
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                @endforeach

                                                                                                <tr>
                                                                                                    <td colspan="2">
                                                                                                        <h5
                                                                                                            class="font-size-14 m-0">
                                                                                                            Jasa Pasang :
                                                                                                        </h5>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        @if ($trx->jasa_pasang == 'YA')
                                                                                                            <span
                                                                                                                class="badge rounded-pill bg-success-subtle text-success font-size-12">{{ $trx->jasa_pasang }}</span>
                                                                                                        @else
                                                                                                            <span
                                                                                                                class="badge rounded-pill bg-danger-subtle text-danger font-size-12">{{ $trx->jasa_pasang }}</span>
                                                                                                        @endif

                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td colspan="2">
                                                                                                        <h5
                                                                                                            class="font-size-14 m-0">
                                                                                                            Sub Total :</h5>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        @currency($trx->total)
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td colspan="2">
                                                                                                        <h5
                                                                                                            class="font-size-14 m-0">
                                                                                                            Biaya Ongkir
                                                                                                            :</h5>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        @currency(0)
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr class="bg-light">
                                                                                                    <td colspan="2">
                                                                                                        <h5
                                                                                                            class="font-size-14 m-0">
                                                                                                            Total:</h5>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        @currency($trx->total)
                                                                                                    </td>
                                                                                                </tr>

                                                                                            </tbody>
                                                                                            <div class="modal-footer">
                                                                                                @if ($trx->status == 'pending')
                                                                                                    <form
                                                                                                        action="{{ route('trx-retail.update', $trx->id) }}"
                                                                                                        method="POST">
                                                                                                        @csrf
                                                                                                        <input
                                                                                                            type="hidden"
                                                                                                            name="status"
                                                                                                            value="process">
                                                                                                        <button
                                                                                                            type="submit"
                                                                                                            class="btn btn-success">Proses
                                                                                                            Pesanan</button>
                                                                                                    </form>
                                                                                                    <form
                                                                                                        action="{{ route('trx-retail.update', $trx->id) }}"
                                                                                                        method="POST">
                                                                                                        @csrf
                                                                                                        <input
                                                                                                            type="hidden"
                                                                                                            name="status"
                                                                                                            value="canceled">
                                                                                                        <button
                                                                                                            type="submit"
                                                                                                            class="btn btn-danger">Tolak
                                                                                                            Pesanan</button>
                                                                                                    </form>
                                                                                                @endif
                                                                                                @if ($trx->status == 'process')
                                                                                                    <form
                                                                                                        action="{{ route('trx-retail.update', $trx->id) }}"
                                                                                                        method="POST">
                                                                                                        @csrf
                                                                                                        <input
                                                                                                            type="hidden"
                                                                                                            name="status"
                                                                                                            value="success">
                                                                                                        <button
                                                                                                            type="submit"
                                                                                                            class="btn btn-success">Transaksi
                                                                                                            Selesai</button>
                                                                                                    </form>
                                                                                                @endif

                                                                                            </div>
                                                                                        </table>

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
