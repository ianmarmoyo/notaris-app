@extends('layouts/layoutMaster')

@section('title', $title)

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-validate/jquery.validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-style')
    <style>
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

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin-dashboard-analytics') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </nav>
    <!-- Permission Table -->
    <div class="card">
        <div class="card-header header-elements">
            <span class=" me-2">{{ $title }}</span>

            <div class="card-header-elements ms-auto">
                <button type="button" onclick="modal_add()" class="btn btn-primary"><span
                        class="tf-icon ti ti-plus ti-xs me-1"></span>Tambahkan Hak Akses</button>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatable table" id="datatable_menu">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Hak Akses</th>
                        <th>Assign To</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <!--/ Permission Table -->

    <!-- Modal -->
    @include('content.accessPermision.form_modal')
    <!-- /Modal -->
    @include('_partials/_modals/modal-edit-permission')
@endsection

@section('page-script')
    <script>
        function modal_add() {
            $('#form').attr('action', "{{ route('admin-accessPermission-store') }}");
            $("#form").trigger("reset");
            $('#addPermissionModal').find('h3').html('Tambah Hak Akses');
            $('#addPermissionModal').modal('show');
        }
        $(document).ready(function() {

            $("select[name=accessForMenu]").select2({
                allowClear: true,
                placeholder: 'Pilih...',
                dropdownParent: $("#addPermissionModal"),
            });

            $("#parent_menu_id").select2({
                allowClear: true,
                placeholder: 'Select Parent Menu',
                dropdownParent: $("#addPermissionModal"),
                // templateResult: formatResultUser,
                ajax: {
                    url: "{{ route('admin-menu-select') }}",
                    type: 'get',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            name: params.term,
                            page: params.page,
                            limit: 30,
                        };
                    },
                    processResults: function(data, params) {
                        var option = [];
                        params.page = params.page || 1;
                        $.each(data.data, function(index, item) {
                            option.push({
                                id: item.id,
                                text: item.name,
                                slug: item.slug
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
            });

            $("#child_menu_id").select2({
                allowClear: true,
                placeholder: 'Select Child Menu',
                dropdownParent: $("#addPermissionModal"),
                // templateResult: formatResultUser,
                ajax: {
                    url: "{{ route('admin-menu-selectChildMenu') }}",
                    type: 'get',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            name: params.term,
                            page: params.page,
                            limit: 30,
                        };
                    },
                    processResults: function(data, params) {
                        var option = [];
                        params.page = params.page || 1;
                        $.each(data.data, function(index, item) {
                            option.push({
                                id: item.id,
                                text: item.name,
                                slug: item.slug
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
            });

            dataTable = $('.datatable').DataTable({
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
                    url: "{{ route('admin-accessPermission-read') }}",
                    type: "GET",
                    data: function(data) {

                    }
                },
                "drawCallback": function(settings) {
                    $('[data-toggle="tooltip"]').tooltip()
                },
                columnDefs: [{
                        orderable: false,
                        searchable: false,
                        targets: [0]
                    },
                    {
                        // User Role
                        targets: 2,
                        orderable: false,
                        render: function(data, type, full, meta) {
                            var $assignedTo = full['roles'],
                                $output = '';

                            var roleBadgeObj = {
                                superadmin: '<a href="javascript:;"><span class="badge bg-label-primary m-1">Super Admin</span></a>',
                                admin: '<a href="javascript:;"><span class="badge bg-label-warning m-1">Admin</span></a>',
                                member: '<a href="javascript:;"><span class="badge bg-label-success m-1">Anggota</span></a>'
                            };


                            $.each($assignedTo, function(index, val) {
                                switch (val.name) {
                                    case 'superadmin':
                                        $output += roleBadgeObj[val.name];
                                        break;
                                    case 'admin':
                                        $output += roleBadgeObj[val.name];
                                        break;
                                    case 'member':
                                        $output += roleBadgeObj[val.name];
                                        break;
                                    default:
                                        break;
                                }
                            });

                            return '<span class="text-nowrap">' + $output + '</span>';
                        }
                    },
                    {
                        // Actions
                        targets: -1,
                        searchable: false,
                        title: 'Aksi',
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return (`
                              <span class="text-nowrap">
                                  <button class="btn btn-sm btn-icon me-2 item-edit" data-id="${row.id}" data-name="${row.name}" data-bs-toggle="modal" data-bs-dismiss="modal">
                                    <i class="ti ti-edit"></i>
                                  </button>
                                <button class="btn btn-sm btn-icon delete-record" data-id="${row.id}">
                                  <i class="ti ti-trash"></i>
                                </button>
                              </span>
                            `);
                        }
                    },
                ],
                columns: [{
                        data: null,
                        "class": "align-top",
                        "orderable": false,
                        "searchable": false,
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        className: "details-control",
                        data: "name"
                    },
                    {
                        data: "guard_name"
                    },
                    {
                        data: "id"
                    }
                ]
            });

            // Form Submit
            $("#form").validate({
                rules: {
                    role: "required",
                },
                messages: {
                    role: "Please enter a access name",
                },
                submitHandler: function(form) {
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
                            $('#addPermissionModal').modal('hide')
                            resetForm();
                            dataTable.draw();
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
                }
            });

            $("#editPermissionForm").validate({
                rules: {
                    role: "required",
                },
                messages: {
                    role: "Please enter a access name",
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: $('#editPermissionForm').attr('action'),
                        method: 'post',
                        data: new FormData($('#editPermissionForm')[0]),
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $('.custome-loading').removeClass('d-none');
                        }
                    }).done(function(response) {
                        $('.custome-loading').addClass('d-none');
                        if (response.status) {
                            $('#editPermissionModal').modal('hide')
                            resetForm();
                            dataTable.draw();
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
                }
            });
        });

        $(document).on('click', '.item-edit', function() {
            let name = $(this).data('name'),
                id = $(this).data('id');
            let el_form = $('#editPermissionForm');
            $('#editPermissionForm').attr('action', "{{ route('admin-accessPermission-update') }}");
            el_form.find('input#id').val(id);
            el_form.find('input#name').val(name);
            $('#editPermissionModal').modal('show');
            $('#editPermissionModal').find('h3').html('Ubah Nama Role');
        });

        $(document).on('click', '.delete-record', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Kamu Yakin?',
                text: "Peringatan Dengan mengahapus, Anda mungkin merusak fungsi izin sistem. Harap pastikan Anda benar-benar yakin sebelum melanjutkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya hapus!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('/admin/accessPermission/delete') }}/",
                        method: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            $('.overlay').removeClass('d-none');
                        }
                    }).done(function(response) {
                        $('.overlay').addClass('d-none');
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: 'Data berhasil di hapus.',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            dataTable.draw();
                        } else {
                            Swal.fire({
                                title: 'Warning!',
                                text: response.message,
                                icon: 'warning',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            });
                        }
                        return;
                    }).fail(function(response) {
                        const {
                            status,
                            message
                        } = response.responseJSON
                        Swal.fire({
                            title: 'Warning!',
                            text: message,
                            icon: 'warning',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    })
                }
            });
        })

        $('select#accessForMenu').on('change', function() {
            let element = $(this),
                value = element.val(),
                parent_menu_id = $('select[name=parent_menu_id]'),
                child_menu_id = $('select[name=child_menu_id]'),
                access_name = $('input[name=name]');

            parent_menu_id.empty();
            child_menu_id.empty();

            if (value == 'parent') {
                parent_menu_id.closest('.col-12').removeClass('d-none');
                child_menu_id.closest('.col-12').addClass('d-none');
            } else if (value == 'child') {
                child_menu_id.closest('.col-12').removeClass('d-none');
                parent_menu_id.closest('.col-12').addClass('d-none');
            } else {
                parent_menu_id.closest('.col-12').addClass('d-none');
                child_menu_id.closest('.col-12').addClass('d-none');
            }
        });

        $('select[name=parent_menu_id]').on('change', function() {
            let slug = $(this).select2('data')[0].slug,
                access_name = $('input[name=name]');
            access_name.val(slug);
        });

        $('select[name=child_menu_id]').on('change', function() {
            let slug = $(this).select2('data')[0].slug,
                access_name = $('input[name=name]');
            access_name.val(slug);
        });

        function resetForm() {
            $('#form').trigger('reset');
            $('#accessForMenu').val('').change();
            $('#parent_menu_id').empty();
            $('#child_menu_id').empty();
        }
    </script>
@endsection
