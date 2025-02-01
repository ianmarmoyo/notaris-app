@extends('layouts/layoutMaster')

@section('title', $title)

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/css/thumbnail.css') }}">
    <style>
        label:has(+ input[required])::after {
            content: '*';
            color: red;
            margin-left: 3px;
            font-weight: bolder;
        }

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

        table.dataTable tbody tr td {
            text-transform: capitalize;
        }
    </style>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/block-ui/block-ui.js') }}"></script>
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
    <div class="row g-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header pt-2">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#form-tabs-personal"
                                role="tab" aria-selected="true" onclick="tabNav(this)">Data Diri</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-pengguna"
                                role="tab" aria-selected="true" onclick="tabNav(this)">Pengguna</button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    {{-- Form Personal --}}
                    <div class="tab-pane fade active show" id="form-tabs-personal" role="tabpanel">
                        <div id="custom_loading" class="custome-loading custom_loading_all d-none">
                            <div class="spinner-border spinner-border-lg text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="nama">Nama Guru</label>
                                <input type="text" id="nama" name="nama" class="form-control test"
                                    placeholder="Masukan Nama Guru..." value="{{ @$guru->nama }}" disabled />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="institution_id">Lembaga <b style="color:red;">*</b></label>
                                <input type="text" value="{{ @$guru->institution->name }}" class="form-control"
                                    disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="date_birth">Tanggal Lahir</label>
                                <input type="text" class="form-control" placeholder="YYYY-MM-DD"
                                    value="{{ @$guru->tgl_lahir }}" disabled />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="place_of_birth">Tempat Lahir</label>
                                <input type="text" id="place_of_birth" name="place_of_birth" class="form-control"
                                    placeholder="Tempat Lahir..." value="{{ @$guru->tempat_lahir }}" disabled />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="jabatan">Jabatan</label>
                                <select name="jabatan" id="" class="select2 form-select" disabled>
                                    <option value=""></option>
                                    @foreach (config('enums.title') as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $key == @$guru->jabatan ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="gender">Jenis Kelamin</label>
                                <select name="gender" id="" class="select2 form-select" disabled>
                                    <option value=""></option>
                                    @foreach (config('enums.gender') as $key => $value)
                                        <option value="{{ $key }}" {{ $key == @$guru->jk ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="religion">Agama</label>
                                <select name="religion" id="" class="select2 form-select text-capitalize"
                                    disabled>
                                    <option value=""></option>
                                    @foreach (config('enums.regligions') as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $key == @$guru->agama ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phone">No WA/Telepon</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    placeholder="658 799 8941" value="{{ @$guru->no_telp }}" disabled />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phone">Wali Dari Kelas</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    placeholder="658 799 8941" value="{{ @$guru->kelas->nama }}" disabled />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="address">Alamat Lengkap</b></label>
                                <textarea name="address" id="" cols="30" rows="3" class="form-control"
                                    placeholder="Perumahan, Blok A01" disabled>{{ @$guru->alamat }}</textarea>
                            </div>
                        </div>
                        <div class="content-header mb-3 mt-3">
                            <h6 class="mb-0">Media Lampiran</h6>
                            <small>Lampiran Foto Diri.</small>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="photo">Foto Diri</label>
                                <div class="upload-container" id="image-login">
                                    <div class="upload-img">
                                        <img src="{{ @$guru->view_foto }}" alt = "">
                                    </div>
                                </div>
                                <div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                @isset($guru->kelases)
                                    <label for="" class="form-label">Mengajar Untuk Kelas</label>
                                    <table class="table table-bordered">
                                        <tbody>
                                            @foreach ($guru->kelases as $key => $value)
                                                <tr>
                                                    <td>{{ $value->nama }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endisset
                        </div>
                        <div class="pt-4">
                        </div>
                    </div>

                    <div class="tab-pane fade" id="form-tabs-pengguna" role="tabpanel">
                        <div id="custom_loading" class="custome-loading custom_loading_all d-none">
                            <div class="spinner-border spinner-border-lg text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div class="row g-3">
                            <form id="form" action="{{ route('admin-useradmin-update', ['id' => $user]) }}">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="name">Nama Pengguna</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $user->name }}" placeholder="Full Name..." />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="email">Email</label>
                                    <div class="col-sm-10">
                                        <div class="input-group input-group-merge">
                                            <input type="text" name="email" class="form-control"
                                                value="{{ $user->email }}" placeholder="Email..." />
                                            <span id="" class="input-group-text">@example.com</span>
                                        </div>
                                        <div class="form-text"> You can use letters, numbers & periods </div>
                                    </div>
                                </div>
                                <div class="row mb-3 form-password-toggle">
                                    <label class="col-sm-2 col-form-label" for="password">Password</label>
                                    <div class="col-sm-10">
                                        <div class="input-group input-group-merge">
                                            <input type="password" name="password" id="bs-validation-password"
                                                class="form-control"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                required />
                                            <span class="input-group-text cursor-pointer" id="basic-default-password4"><i
                                                    class="ti ti-eye-off"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 form-password-toggle">
                                    <label class="col-sm-2 col-form-label"
                                        for="password_confirm">KonfirmasiPassword</label>
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
        </div>
        @if ($guru)
            <div class="col-lg-12" id="card-mapels">
                <div class="card">
                    <div class="card-header header-elements">
                        <h5 class=" me-2">{{ __('Mata Pelajaran') }}</h5>
                        <div class="card-header-elements ms-auto">

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        </div>
                    </div>
                    <div class="card-datatable table-responsive">
                        <table class="table table-bordered list-mapel-guru">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>Semester</th>
                                    <th>Tahun Ajaran</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-12" id="card-ekskuls">
                <div class="card">
                    <div class="card-header header-elements">
                        <h5 class=" me-2">{{ __('Ekstrakurikuler') }}</h5>
                        <div class="card-header-elements ms-auto">

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        </div>
                    </div>
                    <div class="card-datatable table-responsive">
                        <table class="table table-bordered text-capitalize list-guru-ekskul">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Ekstrakurikuler</th>
                                    <th>Kelas</th>
                                    <th>Semester</th>
                                    <th>Tahun Ajaran</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('page-script')
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script>
        $('#image-login').click(function() {
            $('#upload-input-login').trigger('click');
        });

        $('#upload-input-login').change(event => {
            const file = event.target.files[0];
            const reader = new FileReader();
            let el = $('#image-login')
            reader.readAsDataURL(file);

            reader.onloadend = () => {
                el.find('.upload-text').text(file.name);
                el.find('.upload-img img').attr('aria-label', file.name);
                el.find('.upload-img img').attr('src', reader.result);
            }
        })

        function modal_add_mapel() {
            $('#modalAddMapel').modal('show')
        }

        function modal_add_ekskul() {
            $('#modalAddEkskul').modal('show')
        }

        let kelases = [];
        @isset($guru->kelases)
          kelases = @json($guru->kelases->pluck('id'));
        @endisset
        $(document).ready(function() {

            list_mapel_guru = $('.list-mapel-guru').DataTable({
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
                    url: "{{ route('admin-guru-readmapelguru') }}",
                    type: "GET",
                    data: function(data) {
                        data.kelas_id = kelases;
                        data.guru_id = "{{ @$guru->id }}";
                    }
                },
                language: {
                    url: "{{ asset('assets/vendor/libs/datatables-bs5/lang_id.json') }}"
                },
                "drawCallback": function(settings) {
                    $('[data-toggle="tooltip"]').tooltip()
                },
                columnDefs: [{
                        "orderable": false,
                        "searchable": false,
                        targets: [0, 2]
                    },
                    {
                        targets: [2],
                        className: 'dt-center'
                    }
                ],
                columns: [{
                        data: null,
                        className: "dt-center",
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "nama_mapel"
                    },
                    {
                        data: "nama_kelas"
                    },
                    {
                        data: "nama_semester"
                    },
                    {
                        data: "tahun_akademik"
                    }
                ]
            });

            list_ekskul_guru = $('.list-guru-ekskul').DataTable({
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
                    url: "{{ route('admin-guru-readekskulguru') }}",
                    type: "GET",
                    data: function(data) {
                        data.kelas_id = kelases;
                        data.guru_id = "{{ @$guru->id }}";
                    }
                },
                language: {
                    url: "{{ asset('assets/vendor/libs/datatables-bs5/lang_id.json') }}"
                },
                "drawCallback": function(settings) {
                    $('[data-toggle="tooltip"]').tooltip()
                },
                columnDefs: [{
                        "orderable": false,
                        "searchable": false,
                        targets: [0, 2]
                    },
                    {
                        targets: [2],
                        className: 'dt-center'
                    }
                ],
                columns: [{
                        data: null,
                        className: "dt-center",
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "nama_ekskul"
                    },
                    {
                        data: "nama_kelas"
                    },
                    {
                        data: "nama_semester"
                    },
                    {
                        data: "tahun_akademik"
                    }
                ]
            });

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
                        location.reload();
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

        function tabNav(e) {
            let data_target = $(e).attr('data-bs-target');
            let card_mapels = $('#card-mapels');
            let card_ekskuls = $('#card-ekskuls');

            if (data_target == '#form-tabs-pengguna') {
                card_mapels.addClass('d-none');
                card_ekskuls.addClass('d-none');
            } else {
                card_mapels.removeClass('d-none');
                card_ekskuls.removeClass('d-none');
            }
        }

        function pickMapel(e) {
            let mapel_id = $(e).data('mapel_id');
            let kelas_id = $(e).data('kelas_id');
            $.ajax({
                url: "{{ route('admin-guru-pilihmapel') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: this.value,
                    mapel_id: mapel_id,
                    kelas_id: kelas_id,
                    guru_id: "{{ @$guru->id }}"
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function() {
                    sectionBlock();
                }
            }).done(function(response) {
                sectionUnBlock();
                if (response.status) {
                    dataTable.draw();
                    list_mapel_guru.draw();
                    $('#modalAddMapel').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil !',
                        text: response.message,
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: response.message,
                        icon: "error",
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    })
                }
                return;

            }).fail(function(response) {
                var response = response.responseJSON;
                sectionUnBlock();
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    icon: "error",
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                })
            })
        }

        function pickEkskul(e) {
            let ekskul_id = $(e).data('ekskul_id');
            let kelas_id = $(e).data('kelas_id');
            $.ajax({
                url: "{{ route('admin-guru-pilihekskul') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: this.value,
                    ekskul_id: ekskul_id,
                    kelas_id: kelas_id,
                    guru_id: "{{ @$guru->id }}"
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function() {
                    sectionBlock();
                }
            }).done(function(response) {
                sectionUnBlock();
                if (response.status) {
                    dt_ekskul.draw();
                    list_ekskul_guru.draw();
                    $('#modalAddEkskul').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil !',
                        text: response.message,
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: response.message,
                        icon: "error",
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    })
                }
                return;

            }).fail(function(response) {
                var response = response.responseJSON;
                sectionUnBlock();
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    icon: "error",
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                })
            })
        }

        $('select#guru_kelases').on('change', function() {
            var selectedValues = $(this).val();
            dataTable.draw();
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
                        url: "{{ url('/admin/guru/deletegurumapelkelas') }}/" + id,
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
                            dataTable.draw();
                            list_mapel_guru.draw();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil !',
                                text: 'Data telah di hapus.',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
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

        $(document).on('click', '.delete-guru-ekskul', function() {
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
                        url: "{{ url('/admin/guru/deleteguruekskulkelas') }}/" + id,
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
                            dt_ekskul.draw();
                            list_ekskul_guru.draw();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil !',
                                text: 'Data telah di hapus.',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
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
