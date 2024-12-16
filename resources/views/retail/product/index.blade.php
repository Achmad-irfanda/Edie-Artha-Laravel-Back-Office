@extends('layouts.master')
@section('title')
    Sparepart
    
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Data
        @endslot
        @slot('title')
            Sparepart
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <div>
                            <a href="{{ route('product.create') }}" type="button"
                                class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-plus me-1"></i>
                                Tambah Sparepart</a>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-centered datatable dt-responsive nowrap table-card-list"
                                style="border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 120px;">Kode Sparepart</th>
                                        <th>Nama</th>
                                        <th>Varian</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Stok</th>
                                        <th style="width: 120px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td><a href="javascript: void(0);"
                                                    class="text-reset  fw-bold">{{ $product->kode }}</a> </td>
                                            <td>
                                                <img src="{{ URL::asset($product->thumbnail) }}" alt=""
                                                    class="avatar-xs rounded-circle me-2">
                                                <span>{{ $product->nama }}</span>
                                            </td>
                                            <td>
                                                @foreach (json_decode($product->varian) as $varian)
                                                    <div
                                                        class="badge bg-pill bg-secondary-subtle text-secondary font-size-12">
                                                        {{ $varian }}
                                                    </div>
                                                @endforeach
                                            </td>

                                            <td>
                                                @currency($product->harga)
                                            </td>
                                            <td>
                                                <div
                                                    class="badge bg-pill bg-{{ $product->status == 'Ready' ? 'success' : 'danger' }}-subtle text-{{ $product->status == 'Ready' ? 'success' : 'danger' }} font-size-12">
                                                    {{ $product->status }}
                                                </div>
                                            </td>

                                            <td>
                                                {{ $product->stok }}
                                            </td>
                                            <td class="flex">
                                                <div style="display: flex;">
                                                    <a href="{{ route('product.edit', $product) }}"
                                                        class="px-3 text-primary"><i
                                                            class="uil uil-pen font-size-18"></i></a>
                                                    <form action="{{ route('product.destroy', $product) }}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <a href="javascript:void(0);"
                                                            onclick="document.getElementById('deleteForm').submit()"
                                                            class="px-3 text-danger show_confirm"><i
                                                                class="uil uil-trash-alt font-size-18"></i></a>
                                                    </form>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/ecommerce-datatables.init.js') }}"></script>
    {{-- SweetAlert --}}
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

                var deleteId = $(this).closest("tr").find('.delete_id').val();
                var form = $(this).closest("form");
                Swal.fire({
                        title: 'Apa anda yakin?',
                        text: "Data Sparepart Akan dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                            Swal.fire(
                                'Success',
                                'Sparepart Deleted!',
                                'success'
                            )

                        }
                    })
            });

        });
    </script>
@endsection
