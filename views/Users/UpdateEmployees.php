<div class="modal fade" id="editEmployeeModal<?= $employee['id'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4">
            <form action="?action=updateEmployees" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Employee</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row g-3">
                    <input type="hidden" name="id" value="<?= $employee['id'] ?>">
                    <div class="col-md-6">
                        <label class="form-label d-block">Avatar</label>
                        <!-- Trong UpdateEmployees.php -->
                        <button type="button" class="btn btn-outline-primary" id="uploadAvatarBtn<?= $employee['id'] ?>">
                            Upload Avatar
                        </button>
                        <input type="file" id="avatarInput<?= $employee['id'] ?>" accept="image/*" class="d-none" name="image">
                        <input type="hidden" id="avatarPath<?= $employee['id'] ?>">
                        <input type="hidden" name="old_image" id="avatarPath<?= $employee['id'] ?>" value="<?= $employee['image'] ?>">
                        <div class="mt-2" id="avatarPreview<?= $employee['id'] ?>" style="display:<?= !empty($employee['image']) ? 'block' : 'none' ?>;">
                            <img src="../../public/assets/avatars/<?= $employee['image'] ?>" alt="Avatar" class="rounded-circle" width="80" height="80">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($employee['full_name']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($employee['username']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($employee['email']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" value="<?= htmlspecialchars($employee['password']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control" value="<?= htmlspecialchars($employee['phone_number']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control" value="<?= htmlspecialchars($employee['date_of_birth']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="male" <?= $employee['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
                            <option value="female" <?= $employee['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= $employee['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="unactive" <?= $employee['status'] === 'unactive' ? 'selected' : '' ?>>Unactive</option>
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
<script>
    document.getElementById('uploadAvatarBtn<?= $employee['id'] ?>').addEventListener('click', () => {
        document.getElementById('avatarInput<?= $employee['id'] ?>').click();
    });

    document.getElementById('avatarInput<?= $employee['id'] ?>').addEventListener('change', () => {
        const file = document.getElementById('avatarInput<?= $employee['id'] ?>').files[0];
        if (file && file.type.startsWith('image/')) {
            handleFile<?= $employee['id'] ?>(file);
        }
    });

    function handleFile<?= $employee['id'] ?>(file) {
        const fileName = file.name;
        document.getElementById('avatarPath<?= $employee['id'] ?>').value = fileName;

        const reader = new FileReader();
        reader.onload = () => {
            const previewDiv = document.getElementById('avatarPreview<?= $employee['id'] ?>');
            const previewImg = previewDiv.querySelector('img');
            previewImg.src = reader.result;
            previewDiv.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
</script>