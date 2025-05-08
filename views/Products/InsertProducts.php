<div class="container py-2">
    <form action="?action=insertCustomers" method="POST" enctype="multipart/form-data">
        <div class="card rounded-10 py-0  mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <a href="/admin/products" class="btn-sm me-3" title="Back">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h4 class="mb-0">Add New Product</h4>
                    </div>
                    <div>
                        <!-- <button class="btn btn-outline-secondary me-2">Scan to Fill Form</button> -->
                        <!-- <button class="btn btn-outline-primary me-2">Save to Draft</button> -->
                        <button type="submit" class="btn btn-primary">Save Product</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Left Column: Product Image & Tags -->
            <div class="col-md-6 rounded-10">
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title fw-bold pb-3 mb-3 border-bottom">Product type</h6>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Category</label>
                            <input type="text" class="form-control" placeholder="e.g. Sunscreen, Sun" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tag</label>
                            <input type="text" class="form-control" placeholder="e.g. Sunscreen, Sun" />
                        </div>
                        <!-- <div class="mb-3 text-center">
                        <img src="https://via.placeholder.com/200x150" class="img-fluid mb-2" alt="Product Image">
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-sm btn-outline-secondary">Replace</button>
                            <button class="btn btn-sm btn-outline-danger">Remove</button>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-light w-100">+ Add Another Image</button> -->
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title fw-bold pb-2 mb-3 border-bottom">Add Images</h6>

                        <div class="border rounded text-center p-4 upload-area" onclick="document.getElementById('imageInput').click()">
                            <div class="mb-2">
                                <i class="fas fa-cloud-upload-alt fa-2x text-secondary"></i>
                            </div>
                            <p class="mb-1 text-muted">Drag your image here</p>
                            <p class="text-muted">or, <span class="text-primary text-decoration-underline">Browse</span></p>
                            <input type="file" class="d-none" id="imageInput" accept="image/*" onchange="handleImageUpload(event)" />
                        </div>

                        <div id="imagePreview"></div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Product Info -->
            <div class="col-md-6 rounded-10">
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title fw-bold pb-3 mb-3 border-bottom">General Information</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Product Name</label>
                                <input type="text" class="form-control" placeholder="Enter product name" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Slug</label>
                                <input type="text" class="form-control" placeholder="Enter slug" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Warranty period</label>
                                <input type="text" class="form-control" placeholder="Enter warranty period" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Warranty unit</label>
                                <select name="warranty_unit" class="form-select">
                                    <option value="day">Day</option>
                                    <option value="month">Month</option>
                                    <option value="year">Year</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active">Active</option>
                                    <option value="unactive">Unactive</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Price</label>
                                <input type="text" class="form-control" placeholder="$ 100.00" />
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Descriptions</label>
                                <textarea class="form-control" rows="3" placeholder="Enter product description..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Manage property -->
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title fw-bold pb-3 mb-3 border-bottom">Attributes</h6>
                        <div class="row g-3">
                            <div class="row g-2 align-items-center ps-3">
                                <!-- Container for specs -->
                                <div id="spec-list"></div>
                            </div>
                            <div class="row g-2 align-items-center">
                                <div class="col-md-5">
                                    <input type="text" class="form-control" id="labelInput" placeholder="Label (e.g. Memory)">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" id="propertyInput" placeholder="Property (e.g. 8GB RAM)">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary w-100" type="button" onclick="addSpec()">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</form>
</div>
<script>
    let uploadedFiles = [];

    function handleImageUpload(event) {
        const files = Array.from(event.target.files);
        files.forEach(file => {
            if (!uploadedFiles.some(f => f.name === file.name)) {
                uploadedFiles.push(file);
            }
        }); // lưu lại danh sách file
        renderPreview();
    }

    function renderPreview() {
        const previewContainer = document.getElementById('imagePreview');
        previewContainer.innerHTML = '';

        uploadedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const fileSizeMB = (file.size / 1024 / 1024).toFixed(1);
                const preview = `
                    <div class="preview-item" data-index="${index}">
                        <img src="${e.target.result}" alt="${file.name}" />
                        <div>
                            <div class="preview-filename">${file.name}</div>
                            <div class="preview-size">${fileSizeMB} MB</div>
                        </div>
                        <button class="delete-btn" onclick="deleteImage(${index})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                `;
                previewContainer.insertAdjacentHTML('beforeend', preview);
            };
            reader.readAsDataURL(file);
        });
    }

    function deleteImage(index) {
        uploadedFiles.splice(index, 1); // xoá file khỏi mảng
        renderPreview(); // cập nhật lại giao diện
    }
</script>
<script>
    function addSpec() {
        const label = document.getElementById("labelInput").value.trim();
        const property = document.getElementById("propertyInput").value.trim();
        if (!label || !property) return;

        const item = document.createElement("div");
        item.className = "d-flex justify-content-between align-items-center mb-2";

        item.innerHTML = `
      <div class="col-md-5">
        <strong class="col-md-5">${label}</strong>
        </div>
        <div class="col-md-5">
        <span class="col-md-5">${property}</span>
      </div>
      <button class="delete-btn" onclick="this.parentElement.remove()">
        <i class="fas fa-trash-alt"></i>
      </button>
    `;

        document.getElementById("spec-list").appendChild(item);
        document.getElementById("labelInput").value = "";
        document.getElementById("propertyInput").value = "";
    }
</script>