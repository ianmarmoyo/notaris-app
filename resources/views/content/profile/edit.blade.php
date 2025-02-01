@extends('layouts/layoutMaster')

@section('title', ' Vertical Layouts - Forms')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
@endsection

@section('page-style')
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
    </style>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </nav>
    <!-- Form with Tabs -->
    <div class="row">
        <div class="col">
            <div class="card mb-3">
                <div class="card-header pt-2">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#form-tabs-personal"
                                role="tab" aria-selected="true">Data Diri</button>
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
                        <form method="POST" id="form"
                            action="{{ route('admin-useradmin-updateadmin', ['id' => $user->admin->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="name">Nama Lengkap</label>
                                    <input type="text" id="name" name="name" class="form-control test"
                                        placeholder="Masukan Nama Anggota..."
                                        value="{{ Auth::guard('admin')->user()->name }}" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="gelar">Gelar</label>
                                    <input type="text" id="gelar" name="gelar" class="form-control test"
                                        placeholder="Masukan Gelar..." value="{{ $user->gelar }}" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="pendidikan_terakhir">Pendidikan Terakhit</label>
                                    <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir"
                                        class="form-control test" placeholder="Masukan Gelar..."
                                        value="{{ $user->gelar }}" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="date_birth">Tanggal Lahir</label>
                                    <input type="text" id="date_birth" name="date_birth" value="{{ $user->date_birth }}"
                                        class="form-control dob-picker" placeholder="YYYY-MM-DD" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="place_of_birth">Tempat Lahir</label>
                                    <input type="text" id="place_of_birth" name="place_of_birth" class="form-control"
                                        placeholder="Tempat Lahir..." value="{{ $user->place_of_birth }}" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="gender">Jenis Kelamin <b
                                            style="color:red;">*</b></label>
                                    <select name="gender" id="" class="select2 form-select">
                                        <option value=""></option>
                                        @foreach (config('enums.gender') as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="religion">Agama <b style="color:red;">*</b></label>
                                    <select name="religion" id="" class="select2 form-select text-capitalize">
                                        <option value=""></option>
                                        @foreach (config('enums.regligions') as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 select2-primary">
                                    <label class="form-label" for="province_id">Provinsi</label>
                                    <select id="province_id" name="province_id" class="select2 form-control"
                                        placeholder="Select Province">
                                    </select>
                                </div>
                                <div class="col-md-6 select2-primary">
                                    <label class="form-label" for="regencie_id">Kebupaten/Kota</label>
                                    <select id="regencie_id" name="regency_id" class="select2 form-control"
                                        placeholder="Select Regencie">
                                    </select>
                                </div>
                                <div class="col-md-6 select2-primary">
                                    <label class="form-label" for="district_id">Kecamatan</label>
                                    <select id="district_id" name="district_id" class="select2 form-control">
                                    </select>
                                </div>
                                <div class="col-md-6 select2-primary">
                                    <label class="form-label" for="village_id">Desa/Kelurahan</label>
                                    <select id="village_id" name="village_id" class="select2 form-control">
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="postal_code">Kode Pos</label>
                                    <input type="text" id="postal_code" name="postal_code"
                                        value="{{ $user->postal_code }}" class="form-control"
                                        placeholder="Masukkan Kode Pos" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="phone">No WA/Telepon</label>
                                    <input type="text" id="phone" name="phone" value="{{ $user->phone }}"
                                        class="form-control phone-mask" placeholder="658 799 8941"
                                        aria-label="658 799 8941" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="address">Alamat Lengkap</b></label>
                                    <textarea name="address" id="" cols="30" rows="3" class="form-control"
                                        placeholder="Perumahan, Blok A01">{{ $user->address }}</textarea>
                                </div>
                            </div>
                            <div class="content-header mb-3 mt-3">
                                <h6 class="mb-0">Foto</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="photo">Foto Diri</label>
                                    <input type="file" id="photo" name="photo" class="form-control"
                                        placeholder="" readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="photo">Foto</label>
                                    <img src="{{ asset($user->getPhoto()) }}" alt="Avatar" class="rounded"
                                        style="width:3cm;heigth:2cm;">
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                <button type="reset" class="btn btn-label-secondary">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#province_id, #regencie_id, #district_id').trigger('change');

            let form = document.getElementById('form');
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
                                message: 'Nama wajib diisi.'
                            }
                        }
                    },
                    phone: {
                        validators: {
                            notEmpty: {
                                message: 'Nomor telepon wajib diisi.'
                            },
                            stringLength: {
                                min: 11,
                                max: 12,
                                message: 'Nomor telepon minimal 11 digit dan maksimal 12 digit.'
                            },
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
                    method: 'post',
                    data: new FormData($('#form')[0]),
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('.custome-loading').removeClass('d-none');
                    }
                }).done(function(response) {
                    let {
                        status,
                        message,
                        route
                    } = response
                    $('.custome-loading').addClass('d-none');
                    if (status) {
                        toastr.success(message, 'Berhasil', 1000);
                    } else {
                        toastr.warning(message, 'Warning', 1000);
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
            });

            $("#province_id").select2({
                allowClear: true,
                placeholder: 'Pilih Provinsi...',
                // templateResult: formatResultUser,
                ajax: {
                    url: "{{ url('/api/province/select') }}",
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
            }).on('change.select2', function() {
                validation.revalidateField('province_id');
            });

            $("#regencie_id").select2({
                allowClear: true,
                placeholder: 'Pilih Kota/Kabupaten...',
                // templateResult: formatResultUser,
                ajax: {
                    url: "{{ url('api/regencie/select') }}",
                    type: 'get',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            name: params.term,
                            page: params.page,
                            province_id: $('#province_id').val(),
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
            }).on('change.select2', function() {
                validation.revalidateField('regency_id');
            });

            $("#district_id").select2({
                allowClear: true,
                placeholder: 'Pilih Kecamatan...',
                ajax: {
                    url: "{{ url('/api/district/select') }}",
                    type: 'get',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            name: params.term,
                            page: params.page,
                            regency_id: $('#regencie_id').val(),
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
            }).on('change.select2', function() {
                validation.revalidateField('district_id');
            });

            $("#village_id").select2({
                allowClear: true,
                placeholder: 'Pilih Desa/Kelurahan...',
                ajax: {
                    url: "{{ url('api/village/select') }}",
                    type: 'get',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            name: params.term,
                            page: params.page,
                            district_id: $('#district_id').val(),
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
            }).on('change.select2', function() {
                validation.revalidateField('village_id');
            });

            $('select[name=religion]')
                .val("{{ $user->religion }}")
                .trigger('change');


            $('select[name=gender]')
                .val("{{ $user->gender }}")
                .trigger('change');


            @isset($user->province)
                $("#province_id").select2('trigger', 'select', {
                    data: {
                        id: "{{ $user->province_id }}",
                        text: "{{ $user->province->name }}"
                    }
                });
            @endisset

            @isset($user->regency)
                $("#regencie_id").select2('trigger', 'select', {
                    data: {
                        id: "{{ $user->regency_id }}",
                        text: "{{ $user->regency->name }}"
                    }
                });
            @endisset

            @isset($user->district)
                $("#district_id").select2('trigger', 'select', {
                    data: {
                        id: "{{ $user->district_id }}",
                        text: "{{ $user->district->name }}"
                    }
                });
            @endisset

            @isset($user->village)
                $("#village_id").select2('trigger', 'select', {
                    data: {
                        id: "{{ $user->village_id }}",
                        text: "{{ $user->village->name }}"
                    }
                });
            @endisset

            $('#province_id, #regencie_id, #district_id').trigger('change');
        });

        $('#province_id').on('change', function() {
            if ($(this).val() == null) {
                $('#regencie_id, #district_id, #village_id').select2("enable", true);
                $('#regencie_id, #district_id, #village_id').empty();
            } else {
                $('#regencie_id').prop('disabled', false)
            }
        })

        $('#regencie_id').on('change', function() {
            if ($(this).val() == null) {
                $('#district_id').select2("enable", true);
                $('#district_id').empty();
            } else {
                $('#district_id').prop('disabled', false)
            }
        });

        $('#district_id').on('change', function() {
            if ($(this).val() == null) {
                $('#village_id').select2("enable", true);
                $('#village_id').empty();
            } else {
                $('#village_id').prop('disabled', false)
            }
        })
    </script>
@endsection
