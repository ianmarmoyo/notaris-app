@extends('layouts/layoutMaster')

@section('title', $title)

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
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
                <a href="javascript:;" class="btn btn-primary btn_add">
                    <span class="tf-icon ti ti-plus ti-xs me-1"></span>Buat data klien
                </a>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatable table" id="datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>No Telp</th>
                        <th>alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!--/ Permission Table -->
    <div id="modalForm" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" id="section-addtitle">
            <form id="form-adddata" action="">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="nama">Nama</label>
                            <div class="col-sm-8">
                                <input type="text" name="nama" class="form-control" placeholder="Nama..." required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="no_telp">No Telp</label>
                            <div class="col-sm-8">
                                <input type="text" name="no_telp" class="form-control" placeholder="Nama..." required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="nama">Alamat</label>
                            <div class="col-sm-8">
                                <textarea name="alamat" class="form-control" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary ">Submit</button>
                    </div>

                </div>
            </form><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/block-ui/block-ui.js') }}"></script>
@endsection
@section('page-script')
    <script>
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
                    url: "{{ route('admin-client-read') }}",
                    type: "GET",
                    data: function(data) {

                    }
                },
                language: {
                    url: "{{ asset('assets/vendor/libs/datatables-bs5/lang_id.json') }}"
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
                        // Actions
                        targets: 4,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return (`
                              <a href="javascript:;" class="text-body dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm mx-1"></i></a>
                                <div class="dropdown-menu dropdown-menu-end m-0">
                                  <a href="{{ url('admin/client/detail') }}/${data}" class="dropdown-item">
                                    <i class="ti ti-eye me-1"></i> Detail
                                  </a>
                                  <a href="javascript:;" class="dropdown-item btn_edit"
                                    data-id="${data}"
                                    data-nama="${row.nama}"
                                    data-no_telp="${row.no_telp}"
                                    data-alamat="${row.alamat}"
                                    >
                                    <i class="ti ti-edit me-1"></i> Edit
                                  </a>
                                  <a href="javascript:;" class="dropdown-item delete-record" data-id="${data}"><i class="ti ti-trash me-1"></i>Hapus</a>
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
                        className: "details-control",
                        data: "nama"
                    },
                    {
                        data: "no_telp"
                    },
                    {
                        className: "dt-center",
                        data: "alamat"
                    },
                    {
                        className: "dt-center",
                        data: "id"
                    }
                ]
            });

            const form = document.getElementById('form-adddata');
            const validation = FormValidation.formValidation(form, {
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    nama: {
                        validators: {
                            notEmpty: {
                                message: 'Masukan nama.'
                            }
                        }
                    },
                    no_telp: {
                        validators: {
                            notEmpty: {
                                message: 'Masukan nomor telepon.'
                            }
                        }
                    },
                    alamat: {
                        validators: {
                            notEmpty: {
                                message: 'Masukan alamat.'
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

                let form = $('#form-adddata'),
                    data = new FormData($(form)[0]),
                    action = form.attr('action');

                $.ajax({
                    url: action,
                    method: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    beforeSend: function() {
                        sectionBlock();
                    }
                }).done(function(response) {
                    sectionUnBlock()
                    if (response.status) {
                        $('#modalForm').modal('hide')
                        toastr.success(response.message, 'Success', 1000);
                        dataTable.draw()
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

        $(document).on('click', '.btn_add', function() {
            $('#modalForm').modal('show')

            let form = $('#form-adddata');
            form.attr('action', `{{ route('admin-client-store') }}`);
            resetForm();
        });

        $(document).on('click', '.btn_edit', function() {
            var id = $(this).data('id');
            $('#modalForm').modal('show');

            let form = $('#form-adddata');
            form.attr('action', `{{ route('admin-client-update') }}`);
            form.find('input[name=id]').val(id);
            form.find('input[name=nama]').val($(this).data('nama'));
            form.find('input[name=no_telp]').val($(this).data('no_telp'));
            form.find('textarea[name=alamat]').val($(this).data('alamat'));
        });

        function resetForm() {
            let form = $('#form-adddata');
            form[0].reset();
        }

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
                        url: "{{ url('/admin/client/delete') }}/" + id,
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
                                title: 'Terhapus!',
                                text: 'Data telah dihapus.',
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

        function sectionBlock() {
            $('.modal-content').block({
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
            $('.modal-content').unblock();
        }
    </script>
@endsection
