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
                    <h5 class="card-title mb-1 pt-2">Total Pelanggan</h5>
                    <small class="text-muted">Bulan Ini</small>
                    <p class="mb-2 mt-1">
                        {{ number_format($total_pelanggan, 0, '.', ',') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Profit -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-devices-check ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">Total Layanan</h5>
                    <small class="text-muted">Bulan Ini</small>
                    <p class="mb-2 mt-1">
                        {{ number_format($total_layanan, 0, '.', ',') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Profit -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-devices-check ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">Total Proses</h5>
                    <small class="text-muted">Bulan Ini</small>
                    <p class="mb-2 mt-1">
                        {{ number_format($total_wo_proses, 0, '.', ',') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Profit -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-devices-check ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">Total Selesai</h5>
                    <small class="text-muted">Bulan Ini</small>
                    <p class="mb-2 mt-1">
                        {{ number_format($total_wo_selesai, 0, '.', ',') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Sales -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-info mb-2 rounded"><i class="ti ti-devices-check ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">Total Tagihan Invoice</h5>
                    <small class="text-muted">Bulan Ini</small>
                    <p class="mb-2 mt-1">
                        {{ number_format($total_tagihan_invoice, 0, '.', ',') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Profit -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-info mb-2 rounded"><i class="ti ti-devices-check ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">Total Pembayaran</h5>
                    <small class="text-muted">Bulan Ini</small>
                    <p class="mb-2 mt-1">
                        {{ number_format($total_pembayaran, 0, '.', ',') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-7">
            <div class="card">
                <div class="card-header header-elements">
                    <h5 class="card-title mb-0">Grafik Layanan Proses Bulanan</h5>
                    {{-- <div class="card-action-element ms-auto py-0">
                        <div class="dropdown">
                            <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown"
                                aria-expanded="false"><i class="ti ti-calendar"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Today</a>
                                </li>
                                <li><a href="javascript:void(0);"
                                        class="dropdown-item d-flex align-items-center">Yesterday</a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 7
                                        Days</a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 30
                                        Days</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Current
                                        Month</a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last
                                        Month</a></li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
                <div class="card-body">
                    <canvas id="chartLayananProsesBulanan" class="chartjs" data-height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="card">
                <div class="card-header header-elements">
                    <h5 class="card-title mb-0">Grafik Layanan Proses 5 Tahun Terakhir</h5>
                    {{-- <div class="card-action-element ms-auto py-0">
                        <div class="dropdown">
                            <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown"
                                aria-expanded="false"><i class="ti ti-calendar"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a href="javascript:void(0);"
                                        class="dropdown-item d-flex align-items-center">Today</a>
                                </li>
                                <li><a href="javascript:void(0);"
                                        class="dropdown-item d-flex align-items-center">Yesterday</a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 7
                                        Days</a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 30
                                        Days</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Current
                                        Month</a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last
                                        Month</a></li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
                <div class="card-body">
                    <canvas id="chartLayananProsesTahunan" class="chartjs" data-height="400"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-7">
            <div class="card">
                <div class="card-header header-elements">
                    <h5 class="card-title mb-0">Grafik Layanan Selesai Bulanan</h5>
                    {{-- <div class="card-action-element ms-auto py-0">
                        <div class="dropdown">
                            <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown"
                                aria-expanded="false"><i class="ti ti-calendar"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Today</a>
                                </li>
                                <li><a href="javascript:void(0);"
                                        class="dropdown-item d-flex align-items-center">Yesterday</a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 7
                                        Days</a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 30
                                        Days</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Current
                                        Month</a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last
                                        Month</a></li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
                <div class="card-body">
                    <canvas id="chartLayananSelesaiBulanan" class="chartjs" data-height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="card">
                <div class="card-header header-elements">
                    <h5 class="card-title mb-0">Grafik Layanan Selesai 5 Tahun Terakhir</h5>
                    {{-- <div class="card-action-element ms-auto py-0">
                        <div class="dropdown">
                            <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown"
                                aria-expanded="false"><i class="ti ti-calendar"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a href="javascript:void(0);"
                                        class="dropdown-item d-flex align-items-center">Today</a>
                                </li>
                                <li><a href="javascript:void(0);"
                                        class="dropdown-item d-flex align-items-center">Yesterday</a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 7
                                        Days</a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 30
                                        Days</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Current
                                        Month</a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last
                                        Month</a></li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
                <div class="card-body">
                    <canvas id="chartLayananSelesaiTahunan" class="chartjs" data-height="400"></canvas>
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
        let chartLayananSelesaiTahunan;
        let chartLayananSelesaiBulanan;

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
                        data: [],
                        backgroundColor: '#28dac6',
                        borderColor: 'transparent',
                        maxBarThickness: 15,
                        borderRadius: {
                            topRight: 15,
                            topLeft: 15
                        }
                    }]
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
                            // max: 400,
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

            chartLayananProsesTahunan = new Chart(document.getElementById('chartLayananProsesTahunan'), {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        data: [],
                        backgroundColor: '#28dac6',
                        borderColor: 'transparent',
                        maxBarThickness: 15,
                        borderRadius: {
                            topRight: 15,
                            topLeft: 15
                        }
                    }]
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
                            // max: ,
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

            chartLayananSelesaiBulanan = new Chart(document.getElementById('chartLayananSelesaiBulanan'), {
                type: 'bar',
                data: {
                    labels: [
                        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                    datasets: [{
                        data: [],
                        backgroundColor: '#836AF9',
                        borderColor: 'transparent',
                        maxBarThickness: 15,
                        borderRadius: {
                            topRight: 15,
                            topLeft: 15
                        }
                    }]
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
                            // max: 400,
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

            chartLayananSelesaiTahunan = new Chart(document.getElementById('chartLayananSelesaiTahunan'), {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        data: [],
                        backgroundColor: '#836AF9',
                        borderColor: 'transparent',
                        maxBarThickness: 15,
                        borderRadius: {
                            topRight: 15,
                            topLeft: 15
                        }
                    }]
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
                            // max: ,
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
            updateChartLayananProsesTahunan();

            updateChartLayananSelesaiBulanan();
            updateChartLayananSelesaiTahunan();
        });

        function updateChartLayananProsesBulanan() {
            $.ajax({
                url: "{{ route('admin-dashboard-dataChartLayananBulanan') }}",
                method: 'get',
                dataType: 'json',
                data: {
                    status_penugasan: 'Dalam Proses'
                },
                beforeSend: function() {

                },
                success: function(response) {
                    chartLayananProsesBulanan.data.labels = response.labels;
                    chartLayananProsesBulanan.data.datasets[0].data = response.data;
                    chartLayananProsesBulanan.update();
                }
            });
        }

        function updateChartLayananProsesTahunan() {
            $.ajax({
                url: "{{ route('admin-dashboard-dataChartLayananTahunan') }}",
                method: 'get',
                dataType: 'json',
                data: {
                    status_penugasan: 'Dalam Proses'
                },
                beforeSend: function() {

                },
                success: function(response) {
                    chartLayananProsesTahunan.data.labels = response.labels;
                    chartLayananProsesTahunan.data.datasets[0].data = response.data;
                    chartLayananProsesTahunan.update();
                }
            });
        }

        function updateChartLayananSelesaiBulanan() {
            $.ajax({
                url: "{{ route('admin-dashboard-dataChartLayananBulanan') }}",
                method: 'get',
                dataType: 'json',
                data: {
                    status_penugasan: 'Selesai'
                },
                beforeSend: function() {

                },
                success: function(response) {
                    chartLayananSelesaiBulanan.data.labels = response.labels;
                    chartLayananSelesaiBulanan.data.datasets[0].data = response.data;
                    chartLayananSelesaiBulanan.update();
                }
            });
        }

        function updateChartLayananSelesaiTahunan() {
            $.ajax({
                url: "{{ route('admin-dashboard-dataChartLayananTahunan') }}",
                method: 'get',
                dataType: 'json',
                data: {
                  status_penugasan: 'Selesai'
                },
                beforeSend: function() {
                    status_penugasan: 'Selesai'
                },
                success: function(response) {
                    chartLayananSelesaiTahunan.data.labels = response.labels;
                    chartLayananSelesaiTahunan.data.datasets[0].data = response.data;
                    chartLayananSelesaiTahunan.update();
                }
            });
        }
    </script>
@endsection
