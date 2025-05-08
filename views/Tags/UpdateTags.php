<div class="modal fade" id="editTagModal<?= $tag['id'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4">
            <form action="?action=updateTags" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tag</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row g-3">
                    <input type="hidden" name="id" value="<?= $tag['id'] ?>">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($tag['name']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" value="<?= htmlspecialchars($tag['description']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= $tag['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="unactive" <?= $tag['status'] === 'unactive' ? 'selected' : '' ?>>Unactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>