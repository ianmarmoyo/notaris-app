@extends('layouts/layoutMaster')

@section('title', $title)

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/nestable/nestable.min.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-validate/jquery.validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/nestable/jquery.nestable.js') }}"></script>
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

        .dd-handle {
            display: block;
            height: 40px;
            padding: 8px 10px;
            text-decoration: none;
            font-weight: 500;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .dd-handle span {
            font-weight: 500;
        }

        .dd-item>button {
            margin: 10px 0;
        }

        .dd .is-header {
            background: mediumpurple;
            color: white;
        }
    </style>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin-dashboard-analytics') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Menu Management</li>
        </ol>
    </nav>
    <!-- Permission Table -->
    <div class="card">
        <div class="card-header header-elements">
            <span class=" me-2">Menu Menagement</span>

            <div class="card-header-elements ms-auto">
                <a href="javascript:;" onclick="modal_sort()" class="btn btn-primary"><span
                        class="tf-icon ti ti-menu-order ti-xs"></span></a>
                <button type="button" onclick="modal_add()" class="btn btn-primary"><span
                        class="tf-icon ti ti-plus ti-xs me-1"></span>Tambah Menu</button>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatable table-hover table" id="datatable_menu">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>URL</th>
                        <th>Icon</th>
                        <th>Is Header</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <!--/ Permission Table -->

    <!-- Modal -->
    @include('content.menu.modal-sort', ['menusParent' => $menusParent])
    @include('content.menu.modal-add')
    @include('content.menu.modal-edit')
    @include('content.menu.modal-edit-menuchild')
    @include('_partials/_modals/modal-edit-permission')
    <!-- /Modal -->
@endsection

@section('page-script')
    <script>
        function modal_sort() {
            $.ajax({
                url: "{{ url('/admin/menu/getParentMenu') }}/",
                method: 'GET',
                data: {},
                dataType: 'json',
                beforeSend: function() {

                }
            }).done(function(response) {
                if (response.status) {
                    $('ol.dd-list').empty();
                    $('#modal_sort').modal('show');
                    $('form#form-sort').attr('action', "{{ route('admin-menu-updatesort') }}");
                    let html = '';
                    $.each(response.data, function(index, val) {
                        let is_header = '';
                        if (val.is_header == 1) {
                            is_header = 'is-header';
                        }
                        html += `
                            <li class="dd-item" data-id="${val.id}">
                                <div class="dd-handle ${is_header}">${val.name}</div>
                            </li>
                        `;
                    });
                    $('ol.dd-list').append(html);
                } else {

                }
                return;
            }).fail(function(response) {
                const {
                    status,
                    message
                } = response.responseJSON
            })
        }

        function modal_add() {
            $('#addPermissionModal').modal('show');
        }

        $(document).ready(function() {
            $('.dd').nestable({
                maxDepth: 1
            }).nestable('collapseAll');

            $("#menu_header").select2({
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
                                text: item.name
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

            $("#menu_header_foredit").select2({
                allowClear: true,
                placeholder: 'Select Parent Menu',
                dropdownParent: $("#modal_edit"),
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
                                text: item.name
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
                    url: "{{ route('admin-menu-read') }}",
                    type: "GET",
                    data: function(data) {

                    }
                },
                "drawCallback": function(settings) {
                    $('[data-toggle="tooltip"]').tooltip()
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
                        render: function(data, type, row) {
                            let result = '';
                            if (row.is_header == '1') {
                                result = `
                                    <span class="badge bg-primary">${data}</span>
                                `;
                            } else {
                                result = `
                                    <p class="details-control" style="cursor:pointer;">${data}</p>
                                `;
                            }
                            return result;
                        },
                        targets: [1]
                    },
                    {
                        render: function(data, type, row) {
                            return `<i class="${data}"></i>`;
                        },
                        targets: [3]
                    },
                    {
                        render: function(data, type, row) {
                            return `<i class="${data}"></i>`;
                        },
                        targets: [3]
                    },
                    {
                        // Label
                        targets: 4,
                        render: function(data, type, full, meta) {
                            var $status_number = full['is_header'];
                            var $status = {
                                0: {
                                    title: 'No Header',
                                    class: 'bg-label-primary'
                                },
                                1: {
                                    title: 'Is Header',
                                    class: ' bg-label-success'
                                }
                            };
                            if (typeof $status[$status_number] === 'undefined') {
                                return data;
                            }
                            return (
                                '<span class="badge ' + $status[$status_number].class + '">' +
                                $status[$status_number].title + '</span>'
                            );
                        }
                    },
                    {
                        targets: 5,
                        title: 'Actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return (`
                              <div class="d-inline-block">
                                  <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="text-primary ti ti-dots-vertical"></i>
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-end m-0">
                                      <a href="{{ url('admin/member/show') }}/${data}" class="dropdown-item">Details</a>
                                      <a href="javascript:;" class="dropdown-item">Archive</a>
                                      <a href="javascript:;" class="dropdown-item sort-child" data-id="${data}">Sort</a>
                                      <div class="dropdown-divider">

                                      </div>
                                      <a href="javascript:;" class="dropdown-item text-danger delete-record" data-id="${row.id}" data-is_parent="${row.sub_menu.length}">Delete</a>
                                  </div>
                              </div>
                              <a href="javascript:;" class="btn btn-sm btn-icon item-edit" data-id="${data}" data-is_header=${row.is_header} data-is_parent="${true}" data-name="${row.name}" data-icon="${row._icon}" data-slug="${row.slug}">
                                <i class="text-primary ti ti-pencil"></i>
                              </a>
                            `);
                        }
                    }
                ],
                columns: [{
                        data: "no"
                    },
                    {
                        className: "details-control",
                        data: "name"
                    },
                    {
                        data: "uri"
                    },
                    {
                        data: "icon"
                    },
                    {
                        data: "is_header"
                    },
                    {
                        data: "id"
                    },
                ]
            });

            // Form Submit
            $("#form_add_menu").validate({
                rules: {
                    menu_name: "required",
                },
                messages: {
                    menu_name: "Please enter a menu name",
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: $('#form_add_menu').attr('action'),
                        method: 'post',
                        data: new FormData($('#form_add_menu')[0]),
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
                        $('.custome-loading').addClass('d-none');
                        toastr.error(response.message, 'Error', 1000);
                    })
                }
            });

            $("#form_edit_menu").validate({
                rules: {
                    menu_name: "required",
                },
                messages: {
                    menu_name: "Please enter a menu name",
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: $('#form_edit_menu').attr('action'),
                        method: 'post',
                        data: new FormData($('#form_edit_menu')[0]),
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $('.custome-loading').removeClass('d-none');
                        }
                    }).done(function(response) {
                        $('.custome-loading').addClass('d-none');
                        if (response.status) {
                            $('#modal_edit').modal('hide')
                            resetForm();
                            dataTable.draw();
                            toastr.success(response.message, 'Success', 1000);
                        } else {
                            toastr.warning(response.message, 'Warning', 1000);
                        }
                        return;
                    }).fail(function(response) {
                        $('.custome-loading').addClass('d-none');
                        toastr.error(response.message, 'Error', 1000);
                    })
                }
            });

            $("#form_edit_submenu").validate({
                rules: {
                    menu_name: "required",
                },
                messages: {
                    menu_name: "Please enter a menu name",
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: $('#form_edit_submenu').attr('action'),
                        method: 'post',
                        data: new FormData($('#form_edit_submenu')[0]),
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $('.custome-loading').removeClass('d-none');
                        }
                    }).done(function(response) {
                        $('.custome-loading').addClass('d-none');
                        if (response.status) {
                            $('#modal_edit_submenu').modal('hide')
                            resetForm();
                            dataTable.draw();
                            toastr.success(response.message, 'Success', 1000);
                        } else {
                            toastr.warning(response.message, 'Warning', 1000);
                        }
                        return;
                    }).fail(function(response) {
                        $('.custome-loading').addClass('d-none');
                        toastr.error(response.message, 'Error', 1000);
                    })
                }
            });

            // Form Submit
            $("#form-sort").on("submit", function(event) {
                event.preventDefault();
                $.ajax({
                    url: $('#form-sort').attr('action'),
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "order": JSON.stringify($('.dd').nestable('serialize'))
                    },
                    type: 'POST',
                    beforeSend: function() {
                        $('.custome-loading').removeClass('d-none');
                    }
                }).done(function(response) {
                    if (response.status) {
                        $('.custome-loading').addClass('d-none');
                        $('#modal_sort').modal('hide');
                        location.reload()
                        toastr.success(response.message, 'Success', 1000);
                        return;
                    } else {
                        $('.custome-loading').removeClass('d-none');
                        toastr.warning(response.message, 'Warning', 1000);
                    }
                }).fail(function(response) {
                    var response = response.responseJSON;
                    $('.custome-loading').addClass('d-none');
                    toastr.error(response.message, 'Error', 1000);
                })
            });
        });

        // Add event listener for opening and closing details
        $('#datatable_menu tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = dataTable.row(tr);
            console.log({
                tr,
                row
            });

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });

        function format(data) {
            let html = '';
            data.sub_menu.forEach((val, index) => {
                html += `
                    <tr>
                        <td>${val.name}</td>
                        <td>${val.uri}</td>
                        <td>
                            <div class="d-inline-block">
                                  <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="text-primary ti ti-dots-vertical"></i>
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-end m-0">
                                      <a href="{{ url('admin/member/show') }}/${data}" class="dropdown-item">Details</a>
                                      <a href="javascript:;" class="dropdown-item">Archive</a>
                                      <div class="dropdown-divider">

                                      </div>
                                      <a href="javascript:;" class="dropdown-item text-danger delete-record" data-id="${val.id}" data-is_parent="no">Delete</a>
                                  </div>
                              </div>
                              <a href="javascript:;" class="btn btn-sm btn-icon item-edit-child" data-id="${val.id}" data-is_parent="${false}" data-name="${val.name}" data-slug="${val.slug}">
                                <i class="text-primary ti ti-pencil"></i>
                            </a>
                        </td>
                    </tr>
                `;
            });
            let table = `
                <table class="table table-stripped" style="padding-left:50px;">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Menu</th>
                            <th>URI</th>
                            <th>Aksi</th>
                        </tr>    
                    </thead>
                    <tbody>
                        ${html}
                    </tbody>
                </table> 
            `;
            return table;
        }

        $(document).on('click', '.item-edit', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let icon = $(this).data('icon');
            let slug = $(this).data('slug');
            let is_parent = $(this).data('is_parent');
            let is_header = $(this).data('is_header');
            let el_form = $('#form_edit_menu');

            if (is_header == 1) {
                el_form.find('input#menu_icon').closest('.col-12').hide();
                el_form.find('input#slug').closest('.col-12').hide();
            } else {
                el_form.find('input#menu_icon').closest('.col-12').show();
                el_form.find('input#slug').closest('.col-12').show();
            }

            el_form.find('input#is_parent').val(is_parent);
            el_form.find('input#id').val(id);
            el_form.find('input#menu_name').val(name);
            el_form.find('input#menu_icon').val(icon);
            el_form.find('input#slug').val(slug);
            $('#modal_edit').modal('show');
        });

        $(document).on('click', '.item-edit-child', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let slug = $(this).data('slug');
            let is_parent = $(this).data('is_parent');
            let el_form = $('#form_edit_submenu');

            el_form.find('input#id').val(id);
            el_form.find('input#is_parent').val(is_parent);
            el_form.find('input#menu_name').val(name);
            el_form.find('input#slug').val(slug);
            $('#modal_edit_submenu').modal('show');
        });

        $(document).on('click', '.delete-record', function() {
            let id = $(this).data('id');
            let is_parent = $(this).data('is_parent');

            Swal.fire({
                title: 'Kamu Yakin?',
                text: "Menu ini akan di hapus!",
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
                        url: "{{ url('/admin/menu/delete') }}",
                        method: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id,
                            "is_parent": is_parent
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
                                text: 'Menu berhasil di hapus.',
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

        $(document).on('click', '.sort-child', function() {
            let id = $(this).data('id');
            $.ajax({
                url: "{{ url('/admin/menu/getChildMenu') }}/" + id,
                method: 'GET',
                data: {},
                dataType: 'json',
                beforeSend: function() {

                }
            }).done(function(response) {
                if (response.status) {
                    $('ol.dd-list').empty();
                    $('#modal_sort').modal('show');
                    $('form#form-sort').attr('action', "{{ route('admin-menu-updatesortchild') }}");
                    let html = '';
                    $.each(response.data, function(index, val) {
                        html += `
                            <li class="dd-item" data-id="${val.id}">
                                <div class="dd-handle">${val.name}</div>
                            </li>
                        `;
                    });
                    $('ol.dd-list').append(html);
                } else {

                }
                return;
            }).fail(function(response) {
                const {
                    status,
                    message
                } = response.responseJSON
            })
        })

        function resetForm() {
            $('#form_add_menu').trigger('reset');
            $('#menu_header').empty();
            $('#menu_header').prop('disabled', false);
            $('input#menu_icon, input#slug').prop('disabled', false);
        }
    </script>
@endsection
