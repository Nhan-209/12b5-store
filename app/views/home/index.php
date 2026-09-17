<?php
$pageTitle = 'Trang Chủ';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <!-- Hero Banner Section -->
    <div class="hero-banner mb-5 shadow-sm">
        <div class="row align-items-center position-relative" style="z-index: 1;">
            <div class="col-lg-7 py-3">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-10 text-white mb-3 small">
                    <span class="badge bg-danger">MỚI RA MẮT 2026</span>
                    <span>Thế Hệ Thiết Bị Điện Tử Đỉnh Cao</span>
                </div>
                <h1 class="display-5 fw-extrabold text-white mb-3">
                    Công Nghệ Tương Lai.<br>
                    <span style="color: #60a5fa;">Hiệu Năng Vượt Trội.</span>
                </h1>
                <p class="lead text-white-50 mb-4" style="max-width: 540px;">
                    Trải nghiệm dòng sản phẩm Laptop, Điện thoại Flagship, Smartwatch và Âm thanh chính hãng mới nhất. Hệ thống vận hành trên nền tảng Microservice với Rust High-Performance Engine xử lý tính toán tốc độ cao.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="/products" class="btn btn-primary btn-lg px-4 fw-semibold shadow-sm">
                        <i class="bi bi-bag-fill me-2"></i> Mua Ngay Bây Giờ
                    </a>
                    <a href="/products?category=laptop-may-tinh" class="btn btn-outline-light btn-lg px-4 fw-medium">
                        Xem Laptop M3 & RTX 4070
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center d-none d-lg-block">
                <div class="p-4 bg-white bg-opacity-10 rounded-4 backdrop-blur border border-white border-opacity-20 shadow-lg">
                    <i class="bi bi-laptop display-1 text-info mb-3"></i>
                    <h5 class="text-white fw-bold">MacBook Pro 14" M3 Pro</h5>
                    <p class="text-white-50 small mb-2">18GB Unified RAM | 512GB SSD | 120Hz ProMotion</p>
                    <div class="fs-4 fw-bold text-warning mb-3">49.990.000 ₫</div>
                    <a href="/product/macbook-pro-14-m3-pro-512gb" class="btn btn-sm btn-light px-4 fw-bold">Xem Chi Tiết</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Highlights Grid -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h3 class="fw-bold mb-1">Danh Mục Thiết Bị Điện Tử</h3>
                <p class="text-muted small mb-0">Lựa chọn các dòng thiết bị công nghệ chính hãng</p>
            </div>
            <a href="/products" class="text-primary text-decoration-none fw-semibold small">Xem tất cả <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row g-3">
            <?php foreach ($categories as $cat): ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="/products?category=<?= urlencode($cat['slug']) ?>" class="category-box">
                        <i class="bi <?= htmlspecialchars($cat['icon']) ?>"></i>
                        <h6 class="fw-bold mb-1 small"><?= htmlspecialchars($cat['name']) ?></h6>
                        <span class="text-muted" style="font-size: 0.75rem;"><?= $cat['product_count'] ?? 0 ?> sản phẩm</span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Featured Products Section -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Thiết Bị Nổi Bật</h3>
                <p class="text-muted small mb-0">Các mẫu flagship, ultrabook bán chạy nhất</p>
            </div>
            <div class="d-flex gap-2">
                <a href="/products?sort=best_seller" class="btn btn-outline-secondary btn-sm">Bán Chạy Nhất</a>
                <a href="/products?sort=price_asc" class="btn btn-outline-secondary btn-sm">Giá Tốt</a>
            </div>
        </div>

        <div class="row g-4">
            <?php foreach ($featuredProducts as $product): ?>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="tech-card">
                        <div class="card-img-wrap">
                            <?php if ($product['discount_percent'] > 0): ?>
                                <span class="badge-discount">-<?= $product['discount_percent'] ?>%</span>
                            <?php endif; ?>
                            <div class="p-3 text-center">
                                <i class="bi bi-device-hdd display-4 text-primary opacity-75"></i>
                            </div>
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-muted small fw-medium"><?= htmlspecialchars($product['brand_name'] ?? '') ?></span>
                                <div class="text-warning small">
                                    <i class="bi bi-star-fill"></i> <?= $product['rating'] ?> <span class="text-muted">(<?= $product['review_count'] ?>)</span>
                                </div>
                            </div>
                            <h6 class="fw-bold mb-2">
                                <a href="/product/<?= urlencode($product['slug']) ?>" class="text-dark text-decoration-none line-clamp-2">
                                    <?= htmlspecialchars($product['name']) ?>
                                </a>
                            </h6>

                            <!-- Specs Preview Pills -->
                            <div class="mb-3">
                                <?php 
                                $specs = $product['specs_array'];
                                if (!empty($specs['cpu'])): ?>
                                    <span class="spec-pill"><i class="bi bi-cpu me-1"></i><?= htmlspecialchars(substr($specs['cpu'], 0, 20)) ?></span>
                                <?php endif; ?>
                                <?php if (!empty($specs['ram'])): ?>
                                    <span class="spec-pill"><i class="bi bi-memory me-1"></i><?= htmlspecialchars($specs['ram']) ?></span>
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
    </div>

    <!-- Rust Engine Smart Recommendation Showcase -->
    <?php if (!empty($recommendedProducts)): ?>
        <div class="card border-0 shadow-sm rounded-4 mb-5 overflow-hidden" style="background: linear-gradient(135deg, #0b1329 0%, #172554 100%);">
            <div class="card-body p-4 p-md-5 text-white">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-25 gap-3">
                    <div>
                        <div class="badge-rust-power mb-2">
                            <i class="bi bi-lightning-charge-fill"></i>
                            <?= $engineInfo['engine'] === 'rust' ? 'RUST ENGINE RECOMMENDER' : 'PHP CORE RECOMMENDER' ?> (<?= $engineInfo['latency_ms'] ?>ms)
                        </div>
                        <h3 class="fw-bold text-white mb-1">Gợi Ý Thông Minh Dành Cho Bạn</h3>
                        <p class="text-white-50 small mb-0">Thuật toán Cosine Similarity phân tích đặc trưng thông số kỹ thuật (RAM, CPU, màn hình, phân khúc giá) theo thời gian thực.</p>
                    </div>
                    <a href="/products" class="btn btn-outline-light btn-sm px-3">Khám phá thêm</a>
                </div>

                <div class="row g-3">
                    <?php foreach ($recommendedProducts as $recProd): ?>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="bg-white bg-opacity-10 rounded-3 p-3 h-100 border border-white border-opacity-10 d-flex flex-column">
                                <div class="text-center py-2 mb-2">
                                    <i class="bi bi-phone-fill display-5 text-info"></i>
                                </div>
                                <h6 class="fw-bold text-white mb-2">
                                    <a href="/product/<?= urlencode($recProd['slug']) ?>" class="text-white text-decoration-none">
                                        <?= htmlspecialchars($recProd['name']) ?>
                                    </a>
                                </h6>
                                <div class="mt-auto pt-2 d-flex justify-content-between align-items-center">
                                    <span class="text-warning fw-bold"><?= $recProd['formatted_price'] ?? number_format((float)$recProd['price'], 0, ',', '.') . ' ₫' ?></span>
                                    <a href="/product/<?= urlencode($recProd['slug']) ?>" class="btn btn-sm btn-light px-2 py-1">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Store Value Propositions -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="p-4 bg-white rounded-4 border text-center shadow-xs h-100">
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle d-inline-flex mb-3">
                    <i class="bi bi-shield-check fs-3"></i>
                </div>
                <h6 class="fw-bold">Chính Hãng 100%</h6>
                <p class="text-muted small mb-0">Tất cả thiết bị đều có hóa đơn VAT và bảo hành chính hãng 12-24 tháng.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-4 bg-white rounded-4 border text-center shadow-xs h-100">
                <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle d-inline-flex mb-3">
                    <i class="bi bi-truck fs-3"></i>
                </div>
                <h6 class="fw-bold">Giao Hàng Siêu Tốc</h6>
                <p class="text-muted small mb-0">Giao hàng hỏa tốc trong 2 giờ nội thành hoặc 24-48 giờ toàn quốc.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-4 bg-white rounded-4 border text-center shadow-xs h-100">
                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle d-inline-flex mb-3">
                    <i class="bi bi-arrow-repeat fs-3"></i>
                </div>
                <h6 class="fw-bold">Lỗi 1 Đổi 1</h6>
                <p class="text-muted small mb-0">Đổi mới thiết bị trong vòng 30 ngày nếu phát sinh lỗi từ nhà sản xuất.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-4 bg-white rounded-4 border text-center shadow-xs h-100">
                <div class="bg-info bg-opacity-10 text-info p-3 rounded-circle d-inline-flex mb-3">
                    <i class="bi bi-headset fs-3"></i>
                </div>
                <h6 class="fw-bold">Hỗ Trợ Kỹ Thuật 24/7</h6>
                <p class="text-muted small mb-0">Đội ngũ kỹ sư công nghệ sẵn sàng tư vấn cấu hình và hỗ trợ cài đặt phần mềm.</p>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
