<div class="modal fade" id="uploadAvatarModal" tabindex="-1" aria-labelledby="uploadAvatarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title">Upload Avatar</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="dropZone" class="border border-2 border-primary rounded p-4 text-center" style="cursor: pointer;">
                    <p>Drag & Drop your avatar here<br>or click to select</p>
                    <input type="file" id="avatarInput" accept="image/*" class="d-none">
                </div>
                <div class="progress mt-3 d-none" id="uploadProgress">
                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                </div>
                <div class="mt-3 text-center" id="uploadedAvatar" style="display:none;">
                    <img src="" id="uploadedImg" class="rounded-circle" width="100" height="100">
                    <div>
                        <button class="btn btn-sm btn-secondary mt-2" onclick="reselectAvatar()">Change</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const dropZone = document.getElementById('dropZone');
    const avatarInput = document.getElementById('avatarInput');
    const progressBar = document.querySelector('.progress-bar');
    const progressWrapper = document.getElementById('uploadProgress');
    const uploadedAvatar = document.getElementById('uploadedAvatar');
    const uploadedImg = document.getElementById('uploadedImg');
    const avatarPreview = document.getElementById('avatarPreview');
    const avatarPath = document.getElementById('avatarPath');
    const uploadAvatarBtn = document.getElementById('uploadAvatarBtn');

    dropZone.addEventListener('click', () => avatarInput.click());

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('bg-light');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('bg-light');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('bg-light');
        const file = e.dataTransfer.files[0];
        handleFile(file);
    });

    avatarInput.addEventListener('change', () => {
        const file = avatarInput.files[0];
        handleFile(file);
    });

    function handleFile(file) {
        if (!file || !file.type.startsWith('image/')) return;
        
        // Simulate upload progress
        progressWrapper.classList.remove('d-none');
        progressBar.style.width = '0%';
        let percent = 0;
        const fakeUpload = setInterval(() => {
            percent += 10;
            progressBar.style.width = `${percent}%`;
            if (percent >= 100) {
                clearInterval(fakeUpload);
                showAvatar(file);
            }
        }, 100);
    }

    function showAvatar(file) {
        const reader = new FileReader();
        reader.onload = () => {
            const fileName = file.name;
            uploadedImg.src = reader.result;
            uploadedAvatar.style.display = 'block';
            progressWrapper.classList.add('d-none');

            // Update hidden input
            avatarPath.value = fileName;

            // Update preview
            avatarPreview.querySelector('img').src = reader.result;
            avatarPreview.style.display = 'block';

            // Change button text
            // if (uploadAvatarBtn) {
            //     uploadAvatarBtn.textContent = fileName;
            // }

            // Close upload modal
            const uploadModal = coreui.Modal.getInstance(document.getElementById('uploadAvatarModal'));
            if (uploadModal) uploadModal.hide();

            // Open insert modal again
            const insertModalEl = document.getElementById('addCustomerModal');
            if (insertModalEl) {
                const insertModal = new coreui.Modal(insertModalEl);
                insertModal.show();
            }
        };
        reader.readAsDataURL(file);
    }

    function reselectAvatar() {
        uploadedAvatar.style.display = 'none';
        avatarInput.click();
    }
    document.getElementById('uploadAvatarBtn').addEventListener('click', (e) => {
    e.preventDefault(); // Ngăn ngừa sự kiện click mặc định
    avatarInput.value = ''; // Reset để chọn lại ảnh trùng
    avatarInput.click(); // Mở cửa sổ chọn file ảnh
});

</script>

