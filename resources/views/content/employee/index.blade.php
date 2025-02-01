@extends('layouts/layoutMaster')

@section('title', 'Anggota')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
    <!-- Form Validation -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('page-style')
    <style>
        table.dataTable tbody tr td {
            text-transform: capitalize;
        }
    </style>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <!-- Flat Picker -->
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
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
    <!-- Form with Tabs -->
    <div class="">
        <div class="card">
            <div class="card-header header-elements">
                <span class=" me-2">{{ $title }}</span>

                <div class="card-header-elements ms-auto">
                    <a href="{{ route('admin-employee-create') }}" class="btn btn-primary"><span
                            class="tf-icon ti ti-plus ti-xs me-1"></span>Tambah Pegawai</a>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th width="10">#</th>
                            <th width="400">Nama</th>
                            <th width="300">No Telepon</th>
                            <th width="40">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    {{-- <script src="{{ asset('assets/js/tables-datatables-basic.js') }}"></script> --}}
    <script>
        function modalFilter() {
            $('#modalFilter').modal('show');
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
                    url: "{{ route('admin-employee-data') }}",
                    type: "GET",
                    data: function(data) {
                        data.institution_id = $('form#form-filter').find('select[name=institution_id]')
                            .val();
                        data.kelas_id = $('form#form-filter').find('select[name=kelas_id]').val();
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
                        // User full name and email
                        targets: 1,
                        responsivePriority: 4,
                        render: function(data, type, full, meta) {
                            var $name = full.nama,
                                $image = full.view_foto;
                            if ($image != null || $image != '') {
                                // For Avatar image
                                var $output =
                                    `<img src="${$image}" alt="Avatar" class="rounded-2">`;
                            } else {
                                // For Avatar badge
                                var stateNum = Math.floor(Math.random() * 6);
                                var states = ['success', 'danger', 'warning', 'info', 'primary',
                                    'secondary'
                                ];
                                var $state = states[stateNum],
                                    $name = full['full_name'],
                                    $initials = $name.match(/\b\w/g) || [];
                                $initials = (($initials.shift() || '') + ($initials.pop() || ''))
                                    .toUpperCase();
                                $output = '<span class="avatar-initial rounded-2 bg-label-' +
                                    $state + '">' + $initials + '</span>';
                            }
                            // Creates full output for row
                            var $row_output = `
                            <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="avatar-wrapper">
                                  <div class="avatar me-3">
                                    ${$output}
                                  </div>
                                </div>
                                <div class="d-flex flex-column">
                                  <a href="{{ url('admin/guru') }}/${full.id}" class="text-body text-truncate">
                                    <span class="fw-medium">
                                      ${$name}
                                    </span>
                                    </a>
                                </div>
                              </div>
                            `;
                            return $row_output;
                        }
                    },
                    {

                        targets: 3,
                        title: 'Aksi',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return (`
                                <div class="d-inline-block">
                                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="text-primary ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end m-0">
                                        <a href="{{ url('admin/employee') }}/${data}" class="dropdown-item"><i class="ti ti-eye me-1"></i>Detail</a>
                                        <a href="{{ url('admin/employee/edit') }}/${data}" class="dropdown-item item-edit"><i class="ti ti-pencil me-1"></i>Edit</a>
                                        <a href="javascript:;" class="dropdown-item text-danger delete-record"><i class="ti ti-trash me-1"></i>Hapus</a>
                                    </div>
                                </div>
                            `);
                        }
                    }
                ],
                columns: [{
                        data: null,
                        className: "dt-center",
                        "orderable": false,
                        "searchable": false,
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "nama"
                    },
                    {
                        data: "no_telp"
                    },
                    {
                        data: "id"
                    }
                ]
            });
        });

        $(document).on('click', '.delete-record', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Apa Kamu Yakin?',
                text: "Data ini akan di hapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya hapus!',
                cancelButtonText: 'Tidak!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('/admin/employee/delete') }}/" + id,
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
                                title: 'Berhasil !',
                                text: 'Data telah di hapus.',
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

        $('form#form-filter').submit(function(e) {
            e.preventDefault();
            dataTable.draw();
            $('#modalFilter').modal('hide');
        });
    </script>
@endsection
