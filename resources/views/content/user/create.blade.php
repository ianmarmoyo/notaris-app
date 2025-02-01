@extends('layouts/layoutMaster')

@section('title', $title)

@section('vendor-style')
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

        .custom-loading {
            z-index: 1001;
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            text-align: center;
            backdrop-filter: blur(2px);
        }

        .custom-loading i,
        .custom-loading div {
            position: relative;
            top: 40%;
        }
    </style>
@endsection

@section('vendor-script')
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
                <a href="{{ route('admin-user-index') }}">Daftar User</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Basic with Icons -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $title }}</h5> <small class="text-muted float-end">(*) Tidak boleh
                        kosong</small>
                </div>
                <div class="card-body">
                    <div id="custom_loading" class="custom-loading custom_loading_all d-none">
                        <div class="spinner-border spinner-border-lg text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <form id="form" action="{{ route('admin-user-store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="name">Untuk User ?</label>
                            <div class="col-sm-10">
                                <select name="assign_user" id="" class="form-control select2">
                                    <option value=""></option>
                                    <option value="employee">Pegawai</option>
                                    <option value="member">Anggota</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="name">User</label>
                            <div class="col-sm-10">
                                <select name="assign_id" id="" class="form-control select2"></select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="name">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" placeholder="Nama User..."
                                    readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="email">Email</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" name="email" class="form-control" placeholder="Email..."
                                        readonly />
                                    <span id="" class="input-group-text">@example.com</span>
                                </div>
                                <div class="form-text"> You can use letters, numbers & periods </div>
                            </div>
                        </div>
                        <div class="row mb-3 form-password-toggle">
                            <label class="col-sm-2 col-form-label" for="password">Password</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password" id="bs-validation-password" class="form-control"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        required readonly />
                                    <span class="input-group-text cursor-pointer" id="basic-default-password4"><i
                                            class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 form-password-toggle">
                            <label class="col-sm-2 col-form-label" for="password_confirm">Konfirmasi Password</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password_confirm" id="bs-validation-password"
                                        class="form-control"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        required readonly />
                                    <span class="input-group-text cursor-pointer" id="basic-default-password4"><i
                                            class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script>
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
                                message: 'Masukan nama pengguna.'
                            }
                        }
                    },
                    assign_user: {
                        validators: {
                            notEmpty: {
                                message: 'Pilih jenis pengguna.'
                            }
                        }
                    },
                    assign_id: {
                        validators: {
                            notEmpty: {
                                message: `Pilih data pengguna.`
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Masukan alamat email.'
                            },
                            emailAddress: {
                                message: 'Alamat email tidak valid'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Masukan password pengguna'
                            },
                            stringLength: {
                                min: 6,
                                max: 12,
                                message: 'Password minimal 6 dan maksimal 12 karakter'
                            }
                        }
                    },
                    password_confirm: {
                        validators: {
                            notEmpty: {
                                message: 'Masukan konfirmasi password'
                            },
                            stringLength: {
                                min: 6,
                                max: 12,
                                message: 'Password minimal 6 dan maksimal 12 karakter'
                            },
                            identical: {
                                compare: function() {
                                    return form.querySelector(
                                        '[name="password"]').value;
                                },
                                message: 'Kata sandi dan konfirmasinya tidak sama'
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
                    $('.custom-loading').addClass('d-none');
                    toastr.warning(message, 'Warning', 1000);
                })
            });

            $('select[name=assign_id]').select2({
                allowClear: true,
                placeholder: 'Pilih...',
                ajax: {
                    url: "{{ route('admin-user-memberAndEmployee') }}",
                    type: 'get',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            name: params.term,
                            page: params.page,
                            limit: 30,
                            assign_user: $('select[name=assign_user]').val()
                        };
                    },
                    processResults: function(data, params) {
                        var option = [];
                        params.page = params.page || 1;
                        $.each(data.data, function(index, item) {
                            option.push({
                                id: item.id,
                                text: item.name,
                                email: item.email
                            });
                        });
                        return {
                            results: option,
                            pagination: {
                                more: (params.page * 30) < data.recorsTotal
                            }
                        };
                    },
                },
            }).on('change.select2', function() {
                validation.revalidateField('assign_id');
            });

            $('select[name=assign_user]').trigger('change')
            $('select[name=assign_id]').prop('disabled', true);
        });

        $(document).on('change', 'select[name=assign_user]', function() {
            let el_form = $('form#form');
            el_form.find('input').not('input[name=_token]').val('')
            el_form.find('select[name=assign_id]').empty().prop('disabled', false);
            el_form.find('input').prop('readonly', false);
        })

        $(document).on('change', 'select[name=assign_id]', function() {
            let data = $(this).select2('data')[0],
                el_form = $('form#form');
            console.log(data);

            el_form.find('input[name=name]').val(data.text)
            el_form.find('input[name=email]').val(data.email)
        })
    </script>
@endsection
