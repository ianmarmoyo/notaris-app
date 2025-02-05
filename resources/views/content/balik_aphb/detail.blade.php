@extends('layouts/layoutMaster')

@section('title', 'Academy Course Details - Apps')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/plyr/plyr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-academy-details.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <style>
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
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin-dashboard-analytics') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin-workorder-index') }}">Daftar Penugasan</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </nav>


    <div class="nav-align-top mt-5">
        <ul class="nav nav-pills mb-3" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-prodecure" aria-controls="navs-prodecure" aria-selected="true">
                    Prosedur
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-wo-attachment" aria-controls="navs-wo-attachment" aria-selected="false">Berkas
                    Persyaratan</button>
            </li>
        </ul>
    </div>

    <div id="navs-prodecure">
        <div class="row">
            <div class="col-md-7 mb-3">
                <div class="accordion stick-top accordion-bordered" id="workOrderAttachment">
                    <div class="accordion-item active mb-0">
                        <div class="accordion-header" id="headingOne">
                            <button type="button" class="accordion-button bg-lighter rounded-0">
                                <span class="d-flex flex-column">
                                    <span class="h5 mb-1">
                                        {{ $page_title }}

                                        @if ($work_order_assignment->status_penugasan == 'selesai')
                                            <span class="badge bg-success bg-glow">Selesai</span>
                                        @else
                                            <span class="badge bg-info bg-glow">Dalam Proses</span>
                                        @endif
                                    </span>
                                    <span class="fw-normal text-body">
                                        Tahapan Prosedur
                                    </span>
                                </span>
                            </button>
                        </div>
                        <div id="chapter_1" class="accordion-collapse collapse show" data-bs-parent="#workOrderAttachment">
                            <div class="accordion-body py-3 border-top text-capitalize">
                                @foreach ($procedures as $key => $procedure)
                                    <div class="form-check d-flex align-items-center mb-3">
                                        @if ($procedure->checklist)
                                            <span class="badge badge-center rounded-pill bg-success bg-glow">
                                                <i class="ti ti-check"></i>
                                            </span>
                                        @else
                                            <span class="badge badge-center rounded-pill bg-danger bg-glow">
                                                <i class="ti ti-x"></i>
                                            </span>
                                        @endif
                                        <label for="checklist" class="form-check-label ms-3 w-100">
                                            <span class="mb-0 h6">
                                                {{ $key + 1 }}.
                                                {{ $procedure->proses }}
                                            </span>
                                            <div class="mt-2">
                                                <div class="card shadow-none bg-transparent border border-secondary">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="col-form-label" for="status_pembayaran">
                                                                    Tanggal Selesai
                                                                </label>
                                                                <input type="text" id="" name=""
                                                                    class="form-control"
                                                                    value="{{ $procedure->tgl_checklist ? tglIndo($procedure->tgl_checklist, '%A, %d %B %Y') : null }}"
                                                                    readonly />
                                                            </div>
                                                            @if ($procedure->proses == 'Pembayaran dan Validasi Pajak Waris')
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="col-form-label" for="status_pembayaran">
                                                                        Status Pembayaran
                                                                    </label>
                                                                    <input type="text" class="form-control"
                                                                        id=""
                                                                        value="{{ $procedure->status_pembayaran }}"
                                                                        readonly>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="col-form-label" for="status_pembayaran">
                                                                        Tanggal Pembayaran
                                                                    </label>
                                                                    <input type="text"
                                                                        id="tgl_pembayaran_{{ $procedure->id }}"
                                                                        name="tgl_pembayaran"
                                                                        class="form-control dob-picker"
                                                                        placeholder="YYYY-MM-DD"
                                                                        value="{{ $procedure->tgl_bayar ? tglIndo($procedure->tgl_bayar, '%A, %d %B %Y') : null }}"
                                                                        readonly />
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="col-form-label" for="status_pembayaran">
                                                                        Catatan
                                                                    </label>
                                                                    <textarea name="catatan" class="form-control" id="" cols="30" rows="3" readonly>{{ $procedure->catatan }}</textarea>
                                                                </div>
                                                            @endif
                                                            @if ($procedure->proses == 'Penyerahan')
                                                                <div class="col-md-6 mb-3">
                                                                    <div class="">
                                                                        <img src="{{ $procedure->view_gambar }}"
                                                                            class="" style="max-width: 200px"
                                                                            alt="">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <div class="form-group">
                                <div class="label">Nama penugas</div>
                                <div class="value no_pembayaran"> {{ $work_order_assignment->user_admin->name }}</div>
                            </div>
                            <div class="form-group">
                                <div class="label">Tanggal Penugasan</div>
                                <div class="value no_pembayaran">{{ $work_order_assignment->tgl_penugasan }}</div>
                            </div>
                            <div class="form-group">
                                <div class="label">Keperluan</div>
                                <div class="value no_pembayaran">
                                    {{ $work_order_assignment->work_order_detail->keperluan }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="label">Tanggal Pengajuan</div>
                                <div class="value no_pembayaran">
                                    {{ $work_order_assignment->work_order_detail->work_order->tgl_pengajuan }}</div>
                            </div>
                            <div class="form-group">
                                <div class="label">Nama Klien</div>
                                <div class="value no_pembayaran">
                                    {{ $work_order_assignment->work_order_detail->work_order->nama }}</div>
                            </div>
                            <div class="form-group">
                                <div class="label">Telp Klien</div>
                                <div class="value no_pembayaran">
                                    {{ $work_order_assignment->work_order_detail->work_order->no_telp }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="fade" id="navs-wo-attachment">
        <div class="row">
            <div class="col-md-6">
                <div class="accordion stick-top accordion-bordered" id="workOrderAttachment">
                    <div class="accordion-item active mb-0">
                        <div class="accordion-header" id="headingOne">
                            <button type="button" class="accordion-button bg-lighter rounded-0"
                                data-bs-toggle="collapse" data-bs-target="#chapter_1" aria-expanded="true"
                                aria-controls="chapter_1">
                                <span class="d-flex flex-column">
                                    <span class="h5 mb-1">
                                        {{ $page_title }}
                                    </span>
                                    <span class="fw-normal text-body">Persyaratan Berkas</span>
                                </span>
                            </button>
                        </div>
                        <div id="chapter_1" class="accordion-collapse collapse show"
                            data-bs-parent="#workOrderAttachment">
                            <div class="accordion-body py-3 border-top text-capitalize">
                                @foreach ($wo_attachment as $key => $value)
                                    <div class="form-check d-flex align-items-center mb-3">
                                        @if ($value->checklist == 'yes')
                                            <span class="badge badge-center rounded-pill bg-success bg-glow">
                                                <i class="ti ti-check"></i>
                                            </span>
                                        @else
                                            <span class="badge badge-center rounded-pill bg-danger bg-glow">
                                                <i class="ti ti-x"></i>
                                            </span>
                                        @endif
                                        {{-- <input class="form-check-input" type="checkbox" value="{{ $value->id }}"
                                        onclick="checkListPesyaratan(this)" id="checklist"
                                        @if ($value->checklist == 'yes') checked @endif
                                        @if (!auth()->user()->can('checklist berkas pengajuan')) disabled @endif /> --}}
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <div class="form-group">
                                <div class="label">Catatan</div>
                                <div class="value no_pembayaran"> {{ $catatan_pesyaratan }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/block-ui/block-ui.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>

    <script>
        $('button[data-bs-toggle="tab"]').on('click', function(e) {
            let target = $(e.currentTarget).attr('data-bs-target');
            console.log(target);

            switch (target) {
                case '#navs-prodecure':
                    $('#navs-prodecure').show('fade');
                    // $('#navs-wo-attachment').addClass('d-none');
                    $('#navs-wo-attachment').hide('fade');
                    break;
                case '#navs-wo-attachment':
                    $('#navs-prodecure').hide('fade');
                    // $('#navs-wo-attachment').removeClass('d-none');
                    $('#navs-wo-attachment').show('fade');
                    break;
                default:
                    break;
            }
        });
    </script>
@endsection
