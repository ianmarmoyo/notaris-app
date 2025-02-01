<!-- Edit Permission Modal -->
<div class="modal fade" id="editPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h3 class="mb-2">Edit Permission</h3>
                    <p class="text-muted"></p>
                </div>
                <div class="alert alert-warning" role="alert">
                    <h6 class="alert-heading mb-2">Warning</h6>
                    <p class="mb-0">Warning By editing permission names, you may damage the functionality of system
                        permissions. Please make sure you are completely sure before continuing.</p>
                </div>
                <form id="editPermissionForm" method="POST" class="row">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="col-sm-9">
                        <label class="form-label" for="name">Permission Name</label>
                        <input type="text" id="name" name="name" class="form-control"
                            placeholder="Permission Name" tabindex="-1" />
                    </div>
                    <div class="col-sm-3 mb-3">
                        <label class="form-label invisible d-none d-sm-inline-block">Button</label>
                        <button type="submit" class="btn btn-primary mt-1 mt-sm-0">Change</button>
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
<!--/ Edit Permission Modal -->
