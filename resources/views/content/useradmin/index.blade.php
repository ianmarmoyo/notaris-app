@extends('layouts/layoutMaster')

@section('title', $title)

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
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
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header header-elements">
            <span class=" me-2">{{ $title }}</span>

            <div class="card-header-elements ms-auto">
                <a href="{{ route('admin-useradmin-create') }}" class="btn btn-primary"><span
                        class="tf-icon ti ti-plus ti-xs me-1"></span>Add User Admin</a>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="border-top">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Detail Status</th>
                        <th>Roles</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>

    <!-- Add Permission Modal -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Pilih Peran</h3>
                    </div>
                    <form id="form_sync_role" method="POST" class="row" action="">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <div class="col-md-12 mb-4">
                            <label for="roles" class="form-label">Pilih Peran</label>
                            <div class="select2-primary">
                                <select id="roles" class="select2 form-select multiple" multiple="">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 text-center demo-vertical-spacing">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Simpan</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Discard</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add Permission Modal -->

@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            $('select#roles').select2({
                allowClear: true,
                placeholder: 'Pilih Peran...',
                dropdownParent: $("#addRoleModal"),
            })

            dataTable = $('.datatables-users').DataTable({
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
                    url: "{{ route('admin-useradmin-read') }}",
                    type: "GET",
                    data: function(data) {

                    }
                },
                columnDefs: [{
                        orderable: false,
                        targets: [0]
                    },
                    {
                        className: "text-right",
                        targets: [0]
                    },
                    {
                        targets: 1,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, full, meta) {

                            var $name = full.name;

                            return (`
                              <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="d-flex flex-column">
                                    <span class="fw-medium">
                                      ${$name}
                                    </span>
                                </div>
                              </div>
                            `);
                        }
                    },
                    {
                        targets: 3,
                        searchable: false,
                        orderable: false,
                        className: "dt-center",
                        render: function(data, type, full, meta) {
                            let is_active = full.is_active == 'active' ?
                                '<span class="badge bg-success bg-glow">Active</span>' :
                                '<span class="badge bg-warning bg-glow">Not Active</span>';

                            return (`
                                ${is_active}
                            `);
                        }
                    },
                    {
                        targets: 4,
                        searchable: false,
                        orderable: false,
                        className: "dt-center",
                        render: function(data, type, full, meta) {
                            let roles = new Array(),
                              html = '';

                            $.each(full.roles, function(index, role) {
                                roles.push(role.name)
                            });

                            $.each(roles, function(index, role) {
                                html += `<span class="badge bg-primary bg-glow">${role}</span>`;
                            });

                            return (`
                                ${html}
                            `);
                        }
                    },
                    {
                        // Actions
                        targets: 5,
                        title: 'Actions',
                        className: "dt-center",
                        searchable: false,
                        orderable: false,
                        render: function(data, type, full, meta) {
                            let is_active = full.is_active == 'inactive' ?
                                'Active' :
                                'Inactive';

                            return (`
                                <a href="javascript:;" class="text-body dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm mx-1"></i></a>
                                  <div class="dropdown-menu dropdown-menu-end m-0">
                                    <a href="{{ url('admin/useradmin/edit') }}/${data}" class="dropdown-item"><i class="ti ti-edit me-1"></i>Edit</a>
                                    <a href="{{ url('admin/useradmin/userGiveRole') }}/${data}" class="dropdown-item"><i class="ti ti-eye-check me-1"></i>Detail</a>
                                    <a href="javascript:;" class="dropdown-item user-active" data-is_active="${full.is_active}" data-id="${data}"><i class="ti ti-checks me-1"></i>${is_active}</a>
                                    <a href="javascript:;" class="dropdown-item delete-record" data-id="${data}"><i class="ti ti-trash me-1"></i>Delete</a>
                                </div>
                            `);
                        }
                    }
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
                        data: "name"
                    },
                    {
                        data: "email"
                    },
                    {
                        data: "id"
                    },
                    {
                        data: "id"
                    },
                    {
                        className: "dt-center",
                        data: "id"
                    }
                ],
            });
        });

        $(document).on('click', '.user-active', function() {
            let id = $(this).data('id'),
                is_active = $(this).data('is_active'),
                alert = '';
            if (is_active == 'active') {
                alert = 'User Will Be Deactivated';
            } else {
                alert = 'User will reactivate it';
            }

            Swal.fire({
                title: 'Are you sure?',
                text: alert,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, do it!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('/admin/useradmin/is-active') }}",
                        method: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id
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
                                title: 'OK!',
                                text: 'Successfully.',
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

        $(document).on('click', '.delete-record', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('/admin/useradmin/delete') }}/" + id,
                        method: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
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
                                title: 'Deleted!',
                                text: 'Your file has been deleted.',
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
        });

        function addRole(element) {
            let roles = $(element).data('roles'),
                arrayRoles = roles.split(",");
            $('#addRoleModal').modal('show');
            console.log(arrayRoles);

            // $("select#roles").select2("val", arrayRoles);
            $.each(arrayRoles, function(i, e) {
                $("select#roles").select2("val", e);
            });
        }
    </script>
@endsection
