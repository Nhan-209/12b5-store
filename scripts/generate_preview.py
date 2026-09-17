import os

os.makedirs('preview', exist_ok=True)

header_template = """<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{title} - 12B5 Store | Siêu Thị Thiết Bị Điện Tử & Công Nghệ Cao</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        .preview-bar {{
            background: linear-gradient(90deg, #0f172a, #1e1b4b);
            color: #fff;
            padding: 10px 20px;
            font-size: 0.85rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #3b82f6;
            position: sticky;
            top: 0;
            z-index: 2000;
        }}
        .preview-pill {{
            background: rgba(255,255,255,0.12);
            padding: 5px 12px;
            border-radius: 20px;
            text-decoration: none;
            color: #e2e8f0;
            margin: 0 4px;
            transition: all 0.2s;
            font-size: 0.82rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }}
        .preview-pill:hover, .preview-pill.active {{
            background: #2563eb;
            color: #fff;
            box-shadow: 0 2px 10px rgba(37,99,235,0.5);
            font-weight: 600;
        }}
    </style>
</head>
<body>
<!-- Static Preview Mode Banner -->
<div class="preview-bar shadow-sm">
    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-warning text-dark"><i class="bi bi-eye-fill"></i> Xem Offline Trực Tiếp</span>
        <span class="text-light">Bạn đang xem giao diện HTML/CSS không cần chạy Apache/PHP/Rust</span>
    </div>
    <div class="d-flex align-items-center">
        <span class="me-2 text-white-50">Chọn màn hình:</span>
        <a href="index.html" class="preview-pill {nav_home}"><i class="bi bi-house"></i> 1. Trang Chủ</a>
        <a href="products.html" class="preview-pill {nav_products}"><i class="bi bi-grid"></i> 2. Danh Mục SP</a>
        <a href="detail.html" class="preview-pill {nav_detail}"><i class="bi bi-laptop"></i> 3. Chi Tiết Cấu Hình</a>
        <a href="cart.html" class="preview-pill {nav_cart}"><i class="bi bi-cart3"></i> 4. Giỏ Hàng (2)</a>
        <a href="checkout.html" class="preview-pill {nav_checkout}"><i class="bi bi-qr-code"></i> 5. VietQR Checkout</a>
        <a href="admin.html" class="preview-pill {nav_admin}"><i class="bi bi-speedometer2"></i> 6. Admin KPIs & Pareto</a>
    </div>
</div>

<!-- Main Top Announcement Bar -->
<div class="bg-dark text-white py-1 px-3 small border-bottom border-secondary border-opacity-25">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <span class="badge bg-primary me-2">Graduation Project</span> 
            <span>Hệ thống Thương mại Điện tử Thiết bị Điện tử - Kiến trúc Hybrid PHP + Rust Engine</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span id="rustEngineBadge" class="small">
                <i class="bi bi-cpu text-success me-1"></i> <span class="text-white-50">Rust Engine:</span> <span class="badge bg-success">Online (0.8ms)</span>
            </span>
            <span class="text-white-50">|</span>
            <span class="text-white-50"><i class="bi bi-shield-check text-info"></i> Dual DB (MySQL + SQLite)</span>
        </div>
    </div>
</div>

<!-- Main Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-tech py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.html">
            <div class="bg-primary bg-gradient p-2 rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 38px; height: 38px;">
                <i class="bi bi-lightning-charge-fill fs-5"></i>
            </div>
            <div>
                <span class="brand-title fs-4 fw-bold">12B5 Store</span>
                <div class="text-white-50" style="font-size: 0.65rem; margin-top: -4px; letter-spacing: 1px;">HIGH PERFORMANCE TECH</div>
            </div>
        </a>

        <div class="collapse navbar-collapse show" id="navbarMain">
            <div class="d-flex mx-auto search-box-group my-2 my-lg-0">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-0" placeholder="Tìm kiếm siêu tốc với Rust Levenshtein (Laptop, M3, Sony...)" value="{search_val}">
                    <a href="products.html" class="btn btn-primary px-4 fw-medium">Tìm kiếm</a>
                </div>
            </div>

            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link text-white fw-medium" href="products.html">
                        <i class="bi bi-grid me-1"></i> Sản Phẩm
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white position-relative px-3 py-2 rounded-3 bg-white bg-opacity-10" href="cart.html">
                        <i class="bi bi-cart3 fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">2</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle d-flex align-items-center gap-2 px-3 py-1 rounded-3 bg-primary bg-opacity-25 border border-primary border-opacity-25" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-5 text-info"></i>
                        <span class="small fw-semibold">Quản Trị Viên</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li><a class="dropdown-item" href="admin.html"><i class="bi bi-speedometer2 me-2 text-primary"></i> Admin Dashboard</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="index.html"><i class="bi bi-box-arrow-right me-2"></i> Đăng xuất</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="py-4">
"""

footer_template = """
</main>

<footer class="footer-tech pt-5 pb-4 mt-auto">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="bg-primary p-2 rounded-3 text-white">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </div>
                    <span class="brand-title fs-4 fw-bold">12B5 Store</span>
                </div>
                <p class="text-white-50 small">Hệ thống thương mại điện tử thiết bị công nghệ cao hàng đầu, ứng dụng kiến trúc Microservices đa ngôn ngữ (PHP MVC + Rust Engine) tối ưu hiệu năng bare-metal.</p>
                <div class="d-flex gap-3 text-white-50">
                    <span class="badge bg-secondary"><i class="bi bi-cpu"></i> Rust 2021</span>
                    <span class="badge bg-primary"><i class="bi bi-filetype-php"></i> PHP 8.2+</span>
                    <span class="badge bg-success"><i class="bi bi-database"></i> Dual DB</span>
                    <span class="badge bg-info"><i class="bi bi-git"></i> CI/CD Ready</span>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="text-white fw-bold mb-3">Danh Mục</h6>
                <ul class="list-unstyled small text-white-50">
                    <li class="mb-2"><a href="products.html" class="text-white-50 text-decoration-none">Laptops & MacBooks</a></li>
                    <li class="mb-2"><a href="products.html" class="text-white-50 text-decoration-none">Điện thoại Flagship</a></li>
                    <li class="mb-2"><a href="products.html" class="text-white-50 text-decoration-none">Máy tính bảng Pro</a></li>
                    <li class="mb-2"><a href="products.html" class="text-white-50 text-decoration-none">Thiết bị Âm thanh</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-3">
                <h6 class="text-white fw-bold mb-3">Điểm Nhấn Đồ Án</h6>
                <ul class="list-unstyled small text-white-50">
                    <li class="mb-2"><i class="bi bi-check2-circle text-success me-1"></i> Tìm kiếm mờ Levenshtein (< 1ms)</li>
                    <li class="mb-2"><i class="bi bi-check2-circle text-success me-1"></i> Gợi ý Cosine Similarity đa chiều</li>
                    <li class="mb-2"><i class="bi bi-check2-circle text-success me-1"></i> Phân tích tồn kho Pareto ABC</li>
                    <li class="mb-2"><i class="bi bi-check2-circle text-success me-1"></i> Tạo VietQR tự động chuẩn NAPAS</li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="text-white fw-bold mb-3">Thông Tin Đồ Án</h6>
                <div class="small text-white-50">
                    <p class="mb-1"><strong>Chuyên ngành:</strong> Công Nghệ Thông Tin</p>
                    <p class="mb-1"><strong>Hệ đào tạo:</strong> Đồ Án Tốt Nghiệp</p>
                    <p class="mb-1"><strong>Trạng thái:</strong> 101/101 Kiểm thử đạt</p>
                    <p class="mb-0 text-success fw-bold"><i class="bi bi-check-all"></i> Đã đóng gói 1-Click Run</p>
                </div>
            </div>
        </div>
        <hr class="border-secondary border-opacity-25 my-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center small text-white-50">
            <div>&copy; 2026 12B5 Store. Đồ án tốt nghiệp công nghệ thông tin.</div>
            <div>GitHub Repo: <a href="https://github.com/Nhan-209/12b5-store" target="_blank" class="text-info text-decoration-none">Nhan-209/12b5-store</a></div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
"""

# 1. GENERATE HOME (index.html)
home_body = """
<div class="container">
    <!-- Hero Banner -->
    <div class="hero-banner mb-5 p-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge bg-primary bg-opacity-75 px-3 py-2 rounded-pill mb-3">
                    <i class="bi bi-stars"></i> Next-Gen Tech Electronics 2026
                </span>
                <h1 class="display-4 fw-extrabold mb-3">Siêu Phẩm Công Nghệ<br><span class="brand-title">Hiệu Năng Vượt Trội</span></h1>
                <p class="lead text-white-50 mb-4">Trải nghiệm mua sắm thiết bị điện tử đỉnh cao với công cụ tìm kiếm mờ và gợi ý thông số tự động được tối ưu bằng Rust Bare-Metal Microservice.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="products.html" class="btn btn-primary btn-lg px-4 fw-semibold shadow">
                        <i class="bi bi-bag-check me-2"></i> Khám phá ngay
                    </a>
                    <a href="admin.html" class="btn btn-outline-light btn-lg px-4 fw-semibold">
                        <i class="bi bi-speedometer2 me-2"></i> Xem Dashboard Admin
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center mt-4 mt-lg-0">
                <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=700&auto=format&fit=crop&q=80" alt="MacBook M3" class="img-fluid rounded-4 shadow-lg border border-secondary border-opacity-25" style="max-height: 320px; object-fit: cover;">
            </div>
        </div>
    </div>

    <!-- Category Pills -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0"><i class="bi bi-grid-fill text-primary me-2"></i> Danh Mục Thiết Bị Điện Tử</h3>
        <a href="products.html" class="btn btn-sm btn-outline-primary fw-medium">Xem tất cả <i class="bi bi-arrow-right"></i></a>
    </div>

    <div class="row g-3 mb-5">
        <div class="col-6 col-md-4 col-lg-2">
            <a href="products.html" class="card text-decoration-none border-0 shadow-sm text-center p-3 h-100 category-hover" style="background:#ffffff; border-radius:14px;">
                <div class="fs-1 text-primary mb-2"><i class="bi bi-laptop"></i></div>
                <h6 class="fw-bold text-dark mb-1">Laptops & PC</h6>
                <span class="text-muted small">12 mẫu mới</span>
            </a>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <a href="products.html" class="card text-decoration-none border-0 shadow-sm text-center p-3 h-100 category-hover" style="background:#ffffff; border-radius:14px;">
                <div class="fs-1 text-info mb-2"><i class="bi bi-phone"></i></div>
                <h6 class="fw-bold text-dark mb-1">Smartphones</h6>
                <span class="text-muted small">18 mẫu mới</span>
            </a>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <a href="products.html" class="card text-decoration-none border-0 shadow-sm text-center p-3 h-100 category-hover" style="background:#ffffff; border-radius:14px;">
                <div class="fs-1 text-success mb-2"><i class="bi bi-tablet"></i></div>
                <h6 class="fw-bold text-dark mb-1">Máy tính bảng</h6>
                <span class="text-muted small">8 mẫu mới</span>
            </a>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <a href="products.html" class="card text-decoration-none border-0 shadow-sm text-center p-3 h-100 category-hover" style="background:#ffffff; border-radius:14px;">
                <div class="fs-1 text-danger mb-2"><i class="bi bi-headphones"></i></div>
                <h6 class="fw-bold text-dark mb-1">Thiết bị Âm thanh</h6>
                <span class="text-muted small">15 mẫu mới</span>
            </a>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <a href="products.html" class="card text-decoration-none border-0 shadow-sm text-center p-3 h-100 category-hover" style="background:#ffffff; border-radius:14px;">
                <div class="fs-1 text-warning mb-2"><i class="bi bi-smartwatch"></i></div>
                <h6 class="fw-bold text-dark mb-1">Smartwatches</h6>
                <span class="text-muted small">10 mẫu mới</span>
            </a>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <a href="products.html" class="card text-decoration-none border-0 shadow-sm text-center p-3 h-100 category-hover" style="background:#ffffff; border-radius:14px;">
                <div class="fs-1 text-secondary mb-2"><i class="bi bi-cpu"></i></div>
                <h6 class="fw-bold text-dark mb-1">Linh kiện Hi-End</h6>
                <span class="text-muted small">24 linh kiện</span>
            </a>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1"><i class="bi bi-fire text-danger me-2"></i> Sản Phẩm Nổi Bật & Mới Nhất</h3>
            <p class="text-muted small mb-0">Hàng chính hãng 100% - Bảo hành 12 tháng - Hỗ trợ thanh toán VietQR NAPAS 247</p>
        </div>
        <span class="badge bg-primary px-3 py-2 rounded-pill"><i class="bi bi-cpu-fill me-1"></i> Gợi ý bởi Rust Engine</span>
    </div>

    <div class="row g-4 mb-5">
        <!-- Product 1 -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-tech h-100 border-0 shadow-sm position-relative">
                <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-2 py-1">-7%</span>
                <span class="badge bg-dark position-absolute top-0 end-0 m-3 px-2 py-1"><i class="bi bi-star-fill text-warning"></i> 5.0</span>
                <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&auto=format&fit=crop&q=80" class="card-img-top p-3 rounded-4" style="height:210px; object-fit:cover;" alt="MacBook Pro">
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-light text-primary border mb-2 align-self-start">Apple</span>
                    <h6 class="card-title fw-bold mb-1 text-truncate-2">
                        <a href="detail.html" class="text-dark text-decoration-none">MacBook Pro 16 inch M3 Max (36GB / 1TB SSD)</a>
                    </h6>
                    <div class="d-flex gap-1 flex-wrap mb-2">
                        <span class="badge bg-secondary bg-opacity-10 text-dark small border">M3 Max 16C</span>
                        <span class="badge bg-secondary bg-opacity-10 text-dark small border">36GB Unified</span>
                    </div>
                    <div class="mt-auto">
                        <div class="d-flex align-items-baseline gap-2 mb-3">
                            <span class="fs-5 fw-bold text-danger">89.990.000 ₫</span>
                            <span class="text-muted text-decoration-line-through small">96.990.000 ₫</span>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="detail.html" class="btn btn-outline-primary btn-sm fw-semibold"><i class="bi bi-eye"></i> Xem Chi Tiết</a>
                            <a href="cart.html" class="btn btn-primary btn-sm fw-semibold"><i class="bi bi-cart-plus"></i> Thêm vào giỏ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product 2 -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-tech h-100 border-0 shadow-sm position-relative">
                <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-2 py-1">-11%</span>
                <span class="badge bg-dark position-absolute top-0 end-0 m-3 px-2 py-1"><i class="bi bi-star-fill text-warning"></i> 4.9</span>
                <img src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600&auto=format&fit=crop&q=80" class="card-img-top p-3 rounded-4" style="height:210px; object-fit:cover;" alt="Asus ROG">
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-light text-primary border mb-2 align-self-start">ASUS</span>
                    <h6 class="card-title fw-bold mb-1 text-truncate-2">
                        <a href="detail.html" class="text-dark text-decoration-none">Laptop Gaming Asus ROG Strix SCAR 18 (RTX 4090)</a>
                    </h6>
                    <div class="d-flex gap-1 flex-wrap mb-2">
                        <span class="badge bg-secondary bg-opacity-10 text-dark small border">i9-14900HX</span>
                        <span class="badge bg-secondary bg-opacity-10 text-dark small border">RTX 4090 16GB</span>
                    </div>
                    <div class="mt-auto">
                        <div class="d-flex align-items-baseline gap-2 mb-3">
                            <span class="fs-5 fw-bold text-danger">99.990.000 ₫</span>
                            <span class="text-muted text-decoration-line-through small">112.000.000 ₫</span>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="detail.html" class="btn btn-outline-primary btn-sm fw-semibold"><i class="bi bi-eye"></i> Xem Chi Tiết</a>
                            <a href="cart.html" class="btn btn-primary btn-sm fw-semibold"><i class="bi bi-cart-plus"></i> Thêm vào giỏ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product 3 -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-tech h-100 border-0 shadow-sm position-relative">
                <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-2 py-1">-14%</span>
                <span class="badge bg-dark position-absolute top-0 end-0 m-3 px-2 py-1"><i class="bi bi-star-fill text-warning"></i> 4.9</span>
                <img src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80" class="card-img-top p-3 rounded-4" style="height:210px; object-fit:cover;" alt="iPhone 15 Pro Max">
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-light text-primary border mb-2 align-self-start">Apple</span>
                    <h6 class="card-title fw-bold mb-1 text-truncate-2">
                        <a href="detail.html" class="text-dark text-decoration-none">iPhone 15 Pro Max 256GB Titan Tự Nhiên</a>
                    </h6>
                    <div class="d-flex gap-1 flex-wrap mb-2">
                        <span class="badge bg-secondary bg-opacity-10 text-dark small border">A17 Pro 3nm</span>
                        <span class="badge bg-secondary bg-opacity-10 text-dark small border">Màn OLED 120Hz</span>
                    </div>
                    <div class="mt-auto">
                        <div class="d-flex align-items-baseline gap-2 mb-3">
                            <span class="fs-5 fw-bold text-danger">29.990.000 ₫</span>
                            <span class="text-muted text-decoration-line-through small">34.990.000 ₫</span>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="detail.html" class="btn btn-outline-primary btn-sm fw-semibold"><i class="bi bi-eye"></i> Xem Chi Tiết</a>
                            <a href="cart.html" class="btn btn-primary btn-sm fw-semibold"><i class="bi bi-cart-plus"></i> Thêm vào giỏ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product 4 -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-tech h-100 border-0 shadow-sm position-relative">
                <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-2 py-1">-12%</span>
                <span class="badge bg-dark position-absolute top-0 end-0 m-3 px-2 py-1"><i class="bi bi-star-fill text-warning"></i> 4.8</span>
                <img src="https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=600&auto=format&fit=crop&q=80" class="card-img-top p-3 rounded-4" style="height:210px; object-fit:cover;" alt="Sony XM5">
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-light text-primary border mb-2 align-self-start">Sony</span>
                    <h6 class="card-title fw-bold mb-1 text-truncate-2">
                        <a href="detail.html" class="text-dark text-decoration-none">Tai nghe chống ồn Sony WH-1000XM5 Hi-Res</a>
                    </h6>
                    <div class="d-flex gap-1 flex-wrap mb-2">
                        <span class="badge bg-secondary bg-opacity-10 text-dark small border">Chống ồn V1+QN1</span>
                        <span class="badge bg-secondary bg-opacity-10 text-dark small border">Pin 30 Giờ</span>
                    </div>
                    <div class="mt-auto">
                        <div class="d-flex align-items-baseline gap-2 mb-3">
                            <span class="fs-5 fw-bold text-danger">7.490.000 ₫</span>
                            <span class="text-muted text-decoration-line-through small">8.490.000 ₫</span>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="detail.html" class="btn btn-outline-primary btn-sm fw-semibold"><i class="bi bi-eye"></i> Xem Chi Tiết</a>
                            <a href="cart.html" class="btn btn-primary btn-sm fw-semibold"><i class="bi bi-cart-plus"></i> Thêm vào giỏ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
"""

# 2. GENERATE PRODUCTS (products.html)
products_body = """
<div class="container">
    <div class="row g-4">
        <!-- Sidebar Filter -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm p-4 sticky-top" style="top:90px; border-radius:16px;">
                <h5 class="fw-bold mb-3"><i class="bi bi-funnel text-primary me-2"></i> Bộ Lọc Thông Minh</h5>
                
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Danh mục</label>
                    <select class="form-select form-select-sm">
                        <option>Tất cả danh mục</option>
                        <option selected>Laptops & MacBooks</option>
                        <option>Smartphones</option>
                        <option>Máy tính bảng</option>
                        <option>Âm thanh Hi-Res</option>
                        <option>Đồng hồ thông minh</option>
                        <option>Linh kiện phần cứng</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Hãng sản xuất</label>
                    <div class="form-check small"><input class="form-check-input" type="checkbox" checked> <label class="form-check-label">Apple (4)</label></div>
                    <div class="form-check small"><input class="form-check-input" type="checkbox" checked> <label class="form-check-label">ASUS ROG (3)</label></div>
                    <div class="form-check small"><input class="form-check-input" type="checkbox"> <label class="form-check-label">Sony (2)</label></div>
                    <div class="form-check small"><input class="form-check-input" type="checkbox"> <label class="form-check-label">Samsung (3)</label></div>
                    <div class="form-check small"><input class="form-check-input" type="checkbox"> <label class="form-check-label">NVIDIA (2)</label></div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Khoảng giá</label>
                    <div class="d-flex gap-2 align-items-center">
                        <input type="text" class="form-control form-control-sm" placeholder="0 ₫" value="5.000.000">
                        <span>-</span>
                        <input type="text" class="form-control form-control-sm" placeholder="100tr" value="100.000.000">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted text-uppercase">Dung lượng RAM</label>
                    <div class="d-flex flex-wrap gap-1">
                        <span class="badge bg-primary p-2">16GB</span>
                        <span class="badge bg-light text-dark border p-2">32GB</span>
                        <span class="badge bg-light text-dark border p-2">36GB</span>
                        <span class="badge bg-light text-dark border p-2">64GB</span>
                    </div>
                </div>

                <button class="btn btn-primary w-100 fw-semibold"><i class="bi bi-filter"></i> Áp Dụng Lọc (Rust Accelerated)</button>
            </div>
        </div>

        <!-- Product Grid List -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-4 shadow-sm mb-4">
                <div>
                    <span class="text-muted small">Hiển thị <strong>8</strong> sản phẩm thiết bị điện tử</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="small text-muted text-nowrap">Sắp xếp:</span>
                    <select class="form-select form-select-sm">
                        <option>Giá: Cao đến thấp</option>
                        <option>Giá: Thấp đến cao</option>
                        <option>Đánh giá cao nhất</option>
                        <option>Gợi ý tương đồng (AI Engine)</option>
                    </select>
                </div>
            </div>

            <div class="row g-4">
                <!-- Product Card A -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-tech h-100 border-0 shadow-sm p-3">
                        <span class="badge bg-danger position-absolute top-0 start-0 m-3">-7%</span>
                        <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&auto=format&fit=crop&q=80" class="rounded-3 mb-3" style="height:180px; object-fit:cover;">
                        <h6 class="fw-bold mb-1"><a href="detail.html" class="text-dark text-decoration-none">MacBook Pro 16" M3 Max</a></h6>
                        <span class="badge bg-light text-primary border mb-2 align-self-start">Apple • Laptop</span>
                        <div class="text-danger fw-bold fs-5 mb-3">89.990.000 ₫</div>
                        <a href="detail.html" class="btn btn-primary btn-sm w-100 mt-auto"><i class="bi bi-eye"></i> Xem cấu hình chi tiết</a>
                    </div>
                </div>

                <!-- Product Card B -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-tech h-100 border-0 shadow-sm p-3">
                        <span class="badge bg-danger position-absolute top-0 start-0 m-3">-11%</span>
                        <img src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=500&auto=format&fit=crop&q=80" class="rounded-3 mb-3" style="height:180px; object-fit:cover;">
                        <h6 class="fw-bold mb-1"><a href="detail.html" class="text-dark text-decoration-none">Asus ROG Strix SCAR 18</a></h6>
                        <span class="badge bg-light text-primary border mb-2 align-self-start">ASUS • Gaming</span>
                        <div class="text-danger fw-bold fs-5 mb-3">99.990.000 ₫</div>
                        <a href="detail.html" class="btn btn-primary btn-sm w-100 mt-auto"><i class="bi bi-eye"></i> Xem cấu hình chi tiết</a>
                    </div>
                </div>

                <!-- Product Card C -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-tech h-100 border-0 shadow-sm p-3">
                        <span class="badge bg-danger position-absolute top-0 start-0 m-3">-14%</span>
                        <img src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=500&auto=format&fit=crop&q=80" class="rounded-3 mb-3" style="height:180px; object-fit:cover;">
                        <h6 class="fw-bold mb-1"><a href="detail.html" class="text-dark text-decoration-none">iPhone 15 Pro Max 256GB</a></h6>
                        <span class="badge bg-light text-primary border mb-2 align-self-start">Apple • Điện thoại</span>
                        <div class="text-danger fw-bold fs-5 mb-3">29.990.000 ₫</div>
                        <a href="detail.html" class="btn btn-primary btn-sm w-100 mt-auto"><i class="bi bi-eye"></i> Xem cấu hình chi tiết</a>
                    </div>
                </div>

                <!-- Product Card D -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-tech h-100 border-0 shadow-sm p-3">
                        <span class="badge bg-danger position-absolute top-0 start-0 m-3">-12%</span>
                        <img src="https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=500&auto=format&fit=crop&q=80" class="rounded-3 mb-3" style="height:180px; object-fit:cover;">
                        <h6 class="fw-bold mb-1"><a href="detail.html" class="text-dark text-decoration-none">Sony WH-1000XM5 Hi-Res</a></h6>
                        <span class="badge bg-light text-primary border mb-2 align-self-start">Sony • Âm thanh</span>
                        <div class="text-danger fw-bold fs-5 mb-3">7.490.000 ₫</div>
                        <a href="detail.html" class="btn btn-primary btn-sm w-100 mt-auto"><i class="bi bi-eye"></i> Xem cấu hình chi tiết</a>
                    </div>
                </div>

                <!-- Product Card E -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-tech h-100 border-0 shadow-sm p-3">
                        <span class="badge bg-danger position-absolute top-0 start-0 m-3">-6%</span>
                        <img src="https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=500&auto=format&fit=crop&q=80" class="rounded-3 mb-3" style="height:180px; object-fit:cover;">
                        <h6 class="fw-bold mb-1"><a href="detail.html" class="text-dark text-decoration-none">iPad Pro 13 inch M4 (OLED)</a></h6>
                        <span class="badge bg-light text-primary border mb-2 align-self-start">Apple • Tablet</span>
                        <div class="text-danger fw-bold fs-5 mb-3">37.990.000 ₫</div>
                        <a href="detail.html" class="btn btn-primary btn-sm w-100 mt-auto"><i class="bi bi-eye"></i> Xem cấu hình chi tiết</a>
                    </div>
                </div>

                <!-- Product Card F -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-tech h-100 border-0 shadow-sm p-3">
                        <span class="badge bg-danger position-absolute top-0 start-0 m-3">-5%</span>
                        <img src="https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=500&auto=format&fit=crop&q=80" class="rounded-3 mb-3" style="height:180px; object-fit:cover;">
                        <h6 class="fw-bold mb-1"><a href="detail.html" class="text-dark text-decoration-none">Apple Watch Ultra 2 GPS</a></h6>
                        <span class="badge bg-light text-primary border mb-2 align-self-start">Apple • Watch</span>
                        <div class="text-danger fw-bold fs-5 mb-3">20.990.000 ₫</div>
                        <a href="detail.html" class="btn btn-primary btn-sm w-100 mt-auto"><i class="bi bi-eye"></i> Xem cấu hình chi tiết</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
"""

# 3. GENERATE DETAIL (detail.html)
detail_body = """
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="products.html">Laptops & MacBooks</a></li>
            <li class="breadcrumb-item active" aria-current="page">MacBook Pro 16 inch M3 Max</li>
        </ol>
    </nav>

    <div class="row g-5 mb-5">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-white text-center">
                <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=900&auto=format&fit=crop&q=80" class="img-fluid rounded-3 mb-3" alt="MacBook Pro" style="max-height:420px; object-fit:cover;">
                <div class="d-flex justify-content-center gap-2">
                    <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=150" class="border border-primary rounded-2 p-1" width="70" height="60">
                    <img src="https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=150" class="border rounded-2 p-1 opacity-75" width="70" height="60">
                    <img src="https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=150" class="border rounded-2 p-1 opacity-75" width="70" height="60">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <span class="badge bg-light text-primary border mb-2">Apple • Thiết bị chính hãng</span>
            <h2 class="fw-bold mb-2">MacBook Pro 16 inch M3 Max (36GB RAM / 1TB SSD Space Black)</h2>
            <div class="d-flex align-items-center gap-2 mb-3">
                <div class="text-warning">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
                <span class="fw-bold">5.0</span>
                <span class="text-muted">(18 đánh giá công nghệ)</span>
                <span class="badge bg-success bg-opacity-10 text-success ms-2"><i class="bi bi-check-circle"></i> Còn 12 máy</span>
            </div>

            <div class="p-3 bg-light rounded-4 mb-4">
                <div class="d-flex align-items-baseline gap-3">
                    <span class="display-6 fw-bold text-danger">89.990.000 ₫</span>
                    <span class="text-muted text-decoration-line-through fs-5">96.990.000 ₫</span>
                    <span class="badge bg-danger">-7% Giảm sốc</span>
                </div>
                <p class="text-muted small mb-0 mt-2"><i class="bi bi-shield-check text-success me-1"></i> Giá đã bao gồm VAT & Miễn phí vận chuyển toàn quốc</p>
            </div>

            <!-- Specs Table Quick Overview -->
            <h6 class="fw-bold text-uppercase text-muted small mb-2"><i class="bi bi-cpu me-1"></i> Thông Số Kỹ Thuật Đa Chiều (Định dạng JSON)</h6>
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-sm small bg-white">
                    <tbody>
                        <tr><td class="bg-light fw-semibold" width="30%">Vi xử lý (CPU)</td><td>Apple M3 Max 16-Core CPU</td></tr>
                        <tr><td class="bg-light fw-semibold">Card đồ họa (GPU)</td><td>40-Core GPU Metal 3</td></tr>
                        <tr><td class="bg-light fw-semibold">Bộ nhớ RAM</td><td>36GB Unified Memory (300GB/s bandwidth)</td></tr>
                        <tr><td class="bg-light fw-semibold">Ổ cứng lưu trữ</td><td>1TB PCIe Gen4 NVMe SSD</td></tr>
                        <tr><td class="bg-light fw-semibold">Màn hình</td><td>16.2" Liquid Retina XDR Mini-LED (120Hz ProMotion)</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex gap-3 align-items-center mb-4">
                <div class="input-group" style="width: 130px;">
                    <button class="btn btn-outline-secondary" type="button">-</button>
                    <input type="text" class="form-control text-center fw-bold" value="1">
                    <button class="btn btn-outline-secondary" type="button">+</button>
                </div>
                <a href="cart.html" class="btn btn-primary btn-lg flex-grow-1 fw-bold shadow"><i class="bi bi-cart3 me-2"></i> Thêm Vào Giỏ Hàng</a>
                <a href="checkout.html" class="btn btn-danger btn-lg fw-bold"><i class="bi bi-lightning-fill"></i> Mua Ngay</a>
            </div>
        </div>
    </div>

    <!-- Recommendations using Cosine Similarity -->
    <div class="mt-5 p-4 bg-white rounded-4 shadow-sm border">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1"><i class="bi bi-stars text-primary me-2"></i> Gợi Ý Thiết Bị Tương Đồng (AI Cosine Similarity)</h4>
                <p class="text-muted small mb-0">Thuật toán Rust Engine tính toán độ tương đồng trên không gian vector đặc tính phần cứng (CPU, GPU, RAM, Mức giá)</p>
            </div>
            <span class="badge bg-success"><i class="bi bi-cpu me-1"></i> Rust Recommender (0.9ms)</span>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="card h-100 border p-3 rounded-3">
                    <div class="d-flex gap-3 align-items-center">
                        <img src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=200" class="rounded-2" width="70" height="70" style="object-fit:cover;">
                        <div>
                            <h6 class="fw-bold mb-1 small"><a href="detail.html" class="text-dark text-decoration-none">Asus ROG Strix SCAR 18</a></h6>
                            <span class="badge bg-info bg-opacity-10 text-info small">Độ tương đồng 94%</span>
                            <div class="text-danger fw-bold small mt-1">99.990.000 ₫</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border p-3 rounded-3">
                    <div class="d-flex gap-3 align-items-center">
                        <img src="https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=200" class="rounded-2" width="70" height="70" style="object-fit:cover;">
                        <div>
                            <h6 class="fw-bold mb-1 small"><a href="detail.html" class="text-dark text-decoration-none">iPad Pro 13 inch M4 (OLED)</a></h6>
                            <span class="badge bg-info bg-opacity-10 text-info small">Độ tương đồng 88%</span>
                            <div class="text-danger fw-bold small mt-1">37.990.000 ₫</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border p-3 rounded-3">
                    <div class="d-flex gap-3 align-items-center">
                        <img src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=200" class="rounded-2" width="70" height="70" style="object-fit:cover;">
                        <div>
                            <h6 class="fw-bold mb-1 small"><a href="detail.html" class="text-dark text-decoration-none">iPhone 15 Pro Max 256GB</a></h6>
                            <span class="badge bg-info bg-opacity-10 text-info small">Độ tương đồng 85%</span>
                            <div class="text-danger fw-bold small mt-1">29.990.000 ₫</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
"""

# 4. GENERATE CART (cart.html)
cart_body = """
<div class="container">
    <h3 class="fw-bold mb-4"><i class="bi bi-cart3 text-primary me-2"></i> Giỏ Hàng Công Nghệ Của Bạn</h3>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-3">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th width="140">Số lượng</th>
                                <th>Thành tiền</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=150" class="rounded-3" width="60" height="60" style="object-fit:cover;">
                                        <div>
                                            <h6 class="fw-bold mb-0">MacBook Pro 16" M3 Max</h6>
                                            <span class="text-muted small">Apple • 36GB / 1TB SSD</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="fw-semibold">89.990.000 ₫</td>
                                <td>
                                    <div class="input-group input-group-sm" style="width:100px;">
                                        <button class="btn btn-outline-secondary">-</button>
                                        <input type="text" class="form-control text-center fw-bold" value="1">
                                        <button class="btn btn-outline-secondary">+</button>
                                    </div>
                                </td>
                                <td class="fw-bold text-danger">89.990.000 ₫</td>
                                <td><button class="btn btn-sm text-danger"><i class="bi bi-trash"></i></button></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=150" class="rounded-3" width="60" height="60" style="object-fit:cover;">
                                        <div>
                                            <h6 class="fw-bold mb-0">Tai nghe Sony WH-1000XM5</h6>
                                            <span class="text-muted small">Sony • Chống ồn chủ động Hi-Res</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="fw-semibold">7.490.000 ₫</td>
                                <td>
                                    <div class="input-group input-group-sm" style="width:100px;">
                                        <button class="btn btn-outline-secondary">-</button>
                                        <input type="text" class="form-control text-center fw-bold" value="1">
                                        <button class="btn btn-outline-secondary">+</button>
                                    </div>
                                </td>
                                <td class="fw-bold text-danger">7.490.000 ₫</td>
                                <td><button class="btn btn-sm text-danger"><i class="bi bi-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                    <a href="products.html" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Tiếp tục chọn mua</a>
                    <span class="text-muted small"><i class="bi bi-info-circle text-primary"></i> Kiểm tra tồn kho nguyên tử tự động</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold mb-3">Tóm Tắt Đơn Hàng</h5>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">MÃ GIẢM GIÁ KHUYẾN MÃI</label>
                    <div class="input-group">
                        <input type="text" class="form-control" value="ELECTRO500" placeholder="Nhập mã voucher">
                        <button class="btn btn-dark" type="button">Áp dụng</button>
                    </div>
                    <span class="badge bg-success mt-2"><i class="bi bi-check-circle"></i> Đã giảm 500.000 ₫ từ mã ELECTRO500</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Tổng tiền hàng:</span>
                    <span class="fw-semibold">97.480.000 ₫</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Giảm giá Voucher:</span>
                    <span class="text-success fw-semibold">-500.000 ₫</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Phí giao hàng:</span>
                    <span class="text-success fw-semibold">Miễn phí</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-baseline mb-4">
                    <span class="fs-5 fw-bold">Tổng thanh toán:</span>
                    <span class="fs-4 fw-bold text-danger">96.980.000 ₫</span>
                </div>

                <a href="checkout.html" class="btn btn-primary btn-lg w-100 fw-bold shadow"><i class="bi bi-credit-card me-2"></i> Tiến Hành Đặt Hàng</a>
            </div>
        </div>
    </div>
</div>
"""

# 5. GENERATE CHECKOUT (checkout.html)
checkout_body = """
<div class="container">
    <h3 class="fw-bold mb-4"><i class="bi bi-shield-lock text-primary me-2"></i> Xác Nhận Đơn Hàng & Thanh Toán VietQR</h3>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-geo-alt text-danger me-2"></i> Thông Tin Người Nhận Hàng</h5>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Họ và tên</label>
                        <input type="text" class="form-control" value="Nguyễn Văn A">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Số điện thoại</label>
                        <input type="text" class="form-control" value="0987654321">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Email nhận hóa đơn điện tử</label>
                        <input type="email" class="form-control" value="nguyenvana@gmail.com">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Địa chỉ giao hàng</label>
                        <input type="text" class="form-control" value="123 Đường Công Nghệ, Phường 10, Quận 1, TP. Hồ Chí Minh">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Ghi chú giao hàng</label>
                        <textarea class="form-control" rows="2" placeholder="Giao hàng giờ hành chính, gọi trước khi đến"></textarea>
                    </div>
                </div>

                <h5 class="fw-bold mb-3 pt-3 border-top"><i class="bi bi-wallet2 text-success me-2"></i> Phương Thức Thanh Toán</h5>
                <div class="form-check p-3 border rounded-3 mb-2 bg-light">
                    <input class="form-check-input" type="radio" name="payment" id="p1" checked>
                    <label class="form-check-label fw-bold d-flex align-items-center gap-2" for="p1">
                        <i class="bi bi-qr-code text-primary fs-5"></i> Chuyển khoản VietQR NAPAS 247 (Tự động nhận diện & xác nhận tức thì)
                    </label>
                </div>
                <div class="form-check p-3 border rounded-3 mb-2">
                    <input class="form-check-input" type="radio" name="payment" id="p2">
                    <label class="form-check-label fw-bold d-flex align-items-center gap-2" for="p2">
                        <i class="bi bi-truck text-secondary fs-5"></i> Thanh toán tiền mặt khi nhận hàng (COD)
                    </label>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="text-center mb-3">
                    <span class="badge bg-primary px-3 py-2 rounded-pill mb-2"><i class="bi bi-shield-check"></i> Chuẩn VietQR NAPAS 247</span>
                    <h5 class="fw-bold">Mã QR Thanh Toán Tự Động</h5>
                    <p class="text-muted small">Quét mã bằng ứng dụng ngân hàng bất kỳ để chuyển tiền chính xác 100%</p>
                </div>

                <div class="text-center p-3 bg-light rounded-4 mb-3 border">
                    <!-- VietQR Image Simulation -->
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=00020101021238540010A00000072701240006970422011001234567890208QRIBFTTA53037045408969800005802VN62210817DH20260917ELECTRO6304" alt="VietQR" class="img-fluid rounded-3 shadow-sm border p-2 bg-white mb-2" width="200">
                    <div class="fw-bold text-dark fs-6 mt-1">Ngân hàng Quân Đội (MB Bank)</div>
                    <div class="text-muted small">STK: <strong>0388.999.888</strong> • Chủ TK: <strong>CTY ELECTROSTORE VN</strong></div>
                    <div class="badge bg-warning text-dark mt-2 p-2 fs-6">Số tiền: 96.980.000 ₫</div>
                    <div class="text-muted small mt-1">Nội dung CK: <span class="badge bg-dark">DH982743</span></div>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-success btn-lg fw-bold"><i class="bi bi-check2-circle me-2"></i> Hoàn Tất & Đặt Hàng</button>
                    <a href="cart.html" class="btn btn-outline-secondary btn-sm">Quay lại giỏ hàng</a>
                </div>
            </div>
        </div>
    </div>
</div>
"""

# 6. GENERATE ADMIN (admin.html)
admin_body = """
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1"><i class="bi bi-speedometer2 text-primary me-2"></i> Quản Trị Hệ Thống 12B5 Store</h3>
            <p class="text-muted small mb-0">Hệ thống giám sát kinh doanh, quản lý kho hàng và tích hợp công cụ phân tích Pareto ABC từ Rust Engine.</p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-success px-3 py-2 d-flex align-items-center"><i class="bi bi-check-circle me-1"></i> Microservice Online</span>
            <button class="btn btn-outline-primary btn-sm"><i class="bi bi-arrow-clockwise"></i> Làm mới dữ liệu</button>
        </div>
    </div>

    <!-- KPI Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-white border-start border-4 border-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Doanh Thu Tháng</span>
                        <h4 class="fw-bold text-dark mt-1 mb-0">348.500.000 ₫</h4>
                        <span class="badge bg-success bg-opacity-10 text-success small mt-2"><i class="bi bi-arrow-up"></i> +18.4% so với kỳ trước</span>
                    </div>
                    <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3 fs-3"><i class="bi bi-currency-dollar"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-white border-start border-4 border-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Đơn Hàng Mới</span>
                        <h4 class="fw-bold text-dark mt-1 mb-0">124 Đơn</h4>
                        <span class="badge bg-success bg-opacity-10 text-success small mt-2"><i class="bi bi-check-all"></i> 98% giao thành công</span>
                    </div>
                    <div class="p-3 bg-success bg-opacity-10 text-success rounded-3 fs-3"><i class="bi bi-bag-check"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-white border-start border-4 border-info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Sản Phẩm Trong Kho</span>
                        <h4 class="fw-bold text-dark mt-1 mb-0">48 Mẫu</h4>
                        <span class="badge bg-info bg-opacity-10 text-info small mt-2"><i class="bi bi-cpu"></i> 100% có thông số JSON</span>
                    </div>
                    <div class="p-3 bg-info bg-opacity-10 text-info rounded-3 fs-3"><i class="bi bi-box-seam"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-white border-start border-4 border-warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Khách Hàng Hoạt Động</span>
                        <h4 class="fw-bold text-dark mt-1 mb-0">856 Users</h4>
                        <span class="badge bg-warning bg-opacity-10 text-dark small mt-2"><i class="bi bi-person-plus"></i> +32 đăng ký tuần này</span>
                    </div>
                    <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-3 fs-3"><i class="bi bi-people"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rust Pareto ABC & Linear Regression Report -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-bar-chart-line text-primary me-2"></i> Phân Tích Tồn Kho Pareto ABC (Rust Engine)</h5>
                    <span class="badge bg-primary">Nguyên lý 80/20</span>
                </div>
                <p class="text-muted small">Thuật toán Rust phân nhóm sản phẩm theo tỷ trọng doanh thu để tối ưu hóa vốn lưu động trong kho hàng thiết bị điện tử.</p>

                <div class="table-responsive">
                    <table class="table table-hover align-middle small">
                        <thead class="table-light">
                            <tr>
                                <th>Phân nhóm</th>
                                <th>Tên Thiết Bị</th>
                                <th>Doanh số đóng góp</th>
                                <th>Tỷ trọng</th>
                                <th>Khuyến nghị quản trị</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-danger">Nhóm A</span></td>
                                <td class="fw-bold">MacBook Pro 16" M3 Max</td>
                                <td class="fw-bold text-danger">179.980.000 ₫</td>
                                <td>51.6%</td>
                                <td><span class="text-success fw-semibold"><i class="bi bi-shield-check"></i> Luôn duy trì tồn kho an toàn</span></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">Nhóm A</span></td>
                                <td class="fw-bold">Asus ROG Strix SCAR 18</td>
                                <td class="fw-bold text-danger">99.990.000 ₫</td>
                                <td>28.7%</td>
                                <td><span class="text-success fw-semibold"><i class="bi bi-shield-check"></i> Cần đặt hàng trước 7 ngày</span></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-warning text-dark">Nhóm B</span></td>
                                <td class="fw-bold">iPhone 15 Pro Max 256GB</td>
                                <td class="fw-bold">45.000.000 ₫</td>
                                <td>12.9%</td>
                                <td><span>Nhập hàng theo chu kỳ tuần</span></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-secondary">Nhóm C</span></td>
                                <td class="fw-bold">Tai nghe Sony WH-1000XM5</td>
                                <td class="fw-bold">23.530.000 ₫</td>
                                <td>6.8%</td>
                                <td><span class="text-muted">Giữ mức tồn kho tối thiểu</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h5 class="fw-bold mb-3"><i class="bi bi-graph-up-arrow text-success me-2"></i> Dự Báo Xu Hướng</h5>
                <p class="text-muted small">Mô hình Hồi quy tuyến tính (Linear Regression) chạy tự động bằng Rust Worker.</p>
                <div class="p-3 bg-light rounded-4 mb-3 border">
                    <div class="small text-muted mb-1">Dự báo doanh thu tháng tới:</div>
                    <div class="fs-4 fw-bold text-success">+392.400.000 ₫</div>
                    <div class="small text-muted mt-2">Hệ số tương quan R²: <span class="badge bg-dark">0.962 (Rất cao)</span></div>
                    <div class="small text-muted">Độ dốc tăng trưởng (Slope): <span class="fw-bold text-primary">+14.2%</span></div>
                </div>
                <div class="alert alert-info py-2 small mb-0">
                    <i class="bi bi-info-circle me-1"></i> Dự báo chỉ ra các dòng máy tính xách tay cấu hình cao sẽ dẫn đầu doanh số quý tới.
                </div>
            </div>
        </div>
    </div>
</div>
"""

pages = [
    ("index.html", "Trang Chủ", home_body, "active", "", "", "", "", ""),
    ("products.html", "Danh Mục Sản Phẩm", products_body, "", "active", "", "", "", ""),
    ("detail.html", "Chi Tiết Sản Phẩm & Cấu Hình", detail_body, "", "", "active", "", "", ""),
    ("cart.html", "Giỏ Hàng Công Nghệ", cart_body, "", "", "", "active", "", ""),
    ("checkout.html", "Thanh Toán VietQR NAPAS", checkout_body, "", "", "", "", "active", ""),
    ("admin.html", "Admin Dashboard & KPIs", admin_body, "", "", "", "", "", "active"),
]

for filename, title, body, n_home, n_prod, n_det, n_cart, n_check, n_adm in pages:
    content = header_template.format(
        title=title,
        nav_home=n_home,
        nav_products=n_prod,
        nav_detail=n_det,
        nav_cart=n_cart,
        nav_checkout=n_check,
        nav_admin=n_adm,
        search_val="",
    ) + body + footer_template
    
    filepath = os.path.join('preview', filename)
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    print(f"Generated {filepath}")

print("All preview pages generated successfully!")
