@extends('layouts/layoutMaster')

@section('title', 'Analytics')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}">

    <style>
        .total-balance-monthly .box {
            box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
            padding: 10px;
            border-radius: 5px;
            height: 5em;
            margin-bottom: 16px;
        }
    </style>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/accounting/accounting.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/block-ui/block-ui.js') }}"></script>
@endsection

@section('content')

    <div class="row max-h-32">
        <!-- Transaction Analytics -->
        @include('content.dashboard.items.transaction_analytics')
        <!--/ Transaction Analytics -->

        <!-- Total Transaction Savings Overview -->
        @include('content.dashboard.items.total_tranction_savings')
        <!--/ Total Transaction Savings Overview -->
    </div>
    {{-- Chart Saldo Debit dan kredit --}}
    <div class="row max-h-32 mb-4">
        <div class="col-md-8">
            <div class="card" id="section-chart-balance">
                <div class="card-header">
                    <div class="card-title">
                        Laporan Total Debit Dan Kredit Mingguan
                    </div>
                </div>
                <div class="card-body">
                    <center id="date-range"></center>
                    <div id="chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" id="section">
                <div class="card-header">
                    <div class="card-title">
                        <span class="font-weight-bold">Total Saldo</span>
                        <br>
                        <small>Informasi ini bedasarkan bulanan</small>
                    </div>
                </div>
                <div class="card-body total-balance-monthly d-grid ">
                    <div class="box">
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="card-icon w-20">
                                <span class="badge bg-label-success rounded-pill p-2">
                                    <i class='ti ti-currency-dollar ti-sm'></i>
                                </span>
                            </div>
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">
                                    Rp. {{ number_format($transactionMonthly['total_setoran'], 0, '.', ',') }}
                                </h5>
                                <small>Setoran</small>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="card-icon w-20">
                                <span class="badge bg-label-success rounded-pill p-2">
                                    <i class='ti ti-currency-dollar ti-sm'></i>
                                </span>
                            </div>
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">
                                    Rp. {{ number_format($transactionMonthly['total_penarikan'], 0, '.', ',') }}
                                </h5>
                                <small>Penarikan</small>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="card-icon w-20">
                                <span class="badge bg-label-success rounded-pill p-2">
                                    <i class='ti ti-currency-dollar ti-sm'></i>
                                </span>
                            </div>
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">
                                    Rp. {{ number_format($transactionMonthly['total_pembiayaan'], 0, '.', ',') }}
                                </h5>
                                <small>Angsuran</small>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="card-icon w-20">
                                <span class="badge bg-label-success rounded-pill p-2">
                                    <i class='ti ti-currency-dollar ti-sm'></i>
                                </span>
                            </div>
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">
                                    Rp. {{ number_format($transactionMonthly['total_baitulmal'], 0, '.', ',') }}
                                </h5>
                                <small>Baitul Mal</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Riwaya Transaksi --}}
    <div class="row max-h-32">
        <div class="col-md-4">
            <div class="card" id="section-chart-balance">
                <div class="card-header">
                    <div class="card-title">
                        Transaksi Terakhir
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        @foreach ($lastTransactionHistories as $row)
                            <li class="d-flex align-items-center mb-4 cursor-pointer" data-bs-toggle="tooltip"
                                data-bs-placement="top" data-bs-custom-class="tooltip-info" title="{{ $row->note }}">
                                {{-- <img src="{{ asset('assets/svg/flags/us.svg') }}" alt="User" class="rounded-circle me-3" width="34"> --}}
                                <span class="badge bg-label-info rounded-pill p-2 me-3">
                                    <i class='ti ti-currency-dollar ti-sm'></i>
                                </span>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-1 text-capitalize">
                                                {{ str_replace('_', ' ', $row->type) }}
                                            </h6>

                                        </div>
                                        @php
                                            $date = \Carbon\Carbon::parse($row->updated_at)->locale('id');

                                            $date->settings(['formatFunction' => 'translatedFormat']);
                                        @endphp
                                        <small class="text-muted">{{ $date->diffForHumans() }}</small>
                                    </div>
                                    <div class="user-progress">
                                        <p class="text-success fw-medium mb-0 d-flex justify-content-center gap-1">
                                            @switch($row->type)
                                                @case('setoran')
                                                @case('biaya_admin')

                                                @case('baitul_mal')
                                                    <span class="badge bg-label-success">Rp.
                                                        {{ number_format($row->total_debit - $row->total_credit, 0, '.', ',') }}</span>
                                                @break

                                                @case('penarikan')
                                                    <span class="badge bg-label-danger">Rp.
                                                        {{ number_format($row->total_debit - $row->total_credit, 0, '.', ',') }}</span>
                                                @break

                                                @default
                                            @endswitch
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        {{-- <li class="d-flex align-items-center mb-4">
                            <img src="{{ asset('assets/svg/flags/br.svg') }}" alt="User" class="rounded-circle me-3"
                                width="34">
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mb-0 me-1">$2,415k</h6>
                                    </div>
                                    <small class="text-muted">Brazil</small>
                                </div>
                                <div class="user-progress">
                                    <p class="text-danger fw-medium mb-0 d-flex justify-content-center gap-1">
                                        <i class='ti ti-chevron-down'></i>
                                        100.000.000
                                    </p>
                                </div>
                            </div>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card" id="section">
                <div class="card-header">
                    <div class="card-title">
                        <span class="font-weight-bold">Daftar Angota</span>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="datatables-members table border-top">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Detail Address</th>
                                <th>Type Member</th>
                                <th>Join Date</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

    <script>
        $(() => {
            // swiper loop and autoplay
            // --------------------------------------------------------------------
            const swiperWithPagination = document.querySelector('#transaction-sliders');
            if (swiperWithPagination) {
                new Swiper(swiperWithPagination, {
                    loop: true,
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false
                    },
                    pagination: {
                        clickable: true,
                        el: '.swiper-pagination'
                    }
                });
            }

            $('.datatables-members').DataTable({
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
                    url: "{{ route('admin-member-read') }}",
                    type: "GET",
                    data: function(data) {

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
                        render: function(data, type, row) {
                            let no_id = '-';
                            if (row.no_id != null) {
                                no_id = row.no_id;
                            }
                            return `
                              ${data} <br/> ${no_id}
                            `;
                        },
                        targets: [1]
                    },
                    {
                        render: function(data, type, row) {
                            return moment(data).format('DD/MM/YYYY');
                        },
                        targets: [4]
                    },
                ],
                columns: [{
                        data: "no"
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "address"
                    },
                    {
                        data: "type_member"
                    },
                    {
                        data: "join_date"
                    }
                ]
            });

            // Chart Saldo Debit dan kredit
            report_balance_weekly();
        });

        function report_balance_weekly() {
            $.ajax({
                    url: "{{ url('admin/dashboard/report_balance_weekly') }}",
                    method: 'GET',
                    data: '',
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    beforeSend: function() {
                        sectionBlock('section-chart-balance');
                    }
                })
                .done(function(res) {
                    sectionUnBlock('section-chart-balance');
                    $('center#date-range').html(res.weekStartDate + ' - ' + res.weekEndDate);
                    var options = {
                        series: [{
                                name: 'Debit',
                                data: res.data.total_debit
                            },
                            {
                                name: 'Kredit',
                                // data: [76, 85, 101, 98, 87, 105, 91]
                                data: res.data.total_credit
                            }
                        ],
                        // colors: ['#000000', '#FF0000'],
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                endingShape: 'rounded'
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']
                        },
                        yaxis: {
                            title: {
                                text: 'RP '
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return (accounting.formatMoney(val, 'Rp. ', 0, ',', '.'));
                                }
                            }
                        }
                    };
                    var chart = new ApexCharts(document.querySelector('#chart'), options);
                    chart.render();
                })
                .fail(function(response) {
                    sectionUnBlock();
                    const {
                        status,
                        message
                    } = response.responseJSON;
                    $('.custome-loading').addClass('d-none');
                    toastr.warning(message, 'Warning', 1000);
                });
        }

        function sectionBlock(that) {
            $(`#${that}`).block({
                message: '<div class="spinner-border text-primary" role="status"></div>',
                css: {
                    backgroundColor: 'transparent',
                    border: '0'
                },
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.8
                }
            });
        }

        function sectionUnBlock(that) {
            $(`#${that}`).unblock();
        }
    </script>
@endsection
