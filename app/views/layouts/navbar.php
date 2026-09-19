<?php
$currentUser = $_SESSION['user'] ?? null;
$cartSummary = \App\Models\Cart::getCart();
?>
<!-- Top Promotion & Customer Care Bar -->
<div class="announcement-bar">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-danger rounded-pill px-2 py-1 fw-bold small text-white"><i class="bi bi-gift-fill me-1"></i> KHUYẾN MÃI</span> 
            <span class="small text-light">Nhập mã <strong class="text-white">12B5NEW</strong> giảm ngay 500.000₫ cho đơn hàng đầu tiên</span>
        </div>
        <div class="d-flex align-items-center gap-3 small">
            <span class="text-white-50 d-none d-sm-inline"><i class="bi bi-truck text-rose me-1"></i> Miễn phí giao hàng toàn quốc từ 500k</span>
            <span class="text-white-50 d-none d-sm-inline">|</span>
            <span class="text-white-50 d-none d-sm-inline"><i class="bi bi-shield-check text-emerald me-1"></i> 100% Chính Hãng VAT</span>
            <span class="text-white-50 d-none d-lg-inline">|</span>
            <span class="text-white-50 d-none d-lg-inline"><i class="bi bi-telephone-fill me-1"></i> Hotline: 1800.12B5</span>
        </div>
    </div>
</div>

<!-- Main Frosted Glass Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-glass py-3 sticky-top">
    <div class="container">
        <!-- Brand Identity -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= BASE_URL ?>/">
            <div class="brand-logo-badge">
                <i class="bi bi-lightning-charge-fill fs-5"></i>
            </div>
            <div>
                <span class="brand-title fs-4">12B5 Store</span>
                <div class="brand-subtitle">PREMIUM TECH & SMART DEVICES</div>
            </div>
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <i class="bi bi-list fs-2 text-dark"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <!-- Global Search Form with Instant Dropdown -->
            <form class="d-flex mx-auto search-box-group my-3 my-lg-0" action="<?= BASE_URL ?>/products" method="GET">
                <div class="input-group w-100">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="globalSearchInput" name="q" class="form-control" placeholder="Tìm kiếm điện thoại, laptop, thiết bị âm thanh chính hãng..." autocomplete="off" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                    <button class="btn btn-search" type="submit">Tìm kiếm</button>
                </div>
                <!-- Live dropdown suggestion list populated by app.js -->
                <div id="searchDropdown" class="search-dropdown-menu"></div>
            </form>

            <!-- Navigation Actions -->
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link-custom" href="<?= BASE_URL ?>/products">
                        <i class="bi bi-grid me-1"></i> Sản Phẩm
                    </a>
                </li>

                <!-- Cart Button with Pill Badge -->
                <li class="nav-item">
                    <a class="cart-pill-btn" href="<?= BASE_URL ?>/cart">
                        <i class="bi bi-cart3 fs-5"></i>
                        <span class="small d-none d-md-inline">Giỏ hàng</span>
                        <span id="cartBadgeCount" class="cart-pill-badge" style="<?= ($cartSummary['total_items'] ?? 0) > 0 ? '' : 'display: none;' ?>">
                            <?= $cartSummary['total_items'] ?? 0 ?>
                        </span>
                    </a>
                </li>

                <!-- User Account Dropdown -->
                <?php if ($currentUser): ?>
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 p-1 pe-3 rounded-pill bg-white border shadow-xs" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 34px; height: 34px; background: linear-gradient(135deg, #f43f5e, #fb7185); font-size: 0.85rem;">
                                <?= strtoupper(substr($currentUser['name'], 0, 1)) ?>
                            </div>
                            <span class="small fw-semibold text-dark"><?= htmlspecialchars($currentUser['name']) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4 mt-2">
                            <li class="dropdown-header text-muted small">Tài khoản: <?= htmlspecialchars($currentUser['email']) ?></li>
                            <li><a class="dropdown-item py-2" href="<?= BASE_URL ?>/profile"><i class="bi bi-person me-2 text-muted"></i> Hồ sơ cá nhân</a></li>
                            <li><a class="dropdown-item py-2" href="<?= BASE_URL ?>/orders"><i class="bi bi-bag-check me-2 text-muted"></i> Lịch sử đơn hàng</a></li>
                            <?php if ($currentUser['role'] === 'admin'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2 text-danger fw-bold" href="<?= BASE_URL ?>/admin"><i class="bi bi-speedometer2 me-2"></i> Bảng Quản Trị Admin</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 text-danger" href="<?= BASE_URL ?>/logout"><i class="bi bi-box-arrow-right me-2"></i> Đăng xuất</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-soft-slate btn-sm" href="<?= BASE_URL ?>/login">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-rose btn-sm" href="<?= BASE_URL ?>/register">Đăng ký</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Category Quick Navigation Strip -->
<div class="category-quick-strip d-none d-md-block">
    <div class="container d-flex align-items-center justify-content-between overflow-x-auto gap-2">
        <a href="<?= BASE_URL ?>/products?category=dien-thoai-thong-minh" class="category-quick-link"><i class="bi bi-phone text-rose"></i> Điện Thoại</a>
        <a href="<?= BASE_URL ?>/products?category=laptop-may-tinh" class="category-quick-link"><i class="bi bi-laptop text-rose"></i> Laptop & PC</a>
        <a href="<?= BASE_URL ?>/products?category=may-tinh-bang" class="category-quick-link"><i class="bi bi-tablet text-rose"></i> Máy Tính Bảng</a>
        <a href="<?= BASE_URL ?>/products?category=tai-nghe-am-thanh" class="category-quick-link"><i class="bi bi-headphones text-rose"></i> Tai Nghe & Âm Thanh</a>
        <a href="<?= BASE_URL ?>/products?category=dong-ho-thong-minh" class="category-quick-link"><i class="bi bi-smartwatch text-rose"></i> Smartwatch</a>
        <a href="<?= BASE_URL ?>/products?category=phu-kien-linh-kien" class="category-quick-link"><i class="bi bi-cpu text-rose"></i> Phụ Kiện</a>
        <span class="text-muted opacity-50">|</span>
        <a href="<?= BASE_URL ?>/products?sort=best_seller" class="category-quick-link text-danger fw-bold"><i class="bi bi-fire text-danger"></i> Bán Chạy Nhất</a>
        <a href="<?= BASE_URL ?>/products?category=laptop-may-tinh" class="category-quick-link text-primary fw-bold"><i class="bi bi-tag-fill text-primary"></i> Trả Góp 0%</a>
    </div>
</div>
