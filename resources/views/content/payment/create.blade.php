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

        .client-card {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            display: grid;
            grid-template-columns: 160px 1fr;
            gap: 10px;
            margin-bottom: 15px;
            align-items: baseline;
            text-transform: capitalize;
        }

        .form-group-payment {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 10px;
            margin-bottom: 15px;
            align-items: baseline;
            text-transform: capitalize;
        }

        .label {
            font-weight: bold;
            color: #666;
        }

        .value {
            color: #333;
        }

        .address {
            line-height: 1.5;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
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
                <a href="{{ route('admin-payment-index') }}">Daftar Pembayaran</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-xl mb-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $title }}</h5>
                </div>
                <div class="card-body">
                    <form id="form" action="{{ route('admin-payment-store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <label class="form-label" for="basic-default-fullname">No Pembayaran</label>
                                <input type="text" class="form-control" id="basic-default-fullname"
                                    placeholder="Otomatis..." disabled>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label" for="tgl_pembayaran">Pengajuan Keperluan</label>
                                <select name="work_order_id" id="work_order" class="form-select">
                                </select>
                            </div>
                        </div>
                        <div class="divider divider-dark">
                            <div class="divider-text">Detail Klien</div>
                        </div>
                        <div class="row" id="detail_klien">
                            <div class="col-md-6">
                                <div class="client-card">
                                    <div class="form-group">
                                        <div class="label">Nama Klien</div>
                                        <div class="value nama_klien"></div>
                                    </div>

                                    <div class="form-group">
                                        <div class="label">No Telepon</div>
                                        <div class="value notelp_klien"></div>
                                    </div>

                                    <div class="form-group">
                                        <div class="label">Status Pembayaran</div>
                                        <div class="value status_pembayaran"></div>
                                    </div>

                                    <div class="form-group">
                                        <div class="label">Alamat</div>
                                        <div class="value address address_klien">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <table class="table table-bordered" id="tbl_keperluan">
                                    <thead>
                                        <tr>
                                            <th>Keperluan</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="divider divider-dark">
                            <div class="divider-text">Detail Pembayaran</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="amount">Masukan Nominal</label>
                                    <input type="text" class="form-control" name="amount" id="amount"
                                        placeholder="Masukan Nominal..." min="0" required>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="tgl_pembayaran">Tanggal Pembayaran</label>
                                    <input type="text" id="tgl_pembayaran" name="tgl_pembayaran" class="form-control"
                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}" required />
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="tgl_pembayaran">Metode Pembayaran</label>
                                    <select name="metode_pembayaran" class="form-select" id="" required>
                                        <option value="cash">Cash</option>
                                        <option value="transfer">Transfer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="client-card" id="detail_pembayaran">

                                </div>
                            </div>
                        </div>
                        <button type="submit" form="form" class="btn btn-primary mt-3 btn-submit">Simpan</button>
                    </form>
                </div>
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
    <script src="{{ asset('assets/vendor/libs/accounting/accounting.min.js') }}"></script>

    <script>
        let total_tagihan = 0;
        $(document).ready(function() {
            moment.locale('id');
            $('input[name=tgl_pembayaran]').flatpickr({
                enableTime: true,
                monthSelectorType: 'static',
                time_24hr: true,
                minuteIncrement: 1,
            });

            var cleaveNumeral = new Cleave(`input#amount`, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            });

            $('.form-select').select2();

            $('select#work_order').select2({
                // allowClear: true,
                placeholder: 'Pilih Keperluan...',
                escapeMarkup: function(markup) {
                    return markup;
                },
                templateResult: function(data) {
                    var $state = $(`
                    <div class="text-capitalize">
                      <span>${data.text}</span>
                    </div>
                  `);
                    return $state;
                },
                ajax: {
                    url: "{{ route('admin-payment-selectRequestWorkOrder') }}",
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
                                nama: item.nama,
                                no_telp: item.no_telp,
                                alamat: item.alamat,
                                status_pembayaran: item.status_pembayaran,
                                work_order_details: item.work_order_details
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
                detailWorkOrder(data);
                blockUI();
                listWorkOrder(data.work_order_details);
                getWorkOrderPayment(data.id);
            }).on('select2:unselect', function(e) {
                var data = e.params.data;
            });

            const form = document.getElementById('form');
            const validation = FormValidation.formValidation(form, {
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    amount: {
                        validators: {
                            notEmpty: {
                                message: 'Masukan nominal pembayaran.'
                            },
                            min: {
                                min: 0,
                                message: 'Nominal pembayaran minimal Rp 0.'
                            }
                        }
                    },
                    work_order_id: {
                        validators: {
                            notEmpty: {
                                message: 'Pilih pengajuan keperluan.'
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

        function getWorkOrderPayment(work_order_id) {
            $.ajax({
                url: "{{ route('admin-payment-getworkorderpayment') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    work_order_id: work_order_id
                },
                beforeSend: function() {
                    $('#detail_pembayaran').empty();
                    $('#detail_pembayaran').block({
                        message: '<div class="spinner-border text-white" role="status"></div>',
                        css: {
                            backgroundColor: 'transparent',
                            border: '1'
                        },
                        overlayCSS: {
                            opacity: 0.5
                        }
                    });
                },
                success: function(response) {
                    $('#detail_pembayaran').unblock();
                    let data = response.data[0];

                    if (data == null) {
                        $('#detail_pembayaran').append(`
                          <div class="value address keterangan_pembayaran">
                            <p>Belum ada pembayaran</p>
                          </div>
                        `);
                        return;
                    }

                    if (
                        response.data.length > 1 ||
                        response.sisa_tagihan == total_tagihan
                    ) {
                        let html = '';
                        $.each(response.data, function(index, item) {
                            html = `
                            <div class="form-group-payment">
                              <div class="label">No. Pembayaran</div>
                              <div class="value no_pembayaran">${data.no_pembayaran}</div>
                            </div>
                            <div class="form-group-payment">
                              <div class="label">Tgl. Pembayaran</div>
                              <div class="value no_pembayaran">${moment(data.tgl_bayar).format('DD MMMM YYYY HH:mm')}</div>
                            </div>
                            <div class="form-group-payment">
                              <div class="label">Nominal Pembayaran</div>
                              <div class="value nominal_pembayaran">${accounting.formatMoney(data.nominal, "Rp ", 0, ".", ",")}</div>
                            </div>
                            <hr/>
                          `;
                            $('#detail_pembayaran').append(html);
                        });
                        return;
                    }

                    $('#detail_pembayaran').append(`
                      <div class="form-group-payment">
                          <div class="label">No. Pembayaran</div>
                          <div class="value no_pembayaran">${data.no_pembayaran}</div>
                      </div>

                      <div class="form-group-payment">
                          <div class="label">Nominal Pembayaran</div>
                          <div class="value nominal_pembayaran">${accounting.formatMoney(data.nominal, "Rp ", 0, ".", ",")}</div>
                      </div>

                      <div class="form-group-payment">
                          <div class="label">Sisa Tagihan</div>
                          <div class="value">${accounting.formatMoney((total_tagihan - data.nominal), "Rp ", 0, ".", ",")}</div>
                      </div>

                      <div class="form-group-payment">
                          <div class="label">Keterangan</div>
                          <div class="value address keterangan_pembayaran">
                            Pembayaran pertama = DP, pembayaran kedua = wajib lunas.
                          </div>
                      </div>
                    `);
                },
                error: function(xhr) {
                    $('#detail_pembayaran').unblock();
                    console.log(xhr.responseText);
                }
            });
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

        function detailWorkOrder(data) {
            $('.nama_klien').text(data.nama);
            $('.notelp_klien').text(data.no_telp);
            $('.status_pembayaran').html(`
                <span class="badge bg-label-${data.status_pembayaran == 'belum lunas' ? 'danger' : 'success'} me-1">${data.status_pembayaran}</span>
            `);
            $('.address_klien').text(data.alamat);

            data.status_pembayaran == 'belum lunas' ? $('button.btn-submit').prop('disabled', false) : $(
                'button.btn-submit').prop('disabled', true);
        }

        function listWorkOrder(work_order_details) {
            blockUI();
            let table = $('#tbl_keperluan');
            table.find('tbody').empty();
            table.find('tfoot').empty();
            $.each(work_order_details, function(index, item) {
                table.find('tbody').append(`
                  <tr>
                      <td>${item.keperluan}</td>
                      <td>${accounting.formatMoney(item.harga, "Rp ", 0, ".", ",")}</td>
                  </tr>
              `);
            });

            table.find('tfoot').append(`
                <tr>
                    <td colspan="1"><b>Total</b></td>
                    <td><b>${accounting.formatMoney(work_order_details.reduce((a, b) => a + b.harga, 0), "Rp ", 0, ".", ",")}</b></td>
                </tr>
            `);
            total_tagihan = work_order_details.reduce((a, b) => a + b.harga, 0);
            unblockUI();
        }

        function blockUI() {
            $('#detail_klien').block({
                message: '<div class="spinner-border text-white" role="status"></div>',
                css: {
                    backgroundColor: 'transparent',
                    border: '1'
                },
                overlayCSS: {
                    opacity: 0.5
                }
            });
        }

        function unblockUI() {
            $('#detail_klien').unblock();
        }
    </script>
@endsection
