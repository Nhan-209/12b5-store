<?php
$pageTitle = 'Trang Chủ';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <!-- Hero Banner Section - Modern Pastel & Frosted Glass -->
    <div class="hero-banner mb-5">
        <div class="row align-items-center position-relative" style="z-index: 2;">
            <div class="col-lg-7 py-2">
                <div class="hero-pill-tag">
                    <span class="badge bg-danger rounded-pill px-2 py-1 me-1">FLAGSHIP 2026</span>
                    <span>Đỉnh Cao Công Nghệ &bull; Trợ Giá Lên Đời 2.500.000₫</span>
                </div>
                <h1 class="hero-title">
                    Thế Hệ Thiết Bị Điện Tử.<br>
                    <span class="gradient-text">Hiệu Năng Vượt Bậc.</span>
                </h1>
                <p class="hero-subtitle">
                    Trải nghiệm hệ sinh thái Smartphone, Laptop M3/RTX, Smartwatch và Âm thanh Hi-Res chính hãng 100%. Tối ưu hóa tính toán với <strong>Rust High-Performance Microservice</strong> mang lại phản hồi dưới 1 mili-giây.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="/products" class="btn btn-rose btn-lg px-4 shadow-sm">
                        <i class="bi bi-bag-check-fill me-2"></i> Khám Phá Bộ Sưu Tập
                    </a>
                    <a href="/products?category=laptop-may-tinh" class="btn btn-soft-slate btn-lg px-4">
                        <i class="bi bi-laptop me-2"></i> Xem Laptop M3 & RTX
                    </a>
                </div>

                <!-- Trust Micro-Badges -->
                <div class="d-flex flex-wrap align-items-center gap-3 mt-4 pt-3 border-top border-secondary border-opacity-10 text-muted small">
                    <div><i class="bi bi-patch-check-fill text-success me-1"></i> 100% Nguyên seal VAT</div>
                    <div><i class="bi bi-truck text-primary me-1"></i> Hỏa tốc 2H miễn phí</div>
                    <div><i class="bi bi-arrow-repeat text-danger me-1"></i> 1 Đổi 1 trong 30 ngày</div>
                </div>
            </div>

            <!-- Floating Hero Glass Showcase Card -->
            <div class="col-lg-5 text-center d-none d-lg-block">
                <div class="hero-glass-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1 fw-bold small">
                            <i class="bi bi-star-fill me-1"></i> BEST SELLER
                        </span>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-1 small">Bảo hành 24 tháng</span>
                    </div>

                    <div class="py-3 text-center">
                        <i class="bi bi-laptop display-1 text-primary opacity-85"></i>
                    </div>

                    <h4 class="fw-bold text-dark mb-1">MacBook Pro 14" M3 Pro</h4>
                    <p class="text-muted small mb-3">Apple M3 Pro 11-Core &bull; 18GB Unified RAM &bull; 512GB SSD</p>

                    <div class="d-flex justify-content-center align-items-baseline gap-2 mb-3">
                        <span class="fs-3 fw-extrabold text-danger">49.990.000 ₫</span>
                        <span class="text-muted text-decoration-line-through small">54.990.000 ₫</span>
                    </div>

                    <div class="p-2 bg-white rounded-3 border mb-3 small d-flex justify-content-around text-muted">
                        <div><i class="bi bi-credit-card me-1 text-primary"></i> Trả góp 0%</div>
                        <div><i class="bi bi-gift me-1 text-danger"></i> Tặng túi Tucano</div>
                    </div>

                    <a href="/product/macbook-pro-14-m3-pro-512gb" class="btn btn-rose w-100 fw-bold py-2">
                        Xem Chi Tiết Cấu Hình <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Trust Guarantees Ribbon (4 Pillars of Real Store) -->
    <div class="trust-ribbon">
        <div class="row g-3">
            <div class="col-6 col-lg-3">
                <div class="trust-item">
                    <div class="trust-icon-box trust-icon-rose">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <div class="trust-title">100% Chính Hãng</div>
                        <div class="trust-desc">Nguyên seal, đầy đủ VAT điện tử</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="trust-item">
                    <div class="trust-icon-box trust-icon-emerald">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </div>
                    <div>
                        <div class="trust-title">1 Đổi 1 Trong 30 Ngày</div>
                        <div class="trust-desc">Lỗi phần cứng đổi máy mới ngay</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="trust-item">
                    <div class="trust-icon-box trust-icon-sky">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </div>
                    <div>
                        <div class="trust-title">Giao Hỏa Tốc 2 Giờ</div>
                        <div class="trust-desc">Nội thành miễn phí từ 5 triệu</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="trust-item">
                    <div class="trust-icon-box trust-icon-amber">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>
                    <div>
                        <div class="trust-title">Thu Cũ Trợ Giá 2.5TR</div>
                        <div class="trust-desc">Lên đời máy mới, trả góp 0%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Highlights Grid -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h3 class="fw-bold mb-1">Danh Mục Thiết Bị Điện Tử</h3>
                <p class="text-muted small mb-0">Hệ sinh thái thiết bị di động, điện toán và công nghệ cá nhân</p>
            </div>
            <a href="/products" class="btn btn-outline-rose btn-sm">Xem tất cả danh mục <i class="bi bi-arrow-right ms-1"></i></a>
        </div>

        <div class="row g-3">
            <?php foreach ($categories as $cat): ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="/products?category=<?= urlencode($cat['slug']) ?>" class="category-box">
                        <div class="category-icon-wrapper">
                            <i class="bi <?= htmlspecialchars($cat['icon']) ?>"></i>
                        </div>
                        <div class="category-title"><?= htmlspecialchars($cat['name']) ?></div>
                        <div class="category-count"><?= $cat['product_count'] ?? 0 ?> sản phẩm</div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Featured Products Section -->
    <div class="mb-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <h3 class="fw-bold mb-0">Thiết Bị Nổi Bật</h3>
                    <span class="badge bg-danger rounded-pill small px-3 py-1">HOT DEAL</span>
                </div>
                <p class="text-muted small mb-0 mt-1">Các mẫu flagship, ultrabook và phụ kiện bán chạy nhất tại 12B5 Store</p>
            </div>
            <div class="d-flex gap-2">
                <a href="/products?sort=best_seller" class="btn btn-soft-slate btn-sm">
                    <i class="bi bi-fire text-danger me-1"></i> Bán Chạy Nhất
                </a>
                <a href="/products?sort=price_asc" class="btn btn-soft-slate btn-sm">
                    <i class="bi bi-tag me-1"></i> Giá Tốt Nhất
                </a>
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
                            <span class="badge-installment">Trả góp 0%</span>
                            <div class="p-3 text-center">
                                <i class="bi bi-device-hdd display-4 text-primary opacity-80"></i>
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
                                <button class="btn-add-cart-icon btn-ajax-add-cart" data-product-id="<?= $product['id'] ?>" title="Thêm nhanh vào giỏ hàng">
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Rust Engine Smart Recommendation Showcase (Frosted Glass Aesthetic) -->
    <?php if (!empty($recommendedProducts)): ?>
        <div class="card-rust-showcase mb-5 p-4 p-md-5">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-10 gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge-rust-power">
                            <i class="bi bi-lightning-charge-fill"></i>
                            <?= $engineInfo['engine'] === 'rust' ? 'RUST ENGINE RECOMMENDER' : 'PHP CORE RECOMMENDER' ?>
                        </span>
                        <span class="badge-rust-speed">
                            <i class="bi bi-speedometer2"></i> Latency: <?= $engineInfo['latency_ms'] ?>ms
                        </span>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">Gợi Ý Thông Minh & Phù Hợp Nhu Cầu</h3>
                    <p class="text-muted small mb-0">Thuật toán Cosine Similarity xử lý song song phân tích đặc trưng phần cứng (CPU, RAM, màn hình, phân khúc giá) tức thì.</p>
                </div>
                <a href="/products" class="btn btn-outline-rose btn-sm">Khám phá tất cả <i class="bi bi-arrow-right ms-1"></i></a>
            </div>

            <div class="row g-3">
                <?php foreach ($recommendedProducts as $recProd): ?>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="tech-card bg-white">
                            <div class="card-img-wrap bg-light py-4">
                                <i class="bi bi-device-hdd display-5 text-primary opacity-75"></i>
                            </div>
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small fw-semibold mb-1 w-auto d-inline-block">
                                    <?= htmlspecialchars($recProd['brand_name'] ?? 'Chính Hãng') ?>
                                </span>
                                <h6 class="fw-bold mb-2">
                                    <a href="/product/<?= urlencode($recProd['slug']) ?>" class="text-dark text-decoration-none" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8rem; line-height: 1.4;">
                                        <?= htmlspecialchars($recProd['name']) ?>
                                    </a>
                                </h6>
                                <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                    <div class="price-current fs-6"><?= $recProd['formatted_price'] ?></div>
                                    <a href="/product/<?= urlencode($recProd['slug']) ?>" class="btn btn-sm btn-outline-rose rounded-pill px-3">Xem</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Latest Arrivals Section -->
    <?php if (!empty($latestProducts)): ?>
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1">Thiết Bị Mới Về</h3>
                    <p class="text-muted small mb-0">Cập nhật những đợt hàng công nghệ chính hãng mới nhất trong tuần</p>
                </div>
                <a href="/products?sort=newest" class="btn btn-soft-slate btn-sm">Xem tất cả <i class="bi bi-arrow-right ms-1"></i></a>
            </div>

            <div class="row g-4">
                <?php foreach ($latestProducts as $product): ?>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="tech-card">
                            <div class="card-img-wrap">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill position-absolute top-0 start-0 m-3 px-2 py-1 small fw-bold">
                                    <i class="bi bi-stars"></i> MỚI VỀ
                                </span>
                                <div class="p-3 text-center">
                                    <i class="bi bi-device-hdd display-4 text-primary opacity-80"></i>
                                </div>
                            </div>

                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted small fw-medium"><?= htmlspecialchars($product['brand_name'] ?? '') ?></span>
                                    <div class="text-warning small"><i class="bi bi-star-fill"></i> <?= $product['rating'] ?></div>
                                </div>
                                <h6 class="fw-bold mb-2">
                                    <a href="/product/<?= urlencode($product['slug']) ?>" class="text-dark text-decoration-none" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8rem; line-height: 1.4;">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </a>
                                </h6>
                                <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                    <div class="price-current"><?= $product['formatted_price'] ?></div>
                                    <button class="btn-add-cart-icon btn-ajax-add-cart" data-product-id="<?= $product['id'] ?>" title="Thêm vào giỏ">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Real Showroom & Nationwide Store Experience Banner -->
    <div class="card border-0 rounded-4 p-4 p-md-5 mb-5" style="background: linear-gradient(135deg, #f8fafc 0%, #ffe4e6 50%, #f1f5f9 100%); border: 1px solid var(--border-color) !important;">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white border small text-rose fw-bold mb-2 shadow-xs">
                    <i class="bi bi-geo-alt-fill text-danger"></i> 15 Showroom Trải Nghiệm Toàn Quốc
                </div>
                <h3 class="fw-bold text-dark mb-2">Trải Nghiệm Trực Tiếp Trước Khi Quyết Định</h3>
                <p class="text-muted small mb-0" style="max-width: 620px;">
                    Quý khách có thể đến trực tiếp showroom 12B5 Store để trên tay các siêu phẩm công nghệ, kiểm tra cấu hình bằng phần mềm chuyên dụng và nhận tư vấn chuyên sâu từ đội ngũ kỹ thuật viên.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-column flex-sm-row justify-content-lg-end gap-2">
                    <a href="#" class="btn btn-rose px-4 py-2"><i class="bi bi-telephone-fill me-1"></i> Gọi 1800.1235</a>
                    <a href="#" class="btn btn-soft-slate px-3 py-2"><i class="bi bi-map me-1"></i> Tìm Showroom</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
