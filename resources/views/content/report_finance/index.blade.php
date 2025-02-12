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
    <div class="">
        <div class="card">
            <div class="card-header header-elements">
                <span class="me-2">
                    <h5 class="mb-0">{{ $title }}</h5>
                </span>

                <div class="card-header-elements ms-auto">
                    {{-- <a href="{{ route('admin-payment-create') }}" class="btn btn-primary"><span
                            class="tf-icon ti ti-plus ti-xs me-1"></span>Buat Pembayaran</a> --}}
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th width="10">#</th>
                            <th width="400">No Pengajuan</th>
                            <th width="400">Nama Pengaju</th>
                            <th width="350">Keperluan</th>
                            <th>tgl pembayaran</th>
                            <th width="250">Nominal</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
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
            dataTable = $('.datatable').DataTable({
                stateSave: true,
                processing: true,
                serverSide: true,
                filter: true,
                info: false,
                lengthChange: true,
                responsive: true,
                order: [
                    [2, "desc"]
                ],
                ajax: {
                    url: "{{ route('admin-reportfinance-data') }}",
                    type: "GET",
                    data: function(data) {

                    }
                },
                columnDefs: [{
                        orderable: false,
                        targets: [0]
                    },
                    {
                        className: "text-right",
                        targets: [0]
                    },
                    {
                        targets: 3,
                        render: function(data, type, full, meta) {
                            let html = '';
                            full.work_order_details.forEach((wo, index) => {
                                html += `
                                  <span class="badge rounded-pill bg-label-primary">${wo.keperluan}</span>
                                `;
                            });

                            return `
                            <div class="d-flex gap-2 flex-column text-capitalize">
                              ${html}
                            </div>
                          `;
                        }
                    },
                    {
                        targets: [4],
                        render: function(data, type, full, meta) {
                            return data ? moment(data).format('DD MMMM YYYY HH:mm') : '';
                        }
                    },
                    {
                        targets: [5],
                        render: function(data, type, full, meta) {
                            return accounting.formatMoney(data, "", 0, ".", ",");
                        }
                    }
                ],
                columns: [{
                        data: null,
                        className: "dt-center",
                        "orderable": false,
                        "searchable": false,
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        "orderable": false,
                        "searchable": false,
                        data: "no_wo"
                    },
                    {
                        data: "nama_klien"
                    },
                    {
                        data: "nama_klien"
                    },
                    {
                        data: "tgl_bayar"
                    },
                    {
                        "orderable": false,
                        "searchable": false,
                        data: "nominal"
                    }
                ]
            });
        });

        $(document).on('click', '.delete-record', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Apa Kamu Yakin?',
                text: "Data ini akan di hapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya hapus!',
                cancelButtonText: 'Tidak!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('/admin/employee/delete') }}/" + id,
                        method: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            $('.overlay').removeClass('d-none');
                        }
                    }).done(function(response) {
                        $('.overlay').addClass('d-none');
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil !',
                                text: 'Data telah di hapus.',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            dataTable.draw();
                        } else {
                            Swal.fire({
                                title: 'Warning!',
                                text: response.message,
                                icon: 'warning',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            });
                        }
                        return;
                    }).fail(function(response) {
                        const {
                            status,
                            message
                        } = response.responseJSON
                        Swal.fire({
                            title: 'Warning!',
                            text: message,
                            icon: 'warning',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    })
                }
            });
        });

        $('form#form-filter').submit(function(e) {
            e.preventDefault();
            dataTable.draw();
            $('#modalFilter').modal('hide');
        });
    </script>
@endsection
