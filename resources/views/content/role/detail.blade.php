@extends('layouts/layoutMaster')

@section('title', $title)

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('page-style')
    <style>
        label:has(+ input[required])::after {
            content: '*';
            color: red;
            margin-left: 3px;
            font-weight: bolder;
        }

        table.table-bordered.dataTable {
            border-right-width: 1px;
            border-left-width: 1px;
        }

        h2.accordion-header.parent-permission {
            display: flex
        }

        .form-check.parent-permission {
            margin-left: 1rem;
            font-size: 15px;
            position: relative;
            top: 10px
        }

        h2.parent-permission button.accordion-button {
            width: 10rem
        }

        #accordionSubMenu .card.accordion-item {
            box-shadow: 0px 1px 20px 0px #7367f0
        }
    </style>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/block-ui/block-ui.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin-dashboard-analytics') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin-accessroles-index') }}">Daftar Role</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </nav>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <form id="form" method="POST" action="{{ route('admin-accessroles-updatePermissions') }}">
            @csrf
            <div class="col-xxl">
                <div class="card mb-4" id="section-block">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ $title }}</h5> <small class="text-muted float-end"></small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="code">Nama Role</label>
                                <input type="text" name="role" class="form-control" value="{{ $role->name }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="accordion mt-3" id="accordionExample">
                                <div class="row gy-3">
                                    <div id="custom_loading" class="custome-loading custome_loading_all d-none">
                                        <div class="spinner-border spinner-border-lg text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                    @foreach ($menus as $key => $menu)
                                        <div class="col-md-12">
                                            <div class="card accordion-item">
                                                <h2 class="accordion-header parent-permission" id="">
                                                    <button type="button" class="accordion-button collapsed"
                                                        data-bs-toggle="collapse" data-bs-target="#{{ $menu->slug }}"
                                                        aria-expanded="false" aria-controls="{{ $menu->slug }}"
                                                        data-accordion="parent">
                                                        {{ $menu->name }}
                                                    </button>
                                                    {{-- Access Permission --}}
                                                    @if ($menu->access_menu)
                                                        @foreach ($menu->access_menu as $key => $access)
                                                            <?php
                                                            $is_checked = '';
                                                            if (in_array($access->permission->name, $userPermissions)) {
                                                                $is_checked = 'checked';
                                                            }
                                                            ?>
                                                            <div class="form-check parent-permission">
                                                                <input class="form-check-input" name="permissions[]"
                                                                    type="checkbox" value="{{ $access->permission->name }}"
                                                                    id="permission_parent_menu"
                                                                    @if ($is_checked) @checked(true) @endif>
                                                                <label class="form-check-label text-capitalize"
                                                                    for="permission_parent_menu">
                                                                    {{ str_starts_with($access->permission->name, '_') ? 'Tampilkan Halaman' : $access->permission->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </h2>

                                                <div id="{{ $menu->slug }}" class="accordion-collapse collapse"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        @if (count($menu->sub_menu) > 0)
                                                            <div class="accordion mt-3" id="accordionSubMenu">
                                                                <div class="row gy-3">
                                                                    <div id="custom_loading"
                                                                        class="custome-loading custome_loading_all d-none">
                                                                        <div class="spinner-border spinner-border-lg text-primary"
                                                                            role="status">
                                                                            <span class="sr-only">Loading...</span>
                                                                        </div>
                                                                    </div>
                                                                    @foreach ($menu->sub_menu as $sub_menu)
                                                                        <div class="col-md-4">
                                                                            <div class="card accordion-item">
                                                                                <h2 class="accordion-header" id="">
                                                                                    <button type="button"
                                                                                        class="accordion-button collapsed"
                                                                                        data-bs-toggle="collapse"
                                                                                        data-bs-target="#{{ 'accordion_submenu_' . $sub_menu->id }}"
                                                                                        aria-expanded="false"
                                                                                        data-accordion="child"
                                                                                        aria-controls="{{ 'accordion_submenu_' . $sub_menu->id }}">
                                                                                        {{ $sub_menu->name }}
                                                                                    </button>
                                                                                </h2>

                                                                                <div id="{{ 'accordion_submenu_' . $sub_menu->id }}"
                                                                                    class="accordion-collapse collapse"
                                                                                    data-bs-parent="#accordionSubMenu">
                                                                                    <div class="accordion-body">
                                                                                        {{-- Access Permission Sub Menu --}}
                                                                                        @if ($sub_menu->access_menu)
                                                                                            <?php
                                                                                            $is_checked = '';
                                                                                            if (in_array($sub_menu->access_menu->permission->name, $userPermissions)) {
                                                                                                $is_checked = 'checked';
                                                                                            }
                                                                                            ?>
                                                                                            <div class="form-check">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="checkbox"
                                                                                                    value="{{ $sub_menu->access_menu->permission->name }}"
                                                                                                    name="permissions[]"
                                                                                                    id="permission_child_menu"
                                                                                                    @if ($is_checked) @checked(true) @endif />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="permission_child_menu">
                                                                                                    {{ $sub_menu->access_menu->permission->name }}
                                                                                                </label>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @else
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
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
                    type: {
                        validators: {
                            notEmpty: {
                                message: 'Pilih jenis transacksi.'
                            }
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
                        sectionBlock();
                    }
                }).done(function(response) {
                    sectionUnBlock()
                    if (response.status) {
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
                    sectionUnBlock()
                    toastr.warning(message, 'Warning', 1000);
                })
            });
        });

        // $('button[data-accordion="parent"]').on('click', function() {
        //     let el = $(this),
        //         is_permission = el.find('.form-check');
        //     let cek_class = el.closest('.accordion-item').hasClass('active')
        //     if (is_permission.length > 0 && cek_class) {
        //         is_permission.find('input[type=checkbox]').prop('checked', true);
        //     } else {
        //         is_permission.find('input[type=checkbox]').prop('checked', false);
        //     }
        //     console.log('Checkbox For Child Parent ....');
        // });

        $('input#permission_parent_menu').on('click', function() {
            let checked = $(this).is(':checked'),
                el = $(this),
                card_sub_menu = el.closest('.accordion-item').find('#accordionSubMenu');
            if (!checked && card_sub_menu.length > 0) {
                uncheckAllPermissionSubMenu(el);
            }
        });

        function uncheckAllPermissionSubMenu(el) {
            let card_sub_menu = el.closest('.accordion-item').find('#accordionSubMenu')
            // Swal.fire({
            //     title: 'Peringatan!',
            //     text: 'Jika Kamu mengahapus centang di menu parent, maka mengahapus semua centang di sub menu!',
            //     icon: 'warning',
            //     customClass: {
            //         confirmButton: 'btn btn-primary'
            //     },
            //     buttonsStyling: false
            // });
            // el.prop('checked', true);
            // return;
            Swal.fire({
                title: 'Apa Kamu Yakin?',
                text: "Jika Kamu mengahapus centang di menu parent, maka mengahapus semua centang di sub menu!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya hapus centang!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    el.prop('checked', false);
                    card_sub_menu.find('input#permission_child_menu').prop('checked', false)

                } else {
                    el.prop('checked', true)
                }
            });
        }

        function sectionBlock() {
            $('#section-block').block({
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
            $('#section-block').unblock();
        }
    </script>
@endsection
