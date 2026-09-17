<?php
$pageTitle = !empty($searchQuery) ? 'Kết quả tìm kiếm: "' . htmlspecialchars($searchQuery) . '"' : 'Danh Sách Thiết Bị Điện Tử';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="/products" class="text-decoration-none">Sản phẩm</a></li>
            <?php if ($selectedCategory): ?>
                <li class="breadcrumb-item active"><?= htmlspecialchars($selectedCategory['name']) ?></li>
            <?php elseif ($selectedBrand): ?>
                <li class="breadcrumb-item active">Thương hiệu <?= htmlspecialchars($selectedBrand['name']) ?></li>
            <?php else: ?>
                <li class="breadcrumb-item active">Tất cả thiết bị</li>
            <?php endif; ?>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Sidebar Filters with Frosted Glass -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px; background: rgba(255, 255, 255, 0.88); backdrop-filter: blur(16px); border: 1px solid var(--border-color) !important;">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-funnel-fill me-2 text-danger"></i>Bộ Lọc Tìm Kiếm</h5>
                    <a href="/products" class="text-danger small fw-semibold text-decoration-none">Xóa tất cả</a>
                </div>

                <form action="/products" method="GET">
                    <?php if (!empty($searchQuery)): ?>
                        <input type="hidden" name="q" value="<?= htmlspecialchars($searchQuery) ?>">
                    <?php endif; ?>

                    <!-- Category Filter -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted tracking-wider">Danh Mục Thiết Bị</label>
                        <div class="d-flex flex-column gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" id="cat_all" value="" <?= empty($categorySlug) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="form-check-label small fw-medium" for="cat_all">Tất cả danh mục</label>
                            </div>
                            <?php foreach ($categories as $cat): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" id="cat_<?= $cat['id'] ?>" value="<?= htmlspecialchars($cat['slug']) ?>" <?= $categorySlug === $cat['slug'] ? 'checked' : '' ?> onchange="this.form.submit()">
                                    <label class="form-check-label small d-flex justify-content-between align-items-center" for="cat_<?= $cat['id'] ?>">
                                        <span class="fw-medium"><?= htmlspecialchars($cat['name']) ?></span>
                                        <span class="badge bg-light text-muted border rounded-pill" style="font-size: 0.7rem;"><?= $cat['product_count'] ?? 0 ?></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Brand Filter -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted tracking-wider">Thương Hiệu</label>
                        <div class="d-flex flex-column gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="brand" id="brand_all" value="" <?= empty($brandSlug) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="form-check-label small fw-medium" for="brand_all">Tất cả thương hiệu</label>
                            </div>
                            <?php foreach ($brands as $b): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="brand" id="brand_<?= $b['id'] ?>" value="<?= htmlspecialchars($b['slug']) ?>" <?= $brandSlug === $b['slug'] ? 'checked' : '' ?> onchange="this.form.submit()">
                                    <label class="form-check-label small d-flex justify-content-between align-items-center" for="brand_<?= $b['id'] ?>">
                                        <span class="fw-medium"><?= htmlspecialchars($b['name']) ?></span>
                                        <span class="badge bg-light text-muted border rounded-pill" style="font-size: 0.7rem;"><?= $b['product_count'] ?? 0 ?></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted tracking-wider">Khoảng Giá (VNĐ)</label>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm rounded-3" name="min_price" placeholder="Từ..." value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>">
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm rounded-3" name="max_price" placeholder="Đến..." value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-rose w-100 mt-2">Áp dụng bộ lọc</button>
                    </div>

                    <!-- Store Support Box -->
                    <div class="p-3 bg-light rounded-3 small text-muted border">
                        <div class="fw-bold text-dark mb-1"><i class="bi bi-headset text-danger me-1"></i> Cần tư vấn chọn máy?</div>
                        <p class="mb-2" style="font-size: 0.78rem;">Đội ngũ kỹ thuật viên 12B5 Store luôn sẵn sàng hỗ trợ trực tiếp qua tổng đài.</p>
                        <a href="tel:18001235" class="btn btn-sm btn-outline-dark w-100 rounded-pill"><i class="bi bi-telephone me-1"></i> 1800.1235 (Miễn phí)</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Product List Main Area -->
        <div class="col-lg-9">
            <!-- Header Bar with Filter Details & Sorting -->
            <div class="card border-0 shadow-sm rounded-4 p-3 mb-4" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(16px); border: 1px solid var(--border-color) !important;">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">
                            <?= $selectedCategory ? htmlspecialchars($selectedCategory['name']) : ($selectedBrand ? 'Thương hiệu ' . htmlspecialchars($selectedBrand['name']) : 'Tất Cả Thiết Bị Điện Tử') ?>
                        </h4>
                        <div class="small text-muted d-flex flex-wrap align-items-center gap-2">
                            <span>Tìm thấy <strong><?= count($products) ?></strong> sản phẩm</span>
                            <?php if ($engineInfo): ?>
                                <span class="badge <?= $engineInfo['engine'] === 'rust' ? 'bg-warning text-dark' : 'bg-secondary' ?> rounded-pill">
                                    <i class="bi bi-cpu-fill"></i> <?= $engineInfo['engine'] === 'rust' ? '⚡ Rust Fuzzy Search' : 'PHP Core Search' ?> (<?= $engineInfo['latency_ms'] ?>ms)
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Sort dropdown -->
                    <div class="d-flex align-items-center gap-2">
                        <span class="small text-muted text-nowrap fw-semibold">Sắp xếp theo:</span>
                        <form action="/products" method="GET" class="d-inline">
                            <?php if (!empty($searchQuery)): ?><input type="hidden" name="q" value="<?= htmlspecialchars($searchQuery) ?>"><?php endif; ?>
                            <?php if (!empty($categorySlug)): ?><input type="hidden" name="category" value="<?= htmlspecialchars($categorySlug) ?>"><?php endif; ?>
                            <?php if (!empty($brandSlug)): ?><input type="hidden" name="brand" value="<?= htmlspecialchars($brandSlug) ?>"><?php endif; ?>
                            <select name="sort" class="form-select form-select-sm rounded-pill px-3 shadow-none border-secondary-subtle" onchange="this.form.submit()">
                                <option value="newest" <?= ($sort === 'newest') ? 'selected' : '' ?>>Mới nhất</option>
                                <option value="price_asc" <?= ($sort === 'price_asc') ? 'selected' : '' ?>>Giá tăng dần</option>
                                <option value="price_desc" <?= ($sort === 'price_desc') ? 'selected' : '' ?>>Giá giảm dần</option>
                                <option value="best_seller" <?= ($sort === 'best_seller') ? 'selected' : '' ?>>Bán chạy nhất</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <?php if (empty($products)): ?>
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white my-4">
                    <div class="text-muted mb-3">
                        <i class="bi bi-search display-2 text-secondary opacity-50"></i>
                    </div>
                    <h4 class="fw-bold">Không tìm thấy sản phẩm phù hợp!</h4>
                    <p class="text-muted small mb-4">Hãy thử tìm kiếm với từ khóa khác hoặc xóa bớt tiêu chí lọc danh mục / khoảng giá.</p>
                    <div>
                        <a href="/products" class="btn btn-rose px-4 py-2">Xem Tất Cả Sản Phẩm</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="row g-4 mb-5">
                    <?php foreach ($products as $product): ?>
                        <div class="col-12 col-sm-6 col-xl-4">
                            <div class="tech-card">
                                <div class="card-img-wrap">
                                    <?php if ($product['discount_percent'] > 0): ?>
                                        <span class="badge-discount">-<?= $product['discount_percent'] ?>%</span>
                                    <?php endif; ?>
                                    <span class="badge-installment">Trả góp 0%</span>
                                    <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-thumb-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="device-fallback-icon" style="display: none;">
                                        <i class="bi <?= htmlspecialchars($product['device_icon']) ?>"></i>
                                    </div>
                                </div>

                                <div class="p-3 d-flex flex-column flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small fw-semibold">
                                            <?= htmlspecialchars($product['brand_name'] ?? 'Chính Hãng') ?>
                                        </span>
                                        <div class="text-warning small d-flex align-items-center gap-1">
                                            <i class="bi bi-star-fill"></i>
                                            <span class="fw-bold text-dark"><?= $product['rating'] ?></span>
                                            <span class="text-muted" style="font-size: 0.75rem;">(<?= $product['review_count'] ?>)</span>
                                        </div>
                                    </div>

                                    <h6 class="fw-bold mb-2">
                                        <a href="/product/<?= urlencode($product['slug']) ?>" class="text-dark text-decoration-none" title="<?= htmlspecialchars($product['name']) ?>" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8rem; line-height: 1.4;">
                                            <?= htmlspecialchars($product['name']) ?>
                                        </a>
                                    </h6>

                                    <!-- Specs Preview Pills -->
                                    <div class="mb-3" style="min-height: 32px;">
                                        <?php 
                                        $specs = $product['specs_array'];
                                        if (!empty($specs['cpu'])): ?>
                                            <span class="spec-pill"><i class="bi bi-cpu text-rose"></i> <?= htmlspecialchars(substr($specs['cpu'], 0, 18)) ?></span>
                                        <?php endif; ?>
                                        <?php if (!empty($specs['ram'])): ?>
                                            <span class="spec-pill"><i class="bi bi-memory text-primary"></i> <?= htmlspecialchars($specs['ram']) ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="price-current"><?= $product['formatted_price'] ?></div>
                                            <?php if ($product['formatted_original_price']): ?>
                                                <div class="price-original"><?= $product['formatted_original_price'] ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <button class="btn-add-cart-icon btn-ajax-add-cart" data-product-id="<?= $product['id'] ?>" title="Thêm vào giỏ">
                                            <i class="bi bi-cart-plus"></i>
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
