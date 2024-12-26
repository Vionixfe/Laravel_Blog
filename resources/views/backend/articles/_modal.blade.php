<!-- Modal -->
<div class="modal fade" id="modalConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Confirmation Status</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formConfirm">
                    <input type="hidden" name="uuid" id="uuid">
                    <div class="mb-3">
                        <label for="is_confirm" class="form-label">Confirmation Status</label>
                        <select class="form-control" id="is_confirm" name="is_confirm">
                            <option value="" hidden>-- select position --</option>
                            <option value="1">Confirm</option>
                            <option value="0">UnConfirm</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="formConfirm" class="btn btn-primary btnSubmit">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- Form Modal -->
