<!-- Add Permission Modal -->
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div id="custom_loading" class="custom-loading custom_loading_all d-none">
                    <div class="spinner-border spinner-border-lg text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <div id="custom_loading" class="custom-loading custom_loading_all d-none">
                        <div class="spinner-border spinner-border-lg text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <h3 class="mb-2">Add New Menu</h3>
                </div>
                <form id="form_add_menu" method="POST" class="row" action="{{ route('admin-menu-store') }}">
                    @csrf
                    <div class="col-12 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_header" id="is_header" />
                            <label class="form-check-label" for="is_header">
                                Is Header
                            </label>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label" for="menu_header">Parent Menu</label>
                        <select class="form-control select2" id="menu_header" name="menu_header"></select>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label" for="menu_name">Nama Menu</label>
                        <input type="text" id="menu_name" name="menu_name" class="form-control"
                            placeholder="Menu Name" autofocus />
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label" for="menu_icon">Icon</label>
                        <input type="text" id="menu_icon" name="menu_icon" class="form-control"
                            placeholder="Menu Icon Contoh (ti ti-namaIcon)" autofocus />
                        <details>
                            <summary>Referensi Icon</summary>
                            <p>
                                <a href="https://tabler-icons.io/" target="_blank">Tabler Icon (ti ti-iconName)</a>
                            </p>
                            <p>
                                <a href="https://boxicons.com/" target="_blank">Box Icon (bx bx-iconName)</a>
                            </p>
                            <p>
                                <a href="https://fontawesome.com/v4/icons/" target="_blank">Font Awesome Icon (fa
                                    fa-iconName)</a>
                            </p>
                        </details>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label" for="slug">Slug / Route</label>
                        <input type="text" id="slug" name="slug" class="form-control" placeholder="Icon"
                            autofocus />
                    </div>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Create menu</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Discard</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Add Permission Modal -->
