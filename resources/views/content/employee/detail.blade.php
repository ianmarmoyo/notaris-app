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
                                <img src="{{ $employee->view_foto }}" alt="{{ $employee->nama }}" width="150" class="rounded">
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
                            data-bs-target="#navs-riwayat-kelas" aria-controls="navs-riwayat-kelas" aria-selected="true"
                            tabindex="-1"><i class="tf-icons ti ti-history ti-xs me-1"></i>
                            Riwayat Kelas</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pindah-kelas" aria-controls="navs-pindah-kelas" aria-selected="true"
                            tabindex="-1"><i class="tf-icons ti ti-arrows-move ti-xs me-1"></i>
                            Pindah Kelas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-riwayat-rapor" aria-controls="navs-riwayat-rapor" aria-selected="true"
                            tabindex="-1"><i class="tf-icons ti ti-history ti-xs me-1"></i>
                            Riwayat Rapor
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    {{-- riwayat-kelas --}}
                    <div class="tab-pane fade show active" id="navs-riwayat-kelas" role="tabpanel">
                        {{-- <h5 class="card-header">Riwayat Kelas</h5> --}}
                        <div class="card-datatable table-responsive mb-3">
                            <table class="table table-bordered table-hover border-top" style="border: 1px solid #dbdade;"
                                id="dt-riwayat-kelas">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kelas</th>
                                        <th>Keterangan</th>
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

            let form = document.getElementById('form-pindah-kelas');
            const validation = FormValidation.formValidation(form, {
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    institution_id: {
                        validators: {
                            notEmpty: {
                                message: 'Lembaga wajib diisi.'
                            }
                        }
                    },
                    next_kelas_id: {
                        validators: {
                            notEmpty: {
                                message: 'Kelas wajib diisi.'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5(),
                    autoFocus: new FormValidation.plugins.AutoFocus(),
                    submitButton: new FormValidation.plugins.SubmitButton()
                }
            }).on('core.form.valid', function() {
                $.ajax({
                    url: $('#form-pindah-kelas').attr('action'),
                    method: 'POST',
                    data: new FormData($('#form-pindah-kelas')[0]),
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#nav-tabContent').block({
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
                }).done(function(response) {
                    $('#nav-tabContent').unblock();
                    if (response.status) {
                        location.reload();
                        toastr.success(response.message, 'Success', 1000);
                    } else {
                        toastr.warning(response.message, 'Warning', 1000);
                    }
                    return;
                }).fail(function(response) {
                    const {
                        status,
                        message
                    } = response.responseJSON
                    $('#nav-tabContent').unblock();
                    toastr.warning(message, 'Warning', 1000);
                });
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
