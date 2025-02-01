@extends('layouts/layoutMaster')

@section('title', $title)

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
        <div class="accordion mt-3" id="accordionExample">
            @foreach ($procedures as $key => $procedure)
                <div class="card accordion-item @if ($key == 0) active @endif">
                    <h2 class="accordion-header" id="headingOne">
                        <button type="button" class="accordion-button" data-bs-toggle="collapse"
                            data-bs-target="#accordion_{{ $procedure->id }}" aria-expanded="true"
                            aria-controls="accordion_{{ $procedure->id }}">
                            {{ $procedure->proses }}
                        </button>
                    </h2>

                    <div id="accordion_{{ $procedure->id }}"
                        class="accordion-collapse collapse @if ($key == 0) show @endif"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form action="">
                                @csrf
                                <input type="hidden" name="balik_nama_waris_id" value="{{ $procedure->id }}">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="switch switch-lg">
                                            <input type="checkbox" name="checklist" class="switch-input"
                                                onclick="checklistProses(this)" value="{{ $procedure->id }}"
                                                @if ($procedure->checklist) checked @endif />
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on">
                                                    <i class="ti ti-check"></i>
                                                </span>
                                                <span class="switch-off">
                                                    <i class="ti ti-x"></i>
                                                </span>
                                            </span>
                                            <span class="switch-label">
                                                @if ($procedure->checklist == 1)
                                                    Selesai
                                                @else
                                                    Belum Selesai
                                                @endif
                                            </span>
                                        </label>
                                    </div>
                                    @if ($procedure->proses == 'Pembayaran dan Validasi Pajak Waris')
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="status_pembayaran">
                                                Status Pembayaran
                                            </label>
                                            <select id="status_pembayaran" name="status_pembayaran"
                                                class="select2 form-select" placeholder="Status Pembayaran..."
                                                data-allow-clear="true">
                                                <option value="belum" @if ($procedure->status_pembayaran == 'belum') selected @endif>
                                                    Belum
                                                </option>
                                                <option value="negosiasi" @if ($procedure->status_pembayaran == 'negosiasi') selected @endif>
                                                    Negosiasi</option>
                                                <option value="sudah" @if ($procedure->status_pembayaran == 'sudah') selected @endif>
                                                    Sudah
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="status_pembayaran">
                                                Tanggal Pembayaran
                                            </label>
                                            <input type="text" id="tgl_pembayaran_{{ $procedure->id }}"
                                                name="tgl_pembayaran" class="form-control dob-picker"
                                                placeholder="YYYY-MM-DD" value="{{ $procedure->tgl_bayar }}" />
                                        </div>
                                    @endif
                                    @if ($procedure->proses == 'Penyerahan')
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="status_pembayaran">
                                                Gambar
                                            </label>
                                            <input type="file" id="gambar" name="gambar" class="form-control"
                                                placeholder="No Berkas..." value="" />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="">
                                                <img src="{{ $procedure->view_gambar }}" class=""
                                                    style="max-width: 200px" alt="">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-4 mb-3">
                                        <label class="col-form-label" for="status_pembayaran">
                                            Catatan
                                        </label>
                                        <textarea name="catatan" class="form-control" id="" cols="30" rows="3">{{ $procedure->catatan }}</textarea>
                                    </div>
                                </div>
                            </form>
                            <button type="button" onclick="saveProcedure(this)" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-success waves-effect waves-light" onclick="penugasanSelesai()">
                Penugasan Selesai
            </button>
        </div>
    </div>
    <div class="fade" id="navs-wo-attachment">
        <div class="row">
            <div class="accordion stick-top accordion-bordered" id="workOrderAttachment">
                <div class="accordion-item active mb-0">
                    <div class="accordion-header" id="headingOne">
                        <button type="button" class="accordion-button bg-lighter rounded-0" data-bs-toggle="collapse"
                            data-bs-target="#chapter_1" aria-expanded="true" aria-controls="chapter_1">
                            <span class="d-flex flex-column">
                                <span class="h5 mb-1">{{ $page_title }}</span>
                                <span class="fw-normal text-body">Persyaratan Berkas</span>
                            </span>
                        </button>
                    </div>
                    <div id="chapter_1" class="accordion-collapse collapse show" data-bs-parent="#workOrderAttachment">
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
        $(document).ready(function() {
            $('input[name=tgl_pembayaran]').flatpickr({
                monthSelectorType: 'static'
            });
            // $('button[data-bs-toggle="tab"]').trigger('click');
        });

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

        function checklistProses(e) {
            let id = e.value;
            let status = e.checked;
            let label = $(e).closest('.switch').find('.switch-label');
            console.log({
                status
            });

            if (status) {
                label.text('Selesai');
            } else {
                label.text('Belum Selesai');
            }
        }

        function saveProcedure(e) {
            let closest = $(e).closest('.accordion-body');
            let balik_nama_waris_id = closest.find('input[name="balik_nama_waris_id"]').val();
            let formData = new FormData(closest.find('form')[0]);
            console.log(formData);
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            $.ajax({
                url: "{{ route('admin-baliknamahibah-store') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    sectionBlock(`accordion_${balik_nama_waris_id}`);
                }
            }).done(function(response) {
                sectionUnBlock(`accordion_${balik_nama_waris_id}`);
                if (response.status) {
                    // document.location = response.route
                    toastr.success(response.message, 'Success', 1000);
                } else {
                    toastr.warning(response.message, 'Warning', 1000);
                }
                return;
            }).fail(function(response) {
                sectionUnBlock(`accordion_${balik_nama_waris_id}`);
                const {
                    status,
                    message
                } = response.responseJSON
                toastr.warning(message, 'Warning', 1000);
            })
        }

        function penugasanSelesai() {
            let work_order_assignment_id = "{{ $work_order_assignment_id }}";

            $.ajax({
                url: "{{ route('admin-workorder-assignmentDone') }}",
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "wo_assignment_id": work_order_assignment_id
                },
                beforeSend: function() {
                    $.blockUI({
                        message: '<div class="sk-wave mx-auto"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div>',
                        css: {
                            backgroundColor: 'transparent',
                            border: '0'
                        },
                        overlayCSS: {
                            opacity: 0.5
                        }
                    });
                }
            }).done(function(response) {
                $.unblockUI();
                if (response.status) {
                    document.location = response.route
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil !',
                        text: response.message,
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                } else {
                    toastr.warning(response.message, 'Warning', 1000);
                }
                return;
            }).fail(function(response) {
                $.unblockUI();
                const {
                    status,
                    message
                } = response.responseJSON
                toastr.warning(message, 'Warning', 1000);
            });
        }

        function sectionBlock(element) {
            $(`#${element}`).block({
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
            $(`#${element}`).unblock();
        }
    </script>
@endsection
