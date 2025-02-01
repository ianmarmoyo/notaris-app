@extends('layouts/layoutMaster')

@section('title', ' Vertical Layouts - Forms')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
@endsection

@section('page-style')
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
    </style>
@endsection

@section('vendor-script')
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
                <a href="{{ route('admin-useradmin-index') }}">User Admin</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </nav>
    <!-- Form with Tabs -->
    <div class="row">
        <div class="col">
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
                        <form method="POST" id="form"
                            action="{{ route('admin-useradmin-updateadmin', ['id' => $user->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="name">Nama Lengkap</label>
                                    <input type="text" id="name" name="name" class="form-control test"
                                        placeholder="Masukan Nama Anggota..." value="{{ $user->name }}" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="date_birth">Tanggal Lahir</label>
                                    <input type="text" id="date_birth" name="date_birth"
                                        value="{{ @$user->guru->tgl_lahir }}" class="form-control dob-picker"
                                        placeholder="YYYY-MM-DD" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="place_of_birth">Tempat Lahir</label>
                                    <input type="text" id="place_of_birth" name="place_of_birth" class="form-control"
                                        placeholder="Tempat Lahir..." value="{{ @$user->guru->tempat_lahir }}" />
                                </div>
                              </div>
                            <div class="pt-4">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                <button type="reset" class="btn btn-label-secondary">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#province_id, #regencie_id, #district_id').trigger('change');

            let form = document.getElementById('form');
            const validation = FormValidation.formValidation(form, {
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Nama wajib diisi.'
                            }
                        }
                    },
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
            }).on('core.form.valid', function() {
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
                    let {
                        status,
                        message,
                        route
                    } = response
                    $('.custome-loading').addClass('d-none');
                    if (status) {
                        toastr.success(message, 'Berhasil', 1000);
                    } else {
                        toastr.warning(message, 'Warning', 1000);
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

        });
    </script>
@endsection
