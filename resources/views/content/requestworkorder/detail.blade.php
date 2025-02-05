@extends('layouts/layoutMaster')

@section('title', 'Academy Course Details - Apps')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/plyr/plyr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-academy-details.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
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
    <script src="{{ asset('assets/vendor/libs/plyr/plyr.js') }}"></script>
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

    <div class="card g-3">
        <div class="card-body row g-3">
            <div class="col-lg-7">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-2 gap-1">
                    <div class="me-1">
                        <h5 class="mb-1">{{ $work_order->no_wo }}</h5>
                        <p class="mb-1">Dibuat oleh. <span class="fw-medium"> {{ $work_order->admin->name }} </span></p>
                    </div>
                    <div class="d-flex align-items-center">
                        {{-- <span class="badge bg-label-danger">UI/UX</span>
                        <i class='ti ti-share ti-sm mx-4'></i>
                        <i class='ti ti-bookmarks ti-sm'></i> --}}
                    </div>
                </div>
                <div class="card academy-content shadow-none border">
                    <div class="card-body">
                        <h5>Klien</h5>
                        <div>
                            <div class="form-group">
                                <div class="label">Nama</div>
                                <div class="value no_pembayaran">{{ $work_order->client->nama }}</div>
                            </div>
                            <div class="form-group">
                                <div class="label">Nomor Telepon</div>
                                <div class="value no_pembayaran">{{ $work_order->client->no_telp }}</div>
                            </div>
                            <div class="form-group">
                                <div class="label">Alamat</div>
                                <div class="value no_pembayaran">{{ $work_order->client->alamat }}</div>
                            </div>
                        </div>
                        <hr class="mb-4">
                        <h5>Keperluan</h5>
                        <div class="d-flex justify-content-start user-name">
                            <div class="list-group" style="width: 100%">
                                @foreach ($work_order->work_order_details as $key => $detail)
                                    <div
                                        class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                                        <div>
                                            {{ $detail->master_work_order->nama }}
                                            <br>
                                            <small class="text-muted">Rp. {{ formatRupiah($detail->harga) }}</small>
                                        </div>
                                        @if ($detail->status == 'pending')
                                            <button type="button" class="btn btn-info waves-effect waves-light"
                                                data-bs-toggle="modal" data-bs-target="#assignModal"
                                                onclick="assignModal(this)"
                                                data-work_order_detail_id="{{ $detail->id }}">
                                                Penugasan
                                            </button>
                                        @elseif($detail->status == 'selesai')
                                            <div>
                                                <span class="badge bg-label-success">Selesai</span>
                                                <a href="{{ url('admin/work-order/detail/' . $detail->work_order_assignment->id) }}"
                                                    target="_blank">
                                                    <span class="badge bg-info bg-glow">Lihat</span>
                                                </a>
                                            </div>
                                        @else
                                            <div>
                                              <span class="badge bg-label-primary">Dalam Proses</span>
                                              <a href="{{ url('admin/work-order/detail/' . $detail->work_order_assignment->id) }}"
                                                  target="_blank">
                                                  <span class="badge bg-info bg-glow">Lihat</span>
                                              </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                <div
                                    class="list-group-item text-bg-light d-flex justify-content-between align-items-center list-group-item-action">
                                    <div>
                                        TOTAL
                                    </div>
                                    {{ formatRupiah($work_order->work_order_details->sum('harga')) }}
                                </div>
                            </div>
                        </div>
                        <hr class="mb-4">
                        <h5>Pembayaran | <span
                                class="text-capitalize badge bg-label-{{ $work_order->status_pembayaran == 'lunas' ? 'success' : 'danger' }}">{{ $work_order->status_pembayaran }}</span>
                        </h5>
                        <div class="" id="detail_pembayaran">
                            @foreach ($work_order->work_order_payments as $key => $row)
                                <div class="form-group-payment">
                                    <div class="label">No. Pembayaran</div>
                                    <div class="value no_pembayaran">{{ $row->no_pembayaran }}</div>
                                </div>

                                <div class="form-group-payment">
                                    <div class="label">Tgl. Pembayaran</div>
                                    <div class="value no_pembayaran">{{ tglIndo($row->tgl_bayar) }}</div>
                                </div>

                                <div class="form-group-payment">
                                    <div class="label">Nominal Pembayaran</div>
                                    <div class="value nominal_pembayaran">
                                        {{ formatRupiah($row->nominal) }}
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="accordion stick-top accordion-bordered" id="workOrderAttachment">
                    @foreach ($work_order->work_order_details as $key => $row)
                        <div class="accordion-item @if ($key == 0) active @endif mb-0">
                            <div class="accordion-header" id="headingOne">
                                <button type="button" class="accordion-button bg-lighter rounded-0"
                                    data-bs-toggle="collapse" data-bs-target="#chapter_{{ $row->id }}"
                                    aria-expanded="true" aria-controls="chapter_{{ $row->id }}">
                                    <span class="d-flex flex-column">
                                        <span class="h5 mb-1">{{ $row->master_work_order->nama }}</span>
                                        <span class="fw-normal text-body">Persyaratan Berkas</span>
                                    </span>
                                </button>
                            </div>
                            <div id="chapter_{{ $row->id }}"
                                class="accordion-collapse collapse @if ($key == 0) show @endif"
                                data-bs-parent="#workOrderAttachment">
                                <div class="accordion-body py-3 border-top text-capitalize">
                                    @foreach ($row->work_order_attachments as $key => $value)
                                        <div class="form-check d-flex align-items-center mb-3">
                                            <input class="form-check-input" type="checkbox" value="{{ $value->id }}"
                                                onclick="checkListPesyaratan(this)" id="checklist"
                                                @if ($value->checklist == 'yes') checked @endif
                                                @if (!auth()->user()->can('checklist berkas pengajuan')) disabled @endif />
                                            <label for="checklist" class="form-check-label ms-3">
                                                <span class="mb-0 h6">{{ $key + 1 }}.
                                                    {{ $value->nama_lampiran }}</span>
                                                <span class="text-muted d-block">
                                                    {{ $value->jenis_berkas }}
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <hr>
                                <div class="form-catatan-persyaratan px-3 py-2">
                                    <div class="mb-6">
                                        <label class="form-label" for="basic-default-message">Catatan</label>
                                        <textarea name="catatan_persyaratan" id="catatan_persyaratan" class="form-control" rows="6"
                                            placeholder="Catatan Persyaratan...">{{ $row->catatan_persyaratan }}</textarea>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-light mt-2"
                                        data-work_order_detail_id="{{ $row->id }}"
                                        onclick="updateCatatanPersyaratan(this)">Simpan</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="assignModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="form-assign" action="{{ route('admin-workorder-assignment') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="work_order_id" value="{{ $work_order->id }}">
                        <input type="hidden" name="work_order_detail_id" value="{{ $work_order->id }}">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="user_admin_id" class="form-label">Tugaskan Ke</label>
                                <select name="user_admin_id" id="user_admin" class="select2 form-select">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/block-ui/block-ui.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('select#user_admin').select2({
                allowClear: true,
                placeholder: 'Pilih Penugasan...',
                dropdownParent: $('#assignModal'),
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

            let form = document.querySelector('#form-assign');
            const validation = FormValidation.formValidation(form, {
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    user_admin_id: {
                        validators: {
                            notEmpty: {
                                message: 'Penugasan wajib diisi.'
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
                $.ajax({
                    url: $('form#form-assign').attr('action'),
                    method: 'post',
                    data: new FormData($('form#form-assign')[0]),
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    beforeSend: function() {
                        sectionBlock('.modal-dialog');
                    }
                }).done(function(response) {
                    sectionUnBlock('.modal-dialog')
                    if (response.status) {
                        toastr.success(response.message, 'Success', 1000);
                        document.location = response.route
                    } else {
                        toastr.warning(response.message, 'Warning', 1000);
                    }
                    return;
                }).fail(function(response) {
                    const {
                        status,
                        message
                    } = response.responseJSON
                    sectionUnBlock('.modal-dialog')
                    toastr.warning(message, 'Warning', 1000);
                })
            });
        });

        function updateCatatanPersyaratan(el) {
            let work_order_detail_id = $(el).data('work_order_detail_id');
            $.ajax({
                url: "{{ url('admin/request-workorder/update-workorder-detail') }}/" + work_order_detail_id,
                method: 'post',
                data: {
                    _token: $('input[name=_token]').val(),
                    _method: 'put',
                    work_order_detail_id: work_order_detail_id,
                    catatan_persyaratan: $(el).closest('.form-catatan-persyaratan').find(
                        'textarea#catatan_persyaratan').val()
                },
                dataType: 'json',
                beforeSend: function() {
                    sectionBlock('.modal-dialog');
                }
            }).done(function(response) {
                sectionUnBlock('.modal-dialog')
                if (response.status) {
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
                sectionUnBlock('.modal-dialog')
                toastr.warning(message, 'Warning', 1000);
            })
        }

        function checkListPesyaratan(e) {
            let work_order_attachments_id = $(e).val();
            let work_order_id = "{{ $work_order->id }}";
            let checklist = $(e).is(':checked') ? 'yes' : 'no';

            console.log({
                work_order_attachments_id: work_order_attachments_id,
                work_order_id: work_order_id,
                checklist: checklist
            });

            $.ajax({
                url: "{{ route('admin-requestworkorder-updateWorkOrderAttachment') }}",
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    work_order_attachments_id: work_order_attachments_id,
                    work_order_id: work_order_id,
                    checklist: checklist
                },
                processData: true,
                beforeSend: function() {
                    sectionBlock('#workOrderAttachment');
                }
            }).done(function(response) {
                sectionUnBlock('#workOrderAttachment')
                if (response.status) {
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
                sectionUnBlock('#workOrderAttachment')
                toastr.warning(message, 'Warning', 1000);
            })
        }

        function assignModal(e) {
            let work_order_detail_id = $(e).data('work_order_detail_id');
            $('#assignModal input[name=work_order_detail_id]').val(work_order_detail_id);
        }

        function sectionBlock(element) {
            $(`${element}`).block({
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

        function sectionUnBlock(element) {
            $(`${element}`).unblock();
        }
    </script>
@endsection
