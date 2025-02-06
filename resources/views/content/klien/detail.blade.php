@extends('layouts/layoutMaster')

@section('title', $title)

@section('page-style')
    <style>
        .datatable-vehicles th {
            font-size: 13px;
        }

        .datatable-vehicles tbody td {
            cursor: pointer;
        }

        .thumbs {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            max-width: 100%;

            a {
                max-width: 150px;
                height: 150px;
                margin: 10px;
                overflow: hidden;
                border-radius: 5px;
                border: 3px solid gray;
                box-shadow: 0 0 0 3px grey, 0 5px 8px 3px rgba(black, 0.6);

                img {
                    transform: scale(1);
                    transition: transform 0.1s ease-in-out;
                    filter: grayscale(50%);
                    min-width: 100%;
                    min-height: 100%;
                    max-width: 100%;
                    max-height: 100%;
                }

                &:hover {
                    img {
                        transform: scale(1.1);
                        filter: grayscale(0%);
                    }
                }
            }
        }

        .nav-link.active {
            width: fit-content;
        }

        .vertical-text {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            text-align: center;
        }

        table.dataTable tbody tr td {
            text-transform: capitalize;
        }

        table tbody tr td {
            text-transform: capitalize;
        }

        .client-card {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 10px;
            margin-bottom: 15px;
            align-items: baseline;
            text-transform: capitalize;
        }

        .label {
            font-weight: bold;
            color: #666;
        }

        .value {
            color: #333;
        }

        .address {
            line-height: 1.5;
        }
    </style>
@endsection

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/rateyo/rateyo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/rateyo/rateyo.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/accounting/accounting.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/block-ui/block-ui.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin-dashboard-analytics') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin-client-index') }}">Daftar Klien</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- Customer Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="info-container">
                        <div class="d-flex">
                            <div>
                                <div class="form-group">
                                    <div class="label">Nama</div>
                                    <div class="value">
                                        {{ $client->nama }}</div>
                                </div>
                                <div class="form-group">
                                    <div class="label">Nomor Telepon</div>
                                    <div class="value">
                                        {{ $client->no_telp }}</div>
                                </div>
                                <div class="form-group">
                                    <div class="label">Alamat</div>
                                    <div class="value">
                                        {{ $client->alamat }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /User Card -->
        </div>
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <div class="nav-align-top" id="nav-tabContent">
                <ul class="nav nav-pills mb-3 nav-fill" style="width: fit-content">
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-keperluan" aria-controls="navs-keperluan" aria-selected="true"
                            tabindex="-1"><i class="tf-icons ti ti-message-2-exclamation ti-xs me-1"></i>
                            Keperluan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pengajuan-keperluan" aria-controls="navs-pengajuan-keperluan"
                            aria-selected="true" tabindex="-1"><i class="tf-icons ti ti-history ti-xs me-1"></i>
                            Pengajuan Keperluan</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pembayaran" aria-controls="navs-pembayaran" aria-selected="true"
                            tabindex="-1"><i class="tf-icons ti ti-wallet ti-xs me-1"></i>
                            Pembayaran</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-keperluan" role="tabpanel">
                        <div class="card-datatable table-responsive mb-3">
                            <table class="table table-bordered table-hover border-top" style="border: 1px solid #dbdade;"
                                id="dt-workorder">
                                <thead>
                                    <tr>
                                        <th width="10">#</th>
                                        <th width="400">Invoice Pengajuan</th>
                                        <th width="300">Tgl Pengajuan</th>
                                        <th width="700">Keperluan</th>
                                        <th width="300">Penugasan Ke</th>
                                        <th width="300">Tgl Penugasan</th>
                                        <th width="400">Status Penugasan</th>
                                        <th width="40">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-pengajuan-keperluan" role="tabpanel">
                        <div class="card-datatable table-responsive mb-3">
                            <table class="table table-bordered table-hover border-top" style="border: 1px solid #dbdade;"
                                id="dt-pengajuan-keperluan">
                                <thead>
                                    <tr>
                                        <th width="10">#</th>
                                        <th width="400">Invoice</th>
                                        <th width="300">Nama</th>
                                        <th width="300">Tanggal Pengajuan</th>
                                        <th width="300">Status Keperluan</th>
                                        <th width="40">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-pembayaran" role="tabpanel">
                        <div class="card-datatable table-responsive mb-3">
                            <table class="table table-bordered table-hover border-top" style="border: 1px solid #dbdade;"
                                id="dt-pembayaran">
                                <thead>
                                    <tr>
                                        <th width="10">#</th>
                                        <th width="400">No Pembayaran</th>
                                        <th width="300">Tgl Pembayaran</th>
                                        <th width="700">Pengajuan Keperluan</th>
                                        <th width="300">Nominal</th>
                                        <th width="40">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            moment.locale('id')
            dt_work_order = $('#dt-workorder').DataTable({
                stateSave: true,
                processing: true,
                serverSide: true,
                filter: true,
                info: false,
                lengthChange: true,
                responsive: true,
                order: [
                    [4, "desc"]
                ],
                ajax: {
                    url: "{{ route('admin-workorder-data') }}",
                    type: "GET",
                    data: function(data) {
                        data.client_id = "{{ $client->id }}"
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
                              <span class="emp_name text-truncate">${full.nama_klien}</span>
                              <small class="emp_post text-truncate text-muted">
                                ${data}
                              </small>
                            </div>
                          </div>
                          `;
                        }
                    },
                    {
                        targets: [2, 5],
                        render: function(data, type, full, meta) {
                            return moment(data).format('LL');
                        }
                    },
                    {
                        targets: 4,
                        render: function(data, type, full, meta) {
                            return `
                          <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="d-flex flex-column">
                              <span class="emp_name text-truncate">${full.nama_admin}</span>
                              <small class="emp_post text-truncate text-muted">

                              </small>
                            </div>
                          </div>
                          `;
                        }
                    },
                    {

                        targets: 7,
                        title: 'Aksi',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return (`
                                <div class="d-inline-block">
                                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="text-primary ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end m-0">
                                        <a href="{{ url('admin/work-order/detail') }}/${data}" class="dropdown-item"><i class="ti ti-eye me-1"></i>Detail</a>
                                        <a href="{{ url('admin/work-order/form') }}/${data}" class="dropdown-item"><i class="ti ti-edit me-1"></i>Edit</a>
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
                        "orderable": false,
                        "searchable": false,
                        data: "no_wo"
                    },
                    {
                        data: "tgl_pengajuan"
                    },
                    {
                        data: "keperluan"
                    },
                    {
                        data: "nama_admin"
                    },
                    {
                        data: "tgl_penugasan"
                    },
                    {
                        data: "status_penugasan"
                    },
                    {
                        "orderable": false,
                        "searchable": false,
                        data: "id"
                    }
                ]
            });

            dt_pengajuan_keperluan = $('#dt-pengajuan-keperluan').DataTable({
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
                        data.client_id = "{{ $client->id }}"
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
                            return moment(data).format('LL');
                        }
                    },
                    {
                        targets: 4,
                        render: function(data, type, full, meta) {
                            switch (data) {
                                case 'ready_to_work':
                                    return 'Siap Dikerjaan';
                                    break;
                                    break;
                                case 'draft':
                                    return 'Draft';
                                    break;
                                default:
                                    break;
                            }
                        }
                    },
                    {

                        targets: 5,
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
                        data: "tgl_pengajuan"
                    },
                    {
                        data: "status_wo"
                    },
                    {
                        data: "id"
                    }
                ]
            });

            dt_pembayaran = $('#dt-pembayaran').DataTable({
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
                    url: "{{ route('admin-payment-data') }}",
                    type: "GET",
                    data: function(data) {
                      data.client_id = "{{ $client->id }}"
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
                        targets: [2],
                        render: function(data, type, full, meta) {
                            return moment(data).format('DD MMMM YYYY HH:mm');
                        }
                    },
                    {
                        targets: 3,
                        render: function(data, type, full, meta) {
                            return `
                          <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="d-flex flex-column">
                              <span class="emp_name text-truncate">
                                <a href="{{ url('admin/request-workorder/detail') }}/${full.work_order_id}" class="text-body text-primary">
                                  ${full.no_wo}
                                </a>
                              </span>
                              <small class="emp_post text-truncate text-muted">
                                ${full.nama_klien}
                              </small>
                            </div>
                          </div>
                          `;
                        }
                    },
                    {
                        targets: [4],
                        render: function(data, type, full, meta) {
                            return accounting.formatMoney(data, "", 0, ".", ",");
                        }
                    },
                    {

                        targets: 5,
                        title: 'Aksi',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return (`
                                <div class="d-inline-block">
                                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="text-primary ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end m-0">
                                        <a href="{{ url('admin/payment/detail') }}/${data}" class="dropdown-item"><i class="ti ti-eye me-1"></i>Detail</a>
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
                        "orderable": false,
                        "searchable": false,
                        data: "no_pembayaran"
                    },
                    {
                        data: "tgl_bayar"
                    },
                    {
                        data: "nama_klien"
                    },
                    {
                        "orderable": false,
                        "searchable": false,
                        data: "nominal"
                    },
                    {
                        "orderable": false,
                        "searchable": false,
                        data: "id"
                    }
                ]
            });
        });

        function sectionBlock() {
            $('.modal-body').block({
                message: '<div class="spinner-border text-primary" role="status"></div>',
                css: {
                    backgroundColor: 'transparent',
                    border: '0',
                },
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.8
                }
            });
        }

        function sectionUnBlock() {
            $('.modal-body').unblock();
        }
    </script>
@endsection
