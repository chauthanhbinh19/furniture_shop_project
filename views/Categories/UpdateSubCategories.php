<div class="modal fade" id="editSubCategoryModal<?= $subCategory['id'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4">
            <form action="?action=updateSubCategories" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row g-3">
                    <input type="hidden" name="id" value="<?= $subCategory['id'] ?>">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($subCategory['name']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select">
                            <?php foreach ($data['categories'] as $category): ?>
                                <option value="<?= $category['id'] ?>" <?= $category['name'] == $subCategory['category_name'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" value="<?= htmlspecialchars($subCategory['description']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= $subCategory['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="unactive" <?= $subCategory['status'] === 'unactive' ? 'selected' : '' ?>>Unactive</option>
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