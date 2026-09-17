<?php
$isEdit = !empty($product);
$pageTitle = $isEdit ? 'Chỉnh Sửa Thiết Bị #' . $product['id'] : 'Thêm Thiết Bị Điện Tử Mới';
require __DIR__ . '/../layouts/header.php';
$specs = $isEdit ? ($product['specs_array'] ?? []) : [];
?>

<div class="container px-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h3 class="fw-bold mb-1"><?= $isEdit ? 'Chỉnh Sửa Thiết Bị' : 'Thêm Thiết Bị Mới' ?></h3>
            <span class="text-muted small">Cập nhật thông tin và cấu hình kỹ thuật sản phẩm</span>
        </div>
        <a href="/admin/products" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-5">
        <form action="<?= $isEdit ? '/admin/products/edit/' . $product['id'] : '/admin/products/create' ?>" method="POST">
            <div class="row g-3 mb-4">
                <div class="col-md-8">
                    <label class="form-label small fw-semibold text-muted">Tên thiết bị điện tử *</label>
                    <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($product['name'] ?? '') ?>" placeholder="VD: Laptop Dell XPS 15 9530">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted">Mã SKU</label>
                    <input type="text" name="sku" class="form-control font-monospace" value="<?= htmlspecialchars($product['sku'] ?? '') ?>" placeholder="Tự động nếu để trống">
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-muted">Danh mục *</label>
                    <select name="category_id" class="form-select" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($isEdit && $product['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-muted">Thương hiệu *</label>
                    <select name="brand_id" class="form-select" required>
                        <?php foreach ($brands as $b): ?>
                            <option value="<?= $b['id'] ?>" <?= ($isEdit && $product['brand_id'] == $b['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($b['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted">Giá bán hiện tại (VNĐ) *</label>
                    <input type="number" name="price" class="form-control" required step="10000" value="<?= $product['price'] ?? '' ?>" placeholder="25000000">
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted">Giá niêm yết cũ (VNĐ)</label>
                    <input type="number" name="original_price" class="form-control" step="10000" value="<?= $product['original_price'] ?? '' ?>" placeholder="28000000">
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted">Số lượng tồn kho *</label>
                    <input type="number" name="stock" class="form-control" required min="0" value="<?= $product['stock'] ?? 20 ?>">
                </div>

                <div class="col-12">
                    <label class="form-label small fw-semibold text-muted">Mô tả ngắn</label>
                    <textarea name="short_description" class="form-control" rows="2" placeholder="Điểm nổi bật ngắn gọn..."><?= htmlspecialchars($product['short_description'] ?? '') ?></textarea>
                </div>

                <div class="col-12">
                    <label class="form-label small fw-semibold text-muted">Mô tả chi tiết</label>
                    <textarea name="description" class="form-control" rows="5" placeholder="Bài viết đánh giá chi tiết..."><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Technical specs inputs -->
            <h5 class="fw-bold mb-3 border-top pt-4"><i class="bi bi-cpu me-2 text-primary"></i>Thông Số Kỹ Thuật (Specs)</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted">Vi xử lý (CPU / Chip)</label>
                    <input type="text" name="spec_cpu" class="form-control form-control-sm" value="<?= htmlspecialchars($specs['cpu'] ?? '') ?>" placeholder="VD: Apple M3 / Intel Core i7">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted">Bộ nhớ RAM</label>
                    <input type="text" name="spec_ram" class="form-control form-control-sm" value="<?= htmlspecialchars($specs['ram'] ?? '') ?>" placeholder="VD: 16 GB DDR5">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted">Ổ cứng lưu trữ (Storage)</label>
                    <input type="text" name="spec_storage" class="form-control form-control-sm" value="<?= htmlspecialchars($specs['storage'] ?? '') ?>" placeholder="VD: 512 GB NVMe SSD">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted">Màn hình (Screen)</label>
                    <input type="text" name="spec_screen" class="form-control form-control-sm" value="<?= htmlspecialchars($specs['screen'] ?? '') ?>" placeholder="VD: 14.2 inch 120Hz OLED">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted">Card đồ họa (GPU)</label>
                    <input type="text" name="spec_gpu" class="form-control form-control-sm" value="<?= htmlspecialchars($specs['gpu'] ?? '') ?>" placeholder="VD: NVIDIA RTX 4060">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted">Pin & Sạc (Battery)</label>
                    <input type="text" name="spec_battery" class="form-control form-control-sm" value="<?= htmlspecialchars($specs['battery'] ?? '') ?>" placeholder="VD: 5000 mAh, Sạc 67W">
                </div>
            </div>

            <!-- Options: Featured & Status -->
            <div class="d-flex gap-4 mb-4 border-top pt-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="featured" id="featCheck" <?= (!empty($product['featured'])) ? 'checked' : '' ?>>
                    <label class="form-check-label small fw-semibold" for="featCheck">Sản phẩm nổi bật (Hiển thị trang chủ)</label>
                </div>
                <?php if ($isEdit): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="status" id="statusCheck" <?= (!empty($product['status'])) ? 'checked' : '' ?>>
                        <label class="form-check-label small fw-semibold" for="statusCheck">Đang kinh doanh</label>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary px-4 fw-bold">
                <i class="bi bi-save me-1"></i> Lưu Sản Phẩm
            </button>
            <a href="/admin/products" class="btn btn-outline-secondary ms-2">Hủy bỏ</a>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
