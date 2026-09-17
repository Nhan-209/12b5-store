import os

os.makedirs('preview', exist_ok=True)

header_template = """<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{title} - 12B5 Store | Siêu Thị Thiết Bị Điện Tử & Công Nghệ Cao</title>
    
    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom Theme CSS -->
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        .preview-bar {{
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            color: #fff;
            padding: 9px 20px;
            font-size: 0.83rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            position: sticky;
            top: 0;
            z-index: 2100;
        }}
        .preview-pill {{
            background: rgba(255, 255, 255, 0.1);
            padding: 5px 14px;
            border-radius: 9999px;
            text-decoration: none;
            color: #e2e8f0;
            margin: 0 3px;
            transition: all 0.2s ease;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border: 1px solid transparent;
        }}
        .preview-pill:hover, .preview-pill.active {{
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            color: #fff;
            box-shadow: 0 2px 10px rgba(244, 63, 94, 0.45);
            font-weight: 600;
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }}
    </style>
</head>
<body>
<!-- Static Preview Mode Sticky Navigation Bar -->
<div class="preview-bar shadow-sm">
    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-danger rounded-pill px-2 py-1"><i class="bi bi-eye-fill"></i> Offline Preview Mode</span>
        <span class="text-light d-none d-lg-inline">Giao diện Modern Pastel & Glassmorphism không cần chạy server</span>
    </div>
    <div class="d-flex align-items-center overflow-x-auto">
        <span class="me-2 text-white-50 small d-none d-sm-inline">Màn hình:</span>
        <a href="index.html" class="preview-pill {nav_home}"><i class="bi bi-house"></i> 1. Trang Chủ</a>
        <a href="products.html" class="preview-pill {nav_products}"><i class="bi bi-grid"></i> 2. Danh Mục SP</a>
        <a href="detail.html" class="preview-pill {nav_detail}"><i class="bi bi-laptop"></i> 3. Chi Tiết Cấu Hình</a>
        <a href="cart.html" class="preview-pill {nav_cart}"><i class="bi bi-cart3"></i> 4. Giỏ Hàng (2)</a>
        <a href="checkout.html" class="preview-pill {nav_checkout}"><i class="bi bi-qr-code"></i> 5. VietQR Checkout</a>
        <a href="success.html" class="preview-pill {nav_success}"><i class="bi bi-check-circle"></i> 6. Đặt Hàng Thành Công</a>
        <a href="admin.html" class="preview-pill {nav_admin}"><i class="bi bi-speedometer2"></i> 7. Admin KPIs & Pareto</a>
    </div>
</div>

<!-- Main Top Announcement Bar -->
<div class="announcement-bar">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="badge-thesis"><i class="bi bi-mortarboard-fill me-1"></i> Graduation Thesis</span> 
            <span class="d-none d-md-inline text-white-50">|</span>
            <span class="small text-light">Hệ thống TMĐT Thiết Bị Điện Tử &bull; Kiến trúc Hybrid PHP + Rust Microservice</span>
        </div>
        <div class="d-flex align-items-center gap-3 small">
            <span id="rustEngineBadge" class="d-inline-flex align-items-center">
                <i class="bi bi-cpu text-warning me-1"></i> <span class="text-white-50">Rust Engine:</span> <span class="badge bg-success ms-1">Active (0.8ms)</span>
            </span>
            <span class="text-white-50 d-none d-sm-inline">|</span>
            <span class="text-white-50 d-none d-sm-inline"><i class="bi bi-shield-check text-success me-1"></i> 100% Chính Hãng VAT</span>
            <span class="text-white-50 d-none d-lg-inline">|</span>
            <span class="text-white-50 d-none d-lg-inline"><i class="bi bi-telephone-fill me-1"></i> Hotline: 1800.1235</span>
        </div>
    </div>
</div>

<!-- Main Frosted Glass Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-glass py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.html">
            <div class="brand-logo-badge">
                <i class="bi bi-lightning-charge-fill fs-5"></i>
            </div>
            <div>
                <span class="brand-title fs-4">12B5 Store</span>
                <div class="brand-subtitle">PREMIUM TECH & SMART DEVICES</div>
            </div>
        </a>

        <div class="collapse navbar-collapse show" id="navbarMain">
            <div class="d-flex mx-auto search-box-group my-2 my-lg-0">
                <div class="input-group w-100">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Tìm siêu tốc với Rust Levenshtein (MacBook M3, iPhone 16, Sony...)" value="{search_val}">
                    <a href="products.html" class="btn btn-search">Tìm kiếm</a>
                </div>
            </div>

            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link-custom" href="products.html">
                        <i class="bi bi-grid me-1"></i> Sản Phẩm
                    </a>
                </li>
                <li class="nav-item">
                    <a class="cart-pill-btn" href="cart.html">
                        <i class="bi bi-cart3 fs-5"></i>
                        <span class="small d-none d-md-inline">Giỏ hàng</span>
                        <span class="cart-pill-badge">2</span>
                    </a>
                </li>
                <li class="nav-item dropdown ms-lg-2">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 p-1 pe-3 rounded-pill bg-white border shadow-xs" href="#" data-bs-toggle="dropdown">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 34px; height: 34px; background: linear-gradient(135deg, #f43f5e, #fb7185); font-size: 0.85rem;">
                            A
                        </div>
                        <span class="small fw-semibold text-dark">Admin</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4 mt-2">
                        <li><a class="dropdown-item py-2 text-danger fw-bold" href="admin.html"><i class="bi bi-speedometer2 me-2"></i> Bảng Quản Trị Admin</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2 text-danger" href="index.html"><i class="bi bi-box-arrow-right me-2"></i> Đăng xuất</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Category Quick Navigation Strip -->
<div class="category-quick-strip d-none d-md-block">
    <div class="container d-flex align-items-center justify-content-between overflow-x-auto gap-2">
        <a href="products.html" class="category-quick-link"><i class="bi bi-phone text-danger"></i> Điện Thoại</a>
        <a href="products.html" class="category-quick-link"><i class="bi bi-laptop text-danger"></i> Laptop & PC</a>
        <a href="products.html" class="category-quick-link"><i class="bi bi-tablet text-danger"></i> Máy Tính Bảng</a>
        <a href="products.html" class="category-quick-link"><i class="bi bi-headphones text-danger"></i> Tai Nghe & Âm Thanh</a>
        <a href="products.html" class="category-quick-link"><i class="bi bi-smartwatch text-danger"></i> Smartwatch</a>
        <a href="products.html" class="category-quick-link"><i class="bi bi-cpu text-danger"></i> Phụ Kiện</a>
        <span class="text-muted opacity-50">|</span>
        <a href="products.html" class="category-quick-link text-danger fw-bold"><i class="bi bi-fire text-danger"></i> Bán Chạy Nhất</a>
        <a href="products.html" class="category-quick-link text-primary fw-bold"><i class="bi bi-tag-fill text-primary"></i> Trả Góp 0%</a>
    </div>
</div>

<main class="py-4">
"""

footer_template = """
</main>

<footer class="footer-tech">
    <div class="container">
        <div class="row g-4 pb-4">
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="brand-logo-badge" style="width: 36px; height: 36px;">
                        <i class="bi bi-lightning-charge-fill fs-6"></i>
                    </div>
                    <span class="fs-5 fw-bold text-white">12B5 Store</span>
                </div>
                <p class="small text-muted mb-3" style="line-height: 1.6;">
                    Hệ thống bán lẻ thiết bị điện tử & công nghệ cao chính hãng hàng đầu. Tối ưu hóa hiệu năng vượt trội nhờ kiến trúc Hybrid kết hợp PHP Web Core MVC và Microservice tính toán chuyên sâu viết bằng Rust.
                </p>
                <div class="d-flex gap-2">
                    <a href="https://facebook.com" target="_blank" class="social-icon-btn" title="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="https://youtube.com" target="_blank" class="social-icon-btn" title="YouTube"><i class="bi bi-youtube"></i></a>
                    <a href="https://github.com/Nhan-209/12b5-store" target="_blank" class="social-icon-btn" title="GitHub Repository"><i class="bi bi-github"></i></a>
                    <a href="https://telegram.org" target="_blank" class="social-icon-btn" title="Telegram"><i class="bi bi-telegram"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h6 class="text-white fw-bold mb-3 small text-uppercase tracking-wider">Danh Mục Thiết Bị</h6>
                <ul class="list-unstyled small d-flex flex-column gap-2">
                    <li><a href="products.html">Điện Thoại Flagship</a></li>
                    <li><a href="products.html">Laptop & Ultrabook</a></li>
                    <li><a href="products.html">Máy Tính Bảng (iPad)</a></li>
                    <li><a href="products.html">Tai Nghe Không Dây</a></li>
                    <li><a href="products.html">Smartwatch Cao Cấp</a></li>
                    <li><a href="products.html">Phụ Kiện Chính Hãng</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="text-white fw-bold mb-3 small text-uppercase tracking-wider">Thông Tin Đồ Án Tốt Nghiệp</h6>
                <ul class="list-unstyled small d-flex flex-column gap-2 text-muted">
                    <li><span class="text-white-50">Đề tài:</span> Xây dựng Website TMĐT Thiết Bị Điện Tử</li>
                    <li><span class="text-white-50">Kiến trúc:</span> Hybrid PHP 8.x + Rust Microservice</li>
                    <li><span class="text-white-50">Cơ sở dữ liệu:</span> Dual DB (MySQL 8.0 + SQLite)</li>
                    <li><span class="text-white-50">Thuật toán Rust:</span> Fuzzy Levenshtein, Cosine Sim, Pareto ABC</li>
                    <li><span class="text-white-50">CI/CD Pipeline:</span> GitHub Actions Automated Testing</li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="text-white fw-bold mb-3 small text-uppercase tracking-wider">Chính Sách & Liên Hệ</h6>
                <ul class="list-unstyled small d-flex flex-column gap-2">
                    <li><a href="#"><i class="bi bi-patch-check text-rose me-1"></i> Bảo hành 12-24 tháng toàn quốc</a></li>
                    <li><a href="#"><i class="bi bi-arrow-repeat text-rose me-1"></i> 1 đổi 1 trong 30 ngày nếu lỗi NSX</a></li>
                    <li><a href="#"><i class="bi bi-truck text-rose me-1"></i> Giao hỏa tốc 2 giờ nội thành</a></li>
                    <li><a href="#"><i class="bi bi-qr-code text-rose me-1"></i> Thanh toán chuẩn VietQR tự động</a></li>
                    <li class="pt-1 text-white-50"><i class="bi bi-telephone text-rose me-1"></i> Hotline: <strong class="text-white">1800.1235</strong> (Miễn phí)</li>
                </ul>
            </div>
        </div>

        <div class="border-top border-secondary border-opacity-25 pt-4 text-center small text-muted">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <p class="mb-0">&copy; 2026 12B5 Store. All rights reserved. Đồ án Tốt Nghiệp Chuyên Ngành CNTT.</p>
                <p class="mb-0">Designed with Modern Pastel & Glassmorphism &bull; Powered by Rust Microservices Engine</p>
            </div>
        </div>
    </div>
</footer>

<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
    <div id="previewToast" class="toast align-items-center text-white bg-dark border-0 rounded-4 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                <span id="toastMessage">Đã thêm thiết bị vào giỏ hàng thành công!</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let cartCount = 2;
    const toastEl = document.getElementById('previewToast');
    const toastMsg = document.getElementById('toastMessage');
    const toast = toastEl ? new bootstrap.Toast(toastEl, { delay: 2500 }) : null;

    // 1. Interactive Add-To-Cart & Buy Now feedback
    document.querySelectorAll('.btn-ajax-add-cart, button.btn-rose').forEach(function(btn) {
        if (btn.innerText.includes('Thêm') || btn.innerText.includes('Mua Ngay') || btn.classList.contains('btn-ajax-add-cart')) {
            btn.addEventListener('click', function(e) {
                if (btn.tagName === 'BUTTON' && !btn.closest('form')) {
                    e.preventDefault();
                    cartCount++;
                    document.querySelectorAll('.cart-pill-badge').forEach(function(badge) {
                        badge.textContent = cartCount;
                    });
                    const card = btn.closest('.product-card, .card');
                    const title = card ? card.querySelector('.product-title, h1, h5')?.innerText?.trim() : 'Thiết bị công nghệ';
                    if (toastMsg) {
                        toastMsg.innerHTML = '<strong>' + (title || 'Thiết bị') + '</strong> đã được thêm vào giỏ!';
                    }
                    if (toast) toast.show();
                }
            });
        }
    });

    // 2. Interactive Live Search Simulation (Rust Microservice Levenshtein)
    const searchInputs = document.querySelectorAll('.search-box-group input');
    searchInputs.forEach(function(input) {
        const wrapper = input.closest('.search-box-group');
        if (!wrapper) return;
        wrapper.style.position = 'relative';

        const dropdown = document.createElement('div');
        dropdown.className = 'dropdown-menu shadow-lg border-0 rounded-4 p-2 w-100 mt-1';
        dropdown.style.display = 'none';
        dropdown.style.maxHeight = '320px';
        dropdown.style.overflowY = 'auto';
        dropdown.style.zIndex = '1050';
        wrapper.appendChild(dropdown);

        const techItems = [
            { name: 'MacBook Pro 14 M3 Pro (18GB/512GB)', price: '49.990.000 ₫', brand: 'Apple', icon: 'bi-laptop', link: 'detail.html' },
            { name: 'iPhone 16 Pro Max 256GB Desert Titanium', price: '34.990.000 ₫', brand: 'Apple', icon: 'bi-phone', link: 'products.html' },
            { name: 'Samsung Galaxy S24 Ultra 512GB AI', price: '31.990.000 ₫', brand: 'Samsung', icon: 'bi-phone', link: 'products.html' },
            { name: 'Tai Nghe Sony WH-1000XM5 Hi-Res ANC', price: '7.490.000 ₫', brand: 'Sony', icon: 'bi-headphones', link: 'products.html' },
            { name: 'iPad Pro M4 11 inch Ultra Retina XDR', price: '28.990.000 ₫', brand: 'Apple', icon: 'bi-tablet', link: 'products.html' },
            { name: 'Apple Watch Ultra 2 GPS + Cellular', price: '21.490.000 ₫', brand: 'Apple', icon: 'bi-smartwatch', link: 'products.html' }
        ];

        input.addEventListener('input', function() {
            const query = input.value.trim().toLowerCase();
            if (query.length < 2) {
                dropdown.style.display = 'none';
                return;
            }
            const filtered = techItems.filter(item => item.name.toLowerCase().includes(query) || item.brand.toLowerCase().includes(query));
            if (filtered.length === 0) {
                dropdown.innerHTML = '<div class="p-3 text-muted text-center small"><i class="bi bi-search me-1"></i> Không tìm thấy thiết bị phù hợp</div>';
            } else {
                let html = '<div class="d-flex justify-content-between align-items-center px-3 py-1 border-bottom mb-2 small"><span class="text-muted fw-bold">Gợi ý tìm kiếm</span><span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill"><i class="bi bi-cpu-fill me-1"></i> Rust Engine: 0.8ms</span></div>';
                filtered.forEach(item => {
                    html += `<a href="${item.link}" class="dropdown-item d-flex align-items-center justify-content-between p-2 rounded-3 mb-1">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi ${item.icon} text-danger fs-5"></i>
                            <div>
                                <div class="fw-semibold text-dark small">${item.name}</div>
                                <span class="badge bg-light text-muted small">${item.brand}</span>
                            </div>
                        </div>
                        <span class="fw-bold text-danger small">${item.price}</span>
                    </a>`;
                });
                dropdown.innerHTML = html;
            }
            dropdown.style.display = 'block';
        });

        document.addEventListener('click', function(e) {
            if (!wrapper.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    });
});
</script>
</body>
</html>
"""

# ==============================================================================
# 1. GENERATE HOME (index.html)
# ==============================================================================
home_body = """
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
                    <a href="products.html" class="btn btn-rose btn-lg px-4 shadow-sm">
                        <i class="bi bi-bag-check-fill me-2"></i> Khám Phá Bộ Sưu Tập
                    </a>
                    <a href="admin.html" class="btn btn-soft-slate btn-lg px-4">
                        <i class="bi bi-speedometer2 me-2"></i> Xem Dashboard Admin
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
                        <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=700&auto=format&fit=crop&q=80" alt="MacBook M3 Pro" class="img-fluid rounded-4 shadow-sm" style="max-height: 180px; object-fit: cover;">
                    </div>

                    <h4 class="fw-bold text-dark mb-1">MacBook Pro 16" M3 Max</h4>
                    <p class="text-muted small mb-3">Apple M3 Max 16-Core &bull; 36GB Unified RAM &bull; 1TB SSD</p>

                    <div class="d-flex justify-content-center align-items-baseline gap-2 mb-3">
                        <span class="fs-3 fw-extrabold text-danger">89.990.000 ₫</span>
                        <span class="text-muted text-decoration-line-through small">96.990.000 ₫</span>
                    </div>

                    <div class="p-2 bg-white rounded-3 border mb-3 small d-flex justify-content-around text-muted">
                        <div><i class="bi bi-credit-card me-1 text-primary"></i> Trả góp 0%</div>
                        <div><i class="bi bi-gift me-1 text-danger"></i> Tặng túi Tucano</div>
                    </div>

                    <a href="detail.html" class="btn btn-rose w-100 fw-bold py-2">
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
            <a href="products.html" class="btn btn-outline-rose btn-sm">Xem tất cả danh mục <i class="bi bi-arrow-right ms-1"></i></a>
        </div>

        <div class="row g-3">
            <div class="col-6 col-md-4 col-lg-2">
                <a href="products.html" class="category-box">
                    <div class="category-icon-wrapper"><i class="bi bi-phone"></i></div>
                    <div class="category-title">Điện Thoại</div>
                    <div class="category-count">18 mẫu mới</div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="products.html" class="category-box">
                    <div class="category-icon-wrapper"><i class="bi bi-laptop"></i></div>
                    <div class="category-title">Laptop & PC</div>
                    <div class="category-count">12 mẫu mới</div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="products.html" class="category-box">
                    <div class="category-icon-wrapper"><i class="bi bi-tablet"></i></div>
                    <div class="category-title">Máy Tính Bảng</div>
                    <div class="category-count">8 mẫu mới</div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="products.html" class="category-box">
                    <div class="category-icon-wrapper"><i class="bi bi-headphones"></i></div>
                    <div class="category-title">Tai Nghe Âm Thanh</div>
                    <div class="category-count">15 mẫu mới</div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="products.html" class="category-box">
                    <div class="category-icon-wrapper"><i class="bi bi-smartwatch"></i></div>
                    <div class="category-title">Smartwatch</div>
                    <div class="category-count">10 mẫu mới</div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="products.html" class="category-box">
                    <div class="category-icon-wrapper"><i class="bi bi-cpu"></i></div>
                    <div class="category-title">Linh Kiện Hi-End</div>
                    <div class="category-count">24 linh kiện</div>
                </a>
            </div>
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
                <a href="products.html" class="btn btn-soft-slate btn-sm">
                    <i class="bi bi-fire text-danger me-1"></i> Bán Chạy Nhất
                </a>
                <a href="products.html" class="btn btn-soft-slate btn-sm">
                    <i class="bi bi-tag me-1"></i> Giá Tốt Nhất
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Product 1 -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="tech-card">
                    <div class="card-img-wrap">
                        <span class="badge-discount">-7%</span>
                        <span class="badge-installment">Trả góp 0%</span>
                        <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&auto=format&fit=crop&q=80" alt="MacBook Pro" style="max-height: 165px; object-fit: cover;">
                    </div>
                    <div class="p-3 d-flex flex-column flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small fw-semibold">Apple</span>
                            <div class="text-warning small d-flex align-items-center gap-1">
                                <i class="bi bi-star-fill"></i>
                                <span class="fw-bold text-dark">5.0</span>
                                <span class="text-muted" style="font-size: 0.75rem;">(18)</span>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-2">
                            <a href="detail.html" class="text-dark text-decoration-none" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8rem; line-height: 1.4;">
                                MacBook Pro 16 inch M3 Max (36GB / 1TB SSD)
                            </a>
                        </h6>
                        <div class="mb-3" style="min-height: 32px;">
                            <span class="spec-pill"><i class="bi bi-cpu text-danger"></i> M3 Max 16C</span>
                            <span class="spec-pill"><i class="bi bi-memory text-primary"></i> 36GB RAM</span>
                        </div>
                        <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                            <div>
                                <div class="price-current">89.990.000 ₫</div>
                                <div class="price-original">96.990.000 ₫</div>
                            </div>
                            <a href="cart.html" class="btn-add-cart-icon" title="Thêm vào giỏ">
                                <i class="bi bi-cart-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="tech-card">
                    <div class="card-img-wrap">
                        <span class="badge-discount">-11%</span>
                        <span class="badge-installment">Trả góp 0%</span>
                        <img src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600&auto=format&fit=crop&q=80" alt="Asus ROG" style="max-height: 165px; object-fit: cover;">
                    </div>
                    <div class="p-3 d-flex flex-column flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small fw-semibold">ASUS ROG</span>
                            <div class="text-warning small d-flex align-items-center gap-1">
                                <i class="bi bi-star-fill"></i>
                                <span class="fw-bold text-dark">4.9</span>
                                <span class="text-muted" style="font-size: 0.75rem;">(25)</span>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-2">
                            <a href="detail.html" class="text-dark text-decoration-none" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8rem; line-height: 1.4;">
                                Laptop Gaming Asus ROG Strix SCAR 18 (RTX 4090)
                            </a>
                        </h6>
                        <div class="mb-3" style="min-height: 32px;">
                            <span class="spec-pill"><i class="bi bi-cpu text-danger"></i> i9-14900HX</span>
                            <span class="spec-pill"><i class="bi bi-gpu-card text-success"></i> RTX 4090 16GB</span>
                        </div>
                        <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                            <div>
                                <div class="price-current">99.990.000 ₫</div>
                                <div class="price-original">112.000.000 ₫</div>
                            </div>
                            <a href="cart.html" class="btn-add-cart-icon" title="Thêm vào giỏ">
                                <i class="bi bi-cart-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="tech-card">
                    <div class="card-img-wrap">
                        <span class="badge-discount">-14%</span>
                        <span class="badge-installment">Trả góp 0%</span>
                        <img src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80" alt="iPhone 15 Pro Max" style="max-height: 165px; object-fit: cover;">
                    </div>
                    <div class="p-3 d-flex flex-column flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small fw-semibold">Apple</span>
                            <div class="text-warning small d-flex align-items-center gap-1">
                                <i class="bi bi-star-fill"></i>
                                <span class="fw-bold text-dark">4.9</span>
                                <span class="text-muted" style="font-size: 0.75rem;">(42)</span>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-2">
                            <a href="detail.html" class="text-dark text-decoration-none" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8rem; line-height: 1.4;">
                                iPhone 15 Pro Max 256GB Titan Tự Nhiên VN/A
                            </a>
                        </h6>
                        <div class="mb-3" style="min-height: 32px;">
                            <span class="spec-pill"><i class="bi bi-cpu text-danger"></i> A17 Pro 3nm</span>
                            <span class="spec-pill"><i class="bi bi-phone text-primary"></i> OLED 120Hz</span>
                        </div>
                        <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                            <div>
                                <div class="price-current">29.990.000 ₫</div>
                                <div class="price-original">34.990.000 ₫</div>
                            </div>
                            <a href="cart.html" class="btn-add-cart-icon" title="Thêm vào giỏ">
                                <i class="bi bi-cart-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product 4 -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="tech-card">
                    <div class="card-img-wrap">
                        <span class="badge-discount">-12%</span>
                        <span class="badge-installment">Trả góp 0%</span>
                        <img src="https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=600&auto=format&fit=crop&q=80" alt="Sony XM5" style="max-height: 165px; object-fit: cover;">
                    </div>
                    <div class="p-3 d-flex flex-column flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small fw-semibold">Sony</span>
                            <div class="text-warning small d-flex align-items-center gap-1">
                                <i class="bi bi-star-fill"></i>
                                <span class="fw-bold text-dark">4.8</span>
                                <span class="text-muted" style="font-size: 0.75rem;">(36)</span>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-2">
                            <a href="detail.html" class="text-dark text-decoration-none" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8rem; line-height: 1.4;">
                                Tai nghe chống ồn Sony WH-1000XM5 Hi-Res Audio
                            </a>
                        </h6>
                        <div class="mb-3" style="min-height: 32px;">
                            <span class="spec-pill"><i class="bi bi-soundwave text-danger"></i> Dual Chip V1+QN1</span>
                            <span class="spec-pill"><i class="bi bi-battery-charging text-success"></i> 30h Pin</span>
                        </div>
                        <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                            <div>
                                <div class="price-current">7.490.000 ₫</div>
                                <div class="price-original">8.490.000 ₫</div>
                            </div>
                            <a href="cart.html" class="btn-add-cart-icon" title="Thêm vào giỏ">
                                <i class="bi bi-cart-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rust Engine Smart Recommendation Showcase -->
    <div class="card-rust-showcase mb-5 p-4 p-md-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-10 gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge-rust-power">
                        <i class="bi bi-lightning-charge-fill"></i> RUST ENGINE RECOMMENDER
                    </span>
                    <span class="badge-rust-speed">
                        <i class="bi bi-speedometer2"></i> Latency: 0.8ms
                    </span>
                </div>
                <h3 class="fw-bold text-dark mb-1">Gợi Ý Thông Minh & Phù Hợp Nhu Cầu</h3>
                <p class="text-muted small mb-0">Thuật toán Cosine Similarity xử lý song song phân tích đặc trưng phần cứng (CPU, RAM, màn hình, phân khúc giá) tức thì.</p>
            </div>
            <a href="products.html" class="btn btn-outline-rose btn-sm">Khám phá tất cả <i class="bi bi-arrow-right ms-1"></i></a>
        </div>

        <div class="row g-3">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="tech-card bg-white">
                    <div class="card-img-wrap bg-light py-4">
                        <img src="https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=300" style="max-height: 120px; object-fit: cover;" class="rounded-3">
                    </div>
                    <div class="p-3 d-flex flex-column flex-grow-1">
                        <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small fw-semibold mb-1 w-auto d-inline-block">Apple</span>
                        <h6 class="fw-bold mb-2">
                            <a href="detail.html" class="text-dark text-decoration-none">iPad Pro 13 inch M4 (OLED)</a>
                        </h6>
                        <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                            <div class="price-current fs-6">37.990.000 ₫</div>
                            <a href="detail.html" class="btn btn-sm btn-outline-rose rounded-pill px-3">Xem</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="tech-card bg-white">
                    <div class="card-img-wrap bg-light py-4">
                        <img src="https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=300" style="max-height: 120px; object-fit: cover;" class="rounded-3">
                    </div>
                    <div class="p-3 d-flex flex-column flex-grow-1">
                        <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small fw-semibold mb-1 w-auto d-inline-block">Apple</span>
                        <h6 class="fw-bold mb-2">
                            <a href="detail.html" class="text-dark text-decoration-none">Apple Watch Ultra 2 GPS</a>
                        </h6>
                        <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                            <div class="price-current fs-6">20.990.000 ₫</div>
                            <a href="detail.html" class="btn btn-sm btn-outline-rose rounded-pill px-3">Xem</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="tech-card bg-white">
                    <div class="card-img-wrap bg-light py-4">
                        <img src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=300" style="max-height: 120px; object-fit: cover;" class="rounded-3">
                    </div>
                    <div class="p-3 d-flex flex-column flex-grow-1">
                        <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small fw-semibold mb-1 w-auto d-inline-block">ASUS</span>
                        <h6 class="fw-bold mb-2">
                            <a href="detail.html" class="text-dark text-decoration-none">ROG Zephyrus G16 OLED</a>
                        </h6>
                        <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                            <div class="price-current fs-6">54.990.000 ₫</div>
                            <a href="detail.html" class="btn btn-sm btn-outline-rose rounded-pill px-3">Xem</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="tech-card bg-white">
                    <div class="card-img-wrap bg-light py-4">
                        <img src="https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=300" style="max-height: 120px; object-fit: cover;" class="rounded-3">
                    </div>
                    <div class="p-3 d-flex flex-column flex-grow-1">
                        <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small fw-semibold mb-1 w-auto d-inline-block">Sony</span>
                        <h6 class="fw-bold mb-2">
                            <a href="detail.html" class="text-dark text-decoration-none">Sony WF-1000XM5 True Wireless</a>
                        </h6>
                        <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                            <div class="price-current fs-6">5.990.000 ₫</div>
                            <a href="detail.html" class="btn btn-sm btn-outline-rose rounded-pill px-3">Xem</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Real Showroom & Nationwide Store Experience Banner -->
    <div class="card border-0 rounded-4 p-4 p-md-5 mb-5" style="background: linear-gradient(135deg, #f8fafc 0%, #ffe4e6 50%, #f1f5f9 100%); border: 1px solid var(--border-color) !important;">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white border small text-danger fw-bold mb-2 shadow-xs">
                    <i class="bi bi-geo-alt-fill"></i> 15 Showroom Trải Nghiệm Toàn Quốc
                </div>
                <h3 class="fw-bold text-dark mb-2">Trải Nghiệm Trực Tiếp Trước Khi Quyết Định</h3>
                <p class="text-muted small mb-0" style="max-width: 620px;">
                    Quý khách có thể đến trực tiếp showroom 12B5 Store để trên tay các siêu phẩm công nghệ, kiểm tra cấu hình bằng phần mềm chuyên dụng và nhận tư vấn chuyên sâu từ đội ngũ kỹ thuật viên.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-column flex-sm-row justify-content-lg-end gap-2">
                    <a href="tel:18001235" class="btn btn-rose px-4 py-2"><i class="bi bi-telephone-fill me-1"></i> Gọi 1800.1235</a>
                    <a href="#" class="btn btn-soft-slate px-3 py-2"><i class="bi bi-map me-1"></i> Tìm Showroom</a>
                </div>
            </div>
        </div>
    </div>
</div>
"""

# ==============================================================================
# 2. GENERATE PRODUCTS (products.html)
# ==============================================================================
products_body = """
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="index.html" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tất cả thiết bị</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Sidebar Filter with Frosted Glass -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 90px; background: rgba(255, 255, 255, 0.88); backdrop-filter: blur(16px); border: 1px solid var(--border-color) !important;">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-funnel-fill me-2 text-danger"></i>Bộ Lọc Thiết Bị</h5>
                    <a href="products.html" class="text-danger small fw-semibold text-decoration-none">Xóa bộ lọc</a>
                </div>
                
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Danh mục</label>
                    <div class="d-flex flex-column gap-2 small">
                        <div class="form-check"><input class="form-check-input" type="radio" name="c" checked> <label class="form-check-label fw-medium">Tất cả danh mục (24)</label></div>
                        <div class="form-check"><input class="form-check-input" type="radio" name="c"> <label class="form-check-label fw-medium">Laptops & MacBooks (12)</label></div>
                        <div class="form-check"><input class="form-check-input" type="radio" name="c"> <label class="form-check-label fw-medium">Smartphones Flagship (18)</label></div>
                        <div class="form-check"><input class="form-check-input" type="radio" name="c"> <label class="form-check-label fw-medium">Máy tính bảng iPad (8)</label></div>
                        <div class="form-check"><input class="form-check-input" type="radio" name="c"> <label class="form-check-label fw-medium">Tai nghe & Âm thanh (15)</label></div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Thương hiệu</label>
                    <div class="d-flex flex-column gap-2 small">
                        <div class="form-check"><input class="form-check-input" type="checkbox" checked> <label class="form-check-label fw-medium">Apple (8)</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox" checked> <label class="form-check-label fw-medium">ASUS ROG (5)</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox"> <label class="form-check-label fw-medium">Sony (4)</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox"> <label class="form-check-label fw-medium">Samsung (6)</label></div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Khoảng giá (VNĐ)</label>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><input type="text" class="form-control form-control-sm rounded-3" value="5.000.000"></div>
                        <div class="col-6"><input type="text" class="form-control form-control-sm rounded-3" value="100.000.000"></div>
                    </div>
                    <button class="btn btn-rose btn-sm w-100 mt-2">Áp dụng giá</button>
                </div>

                <!-- Support box -->
                <div class="p-3 bg-light rounded-3 small text-muted border">
                    <div class="fw-bold text-dark mb-1"><i class="bi bi-headset text-danger me-1"></i> Cần tư vấn chọn máy?</div>
                    <p class="mb-2" style="font-size: 0.78rem;">Đội ngũ kỹ thuật viên 12B5 Store hỗ trợ kiểm tra cấu hình phù hợp nhu cầu.</p>
                    <a href="tel:18001235" class="btn btn-sm btn-outline-dark w-100 rounded-pill"><i class="bi bi-telephone me-1"></i> 1800.1235 (Miễn phí)</a>
                </div>
            </div>
        </div>

        <!-- Product Grid Main -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4 p-3 mb-4" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(16px); border: 1px solid var(--border-color) !important;">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">Tất Cả Thiết Bị Công Nghệ</h4>
                        <div class="small text-muted d-flex align-items-center gap-2">
                            <span>Hiển thị <strong>8</strong> sản phẩm</span>
                            <span class="badge bg-warning text-dark rounded-pill">
                                <i class="bi bi-cpu-fill"></i> ⚡ Rust Fuzzy Search (0.8ms)
                            </span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="small text-muted text-nowrap fw-semibold">Sắp xếp:</span>
                        <select class="form-select form-select-sm rounded-pill px-3 shadow-none border-secondary-subtle">
                            <option>Mới nhất</option>
                            <option>Giá: Cao đến thấp</option>
                            <option>Giá: Thấp đến cao</option>
                            <option>Bán chạy nhất</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <!-- Product 1 -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="tech-card">
                        <div class="card-img-wrap">
                            <span class="badge-discount">-7%</span>
                            <span class="badge-installment">Trả góp 0%</span>
                            <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500" style="max-height: 165px; object-fit: cover;">
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small fw-semibold mb-1 w-auto d-inline-block">Apple &bull; Laptop</span>
                            <h6 class="fw-bold mb-2">
                                <a href="detail.html" class="text-dark text-decoration-none">MacBook Pro 16" M3 Max (36GB / 1TB)</a>
                            </h6>
                            <div class="mb-3">
                                <span class="spec-pill"><i class="bi bi-cpu text-danger"></i> M3 Max 16C</span>
                                <span class="spec-pill"><i class="bi bi-memory text-primary"></i> 36GB RAM</span>
                            </div>
                            <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                <div class="price-current">89.990.000 ₫</div>
                                <a href="detail.html" class="btn btn-sm btn-outline-rose rounded-pill px-3">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="tech-card">
                        <div class="card-img-wrap">
                            <span class="badge-discount">-11%</span>
                            <span class="badge-installment">Trả góp 0%</span>
                            <img src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=500" style="max-height: 165px; object-fit: cover;">
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small fw-semibold mb-1 w-auto d-inline-block">ASUS &bull; Gaming</span>
                            <h6 class="fw-bold mb-2">
                                <a href="detail.html" class="text-dark text-decoration-none">Asus ROG Strix SCAR 18 (RTX 4090)</a>
                            </h6>
                            <div class="mb-3">
                                <span class="spec-pill"><i class="bi bi-cpu text-danger"></i> i9-14900HX</span>
                                <span class="spec-pill"><i class="bi bi-gpu-card text-success"></i> RTX 4090</span>
                            </div>
                            <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                <div class="price-current">99.990.000 ₫</div>
                                <a href="detail.html" class="btn btn-sm btn-outline-rose rounded-pill px-3">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="tech-card">
                        <div class="card-img-wrap">
                            <span class="badge-discount">-14%</span>
                            <span class="badge-installment">Trả góp 0%</span>
                            <img src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=500" style="max-height: 165px; object-fit: cover;">
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small fw-semibold mb-1 w-auto d-inline-block">Apple &bull; Phone</span>
                            <h6 class="fw-bold mb-2">
                                <a href="detail.html" class="text-dark text-decoration-none">iPhone 15 Pro Max 256GB Titan</a>
                            </h6>
                            <div class="mb-3">
                                <span class="spec-pill"><i class="bi bi-cpu text-danger"></i> A17 Pro</span>
                                <span class="spec-pill"><i class="bi bi-phone text-primary"></i> OLED 120Hz</span>
                            </div>
                            <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                <div class="price-current">29.990.000 ₫</div>
                                <a href="detail.html" class="btn btn-sm btn-outline-rose rounded-pill px-3">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="tech-card">
                        <div class="card-img-wrap">
                            <span class="badge-discount">-12%</span>
                            <span class="badge-installment">Trả góp 0%</span>
                            <img src="https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=500" style="max-height: 165px; object-fit: cover;">
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small fw-semibold mb-1 w-auto d-inline-block">Sony &bull; Audio</span>
                            <h6 class="fw-bold mb-2">
                                <a href="detail.html" class="text-dark text-decoration-none">Sony WH-1000XM5 Hi-Res Audio</a>
                            </h6>
                            <div class="mb-3">
                                <span class="spec-pill"><i class="bi bi-soundwave text-danger"></i> Chip V1+QN1</span>
                                <span class="spec-pill"><i class="bi bi-battery text-success"></i> 30h Pin</span>
                            </div>
                            <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                <div class="price-current">7.490.000 ₫</div>
                                <a href="detail.html" class="btn btn-sm btn-outline-rose rounded-pill px-3">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 5 -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="tech-card">
                        <div class="card-img-wrap">
                            <span class="badge-discount">-6%</span>
                            <span class="badge-installment">Trả góp 0%</span>
                            <img src="https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=500" style="max-height: 165px; object-fit: cover;">
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small fw-semibold mb-1 w-auto d-inline-block">Apple &bull; Tablet</span>
                            <h6 class="fw-bold mb-2">
                                <a href="detail.html" class="text-dark text-decoration-none">iPad Pro 13 inch M4 (Ultra OLED)</a>
                            </h6>
                            <div class="mb-3">
                                <span class="spec-pill"><i class="bi bi-cpu text-danger"></i> Chip M4</span>
                                <span class="spec-pill"><i class="bi bi-tv text-primary"></i> Tandem OLED</span>
                            </div>
                            <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                <div class="price-current">37.990.000 ₫</div>
                                <a href="detail.html" class="btn btn-sm btn-outline-rose rounded-pill px-3">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 6 -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="tech-card">
                        <div class="card-img-wrap">
                            <span class="badge-discount">-5%</span>
                            <span class="badge-installment">Trả góp 0%</span>
                            <img src="https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=500" style="max-height: 165px; object-fit: cover;">
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small fw-semibold mb-1 w-auto d-inline-block">Apple &bull; Smartwatch</span>
                            <h6 class="fw-bold mb-2">
                                <a href="detail.html" class="text-dark text-decoration-none">Apple Watch Ultra 2 GPS + Cellular</a>
                            </h6>
                            <div class="mb-3">
                                <span class="spec-pill"><i class="bi bi-activity text-danger"></i> ECG + SpO2</span>
                                <span class="spec-pill"><i class="bi bi-shield text-primary"></i> Titan 49mm</span>
                            </div>
                            <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                <div class="price-current">20.990.000 ₫</div>
                                <a href="detail.html" class="btn btn-sm btn-outline-rose rounded-pill px-3">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
"""

# ==============================================================================
# 3. GENERATE DETAIL (detail.html)
# ==============================================================================
detail_body = """
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="index.html" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="products.html" class="text-decoration-none">Laptop & PC</a></li>
            <li class="breadcrumb-item active" aria-current="page">MacBook Pro 16 inch M3 Max</li>
        </ol>
    </nav>

    <div class="row g-4 mb-5">
        <!-- Gallery Showcase -->
        <div class="col-lg-5">
            <div class="detail-gallery-card h-100 d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-center w-100 mb-3">
                    <span class="detail-gallery-badge position-static">
                        <i class="bi bi-patch-check-fill me-1"></i> Chính Hãng Apple VN/A
                    </span>
                    <span class="badge bg-light text-muted border rounded-pill px-3 py-1 small">
                        Bảo hành 24 Tháng VIP
                    </span>
                </div>

                <div class="py-3 text-center my-auto">
                    <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=800" class="img-fluid rounded-4 shadow-sm" style="max-height: 280px; object-fit: cover;">
                </div>

                <div class="p-3 bg-light rounded-4 border w-100 text-muted small mt-4">
                    <div class="row g-2 text-center" style="font-size: 0.78rem;">
                        <div class="col-4 border-end">
                            <i class="bi bi-box-seam text-danger d-block fs-6 mb-1"></i>
                            <span>Nguyên Seal VAT</span>
                        </div>
                        <div class="col-4 border-end">
                            <i class="bi bi-arrow-repeat text-success d-block fs-6 mb-1"></i>
                            <span>1 Đổi 1 (30 ngày)</span>
                        </div>
                        <div class="col-4">
                            <i class="bi bi-truck text-primary d-block fs-6 mb-1"></i>
                            <span>Hỏa tốc 2 giờ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Purchase Information -->
        <div class="col-lg-7">
            <div class="detail-info-card">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-light text-muted border rounded-pill px-3 py-1 small fw-bold">Apple</span>
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1 small fw-bold">Laptop Flagship</span>
                    </div>
                    <span class="text-muted small">Mã SKU: <strong class="text-dark font-monospace">MBP16-M3MAX-1TB</strong></span>
                </div>

                <h2 class="fw-bold mb-2 text-dark">MacBook Pro 16 inch M3 Max (36GB RAM / 1TB SSD Space Black)</h2>

                <div class="d-flex flex-wrap align-items-center gap-3 mb-3 pb-2 border-bottom">
                    <div class="text-warning small d-flex align-items-center gap-1">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <span class="fw-bold text-dark ms-1">5.0/5.0</span>
                    </div>
                    <span class="text-muted small">(18 đánh giá chuyên sâu)</span>
                    <span class="text-muted small">&bull;</span>
                    <span class="text-success small fw-semibold"><i class="bi bi-bag-check-fill me-1"></i> Đã bán 28 máy</span>
                </div>

                <!-- Price Box -->
                <div class="p-3 rounded-4 mb-4 d-flex flex-wrap align-items-baseline gap-3" style="background: linear-gradient(135deg, #fff1f2 0%, #fdf2f8 100%); border: 1px solid var(--accent-rose-border);">
                    <span class="fs-2 fw-extrabold text-danger">89.990.000 ₫</span>
                    <span class="text-muted text-decoration-line-through fs-5">96.990.000 ₫</span>
                    <span class="badge bg-danger rounded-pill px-3 py-1 small fw-bold">Tiết kiệm 7.000.000₫</span>
                    <span class="text-muted small ms-auto d-none d-sm-inline"><i class="bi bi-credit-card text-primary me-1"></i> Trả góp 0% chỉ từ <strong>7.499.000₫/tháng</strong></span>
                </div>

                <!-- Variant Buttons -->
                <div class="mb-3">
                    <label class="fw-bold small text-uppercase text-muted d-block mb-2 tracking-wider">Phiên Bản Bộ Nhớ RAM & SSD:</label>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="variant-btn active">
                            <span>36GB / 1TB</span>
                            <span class="variant-subtext">Tiêu chuẩn</span>
                        </button>
                        <button type="button" class="variant-btn">
                            <span>48GB / 1TB</span>
                            <span class="variant-subtext">+12.000.000₫</span>
                        </button>
                        <button type="button" class="variant-btn">
                            <span>128GB / 2TB</span>
                            <span class="variant-subtext">+35.000.000₫</span>
                        </button>
                    </div>
                </div>

                <!-- Color Selection -->
                <div class="mb-4">
                    <label class="fw-bold small text-uppercase text-muted d-block mb-2 tracking-wider">Màu Sắc Thiết Bị:</label>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="color-option-btn active">
                            <span class="color-circle" style="background-color: #1e293b;"></span> Space Black (Đen Không Gian)
                        </button>
                        <button type="button" class="color-option-btn">
                            <span class="color-circle" style="background-color: #cbd5e1;"></span> Silver (Bạc Ánh Kim)
                        </button>
                    </div>
                </div>

                <!-- Promotional Gift Box -->
                <div class="promo-gift-box mb-4">
                    <div class="d-flex align-items-center gap-2 fw-bold text-danger mb-2 small">
                        <i class="bi bi-gift-fill"></i> ƯU ĐÃI ĐẶC QUYỀN KHI MUA TẠI 12B5 STORE:
                    </div>
                    <ul class="list-unstyled mb-0 small text-muted d-flex flex-column gap-1">
                        <li><i class="bi bi-check2-circle text-success me-2"></i> Tặng túi chống sốc Tucano Milan chính hãng trị giá <strong>890.000₫</strong></li>
                        <li><i class="bi bi-check2-circle text-success me-2"></i> Giảm thêm <strong>500.000₫</strong> khi thanh toán quét mã VietQR tự động</li>
                        <li><i class="bi bi-check2-circle text-success me-2"></i> Hỗ trợ thu cũ đổi mới (Trade-in) trợ giá lên tới <strong>2.500.000₫</strong></li>
                        <li><i class="bi bi-check2-circle text-success me-2"></i> Vệ sinh tra keo tản nhiệt và cài đặt phần mềm chuyên nghiệp miễn phí trọn đời</li>
                    </ul>
                </div>

                <!-- Form Controls -->
                <div class="d-flex align-items-center gap-3 mb-4">
                    <label class="fw-bold small text-muted text-uppercase mb-0 tracking-wider">Số Lượng:</label>
                    <div class="input-group" style="max-width: 140px;">
                        <button class="btn btn-outline-secondary rounded-start-pill" type="button">-</button>
                        <input type="number" class="form-control text-center font-monospace fw-bold" value="1" min="1">
                        <button class="btn btn-outline-secondary rounded-end-pill" type="button">+</button>
                    </div>
                    <span class="small text-success">
                        <i class="bi bi-check-circle-fill me-1"></i> Còn hàng tại 15 showroom (12 máy sẵn sàng)
                    </span>
                </div>

                <div class="d-flex gap-3">
                    <a href="cart.html" class="btn btn-rose btn-lg px-4 flex-grow-1 fw-bold shadow-sm">
                        <i class="bi bi-cart-plus me-2"></i> Thêm Vào Giỏ Hàng
                    </a>
                    <a href="checkout.html" class="btn btn-soft-slate btn-lg px-4 fw-bold">
                        <i class="bi bi-lightning-charge text-danger me-1"></i> Mua Ngay
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Specifications Table -->
    <div class="row g-4 mb-5">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h4 class="fw-bold mb-3 text-dark"><i class="bi bi-file-earmark-text me-2 text-danger"></i>Mô Tả & Trải Nghiệm Thiết Bị</h4>
                <div class="text-secondary lh-lg" style="font-size: 0.95rem;">
                    MacBook Pro 16 inch M3 Max mang lại sức mạnh vượt trội cho các kỹ sư phần mềm, nhà sáng tạo nội dung 3D và các chuyên gia đồ họa. Được trang bị chip Apple Silicon M3 Max tiến trình 3nm với 16-Core CPU và 40-Core GPU Metal 3, hệ thống xử lý các mô hình AI lớn và render video 8K ProRes mà vẫn duy trì thời lượng pin ấn tượng lên đến 22 giờ liên tục.
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h4 class="fw-bold mb-3 text-dark"><i class="bi bi-cpu me-2 text-danger"></i>Thông Số Kỹ Thuật Đa Chiều</h4>
                <table class="table table-striped table-hover small mb-0 align-middle">
                    <tbody>
                        <tr><th class="text-muted fw-semibold text-uppercase" style="width: 38%;">Vi xử lý (CPU)</th><td class="fw-semibold text-dark">Apple M3 Max 16-Core (12 Performance + 4 Efficiency)</td></tr>
                        <tr><th class="text-muted fw-semibold text-uppercase">Card đồ họa (GPU)</th><td class="fw-semibold text-dark">40-Core GPU Metal 3 Ray Tracing phần cứng</td></tr>
                        <tr><th class="text-muted fw-semibold text-uppercase">Bộ nhớ RAM</th><td class="fw-semibold text-dark">36GB Unified Memory (300GB/s bandwidth)</td></tr>
                        <tr><th class="text-muted fw-semibold text-uppercase">Ổ cứng SSD</th><td class="fw-semibold text-dark">1TB PCIe Gen4 NVMe Siêu Tốc (7.4GB/s)</td></tr>
                        <tr><th class="text-muted fw-semibold text-uppercase">Màn hình</th><td class="fw-semibold text-dark">16.2" Liquid Retina XDR Mini-LED 120Hz ProMotion 1600 nits</td></tr>
                        <tr><th class="text-muted fw-semibold text-uppercase">Cổng kết nối</th><td class="fw-semibold text-dark">3x Thunderbolt 4, HDMI 2.1, SDXC Card, MagSafe 3</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
"""

# ==============================================================================
# 4. GENERATE CART (cart.html)
# ==============================================================================
cart_body = """
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="index.html" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Giỏ hàng của bạn</li>
        </ol>
    </nav>

    <!-- Free Shipping Milestone Progress Bar -->
    <div class="p-3 mb-4 rounded-4" style="background: linear-gradient(135deg, #fff1f2 0%, #f0fdf4 100%); border: 1px solid var(--accent-rose-border);">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="small fw-bold text-dark">
                <i class="bi bi-truck text-danger me-1"></i> Miễn phí vận chuyển hỏa tốc 2 giờ toàn quốc cho đơn hàng từ 5.000.000₫
            </span>
            <span class="badge bg-success rounded-pill px-3 py-1 small">
                Đủ điều kiện Freeship
            </span>
        </div>
        <div class="progress" style="height: 7px; border-radius: 9999px;">
            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-dark"><i class="bi bi-cart3 me-2 text-danger"></i>Giỏ Hàng Công Nghệ (2 thiết bị)</h3>
        <a href="products.html" class="btn btn-soft-slate btn-sm"><i class="bi bi-arrow-left me-1"></i> Tiếp tục mua sắm</a>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="border: 1px solid var(--border-color) !important;">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light text-muted small text-uppercase">
                            <tr>
                                <th style="font-size: 0.75rem;">Sản phẩm</th>
                                <th style="font-size: 0.75rem;">Đơn giá</th>
                                <th style="font-size: 0.75rem; width: 140px;">Số lượng</th>
                                <th style="font-size: 0.75rem;">Thành tiền</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=150" class="rounded-3 border p-1" width="56" height="56" style="object-fit:cover;">
                                        <div>
                                            <h6 class="fw-bold mb-0 small">MacBook Pro 16" M3 Max</h6>
                                            <div class="text-muted small">Apple &bull; 36GB / 1TB SSD &bull; Space Black</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="fw-semibold small text-dark">89.990.000 ₫</td>
                                <td>
                                    <div class="input-group input-group-sm" style="width: 105px;">
                                        <button class="btn btn-outline-secondary rounded-start-pill">-</button>
                                        <input type="number" class="form-control text-center font-monospace fw-bold" value="1" readonly>
                                        <button class="btn btn-outline-secondary rounded-end-pill">+</button>
                                    </div>
                                </td>
                                <td class="fw-bold text-danger small">89.990.000 ₫</td>
                                <td class="text-end"><button class="btn btn-sm text-danger border-0 bg-transparent"><i class="bi bi-trash3 fs-5"></i></button></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=150" class="rounded-3 border p-1" width="56" height="56" style="object-fit:cover;">
                                        <div>
                                            <h6 class="fw-bold mb-0 small">Tai nghe Sony WH-1000XM5</h6>
                                            <div class="text-muted small">Sony &bull; Chống ồn chủ động Hi-Res</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="fw-semibold small text-dark">7.490.000 ₫</td>
                                <td>
                                    <div class="input-group input-group-sm" style="width: 105px;">
                                        <button class="btn btn-outline-secondary rounded-start-pill">-</button>
                                        <input type="number" class="form-control text-center font-monospace fw-bold" value="1" readonly>
                                        <button class="btn btn-outline-secondary rounded-end-pill">+</button>
                                    </div>
                                </td>
                                <td class="fw-bold text-danger small">7.490.000 ₫</td>
                                <td class="text-end"><button class="btn btn-sm text-danger border-0 bg-transparent"><i class="bi bi-trash3 fs-5"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-3 border-top text-muted small">
                    <div><i class="bi bi-shield-check text-success me-1"></i> Bảo hành chính hãng & Bao đổi trả 30 ngày</div>
                    <div><i class="bi bi-qr-code-scan text-primary me-1"></i> Hỗ trợ quét mã VietQR tự động</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Coupon Box -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" style="border: 1px solid var(--border-color) !important;">
                <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-ticket-perforated-fill me-2 text-danger"></i>Mã Ưu Đãi / Khuyến Mãi</h6>
                <div class="input-group mb-2">
                    <input type="text" class="form-control form-control-sm rounded-start-pill text-uppercase font-monospace" value="12B5TECH500">
                    <button class="btn btn-rose btn-sm rounded-end-pill px-3">Áp Dụng</button>
                </div>
                <div class="alert alert-success d-flex justify-content-between align-items-center mb-0 p-2 rounded-3 small">
                    <span><i class="bi bi-check-circle-fill me-1"></i> Đã giảm <strong>500.000 ₫</strong> (12B5TECH500)</span>
                    <button class="btn btn-link btn-sm text-danger p-0"><i class="bi bi-x-circle-fill"></i></button>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="border: 1px solid var(--border-color) !important;">
                <h6 class="fw-bold mb-3 text-dark">Tóm Tắt Đơn Hàng</h6>
                <div class="d-flex justify-content-between small mb-2">
                    <span class="text-muted">Tổng tiền hàng:</span>
                    <span class="fw-semibold text-dark">97.480.000 ₫</span>
                </div>
                <div class="d-flex justify-content-between small mb-2 text-success">
                    <span>Giảm giá Voucher:</span>
                    <span class="fw-bold">-500.000 ₫</span>
                </div>
                <div class="d-flex justify-content-between small mb-3">
                    <span class="text-muted">Phí giao hàng:</span>
                    <span class="text-success fw-semibold">Miễn phí (Freeship)</span>
                </div>
                <div class="border-top pt-3 mb-4 d-flex justify-content-between align-items-baseline">
                    <span class="fw-bold text-dark fs-6">Tổng thanh toán:</span>
                    <span class="fs-4 fw-extrabold text-danger">96.980.000 ₫</span>
                </div>
                <a href="checkout.html" class="btn btn-rose w-100 py-2 fw-bold shadow-sm mb-2">
                    Tiến Hành Đặt Hàng & Thanh Toán <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
"""

# ==============================================================================
# 5. GENERATE CHECKOUT (checkout.html)
# ==============================================================================
checkout_body = """
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="index.html" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="cart.html" class="text-decoration-none">Giỏ hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thanh toán đơn hàng</li>
        </ol>
    </nav>

    <!-- 3-Step Stepper -->
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white" style="border: 1px solid var(--border-color) !important;">
        <div class="row text-center g-2 small">
            <div class="col-4">
                <div class="p-2 rounded-3 bg-light text-muted">
                    <i class="bi bi-cart-check-fill text-success me-1"></i> 1. Giỏ Hàng
                </div>
            </div>
            <div class="col-4">
                <div class="p-2 rounded-3 fw-bold text-danger" style="background: var(--accent-rose-subtle); border: 1px solid var(--accent-rose-border);">
                    <i class="bi bi-geo-alt-fill me-1"></i> 2. Thông Tin & Thanh Toán
                </div>
            </div>
            <div class="col-4">
                <div class="p-2 rounded-3 bg-light text-muted">
                    <i class="bi bi-check-circle me-1"></i> 3. Hoàn Tất Đơn Hàng
                </div>
            </div>
        </div>
    </div>

    <h3 class="fw-bold mb-4 text-dark"><i class="bi bi-credit-card-2-front me-2 text-danger"></i>Đặt Hàng & Thanh Toán Trực Tuyến</h3>

    <div class="row g-4 mb-5">
        <div class="col-lg-7">
            <!-- 1. Customer Shipping Details -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" style="border: 1px solid var(--border-color) !important;">
                <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-geo-alt-fill me-2 text-danger"></i>1. Địa Chỉ Nhận Hàng</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Họ và tên người nhận *</label>
                        <input type="text" class="form-control rounded-3" value="Nguyễn Văn A">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Số điện thoại liên hệ *</label>
                        <input type="tel" class="form-control rounded-3" value="0987654321">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Email nhận hóa đơn VAT *</label>
                        <input type="email" class="form-control rounded-3" value="nguyenvana@gmail.com">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Địa chỉ chi tiết nhận thiết bị *</label>
                        <textarea class="form-control rounded-3" rows="2">123 Đường Công Nghệ, Phường 10, Quận 1, TP. Hồ Chí Minh</textarea>
                    </div>
                </div>
            </div>

            <!-- 2. Payment Method -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" style="border: 1px solid var(--border-color) !important;">
                <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-wallet2 me-2 text-danger"></i>2. Phương Thức Thanh Toán</h5>
                <div class="d-flex flex-column gap-3 mb-3">
                    <label class="p-3 rounded-4 border d-flex align-items-center gap-3 cursor-pointer" style="background: #fff1f2; border-color: var(--accent-rose-border) !important;">
                        <input class="form-check-input mt-0" type="radio" name="pay" checked>
                        <div class="p-2 rounded-3 bg-danger bg-opacity-10 text-danger fs-4"><i class="bi bi-qr-code-scan"></i></div>
                        <div>
                            <div class="fw-bold small text-danger">Chuyển khoản VietQR NAPAS 247 (Khớp Lệnh Tự Động 100%)</div>
                            <div class="text-muted small">Quét mã bằng app ngân hàng bất kỳ. Hệ thống xác nhận đơn ngay lập tức.</div>
                        </div>
                    </label>

                    <label class="p-3 rounded-4 border d-flex align-items-center gap-3 cursor-pointer" style="background: #f8fafc;">
                        <input class="form-check-input mt-0" type="radio" name="pay">
                        <div class="p-2 rounded-3 bg-success bg-opacity-10 text-success fs-4"><i class="bi bi-cash-coin"></i></div>
                        <div>
                            <div class="fw-bold small text-dark">Thanh toán tiền mặt khi nhận hàng (COD)</div>
                            <div class="text-muted small">Được mở hộp đồng kiểm thiết bị cùng bưu tá trước khi thanh toán.</div>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <!-- Dynamic VietQR Napas Card -->
            <div class="vietqr-card mb-4">
                <div class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1 fw-bold small mb-2">
                    <i class="bi bi-patch-check-fill"></i> VietQR Napas 247 Chuẩn Quốc Gia
                </div>
                <h6 class="fw-bold text-dark mb-1">Mã QR Thanh Toán Tự Động</h6>
                <p class="text-muted small mb-3">Mở app Mobile Banking bất kỳ để quét mã chuyển khoản:</p>

                <div class="vietqr-image-container">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=00020101021238540010A00000072701240006970422011001234567890208QRIBFTTA53037045408969800005802VN62210817DH2026091712B56304" alt="VietQR" class="img-fluid">
                </div>

                <div class="bank-detail-box">
                    <div class="bank-copy-row">
                        <span class="text-muted">Ngân hàng thụ hưởng:</span>
                        <strong class="text-dark">MBBank (Ngân Hàng Quân Đội)</strong>
                    </div>
                    <div class="bank-copy-row">
                        <span class="text-muted">Số tài khoản:</span>
                        <div>
                            <strong class="font-monospace text-primary">0901234567</strong>
                            <button type="button" class="btn-copy-code ms-1" onclick="navigator.clipboard.writeText('0901234567'); alert('Đã sao chép số tài khoản MBBank!');">Sao chép</button>
                        </div>
                    </div>
                    <div class="bank-copy-row">
                        <span class="text-muted">Chủ tài khoản:</span>
                        <strong class="text-dark">CONG TY CONG NGHE 12B5 STORE</strong>
                    </div>
                    <div class="bank-copy-row">
                        <span class="text-muted">Số tiền thanh toán:</span>
                        <strong class="text-danger fw-bold">96.980.000 ₫</strong>
                    </div>
                    <div class="bank-copy-row">
                        <span class="text-muted">Nội dung chuyển khoản:</span>
                        <div>
                            <strong class="font-monospace text-dark">DH982743</strong>
                            <button type="button" class="btn-copy-code ms-1" onclick="navigator.clipboard.writeText('DH982743'); alert('Đã sao chép cú pháp!');">Sao chép</button>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <a href="success.html" class="btn btn-rose btn-lg fw-bold text-white shadow-sm"><i class="bi bi-check2-circle me-2"></i> Xác Nhận Đã Chuyển Khoản & Hoàn Tất Đơn</a>
                    <a href="cart.html" class="btn btn-soft-slate btn-sm">Quay lại giỏ hàng</a>
                </div>
            </div>
        </div>
    </div>
</div>
"""

# ==============================================================================
# 6. GENERATE ADMIN (admin.html)
# ==============================================================================
admin_body = """
<div class="container-fluid px-lg-5 px-3">
    <!-- Admin Top Nav -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-danger rounded-pill px-3 py-1 small fw-bold">ADMIN CONSOLE</span>
                <h3 class="fw-bold mb-0 text-dark"><i class="bi bi-speedometer2 me-2 text-danger"></i>Hệ Thống Quản Trị 12B5 Store</h3>
            </div>
            <span class="text-muted small">Trung tâm điều hành kinh doanh & giám sát hiệu năng kiến trúc Hybrid PHP + Rust Microservice</span>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <span class="badge bg-success rounded-pill px-3 py-2 d-flex align-items-center"><i class="bi bi-cpu-fill me-1"></i> Microservice Online</span>
            <button class="btn btn-rose btn-sm"><i class="bi bi-plus-lg me-1"></i> Thêm Thiết Bị Mới</button>
            <button class="btn btn-soft-slate btn-sm"><i class="bi bi-arrow-clockwise me-1"></i> Làm Mới</button>
        </div>
    </div>

    <!-- Rust Engine Microservice Health Banner -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.98) 100%);">
        <div class="card-body p-4 text-white">
            <div class="row align-items-center g-3">
                <div class="col-md-8">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <span class="badge bg-success rounded-pill px-3 py-1 text-uppercase fw-bold">
                            <i class="bi bi-cpu-fill me-1"></i> RUST ENGINE ONLINE
                        </span>
                        <span class="badge bg-white bg-opacity-10 text-light border border-white border-opacity-25 rounded-pill px-3 py-1">Port 5000</span>
                        <span class="badge bg-danger rounded-pill px-3 py-1">Độ trễ: 0.8ms</span>
                    </div>
                    <h5 class="fw-bold mb-1 text-white">Kiến Trúc Hybrid Microservice High-Performance</h5>
                    <p class="text-white-50 small mb-0">
                        Rust Engine đảm nhận các tác vụ nặng: Thuật toán tìm kiếm chuỗi mờ Fuzzy TF-IDF, Gợi ý sản phẩm Cosine Similarity, Phân tích dữ liệu Pareto ABC và Dự báo doanh thu bằng Hồi quy tuyến tính (Linear Regression).
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="p-3 bg-white bg-opacity-10 rounded-4 d-inline-block text-start border border-white border-opacity-10">
                        <div class="text-white-50 small">Trạng thái kết nối REST API:</div>
                        <div class="fw-bold text-success fs-6"><i class="bi bi-check-circle-fill me-1"></i> Microservice Active (200 OK)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100" style="border: 1px solid var(--border-color) !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Tổng Doanh Thu</span>
                    <div class="p-2 rounded-3 bg-success bg-opacity-10 text-success fs-5"><i class="bi bi-currency-dollar"></i></div>
                </div>
                <h4 class="fw-bold text-success mb-1">348.500.000 ₫</h4>
                <span class="badge bg-success bg-opacity-10 text-success small"><i class="bi bi-arrow-up"></i> +18.4% so với kỳ trước</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100" style="border: 1px solid var(--border-color) !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Dự Báo Doanh Thu (Rust)</span>
                    <div class="p-2 rounded-3 bg-danger bg-opacity-10 text-danger fs-5"><i class="bi bi-graph-up-arrow"></i></div>
                </div>
                <h4 class="fw-bold text-danger mb-1">392.400.000 ₫</h4>
                <span class="text-muted small">Dự báo chu kỳ kế tiếp (Hồi quy R²=0.96)</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100" style="border: 1px solid var(--border-color) !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Tổng Đơn Hàng</span>
                    <div class="p-2 rounded-3 bg-primary bg-opacity-10 text-primary fs-5"><i class="bi bi-bag-check"></i></div>
                </div>
                <h4 class="fw-bold mb-1 text-dark">124 đơn</h4>
                <span class="text-muted small">98% đơn đã giao thành công</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100" style="border: 1px solid var(--border-color) !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Kho Hàng & Khách Hàng</span>
                    <div class="p-2 rounded-3 bg-info bg-opacity-10 text-info fs-5"><i class="bi bi-people"></i></div>
                </div>
                <h4 class="fw-bold mb-1 text-dark">48 SP / 856 Users</h4>
                <span class="text-muted small">100% có thông số JSON đa chiều</span>
            </div>
        </div>
    </div>

    <!-- Rust Pareto ABC Analysis & Recent Orders -->
    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100" style="border: 1px solid var(--border-color) !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pie-chart-fill me-2 text-danger"></i>Phân Tích Tồn Kho Pareto 80/20</h5>
                    <span class="badge bg-danger rounded-pill px-3 py-1 small">Rust Analytics</span>
                </div>
                <p class="text-muted small">
                    Thuật toán phân loại nhóm hàng tồn kho theo nguyên lý Pareto: <strong>Nhóm A</strong> (70% giá trị - Flagship), <strong>Nhóm B</strong> (20% giá trị - Tầm trung), <strong>Nhóm C</strong> (10% - Phụ kiện).
                </p>

                <div class="row g-3 text-center my-3">
                    <div class="col-4">
                        <div class="p-3 rounded-4 border" style="background: #fff1f2; border-color: var(--accent-rose-border) !important;">
                            <div class="badge bg-danger rounded-pill mb-1 small">Nhóm A (Flagship)</div>
                            <div class="fs-4 fw-bold text-danger">4</div>
                            <span class="text-muted small">SP chủ lực (70%)</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded-4 border" style="background: #f0fdf4; border-color: #bbf7d0 !important;">
                            <div class="badge bg-success rounded-pill mb-1 small">Nhóm B (Tầm trung)</div>
                            <div class="fs-4 fw-bold text-success">6</div>
                            <span class="text-muted small">SP phụ trợ (20%)</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded-4 border" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                            <div class="badge bg-secondary rounded-pill mb-1 small">Nhóm C (Phổ thông)</div>
                            <div class="fs-4 fw-bold text-secondary">14</div>
                            <span class="text-muted small">Phụ kiện kèm (10%)</span>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold small mb-2 text-dark">Top Thiết Bị Đóng Góp Doanh Số Cao Nhất:</h6>
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-bottom">
                        <span class="fw-semibold text-dark">MacBook Pro 16" M3 Max</span>
                        <span class="text-danger fw-bold">179.980.000 ₫ (51.6%)</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-bottom">
                        <span class="fw-semibold text-dark">Asus ROG Strix SCAR 18</span>
                        <span class="text-danger fw-bold">99.990.000 ₫ (28.7%)</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-bottom">
                        <span class="fw-semibold text-dark">iPhone 15 Pro Max 256GB</span>
                        <span class="text-dark fw-bold">45.000.000 ₫ (12.9%)</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100" style="border: 1px solid var(--border-color) !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-clock-history me-2 text-primary"></i>Đơn Hàng Gần Đây</h5>
                    <button class="btn btn-soft-slate btn-sm">Xem tất cả &rarr;</button>
                </div>

                <div class="table-responsive">
                    <table class="table small align-middle mb-0">
                        <thead class="table-light text-muted">
                            <tr>
                                <th>Mã Đơn</th>
                                <th>Khách Hàng</th>
                                <th>Tổng Tiền</th>
                                <th>Trạng Thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold font-monospace text-primary">ORD-2026-001</td>
                                <td class="fw-medium text-dark">Trần Minh Hoàng</td>
                                <td class="fw-bold text-danger">89.990.000 ₫</td>
                                <td><span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-1">Đã Hoàn Thành</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold font-monospace text-primary">ORD-2026-002</td>
                                <td class="fw-medium text-dark">Lê Thị Mai Anh</td>
                                <td class="fw-bold text-danger">29.990.000 ₫</td>
                                <td><span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 rounded-pill px-2 py-1">Đang Giao Hỏa Tốc</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold font-monospace text-primary">ORD-2026-003</td>
                                <td class="fw-medium text-dark">Phạm Quốc Dũng</td>
                                <td class="fw-bold text-danger">7.490.000 ₫</td>
                                <td><span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 rounded-pill px-2 py-1">Chờ Xác Nhận VietQR</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
"""

# ==============================================================================
# 7. GENERATE SUCCESS (success.html)
# ==============================================================================
success_body = """
<div class="container">
    <!-- 3-Step Checkout Progress Stepper -->
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white" style="border: 1px solid var(--border-color) !important;">
        <div class="row text-center g-2 small">
            <div class="col-4">
                <div class="p-2 rounded-3 bg-light text-muted">
                    <i class="bi bi-cart-check-fill text-success me-1"></i> 1. Giỏ Hàng
                </div>
            </div>
            <div class="col-4">
                <div class="p-2 rounded-3 bg-light text-muted">
                    <i class="bi bi-geo-alt-fill text-success me-1"></i> 2. Thông Tin & Thanh Toán
                </div>
            </div>
            <div class="col-4">
                <div class="p-2 rounded-3 fw-bold text-danger" style="background: var(--accent-rose-subtle); border: 1px solid var(--accent-rose-border);">
                    <i class="bi bi-check-circle-fill me-1"></i> 3. Hoàn Tất Đơn Hàng
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <!-- Success Notification Card -->
            <div class="card border-0 shadow-card rounded-4 p-4 p-md-5 text-center bg-white mb-4" style="background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,241,242,0.65) 100%); border: 1px solid var(--accent-rose-border) !important;">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 76px; height: 76px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; box-shadow: 0 8px 22px rgba(16, 185, 129, 0.35);">
                        <i class="bi bi-check2 display-4"></i>
                    </div>
                </div>
                <span class="badge bg-success rounded-pill px-3 py-1 small mb-2">ĐÃ XÁC NHẬN HỆ THỐNG THÀNH CÔNG</span>
                <h3 class="fw-bold text-dark mb-2">Cảm Ơn Bạn Đã Mua Sắm Tại 12B5 Store!</h3>
                <p class="text-muted">Đơn hàng thiết bị điện tử của bạn đã được tiếp nhận và đang trong quá trình đóng gói niêm phong.</p>
                <div class="d-inline-block px-4 py-2 rounded-pill fw-bold fs-4 text-danger font-monospace mb-3" style="background: var(--accent-rose-subtle); border: 1.5px dashed var(--accent-rose-border);">
                    ORD-2026-12B5TECH
                </div>
                <p class="small text-muted mb-0">Hóa đơn điện tử VAT và thông tin bảo hành kích hoạt tự động theo IMEI/Serial đã gửi tới email <strong>haidang.tech@example.com</strong>.</p>
            </div>

            <!-- VietQR Payment Box -->
            <div class="vietqr-card mb-4 text-center">
                <div class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1 fw-bold small mb-2">
                    <i class="bi bi-patch-check-fill"></i> VietQR Napas 247 Chuẩn Quốc Gia
                </div>
                <h5 class="fw-bold text-dark mb-1"><i class="bi bi-qr-code me-2 text-danger"></i>Mã QR Thanh Toán Tự Động</h5>
                <p class="text-muted small mb-3">Mở ứng dụng Mobile Banking bất kỳ để quét mã thanh toán đối soát tự động:</p>

                <div class="vietqr-image-container mb-3">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=00020101021238540010A00000072701240006970422011001234567890208QRIBFTTA53037045408969800005802VN62210817DH2026091712B56304" alt="VietQR" class="img-fluid rounded-3 shadow-xs">
                </div>

                <div class="bank-detail-box mb-3" style="max-width: 480px; margin: 0 auto;">
                    <div class="bank-copy-row">
                        <span class="text-muted">Ngân hàng thụ hưởng:</span>
                        <strong class="text-dark">MBBank (Ngân Hàng Quân Đội)</strong>
                    </div>
                    <div class="bank-copy-row">
                        <span class="text-muted">Số tài khoản:</span>
                        <div>
                            <strong class="font-monospace text-primary">0901234567</strong>
                            <button type="button" class="btn-copy-code ms-1" onclick="navigator.clipboard.writeText('0901234567'); alert('Đã sao chép số tài khoản MBBank!');">Sao chép</button>
                        </div>
                    </div>
                    <div class="bank-copy-row">
                        <span class="text-muted">Chủ tài khoản:</span>
                        <strong class="text-dark">CONG TY CONG NGHE 12B5 STORE</strong>
                    </div>
                    <div class="bank-copy-row">
                        <span class="text-muted">Số tiền thanh toán:</span>
                        <strong class="text-danger fw-bold fs-6">56.980.000 ₫</strong>
                    </div>
                    <div class="bank-copy-row">
                        <span class="text-muted">Nội dung chuyển khoản:</span>
                        <div>
                            <strong class="font-monospace text-primary">ORD-2026-12B5TECH</strong>
                            <button type="button" class="btn-copy-code ms-1" onclick="navigator.clipboard.writeText('ORD-2026-12B5TECH'); alert('Đã sao chép cú pháp đơn hàng!');">Sao chép</button>
                        </div>
                    </div>
                </div>
                <div class="small text-muted"><i class="bi bi-clock-history me-1 text-primary"></i> Giao dịch chuyển khoản được hệ thống tự động đối soát và kích hoạt bảo hành điện tử.</div>
            </div>

            <!-- Order Details Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" style="border: 1px solid var(--border-color) !important;">
                <h5 class="fw-bold mb-3 border-bottom pb-2 text-dark"><i class="bi bi-receipt me-2 text-danger"></i>Chi Tiết Đơn Hàng</h5>

                <div class="row g-3 mb-4 small">
                    <div class="col-md-6">
                        <div class="text-muted">Người nhận thiết bị:</div>
                        <div class="fw-bold text-dark">Nguyễn Hải Đăng (0912.345.678)</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted">Địa chỉ giao hàng:</div>
                        <div class="fw-bold text-dark">125 Hai Bà Trưng, P. Bến Nghé, Quận 1, TP. Hồ Chí Minh</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted">Phương thức thanh toán:</div>
                        <div class="fw-bold text-dark">Chuyển khoản VietQR Napas 247</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted">Trạng thái đơn hàng:</div>
                        <div><span class="badge bg-warning text-dark text-uppercase">Chờ Xử Lý & Đối Soát</span></div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table small align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Thiết bị điện tử</th>
                                <th>Đơn giá</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="fw-semibold text-dark">MacBook Pro 14 M3 Pro (18GB/512GB)</div>
                                    <span class="text-muted small">Màu Bạc (Silver) &bull; Bảo hành chính hãng 24 tháng</span>
                                </td>
                                <td>49.990.000 ₫</td>
                                <td class="text-center"><span class="badge bg-light text-muted border rounded-pill px-2 py-1">x1</span></td>
                                <td class="text-end fw-bold text-danger">49.990.000 ₫</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="fw-semibold text-dark">Tai Nghe Sony WH-1000XM5 Hi-Res Wireless</div>
                                    <span class="text-muted small">Màu Đen (Black) &bull; Chống ồn chủ động ANC</span>
                                </td>
                                <td>7.490.000 ₫</td>
                                <td class="text-center"><span class="badge bg-light text-muted border rounded-pill px-2 py-1">x1</span></td>
                                <td class="text-end fw-bold text-danger">7.490.000 ₫</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end text-muted">Tạm tính:</td>
                                <td class="text-end fw-semibold">57.480.000 ₫</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end text-success">Voucher 12B5TECH500:</td>
                                <td class="text-end fw-semibold text-success">-500.000 ₫</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end fw-bold text-dark">Tổng thanh toán:</td>
                                <td class="text-end fw-extrabold text-danger fs-5">56.980.000 ₫</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-3">
                <a href="index.html" class="btn btn-rose px-4 py-2 fw-semibold shadow-sm"><i class="bi bi-house me-1"></i> Về Trang Chủ</a>
                <a href="products.html" class="btn btn-soft-slate px-4 py-2"><i class="bi bi-grid me-1"></i> Tiếp Tục Mua Sắm</a>
            </div>
        </div>
    </div>
</div>
"""

pages = [
    ("index.html", "Trang Chủ", home_body, "active", "", "", "", "", "", ""),
    ("products.html", "Danh Mục Sản Phẩm", products_body, "", "active", "", "", "", "", ""),
    ("detail.html", "Chi Tiết Sản Phẩm & Cấu Hình", detail_body, "", "", "active", "", "", "", ""),
    ("cart.html", "Giỏ Hàng Công Nghệ", cart_body, "", "", "", "active", "", "", ""),
    ("checkout.html", "Thanh Toán VietQR NAPAS", checkout_body, "", "", "", "", "active", "", ""),
    ("success.html", "Đặt Hàng Thành Công", success_body, "", "", "", "", "", "active", ""),
    ("admin.html", "Admin Dashboard & KPIs", admin_body, "", "", "", "", "", "", "active"),
]

for filename, title, body, n_home, n_prod, n_det, n_cart, n_check, n_succ, n_adm in pages:
    content = header_template.format(
        title=title,
        nav_home=n_home,
        nav_products=n_prod,
        nav_detail=n_det,
        nav_cart=n_cart,
        nav_checkout=n_check,
        nav_success=n_succ,
        nav_admin=n_adm,
        search_val="",
    ) + body + footer_template
    
    filepath = os.path.join('preview', filename)
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    print(f"Generated {filepath}")

print("All preview pages generated successfully!")
