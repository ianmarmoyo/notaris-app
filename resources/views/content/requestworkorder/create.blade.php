@extends('layouts/layoutMaster')

@section('title', $title)

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
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
    </style>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
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
            <li class="breadcrumb-item">
                <a href="{{ route('admin-requestworkorder-index') }}">Daftar Permintaan Keperluan</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <h5 class="card-header">Form Pengajuan Keperluan</h5>
                <form id="form" action="{{ route('admin-requestworkorder-store') }}" class="card-body">
                    @csrf
                    <h6>1. Detail Klien</h6>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="nama">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" id="" name="nama" class="form-control"
                                placeholder="Masukan Nama..." required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="no_telp">No Telepon</label>
                        <div class="col-sm-9">
                            <input type="number" id="" name="no_telp" class="form-control"
                                placeholder="Masukan No Telepon..." required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="no_telp">Alamat</label>
                        <div class="col-sm-9">
                            <textarea name="alamat" class="form-control" id="" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <hr class="my-4 mx-n4" />
                    <h6>2. Detail Keperluan</h6>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="multicol-country">Status Keperluan</label>
                        <div class="col-sm-9">
                            <select id="multicol-country" name="status_wo" class="select2 form-select"
                                placeholder="Status Keperluan..." data-allow-clear="true">
                                <option value="draft" selected>Draft</option>
                                <option value="ready_to_work">Siap Dikerjakan</option>
                            </select>

                            <div class="alert alert-dark mb-0 mt-2" role="alert">
                                jika status keperluan <b>DRAFT</b>, maka pengajuan masih dalam tahap pengajuan dan masih bisa diubah atau dihapus
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 select2-primary">
                        <label class="col-sm-3 col-form-label" for="work_order_id">Keperluan</label>
                        <div class="col-sm-9">
                            <select id="work_order" name="work_order_id[]" class="select2 form-select" multiple required>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="tgl_pengajuan">Tanggal Pengajuan</label>
                        <div class="col-sm-9">
                            <input type="text" id="tgl_pengajuan" name="tgl_pengajuan" class="form-control dob-picker"
                                placeholder="YYYY-MM-DD" value="{{ date('Y-m-d') }}" />
                        </div>
                    </div>
                    <hr class="my-4 mx-n4" />
                    <h6>3. Pembayaran</h6>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="tgl_pembayaran">Tanggal Pembayaran</label>
                        <div class="col-sm-9">
                            <input type="text" id="tgl_pembayaran" name="tgl_pembayaran" class="form-control dob-picker"
                                placeholder="YYYY-MM-DD" value="{{ date('Y-m-d') }}" />
                        </div>
                    </div>
                    <div class="list-keperluan">

                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="status_pembayaran">Status Pembayaran</label>
                        <div class="col-sm-9">
                            <select id="status_pembayaran" name="status_pembayaran" class="select2 form-select"
                                placeholder="Status Pembayaran..." data-allow-clear="true">
                                <option value="lunas" selected>Lunas</option>
                                <option value="belum lunas">Belum Lunas</option>
                            </select>
                        </div>
                    </div>
                    <div class="pt-4">
                        <div class="row justify-content-end">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary me-sm-2 me-1">Simpan</button>
                                <button type="reset" class="btn btn-label-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('select#work_order').select2({
                multiple: true,
                allowClear: true,
                placeholder: 'Pilih Keperluan...',
                escapeMarkup: function(markup) {
                    return markup;
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
            }).on('select2:select', function(e) {
                var data = e.params.data;
                addWorkOrderAmount(data.id, data.nama);
            }).on('select2:unselect', function(e) {
                var data = e.params.data;
                removeWorkOrderAmount(data.id);
            });

            const form = document.getElementById('form');
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
                                message: 'Masukan nama klien.'
                            }
                        }
                    },
                    no_telp: {
                        validators: {
                            notEmpty: {
                                message: 'Masukan nomor klien.'
                            }
                        }
                    },
                    alamat: {
                        validators: {
                            notEmpty: {
                                message: 'Masukan alamat klien.'
                            }
                        }
                    },
                    "work_order_id[]": {
                        validators: {
                            notEmpty: {
                                message: 'Pilih work order.'
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

                let form = $('#form'),
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
                        document.location = response.route
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

        function addWorkOrderAmount(work_order_id, nama_work_order = null) {
            let html = '';
            html += `
              <div class="row mb-3 select2-primary" id="work_order_${work_order_id}">
                  <label class="col-sm-3 col-form-label" for="work_order_id">${nama_work_order}</label>
                  <div class="col-sm-9">
                      <input type="text" id="amount_${work_order_id}" name="amount[]" placeholder="Masukan Nominal Harga..." class="form-control" />
                  </div>
              </div>
            `;
            $('.list-keperluan').append(html);
            if (document.querySelector(`input#amount_${work_order_id}`)) {
                var cleaveNumeral = new Cleave(`#amount_${work_order_id}`, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand'
                });
            }
        }

        function removeWorkOrderAmount(work_order_id) {
            let list_amount = $('.list-keperluan');
            list_amount.find(`#work_order_${work_order_id}`).remove();
        }

        function sectionBlock() {
            $('.card').block({
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
            $('.card').unblock();
        }

        $('select[name=status_wo]').on('change', function() {
            let value = $(this).val();
            if (value == 'ready_to_work') {
              $(this).next().html('jika status keperluan <b>SIAP DIKERJAKAN</b>, maka pangajuan siap dikerjakan dan tidak bisa diubah atau dihapus.');
              $(this).next().removeClass('alert-dark').addClass('alert-primary');
            } else {
              $(this).next().html('jika status keperluan <b>DRAFT</b>, maka pengajuan masih dalam tahap pengajuan dan masih bisa diubah atau dihapus');
              $(this).next().removeClass('alert-primary').addClass('alert-dark');
            }
        });
    </script>
@endsection
