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
                <h5 class=" me-2">{{ $title }}</h5>

                <div class="card-header-elements ms-auto">
                    @can('buat pengajuan')
                        <a href="{{ route('admin-requestworkorder-create') }}" class="btn btn-primary"><span
                                class="tf-icon ti ti-plus ti-xs me-1"></span>Buat Keperluan</a>
                    @endcan
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table nowrap datatable">
                    <thead>
                        <tr>
                            <th width="10">#</th>
                            <th>Invoice</th>
                            <th>Klien</th>
                            <th width="400">Layanan</th>
                            <th>Nominal</th>
                            <th>terbayar</th>
                            <th>status</th>
                            <th width="40">Aksi</th>
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
                    [1, "desc"]
                ],
                ajax: {
                    url: "{{ route('admin-requestworkorder-data') }}",
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
                        targets: 1,
                        render: function(data, type, full, meta) {
                            return `
                          <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="d-flex flex-column">
                              <span class="emp_name text-truncate">${data}</span>
                              <small class="emp_post text-truncate text-muted">
                                ${moment(full.tgl_pengajuan).format('LL')}
                              </small>
                            </div>
                          </div>
                          `;
                        }
                    },
                    {
                        targets: 3,
                        render: function(data, type, full, meta) {
                            let html = '';
                            full.work_order_details.forEach((wo, index) => {
                                html += `
                                  <li>
                                    <span class="text-capitalize" style="font-size: 14px">${wo.keperluan}</span>
                                  </li>
                                `;
                            });

                            return `
                            <ul>
                              ${html}
                            </ul>
                          `;
                        }
                    },
                    {
                        targets: [4, 5],
                        render: function(data, type, full, meta) {
                            return data.toLocaleString('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            })
                        }
                    },
                    {
                        targets: 6,
                        // className: "text-center",
                        render: function(data, type, full, meta) {
                            switch (data) {
                                case 'ready_to_work':
                                    return '<span class="badge rounded-pill bg-label-success">Siap Dikerjakan</span>';
                                    break;
                                    break;
                                case 'draft':
                                    return '<span class="badge rounded-pill bg-label-warning">Draft</span>';
                                    break;
                                default:
                                    break;
                            }
                        }
                    },
                    {

                        targets: 7,
                        title: 'Aksi',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            let btn_detail = `
                              @can('detail pengajuan')
                                <a href="{{ url('admin/request-workorder/detail') }}/${data}" class="dropdown-item"><i class="ti ti-eye me-1"></i>Detail</a>
                              @endcan
                            `;
                            let btn_edit = `
                              @can('ubah pengajuan')
                                <a href="{{ url('admin/request-workorder/edit') }}/${data}" class="dropdown-item item-edit"><i class="ti ti-pencil me-1"></i>Edit</a>
                              @endcan
                            `;
                            let btn_delete = `
                              @can('hapus pengajuan')
                                <a href="javascript:;" class="dropdown-item text-danger delete-record" data-id="${data}"><i class="ti ti-trash me-1"></i>Hapus</a>
                              @endcan
                            `;

                            if (full.status_wo == 'ready_to_work') {
                                btn_edit = '';
                                btn_delete = '';
                            } else {
                                btn_detail = '';
                            }

                            return (`
                                <div class="d-inline-block">
                                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="text-primary ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end m-0">
                                        ${btn_detail}
                                        ${btn_edit}
                                        ${btn_delete}
                                    </div>
                                </div>
                            `);
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
                        data: "no_wo"
                    },
                    {
                        data: "nama"
                    },
                    {
                        "orderable": false,
                        "searchable": false,
                        data: "nama"
                    },
                    {
                        "orderable": false,
                        "searchable": false,
                        data: "sum_harga" // nominal
                    },
                    {
                        "orderable": false,
                        "searchable": false,
                        data: "sum_payable" // terbayar
                    },
                    {
                        "orderable": false,
                        "searchable": false,
                        data: "status_wo"
                    },
                    {
                        data: "id"
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
                        url: "{{ url('/admin/request-workorder/delete') }}/" + id,
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
