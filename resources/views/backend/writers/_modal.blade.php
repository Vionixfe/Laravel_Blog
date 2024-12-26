<!-- Modal -->
<div class="modal fade" id="modalVerified" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Verified Status</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formWriter">
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="is_verified" class="form-label">Verified Status</label>
                        <select class="form-control" id="is_verified" name="is_verified">
                            <option value="" hidden>-- select position --</option>
                            <option value="1">Verified</option>
                            <option value="0">UnVerified</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="formWriter" class="btn btn-primary btnSubmit">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- Form Modal -->
