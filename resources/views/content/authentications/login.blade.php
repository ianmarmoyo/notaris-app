@php
    $customizerHidden = 'customizer-hide';
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Login Cover - Pages')

@section('vendor-style')
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>
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
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter user mail.'
                            },
                            emailAddress: {
                                message: 'Email address is not valid.'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter user password'
                            },
                            // stringLength: {
                            //     min: 6,
                            //     max: 12,
                            //     message: 'Password minimal 6 dan maksimal 12 karakter'
                            // }
                        }
                    }
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
                        disableButton();
                    }
                }).done(function(response) {
                    enableButton();
                    if (response.status) {
                        document.location = response.route
                        toastr.success(response.message, 'Success', 1000);
                    } else {
                        toastr.options.progressBar = true;
                        toastr.warning(response.message, 'Warning', 1000);
                    }
                    return;
                }).fail(function(response) {
                    enableButton();
                    const {
                        status,
                        message
                    } = response.responseJSON
                    toastr.warning(message, 'Warning', 1000);
                })
            });
        });

        function disableButton() {
            let el = $('button#btn_login');
            el.prop('disabled', true);
            el.find('span.spinner-border').removeClass('d-none');
            el.find('span.text').html('Loading...');
        }

        function enableButton() {
            let el = $('button#btn_login');
            el.prop('disabled', false);
            el.find('span.spinner-border').addClass('d-none');
            el.find('span.text').html('Sign In');
        }
    </script>
@endsection

@section('content')
    <div class="authentication-wrapper authentication-cover authentication-bg">
        <div class="authentication-inner row">
            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 p-0">
                <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
                    <img src="{{ asset('storage/' . config('configs.img_banner_login')) }}" alt="auth-login-cover"
                        class="img-fluid my-5 auth-illustration">
                </div>
            </div>
            <!-- /Left Text -->

            <!-- Login -->
            <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <div class="app-brand mb-4 d-flex justify-content-center">
                        <a href="{{ url('/') }}" class="app-brand-link gap-2">
                            <center>
                                <img class="icon_sidebar" src="{{ asset('storage/' . config('configs.img_banner_icon')) }}"
                                    style="width: 12em;margin-left: 2em" alt="" srcset="">
                            </center>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h3 class=" mb-1">Welcome to {{ config('configs.app_name') }}! 👋</h3>

                    <form id="form" method="POST" action="{{ route('admin-login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Enter Email..." autofocus>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Password</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me">
                                <label class="form-check-label" for="remember-me">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        {{-- <button type="submit" class="btn btn-primary d-grid w-100">
                            Login
                        </button> --}}
                        <button class="btn btn-primary d-grid w-100" id="btn_login" type="submit">
                            <div>
                                <span class="spinner-border me-1 d-none" role="status" aria-hidden="true"></span>
                                <span class="text">Sign In</span>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Login -->
    </div>
    </div>
@endsection
