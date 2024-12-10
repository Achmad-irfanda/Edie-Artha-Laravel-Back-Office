@extends('layouts.master')
@section('title')
    Mekanik
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
            Mekanik
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <div>
                            <a href="{{ route('mekanik.create') }}" type="button"
                                class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-plus me-1"></i>
                                Tambah Mekanik</a>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-centered datatable dt-responsive nowrap table-card-list"
                                style="border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 120px;">No</th>
                                        <th>Nama</th>
                                        <th>No Hp</th>
                                        <th>Jabatan</th>
                                        <th>Alamat</th>
                                        <th>Cabang</th>
                                        <th style="width: 120px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mekaniks as $mekanik)
                                        <tr>
                                            <td><a href="javascript: void(0);"
                                                    class="text-reset  fw-bold">{{ $loop->iteration }}</a> </td>
                                            <td>
                                                <img src="{{ URL::asset($mekanik->image) }}" alt=""
                                                    class="avatar-xs rounded-circle me-2">
                                                <span>{{ $mekanik->nama }}</span>
                                            </td>
                                            <td>
                                                {{ $mekanik->nohp }}
                                            </td>
                                            <td>
                                                {{ $mekanik->jabatan }}
                                            </td>

                                            <td>
                                                {{ $mekanik->alamat }}
                                            </td>
                                            <td>
                                                <div class="badge bg-pill bg-success-subtle text-success font-size-12">
                                                    {{ $mekanik->cabang }}
                                                </div>
                                            </td>
                                            <td class="flex">
                                                <div style="display: flex;">
                                                    <a href="{{ route('mekanik.edit', $mekanik) }}"
                                                        class="px-3 text-primary"><i
                                                            class="uil uil-pen font-size-18"></i></a>
                                                    <form action="{{ route('mekanik.destroy', $mekanik) }}" method="POST">
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
                        text: "Data Mekanik Akan dihapus!",
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
                                'Mekanik Deleted!',
                                'success'
                            )

                        }
                    })
            });

        });
    </script>
@endsection
