@extends('layouts/layoutMaster')

@section('title', $title)

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/css/thumbnail.css') }}">
    <style>
        label:has(+ input[required])::after {
            content: '*';
            color: red;
            margin-left: 3px;
            font-weight: bolder;
        }

        .custome-loading {
            z-index: 1001;
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            text-align: center;
            backdrop-filter: blur(2px);
        }

        .custome-loading i,
        .custome-loading div {
            position: relative;
            top: 40%;
        }

        table.dataTable tbody tr td {
            text-transform: capitalize;
        }
    </style>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
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
    <!-- Form with Tabs -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header pt-2">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#form-tabs-personal"
                                role="tab" aria-selected="true">Data Diri</button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    {{-- Form Personal --}}
                    <div class="tab-pane fade active show" id="form-tabs-personal" role="tabpanel">
                        <div id="custom_loading" class="custome-loading custom_loading_all d-none">
                            <div class="spinner-border spinner-border-lg text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <form method="POST" id="form" action="{{ route('admin-employee-store') }}">
                            @csrf
                            <div class="row mb-3 g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="nama">Nama</label>
                                    <input type="text" id="nama" name="nama" class="form-control test"
                                        placeholder="Masukan Nama..." required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="date_birth">Tanggal Lahir</label>
                                    <input type="text" id="date_birth" name="date_birth" class="form-control dob-picker"
                                        placeholder="YYYY-MM-DD" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="place_of_birth">Tempat Lahir</label>
                                    <input type="text" id="place_of_birth" name="place_of_birth" class="form-control"
                                        placeholder="Tempat Lahir..." />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="gender">Jenis Kelamin</label>
                                    <select name="gender" id="" class="select2 form-select">
                                        <option value=""></option>
                                        @foreach (config('enums.gender') as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="religion">Agama</label>
                                    <select name="religion" id="" class="select2 form-select text-capitalize">
                                        <option value=""></option>
                                        @foreach (config('enums.regligions') as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="phone">No WA/Telepon</label>
                                    <input type="text" id="phone" name="phone" class="form-control"
                                        placeholder="658 799 8941" aria-label="658 799 8941" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="address">Alamat Lengkap</b></label>
                                    <textarea name="address" id="" cols="30" rows="3" class="form-control"
                                        placeholder="Perumahan, Blok A01"></textarea>
                                </div>
                            </div>
                            <div class="content-header mb-3 mt-3">
                                <div class="divider">
                                    <div class="divider-text">
                                        Media Lampiran
                                    </div>
                                </div>
                                <small>Lampiran Foto Diri.</small>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="photo">Foto Diri</label>
                                    <div class="upload-container" id="image-login">
                                        <div class="upload-img">
                                            <img src="" alt = "">
                                        </div>
                                        <center>
                                            <p class="upload-text text-muted">Silakan pilih gambar yang akan diunggah.</p>
                                        </center>
                                    </div>
                                    <div>
                                        <input type="file" name="foto" class="visually-hidden"
                                            id="upload-input-login">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="pt-4">
                        <button type="submit" form="form" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-label-secondary">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script>
        $('#image-login').click(function() {
            $('#upload-input-login').trigger('click');
        });

        $('#upload-input-login').change(event => {
            const file = event.target.files[0];
            const reader = new FileReader();
            let el = $('#image-login')
            reader.readAsDataURL(file);

            reader.onloadend = () => {
                el.find('.upload-text').text(file.name);
                el.find('.upload-img img').attr('aria-label', file.name);
                el.find('.upload-img img').attr('src', reader.result);
            }
        })

        $(document).ready(function() {

            let form = document.getElementById('form');
            const validation = FormValidation.formValidation(form, {
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        nama: {
                            validators: {
                                notEmpty: {
                                    message: 'Nama wajib diisi.'
                                }
                            }
                        },
                        jabatan: {
                            validators: {
                                notEmpty: {
                                    message: 'Nama jabatan wajib diisi.'
                                }
                            },
                        },
                        // 'guru_kelases[]': {
                        //     validators: {
                        //         notEmpty: {
                        //             message: 'Guru mengajar wajib diisi.'
                        //         }
                        //     },
                        // },
                        phone: {
                            validators: {
                                notEmpty: {
                                    message: 'Nomor telepon wajib diisi.'
                                },
                                stringLength: {
                                    min: 11,
                                    max: 12,
                                    message: 'Nomor telepon minimal 11 digit dan maksimal 12 digit.'
                                },
                            }
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap5: new FormValidation.plugins.Bootstrap5(),
                        autoFocus: new FormValidation.plugins.AutoFocus(),
                        submitButton: new FormValidation.plugins.SubmitButton()
                    }
                })
                .on('core.form.valid', function() {
                    $.ajax({
                        url: $('#form').attr('action'),
                        method: 'post',
                        data: new FormData($('#form')[0]),
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $('.custome-loading').removeClass('d-none');
                        }
                    }).done(function(response) {
                        $('.custome-loading').addClass('d-none');
                        if (response.status) {
                            document.location = response.route;
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
                        $('.custome-loading').addClass('d-none');
                        toastr.warning(message, 'Warning', 1000);
                    })
                });

            $('select[name=gender]').select2({
                allowClear: true,
                placeholder: 'Pilih Jenis Kelamin...',
            });

            $('select[name=jabatan]').select2({
                allowClear: true,
                placeholder: 'Pilih Jabatan...',
            });

            $('select[name=religion]').select2({
                allowClear: true,
                placeholder: 'Pilih Agama...',
            });
        });
    </script>
@endsection
