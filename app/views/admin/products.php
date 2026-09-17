<?php
$pageTitle = 'Quản Lý Sản Phẩm - Admin';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h3 class="fw-bold mb-1"><i class="bi bi-box-seam me-2 text-primary"></i>Quản Lý Sản Phẩm</h3>
            <span class="text-muted small">Danh sách thiết bị điện tử, tồn kho và cấu hình kỹ thuật</span>
        </div>
        <div>
            <a href="/admin/products/create" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Thêm Thiết Bị Mới
            </a>
            <a href="/admin" class="btn btn-outline-secondary btn-sm ms-2">
                <i class="bi bi-arrow-left me-1"></i> Về Dashboard
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-5">
        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead class="table-light text-muted small text-uppercase">
                    <tr>
                        <th>ID</th>
                        <th>Thiết bị</th>
                        <th>Danh mục / Hãng</th>
                        <th>Giá bán</th>
                        <th>Tồn kho</th>
                        <th>Đã bán</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td class="text-muted fw-bold">#<?= $p['id'] ?></td>
                            <td>
                                <div class="fw-bold"><?= htmlspecialchars($p['name']) ?></div>
                                <div class="text-muted small">SKU: <code><?= htmlspecialchars($p['sku']) ?></code></div>
                            </td>
                            <td class="small">
                                <div><i class="bi bi-folder me-1 text-primary"></i> <?= htmlspecialchars($p['category_name']) ?></div>
                                <div><i class="bi bi-award me-1 text-secondary"></i> <?= htmlspecialchars($p['brand_name']) ?></div>
                            </td>
                            <td class="fw-bold text-primary"><?= $p['formatted_price'] ?></td>
                            <td>
                                <span class="badge <?= $p['stock'] > 10 ? 'bg-success' : ($p['stock'] > 0 ? 'bg-warning text-dark' : 'bg-danger') ?>">
                                    <?= $p['stock'] ?> chiếc
                                </span>
                            </td>
                            <td class="fw-semibold small"><?= $p['sales_count'] ?></td>
                            <td>
                                <span class="badge <?= $p['status'] == 1 ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= $p['status'] == 1 ? 'Kinh doanh' : 'Tạm ẩn' ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="/admin/products/edit/<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="/admin/products/delete/<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');" title="Xóa">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
