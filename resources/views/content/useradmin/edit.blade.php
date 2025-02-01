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
                <a href="{{ route('admin-useradmin-index') }}">List User Admin</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Basic with Icons -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $title }}</h5> <small class="text-muted float-end">(*) Cannot be
                        empty</small>
                </div>
                <div class="card-body">
                    <div id="custom_loading" class="custom-loading custom_loading_all d-none">
                        <div class="spinner-border spinner-border-lg text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <form id="form" action="{{ route('admin-useradmin-update', ['id' => $user]) }}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="name">Full Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}"
                                    placeholder="Full Name..." />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="email">Email</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" name="email" class="form-control" value="{{ $user->email }}"
                                        placeholder="Email..." />
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
                                        required />
                                    <span class="input-group-text cursor-pointer" id="basic-default-password4"><i
                                            class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 form-password-toggle">
                            <label class="col-sm-2 col-form-label" for="password_confirm">Password Confirmation</label>
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
        });
    </script>
@endsection
