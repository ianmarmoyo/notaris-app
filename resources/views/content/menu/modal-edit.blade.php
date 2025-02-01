<!-- Add Permission Modal -->
<div class="modal fade" id="modal_edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h3 class="mb-2">Edit Menu</h3>
                </div>
                <form id="form_edit_menu" method="POST" class="row" action="{{ route('admin-menu-update') }}">
                    @csrf
                    <input type="hidden" name="is_parent" id="is_parent" value="">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="col-12 mb-2 d-none">
                        <div class="form-check">
                            <input class="form-check-input is_header" type="checkbox" name="is_header" id="is_header" />
                            <label class="form-check-label" for="is_header">
                                Is Header
                            </label>
                        </div>
                    </div>
                    <div class="col-12 mb-3 d-none">
                        <label class="form-label" for="menu_header_foredit">Parent Menu</label>
                        <select class="form-control select2" id="menu_header_foredit" name="menu_header"></select>
                    </div>
                    <div class="col-12 mb-3 ">
                        <label class="form-label" for="menu_name">Nama Menu</label>
                        <input type="text" id="menu_name" name="menu_name" class="form-control"
                            placeholder="Menu Name" autofocus />
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label" for="menu_icon">Icon</label>
                        <input type="text" id="menu_icon" name="menu_icon" class="form-control"
                            placeholder="Menu Icon" autofocus />
                        <a href="https://tabler-icons.io/" target="_blank">Referensi Icon</a>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label" for="slug">Slug / Route</label>
                        <input type="text" id="slug" name="slug" class="form-control" placeholder="Icon"
                            autofocus />
                    </div>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Change menu</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Discard</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Add Permission Modal -->
