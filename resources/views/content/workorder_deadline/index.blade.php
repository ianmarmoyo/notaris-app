@extends('layouts/layoutMaster')

@section('title', 'Anggota')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
    <!-- Form Validation -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('page-style')
    <style>
        table.dataTable tbody tr td {
            text-transform: capitalize;
        }
    </style>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <!-- Flat Picker -->
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin-dashboard-analytics') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </nav>
    <!-- Form with Tabs -->
    <form action="{{ route('admin-workorderdeadline-store') }}" method="post">
        @csrf
        <div class="">
            <div class="card">
                <div class="card-header header-elements">
                    <span class="me-2">
                        <h5 class="mb-0">{{ $title }}</h5>
                    </span>

                    <div class="card-header-elements ms-auto">
                        <button type="submit" class="btn btn-primary"></span>Simpan</button>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="table datatable_">
                        <thead>
                            <tr>
                                <th width="10">#</th>
                                <th width="400">Keperluan</th>
                                <th width="300">Deadline</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($workOrders as $key => $wo)
                                <input type="hidden" name="master_workorder_id[]" value="{{ $wo->id }}">
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $wo->nama }}</td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" class="form-control" placeholder="" aria-label=""
                                                aria-describedby="basic-addon13" name="day_deadline[]"
                                                value="{{ $wo->day_deadline }}">
                                            <span class="input-group-text" id="basic-addon13">Hari</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/tables-datatables-basic.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/libs/accounting/accounting.min.js') }}"></script>

    <script>
        function modalFilter() {
            $('#modalFilter').modal('show');
        }

        $(document).ready(function() {
            moment.locale('id')
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil !',
                    text: '{{ session('success') }}',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            @endif
        });
    </script>
@endsection
