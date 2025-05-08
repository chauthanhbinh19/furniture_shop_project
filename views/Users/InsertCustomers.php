<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="?action=insertCustomers" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label d-block">Avatar</label>
                            <button type="button" class="btn btn-outline-primary" id="uploadAvatarBtn">
                                Upload Avatar
                            </button>
                            <input type="file" id="avatarInput" accept="image/*" class="d-none" name="image">
                            <input type="hidden" id="avatarPath">
                            <div class="mt-2" id="avatarPreview" style="display:none;">
                                <img src="" alt="Avatar" class="rounded-circle" width="80" height="80">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active">Active</option>
                                <option value="unactive">Unactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Customer</button>
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Lắng nghe sự kiện click vào nút "Upload Avatar"
    document.getElementById('uploadAvatarBtn').addEventListener('click', () => {
        // Khi click vào nút, sẽ mở cửa sổ chọn file ảnh
        document.getElementById('avatarInput').click();
    });

    // Lắng nghe sự kiện thay đổi khi người dùng chọn ảnh
    document.getElementById('avatarInput').addEventListener('change', () => {
        const file = document.getElementById('avatarInput').files[0];
        if (file && file.type.startsWith('image/')) {
            handleFile(file);
        }
    });

    // Xử lý file ảnh khi được chọn
    function handleFile(file) {
        const fileName = file.name;

        // Cập nhật giá trị input ẩn với tên file
        document.getElementById('avatarPath').value = fileName;

        // Hiển thị ảnh tải lên
        const reader = new FileReader();
        reader.onload = () => {
            const previewDiv = document.getElementById('avatarPreview');
            const previewImg = previewDiv.querySelector('img');

            previewImg.src = reader.result; // Hiển thị ảnh trong preview
            previewDiv.style.display = 'block'; // Hiển thị ảnh đã tải lên
        };
        reader.readAsDataURL(file);
    }
</script>