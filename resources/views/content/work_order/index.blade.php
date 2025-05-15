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
    <link rel="stylesheet" <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}" />
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
                <h5 class=" me-2">{{ $title }}</h5>

                <div class="card-header-elements ms-auto">
                    {{-- Button --}}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4 mb-3">
                        <label class="form-label" for="basic-default-fullname">Status</label>
                        <select name="filter" id="filter" class="form-control select2">
                            <option value="">Semua</option>
                            <option value="on_going">Layanan Dalam Pengerjaan</option>
                            <option value="on_going_late">Layanan Dalam Pengerjaan Namun Terlambat</option>
                            <option value="done">Layanan Sudah Selesai</option>
                        </select>
                    </div>
                    <div class="col-4 mb-3">
                        <label class="form-label" for="basic-default-fullname">Tanggal</label>
                        <input type="text" name="date_range" id="date-range" class="form-control" id="">
                    </div>
                    <div class="col-4 mb-3">
                        <label class="form-label" for="basic-default-fullname">Layanan</label>
                        <select name="master_work_order_id" id="work_order" class="form-control select2"
                            id=""></select>
                    </div>
                    @if (in_array('superadmin', rolesUser()->toArray()))
                        <div class="col-4 mb-3">
                            <label class="form-label" for="basic-default-fullname">Penugasan</label>
                            <select name="user_id" id="user_admin" class="form-control select2" id="">
                            </select>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th width="10">#</th>
                            <th>Invoice</th>
                            <th>Klien</th>
                            <th>layanan</th>
                            <th>Penugasan</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th width="40">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/pickr/pickr.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/tables-datatables-basic.js') }}"></script> --}}
    <script>
        function modalFilter() {
            $('#modalFilter').modal('show');
        }


        let start_date = moment()
            .startOf('month'),
            end_date = moment()
            .endOf('month');

        $(document).ready(function() {
            moment.locale('id');
            $('.select2').select2();

            $('select#user_admin').select2({
                allowClear: true,
                placeholder: 'Pilih Penugasan...',
                escapeMarkup: function(markup) {
                    return markup;
                },
                ajax: {
                    url: "{{ route('admin-useradmin-select') }}",
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
                        $.each(data.results, function(index, item) {
                            option.push({
                                id: item.id,
                                text: item.name,
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

            $('select#work_order').select2({
                allowClear: true,
                placeholder: 'Pilih Keperluan...',
                escapeMarkup: function(markup) {
                    return markup;
                },
                templateResult: function(data) {
                    var $result = $(`
                    <div class="text-capitalize">
                      <span>${data.text}</span>
                    </div>
                  `);
                    return $result;
                },
                ajax: {
                    url: "{{ route('admin-workorder-select') }}",
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
                        $.each(data.results, function(index, item) {
                            option.push({
                                id: item.id,
                                text: item.nama,
                                nama: item.nama
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
                    [4, "desc"]
                ],
                ajax: {
                    url: "{{ route('admin-workorder-data') }}",
                    type: "GET",
                    data: function(data) {
                        data.filter = $('#filter').val();
                        data.master_work_order_id = $('#work_order').val();
                        data.user_admin_id = $('select#user_admin').val();

                        data.start_date = $("#date-range")
                            .data('daterangepicker') ? $("#date-range")
                            .data('daterangepicker')
                            .startDate.format('YYYY-MM-DD') : start_date.format('YYYY-MM-DD');
                        data.end_date = $("#date-range")
                            .data('daterangepicker') ? $("#date-range")
                            .data('daterangepicker')
                            .endDate.format('YYYY-MM-DD') : end_date.format('YYYY-MM-DD');
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
                        render: function(data, type, full, meta) {
                            return `
                          <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="d-flex flex-column">
                              <span class="emp_name text-truncate">${data}</span>
                              <small class="emp_post text-truncate text-muted">
                                ${moment(full.tgl_pengajuan).format('LL')}
                              </small>
                            </div>
                          </div>
                          `;
                        }
                    },
                    {
                        targets: 3,
                        render: function(data, type, full, meta) {
                            return `
                          <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="d-flex flex-column">
                              <span class="emp_name text-truncate">${data}</span>
                              <small class="emp_post text-truncate text-muted">

                              </small>
                            </div>
                          </div>
                          `;
                        }
                    },
                    {
                        targets: 4,
                        render: function(data, type, full, meta) {
                            return `
                          <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="d-flex flex-column">
                              <span class="emp_name text-truncate">${full.nama_admin}</span>
                              <small class="emp_post text-truncate text-muted">
                                ${moment(full.tgl_penugasan).format('LL')}
                              </small>
                            </div>
                          </div>
                          `;
                        }
                    },
                    {
                        targets: 5,
                        render: function(data, type, full, meta) {
                            if (data) {
                                return `
                                  <div class="d-flex justify-content-start align-items-center user-name">
                                    <div class="d-flex flex-column">
                                      <span class="emp_name text-truncate">${full.work_order_late}</span>
                                      <small class="emp_post text-truncate text-muted">
                                        ${data ? moment(data).format('LL') : ''}
                                      </small>
                                    </div>
                                  </div>
                                `;
                            } else {
                                return ``;
                            }
                        }
                    },
                    {
                        targets: 6,
                        className: "text-center",
                        render: function(data, type, full, meta) {
                            let $status =
                                `<span class="badge rounded-pill bg-label-warning">Belum Selesai</span>`;
                            if (full.status_penugasan == 'Selesai') {
                                $status = `
                                  <div class="d-flex justify-content-center align-items-center user-name">
                                    <div class="d-flex flex-column">
                                      <span class="badge rounded-pill bg-label-success">Selesai</span>
                                      <small class="emp_post text-truncate text-dark">
                                        ${full.tgl_selesai ? moment(full.tgl_selesai).format('LL') : ''}
                                      </small>
                                    </div>
                                  </div>
                                `;
                            }

                            return $status;
                        }
                    },
                    {

                        targets: 7,
                        title: 'Aksi',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {

                            let btn_edit = `
                            <a href="{{ url('admin/work-order/form') }}/${data}" class="dropdown-item"><i class="ti ti-edit me-1"></i>Edit</a>
                          `;
                            if (full.status_penugasan == 'Selesai') {
                                btn_edit = ``;
                            }

                            return (`
                                <div class="d-inline-block">
                                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="text-primary ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end m-0">
                                        <a href="{{ url('admin/work-order/detail') }}/${data}" class="dropdown-item"><i class="ti ti-eye me-1"></i>Detail</a>
                                        ${btn_edit}
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
                        "orderable": false,
                        "searchable": false,
                        data: "no_wo"
                    },
                    {
                        data: "nama_klien"
                    },
                    {
                        data: "keperluan"
                    },
                    {
                        data: "tgl_penugasan"
                    },
                    {
                        data: "tgl_jatuh_tempo"
                    },
                    {
                        "orderable": false,
                        "searchable": false,
                        data: "status_penugasan"
                    },
                    {
                        "orderable": false,
                        "searchable": false,
                        data: "id"
                    }
                ]
            });

            $('input#date-range').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                startDate: moment().startOf('month'),
                endDate: moment().endOf('month'),
                ranges: {
                    Today: [moment(), moment()],
                    Yesterday: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                locale: {
                    format: 'DD/MM/YYYY'
                },
                opens: 'left'
            }).on('apply.daterangepicker', function(ev, picker) {
                var start = picker.startDate.format('YYYY-MM-DD');
                var end = picker.endDate.format('YYYY-MM-DD');
                $(this).val(start + ' - ' + end);
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

        $('select#filter, select#work_order, select#user_admin').on('change', function() {
            dataTable.draw();
        });

        $(document).on('change', '#date-range', function() {
            dataTable.draw();
        });
    </script>
@endsection
