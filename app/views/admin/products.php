<?php
$pageTitle = 'Quản Lý Sản Phẩm - Admin';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container-fluid px-lg-5 px-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-danger rounded-pill px-3 py-1 small fw-bold">ADMIN INVENTORY</span>
                <h3 class="fw-bold mb-0 text-dark"><i class="bi bi-box-seam me-2 text-danger"></i>Quản Lý Sản Phẩm</h3>
            </div>
            <span class="text-muted small">Danh mục thiết bị điện tử, kiểm soát tồn kho và thông số phần cứng</span>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= BASE_URL ?>/admin/products/create" class="btn btn-rose btn-sm fw-semibold shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Thêm Thiết Bị Mới
            </a>
            <a href="<?= BASE_URL ?>/admin" class="btn btn-soft-slate btn-sm">
                <i class="bi bi-speedometer2 me-1"></i> Về Dashboard
            </a>
        </div>
    </div>

    <div class="card card-glass border-0 shadow-card rounded-4 p-4 mb-5">
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
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td class="text-muted fw-bold font-monospace">#<?= $p['id'] ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($p['name']) ?></div>
                                <div class="text-muted small">SKU: <code><?= htmlspecialchars($p['sku']) ?></code></div>
                            </td>
                            <td class="small">
                                <div><i class="bi bi-folder me-1 text-danger"></i> <?= htmlspecialchars($p['category_name']) ?></div>
                                <div><i class="bi bi-award me-1 text-muted"></i> <?= htmlspecialchars($p['brand_name']) ?></div>
                            </td>
                            <td class="fw-bold text-danger"><?= $p['formatted_price'] ?></td>
                            <td>
                                <span class="badge <?= $p['stock'] > 10 ? 'bg-success' : ($p['stock'] > 0 ? 'bg-warning text-dark' : 'bg-danger') ?> rounded-pill px-3 py-1">
                                    <?= $p['stock'] ?> chiếc
                                </span>
                            </td>
                            <td class="fw-semibold small text-muted"><?= $p['sales_count'] ?></td>
                            <td>
                                <span class="badge <?= $p['status'] == 1 ? 'bg-success' : 'bg-secondary' ?> rounded-pill px-3 py-1">
                                    <?= $p['status'] == 1 ? 'Đang kinh doanh' : 'Ngừng kinh doanh' ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1 align-items-center">
                                    <a href="<?= BASE_URL ?>/admin/products/edit/<?= $p['id'] ?>" class="btn btn-sm btn-outline-rose rounded-pill px-2" title="Chỉnh sửa">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <?php if ($p['status'] == 1): ?>
                                        <form action="<?= BASE_URL ?>/admin/products/delete" method="POST" class="d-inline m-0" onsubmit="return confirm('Bạn có chắc muốn chuyển sản phẩm sang trạng thái Ngừng kinh doanh?');">
                                            <?= \App\Core\Csrf::field() ?>
                                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-soft-slate rounded-pill px-2 text-danger border-0" title="Ngừng kinh doanh">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
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
