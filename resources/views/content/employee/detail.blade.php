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
                <a href="{{ route('admin-employee-index') }}">Daftar Pegawai</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- Customer Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class=" d-flex align-items-center flex-column">
                            <div class="user-info text-center">
                                <h4 class="mb-2 text-capitalize">{{ $employee->nama }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap pt-2 pb-2 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="">
                                <img src="{{ $employee->view_foto }}" alt="{{ $employee->nama }}" width="150"
                                    class="rounded">
                            </div>
                        </div>
                    </div>
                    <p class="mt-4 small text-uppercase text-muted">Detail Data Diri</p>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <span class="fw-medium me-1">No Telepon :</span>
                                <span>{{ $employee->no_telp }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium me-1">Agama :</span>
                                <span>{{ $employee->agama }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium me-1">Jenis Kelamin :</span>
                                <span>{{ $employee->jk }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium me-1">Tgl Lahir :</span>
                                <span>{{ $employee->tgl_lahir }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium me-1">Tempat Lahir :</span>
                                <span>{{ $employee->tempat_lahir }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium me-1">Alamat :</span>
                                <span>{{ $employee->alamat }}</span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center">

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
                            data-bs-target="#navs-work-order" aria-controls="navs-work-order" aria-selected="true"
                            tabindex="-1"><i class="tf-icons ti ti-building-bank ti-xs me-1"></i>
                            Work Order</button>
                    </li>
                    {{-- <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pindah-kelas" aria-controls="navs-pindah-kelas" aria-selected="true"
                            tabindex="-1"><i class="tf-icons ti ti-arrows-move ti-xs me-1"></i>
                            Pindah Kelas
                        </button>
                    </li> --}}
                </ul>
                <div class="tab-content">
                    {{-- work-order --}}
                    <div class="tab-pane fade show active" id="navs-work-order" role="tabpanel">
                        {{-- <h5 class="card-header">Riwayat Kelas</h5> --}}
                        <div class="card-datatable table-responsive mb-3">
                            <table class="table table-bordered table-hover border-top" style="border: 1px solid #dbdade;"
                                id="dt-work-order">
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
                                <tbody>

                                </tbody>
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
            $('input#date_print').flatpickr({
                dateFormat: "d-m-Y",
            })

            dataTable = $('#dt-work-order').DataTable({
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
                      data.employee_admin_id = @json(@$employee->admin->id) ?? '-1';
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

                            let btn_edit = `
                            <a href="{{ url('admin/work-order/form') }}/${data}" class="dropdown-item"><i class="ti ti-edit me-1"></i>Edit</a>
                          `;
                            if (full.status_penugasan == 'Selesai') {
                                btn_edit = ``;
                            }

                            return (`
                                <div class="d-inline-block">
                                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="text-primary ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end m-0">
                                        <a href="{{ url('admin/work-order/detail') }}/${data}" class="dropdown-item"><i class="ti ti-eye me-1"></i>Detail</a>
                                        ${btn_edit}
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
