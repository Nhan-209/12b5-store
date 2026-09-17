</main>

<footer>
    <div class="container">
        <div class="row g-4 pb-4">
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="bg-primary p-2 rounded-3 text-white">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </div>
                    <span class="fs-5 fw-bold text-white">12B5 Store</span>
                </div>
                <p class="small text-muted">
                    Hệ thống bán lẻ thiết bị điện tử & công nghệ cao. Tối ưu hóa hiệu năng bằng kiến trúc Hybrid kết hợp PHP Web Core và Microservice xử lý tính toán chuyên sâu bằng ngôn ngữ Rust.
                </p>
                <div class="d-flex gap-3 fs-5">
                    <a href="#" class="text-white-50"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white-50"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="text-white-50"><i class="bi bi-github"></i></a>
                    <a href="#" class="text-white-50"><i class="bi bi-telegram"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <h6 class="text-white fw-bold mb-3">Sản Phẩm</h6>
                <ul class="list-unstyled small d-flex flex-column gap-2">
                    <li><a href="/products?category=dien-thoai-thong-minh">Điện Thoại Di Động</a></li>
                    <li><a href="/products?category=laptop-may-tinh">Laptop & Ultrabook</a></li>
                    <li><a href="/products?category=may-tinh-bang">Máy Tính Bảng</a></li>
                    <li><a href="/products?category=tai-nghe-am-thanh">Tai Nghe Không Dây</a></li>
                    <li><a href="/products?category=dong-ho-thong-minh">Smartwatch</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="text-white fw-bold mb-3">Thông Tin Đồ Án</h6>
                <ul class="list-unstyled small d-flex flex-column gap-2 text-muted">
                    <li><strong class="text-white-50">Đề tài:</strong> Xây dựng Website TMĐT Thiết Bị Điện Tử</li>
                    <li><strong class="text-white-50">Công nghệ:</strong> PHP 8.x + Rust Engine + MySQL/SQLite</li>
                    <li><strong class="text-white-50">CI/CD:</strong> GitHub Actions (Automated Build & Cross-compile)</li>
                    <li><strong class="text-white-50">Mô hình:</strong> Hybrid Microservices Architecture</li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="text-white fw-bold mb-3">Chính Sách & Hỗ Trợ</h6>
                <ul class="list-unstyled small d-flex flex-column gap-2">
                    <li><a href="#">Chính sách bảo hành 12 tháng chính hãng</a></li>
                    <li><a href="#">Đổi trả 1-đổi-1 trong 30 ngày</a></li>
                    <li><a href="#">Giao hàng hỏa tốc 2 giờ nội thành</a></li>
                    <li><a href="#">Hướng dẫn thanh toán & quét mã VietQR</a></li>
                </ul>
            </div>
        </div>

        <div class="border-top border-secondary border-opacity-25 pt-4 text-center small text-muted">
            <p class="mb-1">&copy; <?= date('Y') ?> 12B5 Store - Graduation Project. All rights reserved.</p>
            <p class="mb-0">Designed & Engineered with PHP, HTML/CSS and Rust High-Performance Engine.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom App Script -->
<script src="/js/app.js"></script>
</body>
</html>
