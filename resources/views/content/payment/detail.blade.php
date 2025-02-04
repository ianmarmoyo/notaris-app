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
                                    placeholder="Otomatis..." value="{{ $payment->no_pembayaran }}" disabled>
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
                                        <div class="value nama_klien">{{ $payment->work_order->nama }}</div>
                                    </div>

                                    <div class="form-group">
                                        <div class="label">No Telepon</div>
                                        <div class="value notelp_klien">{{ $payment->work_order->no_telp }}</div>
                                    </div>

                                    <div class="form-group">
                                        <div class="label">Status Pembayaran</div>
                                        <div class="value status_pembayaran">
                                            @if ($payment->work_order->status_pembayaran == 'lunas')
                                                <span class="badge bg-label-success me-1">Lunas</span>
                                            @else
                                                <span class="badge bg-label-danger me-1">Belum Lunas</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="label">Alamat</div>
                                        <div class="value address address_klien">
                                            {{ $payment->work_order->alamat }}
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
                                    <tbody>
                                        @foreach ($payment->work_order->work_order_details as $key => $value)
                                            <tr>
                                                <td>{{ $value->keperluan }}</td>
                                                <td>{{ formatRupiah($value->harga) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>TOTAL</td>
                                            <td>{{ formatRupiah($payment->work_order->work_order_details->sum('harga')) }}
                                            </td>
                                        </tr>
                                    </tfoot>
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
                                    <input type="text" class="form-control" name="" id=""
                                        placeholder="Masukan Nominal..." min="0"
                                        value="{{ formatRupiah($payment->nominal) }}" @disabled(true)>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="tgl_pembayaran">Tanggal Pembayaran</label>
                                    <input type="text" id="" name="" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($payment->tgl_bayar)->format('Y-m-d H:i') }}"
                                        @disabled(true) />
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="tgl_pembayaran">Metode Pembayaran</label>
                                    <input type="text" value="{{ $payment->metode_pembayaran }}" class="form-control"
                                        @disabled(true)>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="client-card" id="detail_pembayaran">
                                    <h5 class="text-primary">Semua Pembayaran</h5>
                                    @foreach ($payment->work_order->work_order_payments as $key => $row)
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

        });
    </script>
@endsection
