@extends('layouts/layoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/chartjs/chartjs.js') }}"></script>
@endsection

@section('content')
    <div class="row">
        <!-- Total Profit -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-users ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">{{ number_format($total_pelanggan, 0, '.', ',') }}</h5>
                    <small class="text-muted">Bulan Ini</small>
                    <p class="mb-2 mt-1">
                        Total Pelanggan
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Profit -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-devices-check ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">{{ number_format($total_layanan, 0, '.', ',') }}</h5>
                    <small class="text-muted">Bulan Ini</small>
                    <p class="mb-2 mt-1">
                        Total Layanan
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Profit -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-devices-check ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">
                        {{ number_format($total_wo_proses, 0, '.', ',') }}
                    </h5>
                    <small class="text-muted">Bulan Ini</small>
                    <p class="mb-2 mt-1">
                        Total Proses
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Profit -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-devices-check ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">{{ number_format($total_wo_selesai, 0, '.', ',') }}</h5>
                    <small class="text-muted">Bulan Ini</small>
                    <p class="mb-2 mt-1">
                        Total Selesai
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Sales -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-info mb-2 rounded"><i class="ti ti-devices-check ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">
                        {{ number_format($total_tagihan_invoice, 0, '.', ',') }}
                    </h5>
                    <small class="text-muted">Bulan Ini</small>
                    <p class="mb-2 mt-1">
                        Total Tagihan Invoice
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Profit -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-info mb-2 rounded"><i class="ti ti-devices-check ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">
                        {{ number_format($total_pembayaran, 0, '.', ',') }}
                    </h5>
                    <small class="text-muted">Bulan Ini</small>
                    <p class="mb-2 mt-1">
                        Total Pembayaran
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="card" id="chart-layanan">
                <div class="card-header header-elements">
                    <h5 class="card-title mb-0">Grafik Layanan Proses Bulanan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-xl-3">
                            <select name="year" id="" class="form-select select2">
                                @foreach (years() as $year)
                                    <option value="{{ $year }}"
                                        @if ($year == date('Y')) @selected(true) @endif>
                                        {{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <canvas id="chartLayananProsesBulanan" class="chartjs" data-height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/dashboards-crm.js') }}"></script>
    <script src="{{ asset('assets/js/charts-chartjs.js') }}"></script>

    <script>
        let chartLayananProsesTahunan;
        let chartLayananProsesBulanan;

        $(() => {
            const purpleColor = '#836AF9',
                yellowColor = '#ffe800',
                cyanColor = '',
                orangeColor = '#FF8132',
                orangeLightColor = '#FDAC34',
                oceanBlueColor = '#299AFF',
                greyColor = '#4F5D70',
                greyLightColor = '#EDF1F4',
                blueColor = '#2B9AFF',
                blueLightColor = '#84D0FF';

            let cardColor, headingColor, labelColor, borderColor, legendColor;

            if (isDarkStyle) {
                cardColor = config.colors_dark.cardColor;
                headingColor = config.colors_dark.headingColor;
                labelColor = config.colors_dark.textMuted;
                legendColor = config.colors_dark.bodyColor;
                borderColor = config.colors_dark.borderColor;
            } else {
                cardColor = config.colors.cardColor;
                headingColor = config.colors.headingColor;
                labelColor = config.colors.textMuted;
                legendColor = config.colors.bodyColor;
                borderColor = config.colors.borderColor;
            }

            chartLayananProsesBulanan = new Chart(document.getElementById('chartLayananProsesBulanan'), {
                type: 'bar',
                data: {
                    labels: [
                        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                    datasets: [{
                            label: 'Layanan Proses',
                            data: [],
                            backgroundColor: '#836AF9',
                            borderColor: 'transparent',
                            maxBarThickness: 20,
                            borderRadius: {
                                topRight: 15,
                                topLeft: 15
                            }
                        },
                        {
                            label: 'Layanan Selesai',
                            data: [],
                            backgroundColor: '#28dac6',
                            borderColor: 'transparent',
                            borderWidth: 1,
                            maxBarThickness: 20,
                            borderRadius: {
                                topRight: 15,
                                topLeft: 15
                            }
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 500
                    },
                    plugins: {
                        tooltip: {
                            rtl: isRtl,
                            backgroundColor: cardColor,
                            titleColor: headingColor,
                            bodyColor: legendColor,
                            borderWidth: 1,
                            borderColor: borderColor
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: borderColor,
                                drawBorder: false,
                                borderColor: borderColor
                            },
                            ticks: {
                                color: labelColor
                            }
                        },
                        y: {
                            min: 0,
                            beginAtZero: true,
                            grid: {
                                color: borderColor,
                                drawBorder: false,
                                borderColor: borderColor
                            },
                            ticks: {
                                stepSize: 100,
                                color: labelColor
                            }
                        }
                    }
                }
            });

            updateChartLayananProsesBulanan();
        });

        $('#chart-layanan select[name=year]').on('change', function() {
            updateChartLayananProsesBulanan();
        });

        function updateChartLayananProsesBulanan() {
            let year = $('#chart-layanan select[name=year]').val();
            $.ajax({
                url: "{{ route('admin-dashboard-dataChartLayanan') }}",
                method: 'get',
                dataType: 'json',
                data: {
                    status_penugasan: 'Dalam Proses',
                    tahun: year
                },
                beforeSend: function() {

                },
                success: function(response) {
                    chartLayananProsesBulanan.data.labels = response.labels;
                    chartLayananProsesBulanan.data.datasets[0].data = response.data.dalam_proses;
                    chartLayananProsesBulanan.data.datasets[1].data = response.data.selesai;
                    chartLayananProsesBulanan.update();
                }
            });
        }
    </script>
@endsection
