@extends('layouts/layoutMaster')

@section('title', $title)

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
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
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/block-ui/block-ui.js') }}"></script>
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
    <div class="row g-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header pt-2">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link waves-effect active" role="tab"
                                data-bs-toggle="tab" data-bs-target="#form-tabs-personal"
                                aria-controls="form-tabs-personal" aria-selected="true">Data
                                Pegawai</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab"
                                data-bs-target="#form-tabs-pengguna" aria-controls="form-tabs-pengguna"
                                aria-selected="false" tabindex="-1">Pengguna</button>
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
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="nama">Nama</label>
                                <input type="text" id="nama" name="nama" class="form-control test"
                                    placeholder="Masukan Nama Guru..." value="{{ @$user->employee->nama }}" disabled />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="date_birth">Tanggal Lahir</label>
                                <input type="text" class="form-control" placeholder="YYYY-MM-DD"
                                    value="{{ @$user->employee->tgl_lahir }}" disabled />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="place_of_birth">Tempat Lahir</label>
                                <input type="text" id="place_of_birth" name="place_of_birth" class="form-control"
                                    placeholder="Tempat Lahir..." value="{{ @$user->employee->tempat_lahir }}"
                                    disabled />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="gender">Jenis Kelamin</label>
                                <select name="gender" id="" class="select2 form-select" disabled>
                                    <option value=""></option>
                                    @foreach (config('enums.gender') as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $key == @$user->employee->jk ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="religion">Agama</label>
                                <select name="religion" id="" class="select2 form-select text-capitalize"
                                    disabled>
                                    <option value=""></option>
                                    @foreach (config('enums.regligions') as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $key == @$user->employee->agama ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phone">No WA/Telepon</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    placeholder="658 799 8941" value="{{ @$user->employee->no_telp }}" disabled />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="address">Alamat Lengkap</b></label>
                                <textarea name="address" id="" cols="30" rows="3" class="form-control"
                                    placeholder="Perumahan, Blok A01" disabled>{{ @$user->employee->alamat }}</textarea>
                            </div>
                        </div>
                        <div class="content-header mb-3 mt-3">
                            <h6 class="mb-0">Media Lampiran</h6>
                            <small>Lampiran Foto Diri.</small>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="photo">Foto Diri</label>
                                <div class="upload-container" id="image-login">
                                    <div class="upload-img">
                                        <img src="{{ @$user->employee->view_foto }}" alt = "">
                                    </div>
                                </div>
                                <div>

                                </div>
                            </div>
                        </div>
                        <div class="pt-4">
                        </div>
                    </div>

                    <div class="tab-pane fade" id="form-tabs-pengguna" role="tabpanel">
                        <div id="custom_loading" class="custome-loading custom_loading_all d-none">
                            <div class="spinner-border spinner-border-lg text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div class="row g-3">
                            <form id="form" action="{{ route('admin-useradmin-update', ['id' => $user]) }}">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="name">Nama Pengguna</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $user->name }}" placeholder="Full Name..." />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="email">Email</label>
                                    <div class="col-sm-10">
                                        <div class="input-group input-group-merge">
                                            <input type="text" name="email" class="form-control"
                                                value="{{ $user->email }}" placeholder="Email..." />
                                            <span id="" class="input-group-text">@example.com</span>
                                        </div>
                                        <div class="form-text"> You can use letters, numbers & periods </div>
                                    </div>
                                </div>
                                <div class="row mb-3 form-password-toggle">
                                    <label class="col-sm-2 col-form-label" for="password">Password</label>
                                    <div class="col-sm-10">
                                        <div class="input-group input-group-merge">
                                            <input type="password" name="password" id="bs-validation-password"
                                                class="form-control"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                required />
                                            <span class="input-group-text cursor-pointer" id="basic-default-password4"><i
                                                    class="ti ti-eye-off"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 form-password-toggle">
                                    <label class="col-sm-2 col-form-label"
                                        for="password_confirm">KonfirmasiPassword</label>
                                    <div class="col-sm-10">
                                        <div class="input-group input-group-merge">
                                            <input type="password" name="password_confirm" id="bs-validation-password"
                                                class="form-control"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                required />
                                            <span class="input-group-text cursor-pointer" id="basic-default-password4"><i
                                                    class="ti ti-eye-off"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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

            // Form Submit
            const form = document.getElementById('form');
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
                                message: 'Please enter full name.'
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter email address.'
                            },
                            emailAddress: {
                                message: 'Email address not valid'
                            }
                        }
                    },
                    password: {
                        validators: {
                            stringLength: {
                                min: 6,
                                max: 12,
                                message: 'Password minimal 6 and maximal 12 character'
                            }
                        }
                    },
                    password_confirm: {
                        validators: {
                            stringLength: {
                                min: 6,
                                max: 12,
                                message: 'Password minimal 6 dan maximal 12 character'
                            },
                            identical: {
                                compare: function() {
                                    return form.querySelector(
                                        '[name="password"]').value;
                                },
                                message: 'The password and confirmation are not the same'
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
                    url: $('#form').attr('action'),
                    method: 'POST',
                    data: new FormData($('#form')[0]),
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('.custom-loading').removeClass('d-none');
                    }
                }).done(function(response) {
                    $('.custom-loading').addClass('d-none');
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
                    $('.custom-loading').addClass('d-none');
                    toastr.warning(message, 'Warning', 1000);
                })
            });
        });

        function sectionBlock() {
            $('.modal-content').block({
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
            $('.modal-content').unblock();
        }
    </script>
@endsection
