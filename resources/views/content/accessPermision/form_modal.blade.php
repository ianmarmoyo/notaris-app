<!-- Add Permission Modal -->
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h3 class="mb-2"></h3>
                </div>
                <form id="form" method="POST" class="row" action="">
                    @csrf
                    <input type="hidden" name="id" id="id">

                    <div class="col-12 mb-3">
                        <label class="form-label" for="role">Hak Akses Untuk Menu ?</label>
                        <select name="accessForMenu" id="accessForMenu" class="form-control select2">
                            <option value=""></option>
                            <option value="parent">Parent Menu</option>
                            <option value="child">Child Menu</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3 d-none">
                        <label class="form-label" for="parent_menu_id">Parent Menu</label>
                        <select name="parent_menu_id" id="parent_menu_id" class="form-control select2">

                        </select>
                    </div>
                    <div class="col-12 mb-3 d-none">
                        <label class="form-label" for="child_menu_id">Child Menu</label>
                        <select name="child_menu_id" id="child_menu_id" class="form-control select2">

                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label" for="name">Nama Hak Akses</label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="Nama Hak Akses.." required>
                    </div>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Simpan</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Discard</button>
                    </div>
                </form>
            </div>
            <div id="custom_loading" class="custome-loading custome_loading_all d-none">
                <div class="spinner-border spinner-border-lg text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Add Permission Modal -->
