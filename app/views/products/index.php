<?php
$pageTitle = !empty($searchQuery) ? 'Kết quả tìm kiếm: "' . htmlspecialchars($searchQuery) . '"' : 'Danh Sách Thiết Bị Điện Tử';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
            <?php if ($selectedCategory): ?>
                <li class="breadcrumb-item active"><?= htmlspecialchars($selectedCategory['name']) ?></li>
            <?php endif; ?>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-funnel me-2 text-primary"></i>Bộ Lọc</h5>
                    <a href="/products" class="text-muted small text-decoration-none">Xóa bộ lọc</a>
                </div>

                <form action="/products" method="GET">
                    <?php if (!empty($searchQuery)): ?>
                        <input type="hidden" name="q" value="<?= htmlspecialchars($searchQuery) ?>">
                    <?php endif; ?>

                    <!-- Category Filter -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Danh Mục</label>
                        <div class="d-flex flex-column gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" id="cat_all" value="" <?= empty($categorySlug) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="form-check-label small" for="cat_all">Tất cả danh mục</label>
                            </div>
                            <?php foreach ($categories as $cat): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" id="cat_<?= $cat['id'] ?>" value="<?= htmlspecialchars($cat['slug']) ?>" <?= $categorySlug === $cat['slug'] ? 'checked' : '' ?> onchange="this.form.submit()">
                                    <label class="form-check-label small d-flex justify-content-between" for="cat_<?= $cat['id'] ?>">
                                        <span><?= htmlspecialchars($cat['name']) ?></span>
                                        <span class="text-muted">(<?= $cat['product_count'] ?? 0 ?>)</span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Brand Filter -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Thương Hiệu</label>
                        <div class="d-flex flex-column gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="brand" id="brand_all" value="" <?= empty($brandSlug) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="form-check-label small" for="brand_all">Tất cả thương hiệu</label>
                            </div>
                            <?php foreach ($brands as $b): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="brand" id="brand_<?= $b['id'] ?>" value="<?= htmlspecialchars($b['slug']) ?>" <?= $brandSlug === $b['slug'] ? 'checked' : '' ?> onchange="this.form.submit()">
                                    <label class="form-check-label small d-flex justify-content-between" for="brand_<?= $b['id'] ?>">
                                        <span><?= htmlspecialchars($b['name']) ?></span>
                                        <span class="text-muted">(<?= $b['product_count'] ?? 0 ?>)</span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Khoảng Giá (VNĐ)</label>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" name="min_price" placeholder="Từ" value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>">
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" name="max_price" placeholder="Đến" value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary w-100">Áp dụng giá</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Product List Main Area -->
        <div class="col-lg-9">
            <!-- Header bar with sorting & engine status -->
            <div class="card border-0 shadow-xs rounded-4 p-3 mb-4 bg-white">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h4 class="fw-bold mb-1">
                            <?= $selectedCategory ? htmlspecialchars($selectedCategory['name']) : ($selectedBrand ? 'Thương hiệu ' . htmlspecialchars($selectedBrand['name']) : 'Tất Cả Thiết Bị') ?>
                        </h4>
                        <div class="small text-muted">
                            Tìm thấy <strong><?= count($products) ?></strong> sản phẩm
                            <?php if ($engineInfo): ?>
                                &bull; 
                                <span class="badge <?= $engineInfo['engine'] === 'rust' ? 'bg-warning text-dark' : 'bg-secondary' ?> ms-1">
                                    <i class="bi bi-cpu-fill"></i> <?= $engineInfo['engine'] === 'rust' ? 'Rust Fast Search' : 'PHP Fallback' ?> (<?= $engineInfo['latency_ms'] ?>ms)
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Sort dropdown -->
                    <div class="d-flex align-items-center gap-2">
                        <span class="small text-muted text-nowrap">Sắp xếp:</span>
                        <form action="/products" method="GET" class="d-inline">
                            <?php if (!empty($searchQuery)): ?><input type="hidden" name="q" value="<?= htmlspecialchars($searchQuery) ?>"><?php endif; ?>
                            <?php if (!empty($categorySlug)): ?><input type="hidden" name="category" value="<?= htmlspecialchars($categorySlug) ?>"><?php endif; ?>
                            <?php if (!empty($brandSlug)): ?><input type="hidden" name="brand" value="<?= htmlspecialchars($brandSlug) ?>"><?php endif; ?>
                            <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="newest" <?= ($sort === 'newest') ? 'selected' : '' ?>>Mới nhất</option>
                                <option value="price_asc" <?= ($sort === 'price_asc') ? 'selected' : '' ?>>Giá tăng dần</option>
                                <option value="price_desc" <?= ($sort === 'price_desc') ? 'selected' : '' ?>>Giá giảm dần</option>
                                <option value="best_seller" <?= ($sort === 'best_seller') ? 'selected' : '' ?>>Bán chạy nhất</option>
                                <option value="rating" <?= ($sort === 'rating') ? 'selected' : '' ?>>Đánh giá cao</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <?php if (empty($products)): ?>
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
                    <div class="text-muted mb-3">
                        <i class="bi bi-inbox display-1"></i>
                    </div>
                    <h5 class="fw-bold">Không tìm thấy sản phẩm nào!</h5>
                    <p class="text-muted small mb-4">Vui lòng thử tìm kiếm bằng từ khóa khác hoặc điều chỉnh lại các tiêu chí lọc.</p>
                    <div>
                        <a href="/products" class="btn btn-primary btn-sm px-4">Xem tất cả sản phẩm</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($products as $product): ?>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="tech-card">
                                <div class="card-img-wrap">
                                    <?php if ($product['discount_percent'] > 0): ?>
                                        <span class="badge-discount">-<?= $product['discount_percent'] ?>%</span>
                                    <?php endif; ?>
                                    <div class="p-3 text-center">
                                        <i class="bi bi-device-hdd display-5 text-primary opacity-75"></i>
                                    </div>
                                </div>
                                <div class="p-3 d-flex flex-column flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-muted small fw-medium"><?= htmlspecialchars($product['brand_name'] ?? '') ?></span>
                                        <div class="text-warning small">
                                            <i class="bi bi-star-fill"></i> <?= $product['rating'] ?>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold mb-2">
                                        <a href="/product/<?= urlencode($product['slug']) ?>" class="text-dark text-decoration-none line-clamp-2">
                                            <?= htmlspecialchars($product['name']) ?>
                                        </a>
                                    </h6>

                                    <div class="mb-3">
                                        <?php 
                                        $specs = $product['specs_array'];
                                        if (!empty($specs['cpu'])): ?>
                                            <span class="spec-pill"><i class="bi bi-cpu me-1"></i><?= htmlspecialchars(substr($specs['cpu'], 0, 18)) ?></span>
                                        <?php endif; ?>
                                        <?php if (!empty($specs['ram'])): ?>
                                            <span class="spec-pill"><i class="bi bi-memory me-1"></i><?= htmlspecialchars($specs['ram']) ?></span>
                                        <?php endif; ?>
                                        <?php if (!empty($specs['storage'])): ?>
                                            <span class="spec-pill"><i class="bi bi-hdd me-1"></i><?= htmlspecialchars($specs['storage']) ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold text-primary fs-5"><?= $product['formatted_price'] ?></div>
                                            <?php if ($product['formatted_original_price']): ?>
                                                <div class="text-muted text-decoration-line-through small" style="font-size: 0.75rem;"><?= $product['formatted_original_price'] ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm btn-ajax-add-cart rounded-3" data-product-id="<?= $product['id'] ?>" title="Thêm vào giỏ">
                                            <i class="bi bi-cart-plus fs-6"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
