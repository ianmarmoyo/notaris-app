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
                @can('accessroles_create', 'admin')
                    <button type="button" onclick="modal_add()" class="btn btn-primary"><span
                            class="tf-icon ti ti-plus ti-xs me-1"></span>Tambah Role</button>
                @endcan
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatable table" id="datatable_menu">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Role</th>
                        <th>Guard Name</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <!--/ Permission Table -->

    <!-- Modal -->
    @include('content.role.form_modal')
    <!-- /Modal -->
@endsection

@section('page-script')
    <script>
        function modal_add() {
            $('#addRoleForm').attr('action', "{{ route('admin-accessroles-store') }}");
            $("#addRoleForm").trigger("reset");
            $('#addRoleModal').find('h3').html('Tambah Role');
            $('#addRoleModal').modal('show');
        }
        $(document).ready(function() {
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
                    url: "{{ route('admin-accessroles-read') }}",
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
                }, {
                    // Actions
                    targets: 3,
                    searchable: false,
                    title: 'Hak Akses',
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return (`
                              <span class="text-nowrap">
                                <a href="{{ url('admin/accessroles/detail') }}/${row.id}" class="btn btn-sm btn-icon" data-id="${row.id}">
                                  <i class="ti ti-eye-check"></i>
                                </a>
                              </span>
                            `);
                    }
                }],
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
            $("#addRoleForm").validate({
                rules: {
                    role: "required",
                },
                messages: {
                    role: "Please enter a role name",
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: $('#addRoleForm').attr('action'),
                        method: 'post',
                        data: new FormData($('#addRoleForm')[0]),
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $('.custome-loading').removeClass('d-none');
                        }
                    }).done(function(response) {
                        $('.custome-loading').addClass('d-none');
                        if (response.status) {
                            $('#addRoleModal').modal('hide')
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
            let id = $(this).data('id');
            let name = $(this).data('name');
            let note = $(this).data('note');
            let el_form = $('#form');
            $('#form').attr('action', "");
            el_form.find('input#id').val(id);
            el_form.find('input#name').val(name);
            el_form.find('input#note').val(note);
            $('#addRoleModal').modal('show');
            $('#addRoleModal').find('h3').html('Ubah Nama Role');
        });

        $(document).on('click', '.delete-record', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Kamu Yakin?',
                text: "Data ini akan di hapus!",
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
                        url: "{{ url('/admin/guaranteedata/delete') }}/",
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

        $('#is_header').click(function() {
            if ($('#is_header').is(':checked')) {
                $('#menu_header').empty();
                $('#menu_header').select2("enable", true);
                $('input#menu_icon, input#slug').val('');
                $('input#menu_icon, input#slug').prop('disabled', true);

            } else {
                $('#menu_header').prop('disabled', false);
                $('input#menu_icon, input#slug').prop('disabled', false);
            }
        });

        function resetForm() {
            $('#form_add_menu').trigger('reset');
            $('#menu_header').empty();
            $('#menu_header').prop('disabled', false);
            $('input#menu_icon, input#slug').prop('disabled', false);
        }
    </script>
@endsection
