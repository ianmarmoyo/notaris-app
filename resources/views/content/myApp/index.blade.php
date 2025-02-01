@extends('layouts/layoutMaster')

@section('title', $title)

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
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
    <link rel="stylesheet" href="{{ asset('assets/css/thumbnail.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/autosize/autosize.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin-dashboard-analytics') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </nav>

    <div class="row">
        <form id="form" class="form" action="{{ route('admin-myapp-store') }}">
            @csrf
            <!-- Basic with Icons -->
            <div class="col-xxl section-block">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ $title }}</h5> <small class="text-muted float-end">(*) Can not be
                            empty</small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="app_name">Application Name</label>
                                    <input type="text" class="form-control" value="{{ @$myapp['app_name'] ?? '' }}"
                                        name="app_name" placeholder="My Application...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="app_copyright">Application Copy Right & Link</label>
                                    <input type="text" class="form-control" name="app_copyright"
                                        value="{{ @$myapp['app_copyright'] ?? '' }}"
                                        placeholder="Application Copy Right...">
                                    {{-- <div class="input-group">
                                        <input type="text" name="app_copyright" value="{{ @$myapp['app_copyright'] ?? '' }}" class="form-control">
                                        <input type="text" name="app_link" placeholder="Link..." class="form-control">
                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="company_name">Company Name</label>
                                    <input type="text" class="form-control" value="{{ @$myapp['company_name'] ?? '' }}"
                                        name="company_name" placeholder="Company Name...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="company_city">Company City</label>
                                    <input type="text" class="form-control" value="{{ @$myapp['company_city'] ?? '' }}"
                                        name="company_city" placeholder="Company City...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="company_phone">Company Phone</label>
                                    <input type="text" class="form-control" value="{{ @$myapp['company_phone'] ?? '' }}"
                                        name="company_phone" placeholder="Company Phone...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="company_email">Company Emial</label>
                                    <input type="email" class="form-control" value="{{ @$myapp['company_email'] ?? '' }}"
                                        name="company_email" placeholder="Company Email...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="company_address">Company Address</label>
                                    <textarea name="company_address" class="form-control" id="" cols="30" rows="2">{{ @$myapp['company_address'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <h5>Tagline</h5>
                            <div class="col-12">
                                <div id="snow-toolbar">
                                    <span class="ql-formats">
                                        <select class="ql-font"></select>
                                        <select class="ql-size"></select>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-bold"></button>
                                        <button class="ql-italic"></button>
                                        <button class="ql-underline"></button>
                                        <button class="ql-strike"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <select class="ql-color"></select>
                                        <select class="ql-background"></select>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-script" value="sub"></button>
                                        <button class="ql-script" value="super"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-header" value="1"></button>
                                        <button class="ql-header" value="2"></button>
                                        <button class="ql-blockquote"></button>
                                        <button class="ql-code-block"></button>
                                    </span>
                                </div>
                                <div id="snow-editor">

                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <h5>Media</h5>
                            <div class="col-lg-4">
                                <div class="upload-container" id="image-icon">
                                    <div class="upload-img">
                                        <img src="{{ @$myapp['img_banner_icon'] }}" alt = "">
                                    </div>
                                    <center>
                                        <p class="upload-text text-muted">Unggah untuk banner menu kiri.</p>
                                    </center>
                                </div>
                                <div>
                                    <input type="file" name="img_banner_icon" class="visually-hidden"
                                        id="upload-input-icon">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="upload-container" id="image-login">
                                    <div class="upload-img">
                                        <img src="{{ @$myapp['img_banner_login'] }}" alt = "">
                                    </div>
                                    <center>
                                        <p class="upload-text text-muted">Unggah untuk gambar baner login.</p>
                                    </center>
                                </div>
                                <div>
                                    <input type="file" name="img_banner_login" class="visually-hidden"
                                        id="upload-input-login">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="upload-container" id="image-favicon">
                                    <div class="upload-img">
                                        <img src="{{ @$myapp['favicon_icon'] }}" alt = "">
                                    </div>
                                    <center>
                                        <p class="upload-text text-muted">Unggah untuk gambar favicon.</p>
                                    </center>
                                </div>
                                <div>
                                    <input type="file" name="favicon_icon" class="visually-hidden"
                                        id="upload-input-favicon">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <h5>Sosial Media</h5>
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" id="basic-addon-search31">
                                        <i class="ti ti-brand-facebook"></i>
                                    </span>
                                    <input type="text" name="facebook_url" value="{{ @$myapp['facebook_url'] }}"
                                        class="form-control" placeholder="Masukan URL..."
                                        aria-describedby="basic-addon-search31">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" id="basic-addon-search31">
                                        <i class="ti ti-brand-instagram"></i>
                                    </span>
                                    <input type="text" name="instagram_url" value="{{ @$myapp['instagram_url'] }}"
                                        class="form-control" placeholder="Masukan URL..."
                                        aria-describedby="basic-addon-search31">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" id="basic-addon-search31">
                                        <i class="ti ti-brand-whatsapp"></i>
                                    </span>
                                    <input type="text" name="whatsapp_url" value="{{ @$myapp['whatsapp_url'] }}"
                                        class="form-control" placeholder="Masukan URL..."
                                        aria-describedby="basic-addon-search31">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" id="basic-addon-search31">
                                        <i class="ti ti-brand-telegram"></i>
                                    </span>
                                    <input type="text" name="telegram_url" value="{{ @$myapp['telegram_url'] }}"
                                        class="form-control" placeholder="Masukan URL..."
                                        aria-describedby="basic-addon-search31">
                                </div>
                            </div>
                        </div>
                        {{-- Button --}}
                        <button type="submit" form="form" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>

        </form>
    </div>

@endsection
@section('page-script')
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/block-ui/block-ui.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#image-icon').click(function() {
                $('#upload-input-icon').trigger('click');
            });

            $('#upload-input-icon').change(event => {
                const file = event.target.files[0];
                const reader = new FileReader();
                let el = $('#image-icon')
                reader.readAsDataURL(file);

                reader.onloadend = () => {
                    el.find('.upload-text').text(file.name);
                    el.find('.upload-img img').attr('aria-label', file.name);
                    el.find('.upload-img img').attr('src', reader.result);
                }
            })

            $('#image-login').click(function() {
                $('#upload-input-login').trigger('click');
            });

            $('#upload-input-login').change(event => {
                const file = event.target.files[0];
                const reader = new FileReader();
                let el = $('#image-login')
                reader.readAsDataURL(file);

                reader.onloadend = () => {
                    el.find('.upload-text').text(file.name);
                    el.find('.upload-img img').attr('aria-label', file.name);
                    el.find('.upload-img img').attr('src', reader.result);
                }
            })

            $('#image-favicon').click(function() {
                $('#upload-input-favicon').trigger('click');
            });

            $('#upload-input-favicon').change(event => {
                const file = event.target.files[0];
                const reader = new FileReader();
                let el = $('#image-favicon')
                reader.readAsDataURL(file);

                reader.onloadend = () => {
                    el.find('.upload-text').text(file.name);
                    el.find('.upload-img img').attr('aria-label', file.name);
                    el.find('.upload-img img').attr('src', reader.result);
                }
            })

            let img_banner_icon,
                img_banner_login;

            const img_icon = document.getElementById('dropzone-icon-img');

            if (img_icon) {
                let myDropzoneImgIcon = new Dropzone(img_icon, {
                    previewTemplate: previewTemplateImgIcon,
                    paramName: 'thumbnails',
                    parallelUploads: 1,
                    maxFilesize: 5,
                    addRemoveLinks: true,
                    maxFiles: 1,
                    acceptedFiles: ".jpeg,.jpg,.png,.pdf",
                    dictMaxFilesExceeded: 'Anda tidak dapat mengunggah file lagi.',
                    dictInvalidFileType: "Anda tidak dapat mengunggah file jenis ini.",
                    init: function() {

                        var myDropzone = this;

                        @if (isset($myapp['img_banner_icon']))
                            let url_img = "{{ asset('storage/' . @$myapp['img_banner_icon']) }}";
                            var mockFile = {
                                name: 'Image Icon',
                                size: 12345,
                                width: "300",
                                height: "300",
                                fromServer: true,
                            };

                            myDropzone.emit("addedfile", mockFile);
                            myDropzone.emit("thumbnail", mockFile, url_img);
                            myDropzone.emit("complete", mockFile);
                            $(".dz-hidden-input").prop("disabled", true);
                        @endif
                    },
                    removedfile: function(file, dataUrl) {
                        var myDropzone = this;
                        file.previewElement.remove();
                        $(".dz-hidden-input").prop("disabled", false);
                    }
                }).on('thumbnail', (file, dataUrl) => {

                    let previewElement = file.previewElement;
                    img_banner_icon = file;

                    // img_banner_icon.push({
                    //     index: index,
                    //     file: file
                    // });
                });
            }

            const snowEditor = new Quill('#snow-editor', {
                bounds: '#snow-editor',
                modules: {
                    formula: true,
                    toolbar: '#snow-toolbar'
                },
                theme: 'snow'
            });
            snowEditor.pasteHTML("{!! @$myapp['app_tagline'] ?? '' !!}");

            // Form Submit
            const form = document.getElementById('form');
            const validation = FormValidation.formValidation(form, {
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {

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

                var myEditor = document.querySelector('#snow-editor')
                var html = myEditor.children[0].innerHTML

                data.append("app_tagline", html);
                data.append("img_banner_login", img_banner_login);
                data.append("img_banner_icon", img_banner_icon);

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
                    sectionUnBlock();
                    if (response.status) {
                        // document.location = response.route;
                        toastr.success(response.message, 'Success', 1000);
                    } else {
                        toastr.warning(response.message, 'Warning', 1000);
                    }
                    return;
                }).fail(function(response) {
                    const {
                        status,
                        message,
                        data
                    } = response.responseJSON
                    sectionUnBlock();
                    toastr.warning(data, 'Warning', 1000);
                })
            });

        });

        const previewTemplate = `
            <div class="dz-preview dz-file-preview">
                <div class="dz-details">
                    <div class="dz-thumbnail">
                    <img data-dz-thumbnail />
                    <span class="dz-nopreview">No preview</span>
                    <div class="dz-success-mark"></div>
                    <div class="dz-error-mark"></div>
                    <div class="dz-error-message"><span data-dz-errormessage></span></div>
                    <div class="progress">
                        <div
                        class="progress-bar progress-bar-primary"
                        role="progressbar"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        data-dz-uploadprogress
                        ></div>
                    </div>
                    </div>
                    <div class="dz-filename" data-dz-name></div>
                    <div class="dz-size" data-dz-size></div>
                </div>
            </div>
        `;

        const previewTemplateImgIcon = `
            <div class="dz-preview dz-file-preview">
                <div class="dz-details">
                    <div class="dz-thumbnail">
                    <img data-dz-thumbnail />
                    <span class="dz-nopreview">No preview</span>
                    <div class="dz-success-mark"></div>
                    <div class="dz-error-mark"></div>
                    <div class="dz-error-message"><span data-dz-errormessage></span></div>
                    <div class="progress">
                        <div
                        class="progress-bar progress-bar-primary"
                        role="progressbar"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        data-dz-uploadprogress
                        ></div>
                    </div>
                    </div>
                    <div class="dz-filename" data-dz-name></div>
                    <div class="dz-size" data-dz-size></div>
                </div>
            </div>
        `;

        function sectionBlock() {
            $('.section-block').block({
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
            $('.section-block').unblock();
        }
    </script>
@endsection
