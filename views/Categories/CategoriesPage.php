<?php
$totalPages = $data['totalPages'];
$currentPage = $data['currentPage'];
$maxVisible = 7;

$start = max(1, $currentPage - 3);
$end = min($totalPages, $currentPage + 3);

if ($end - $start < $maxVisible - 1) {
    if ($start == 1) {
        $end = min($start + $maxVisible - 1, $totalPages);
    } elseif ($end == $totalPages) {
        $start = max(1, $end - $maxVisible + 1);
    }
}
?>
<div class="container-fluid py-2">
    <div class="card rounded-10 py-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h4 class="mb-0">Category</h4>
                    <button class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#addCategoryModal">
                        <i class="cil-user-follow"></i> Add category
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-2">
    <div class="card rounded-10">
        <div class="card-body">
            <!-- New filter section: search box and dropdown -->
            <form method="get" action="" id="filterForm">
            <div class="row g-3 mb-3 mt-0 align-items-end">
                    <!-- Search input -->
                    <div class="col-md-4">
                        <label for="searchInput" class="form-label fw-bold">Search</label>
                        <div class="input-group position-relative">
                            <span class="position-absolute"
                                style="left: 10px; top: 50%; transform: translateY(-50%); z-index: 2;">
                                <svg class="icon icon-xs text-dark" viewBox="0 0 512 512" width="20" height="20" fill="gray">
                                    <path d="M505 442.7L405.3 343c28.4-34.9 45.7-79 45.7-127C451 96.5 354.5 0 231.5 0S12 96.5 12 216.5 108.5 433 231.5 433c48 0 92.1-17.3 127-45.7l99.7 99.7c4.7 4.7 12.3 4.7 17 0l28.8-28.8c4.8-4.7 4.8-12.3.1-17zM231.5 375c-87.5 0-158.5-71-158.5-158.5S144 58 231.5 58 390 129 390 216.5 319 375 231.5 375z" />
                                </svg>
                            </span>
                            <input type="text" id="searchInput" name="search"
                                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                                class="form-control ps-5 rounded-10 py-2"
                                placeholder="Search category name...">
                        </div>
                    </div>

                    <!-- Status select -->
                    <div class="col-md-4">
                        <label for="statusSelect" class="form-label fw-bold">Status</label>
                        <select class="form-select rounded-10 py-2" id="statusSelect" name="status">
                            <option value="all">All</option>
                            <option value="active" <?= ($_GET['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="unactive" <?= ($_GET['status'] ?? '') === 'unactive' ? 'selected' : '' ?>>Unactive</option>
                        </select>
                    </div>

                    <!-- Sort select -->
                    <div class="col-md-4">
                        <label for="sortSelect" class="form-label fw-bold">Sort</label>
                        <select class="form-select rounded-10 py-2" id="sortSelect" name="sort">
                            <option value="newest" <?= ($_GET['sort'] ?? '') === 'newest' ? 'selected' : '' ?>>Select by Newest</option>
                            <option value="oldest" <?= ($_GET['sort'] ?? '') === 'oldest' ? 'selected' : '' ?>>Select by Oldest</option>
                        </select>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <!-- PHP loop example -->
                        <?php foreach ($data['categories'] as $category): ?>
                            <tr>
                                <td><?= htmlspecialchars($category['id']) ?></td>
                                <td><?= htmlspecialchars($category['name']) ?></td>
                                <td class="text-center">
                                    <?php if ($category['status'] === 'active'): ?>
                                        <span class="badge bg-success text-white">Active</span>
                                    <?php elseif ($category['status'] === 'unactive'): ?>
                                        <span class="badge bg-danger text-white">Unactive</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary text-white"><?= htmlspecialchars($category['status']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><!-- Định dạng ngày tạo tài khoản -->
                                    <?= date('d-m-Y', strtotime($category['created_at'])) ?></td>
                                <td>
                                    <button class="btn btn-outline-warning" data-coreui-toggle="modal" data-coreui-target="#editCategoryModal<?= $category['id'] ?>">
                                        Edit
                                    </button>
                                    <a href="delete_category.php?id=<?= $category['id'] ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                    <!-- Include modal update ở đây -->
                                    <?php include __DIR__ . '/UpdateCategories.php'; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mt-4">
                    <!-- Previous -->
                    <li class="page-item <?= ($data['currentPage'] <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= max(1, $data['currentPage'] - 1) ?>">Previous</a>
                    </li>

                    <!-- Các số trang -->
                    <!-- First page + ... -->
                    <?php if ($start > 1): ?>
                        <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
                        <?php if ($start > 2): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <!-- Pages around current -->
                    <?php for ($i = $start; $i <= $end; $i++): ?>
                        <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- ... + Last page -->
                    <?php if ($end < $totalPages): ?>
                        <?php if ($end < $totalPages - 1): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $totalPages ?>"><?= $totalPages ?></a></li>
                    <?php endif; ?>

                    <!-- Next -->
                    <li class="page-item <?= ($data['currentPage'] >= $data['totalPages']) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= min($data['totalPages'], $data['currentPage'] + 1) ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<script>
    const filterForm = document.getElementById('filterForm');

    filterForm.querySelectorAll('select[name="status"], select[name="sort"]').forEach(function(select) {
        select.addEventListener('change', function() {
            filterForm.submit();
        });
    });
</script>
<?php
include 'InsertCategories.php';
?>