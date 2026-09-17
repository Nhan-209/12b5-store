<?php
$currentUser = $_SESSION['user'] ?? null;
$cartSummary = \App\Models\Cart::getCart();
?>
<!-- Top announcement bar -->
<div class="bg-dark text-white py-1 px-3 small border-bottom border-secondary border-opacity-25">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <span class="badge bg-primary me-2">Graduation Project</span> 
            <span>Hệ thống Thương mại Điện tử Thiết bị Điện tử - Kiến trúc Hybrid PHP + Rust Engine</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span id="rustEngineBadge" class="small">
                <i class="bi bi-cpu text-warning me-1"></i> <span class="text-white-50">Checking Engine...</span>
            </span>
            <span class="text-white-50">|</span>
            <a href="https://github.com" target="_blank" class="text-white-50 text-decoration-none">
                <i class="bi bi-github"></i> CI/CD Pipeline
            </a>
        </div>
    </div>
</div>

<!-- Main Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-tech py-3 sticky-top">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="/">
            <div class="bg-primary bg-gradient p-2 rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 38px; height: 38px;">
                <i class="bi bi-lightning-charge-fill fs-5"></i>
            </div>
            <div>
                <span class="brand-title fs-4 fw-bold">ElectroStore</span>
                <div class="text-white-50" style="font-size: 0.65rem; margin-top: -4px; letter-spacing: 1px;">HIGH PERFORMANCE TECH</div>
            </div>
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <!-- Global Search Form -->
            <form class="d-flex mx-auto search-box-group my-2 my-lg-0" action="/products" method="GET">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="globalSearchInput" name="q" class="form-control border-start-0 ps-0" placeholder="Tìm điện thoại, laptop, CPU, RAM, Sony XM5..." autocomplete="off" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                    <button class="btn btn-primary px-4 fw-medium" type="submit">Tìm kiếm</button>
                </div>
                <!-- Live dropdown suggestion list -->
                <div id="searchDropdown" class="search-dropdown-menu"></div>
            </form>

            <!-- Navigation Actions -->
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link text-white fw-medium" href="/products">
                        <i class="bi bi-grid me-1"></i> Sản Phẩm
                    </a>
                </li>

                <!-- Cart Button -->
                <li class="nav-item">
                    <a class="nav-link text-white position-relative px-3 py-2 rounded-3 bg-white bg-opacity-10" href="/cart">
                        <i class="bi bi-cart3 fs-5"></i>
                        <span id="cartBadgeCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="<?= ($cartSummary['total_items'] ?? 0) > 0 ? '' : 'display: none;' ?>">
                            <?= $cartSummary['total_items'] ?? 0 ?>
                        </span>
                    </a>
                </li>

                <!-- User Account Dropdown -->
                <?php if ($currentUser): ?>
                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                <?= strtoupper(substr($currentUser['name'], 0, 1)) ?>
                            </div>
                            <span><?= htmlspecialchars($currentUser['name']) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li class="dropdown-header text-muted small">Tài khoản: <?= htmlspecialchars($currentUser['email']) ?></li>
                            <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i> Hồ sơ của tôi</a></li>
                            <li><a class="dropdown-item" href="/orders"><i class="bi bi-bag-check me-2"></i> Lịch sử đơn hàng</a></li>
                            <?php if ($currentUser['role'] === 'admin'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-primary fw-bold" href="/admin"><i class="bi bi-speedometer2 me-2"></i> Trang Quản Trị (Admin)</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i> Đăng xuất</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-2">
                        <a class="btn btn-outline-light btn-sm px-3" href="/login">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm px-3" href="/register">Đăng ký</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Category Quick Strip -->
<div class="bg-white border-bottom shadow-xs py-2 d-none d-md-block">
    <div class="container d-flex align-items-center justify-content-between overflow-x-auto gap-4 small fw-medium text-nowrap">
        <a href="/products?category=dien-thoai-thong-minh" class="text-decoration-none text-dark"><i class="bi bi-phone text-primary me-1"></i> Điện Thoại</a>
        <a href="/products?category=laptop-may-tinh" class="text-decoration-none text-dark"><i class="bi bi-laptop text-primary me-1"></i> Laptop & PC</a>
        <a href="/products?category=may-tinh-bang" class="text-decoration-none text-dark"><i class="bi bi-tablet text-primary me-1"></i> Máy Tính Bảng</a>
        <a href="/products?category=tai-nghe-am-thanh" class="text-decoration-none text-dark"><i class="bi bi-headphones text-primary me-1"></i> Tai Nghe & Âm Thanh</a>
        <a href="/products?category=dong-ho-thong-minh" class="text-decoration-none text-dark"><i class="bi bi-smartwatch text-primary me-1"></i> Đồng Hồ Thông Minh</a>
        <a href="/products?category=phu-kien-linh-kien" class="text-decoration-none text-dark"><i class="bi bi-cpu text-primary me-1"></i> Phụ Kiện & Linh Kiện</a>
        <span class="text-muted">|</span>
        <a href="/products?sort=best_seller" class="text-decoration-none text-danger fw-bold"><i class="bi bi-fire me-1"></i> Bán Chạy Nhất</a>
    </div>
</div>
