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
                    <li><a href="/products?category=dien-thoai-thong-minh">Điện Thoại Flagship</a></li>
                    <li><a href="/products?category=laptop-may-tinh">Laptop & Ultrabook</a></li>
                    <li><a href="/products?category=may-tinh-bang">Máy Tính Bảng (iPad)</a></li>
                    <li><a href="/products?category=tai-nghe-am-thanh">Tai Nghe Không Dây</a></li>
                    <li><a href="/products?category=dong-ho-thong-minh">Smartwatch Cao Cấp</a></li>
                    <li><a href="/products?category=phu-kien-linh-kien">Phụ Kiện Chính Hãng</a></li>
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
                <p class="mb-0">&copy; <?= date('Y') ?> 12B5 Store. All rights reserved. Đồ án Tốt Nghiệp Chuyên Ngành CNTT.</p>
                <p class="mb-0">Designed with Modern Pastel & Glassmorphism &bull; Powered by Rust Microservices Engine</p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom App Script -->
<script src="/js/app.js"></script>
</body>
</html>
