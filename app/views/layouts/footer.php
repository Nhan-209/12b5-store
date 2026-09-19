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
                    Hệ thống bán lẻ thiết bị điện tử & công nghệ cao chính hãng hàng đầu. Cam kết 100% sản phẩm nguyên seal, bảo hành chính hãng toàn quốc và mang lại trải nghiệm mua sắm công nghệ an tâm tuyệt đối.
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
                    <li><a href="<?= BASE_URL ?>/products?category=dien-thoai-thong-minh">Điện Thoại Flagship</a></li>
                    <li><a href="<?= BASE_URL ?>/products?category=laptop-may-tinh">Laptop & Ultrabook</a></li>
                    <li><a href="<?= BASE_URL ?>/products?category=may-tinh-bang">Máy Tính Bảng (iPad)</a></li>
                    <li><a href="<?= BASE_URL ?>/products?category=tai-nghe-am-thanh">Tai Nghe Không Dây</a></li>
                    <li><a href="<?= BASE_URL ?>/products?category=dong-ho-thong-minh">Smartwatch Cao Cấp</a></li>
                    <li><a href="<?= BASE_URL ?>/products?category=phu-kien-linh-kien">Phụ Kiện Chính Hãng</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="text-white fw-bold mb-3 small text-uppercase tracking-wider">Hỗ Trợ Khách Hàng</h6>
                <ul class="list-unstyled small d-flex flex-column gap-2 text-muted">
                    <li><a href="<?= BASE_URL ?>/products?category=laptop-may-tinh"><i class="bi bi-chevron-right text-rose small me-1"></i> Hướng dẫn mua hàng online</a></li>
                    <li><a href="<?= BASE_URL ?>/products"><i class="bi bi-chevron-right text-rose small me-1"></i> Chính sách bảo hành VIP 24 tháng</a></li>
                    <li><a href="<?= BASE_URL ?>/cart"><i class="bi bi-chevron-right text-rose small me-1"></i> Quy định đổi mới trong 30 ngày</a></li>
                    <li><a href="<?= BASE_URL ?>/orders"><i class="bi bi-chevron-right text-rose small me-1"></i> Tra cứu trạng thái đơn hàng</a></li>
                    <li><a href="<?= BASE_URL ?>/checkout"><i class="bi bi-chevron-right text-rose small me-1"></i> Hướng dẫn thanh toán VietQR & MoMo</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="text-white fw-bold mb-3 small text-uppercase tracking-wider">Hệ Thống Showroom</h6>
                <ul class="list-unstyled small d-flex flex-column gap-2">
                    <li class="d-flex align-items-start gap-2 text-light"><i class="bi bi-geo-alt-fill text-rose mt-1"></i> <span><strong class="text-white">Hà Nội:</strong> 12B5 Cầu Giấy, Q. Cầu Giấy</span></li>
                    <li class="d-flex align-items-start gap-2 text-light"><i class="bi bi-geo-alt-fill text-rose mt-1"></i> <span><strong class="text-white">TP.HCM:</strong> 88 Nguyễn Huệ, Quận 1</span></li>
                    <li class="d-flex align-items-center gap-2 text-light"><i class="bi bi-clock-fill text-rose"></i> <span>Mở cửa: 08:00 - 22:00 hàng ngày</span></li>
                    <li class="d-flex align-items-center gap-2 text-light"><i class="bi bi-envelope-fill text-rose"></i> <span>Email: support@12b5.store</span></li>
                    <li class="pt-2 text-white"><i class="bi bi-telephone-fill text-rose me-2"></i> Hotline: <strong class="text-white fs-6">1800.12B5</strong> <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 rounded-pill px-2 py-0 ms-1">Miễn phí</span></li>
                </ul>
            </div>
        </div>

        <div class="border-top border-secondary border-opacity-25 pt-4 text-center small text-muted">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <p class="mb-0">&copy; <?= date('Y') ?> 12B5 Store. Siêu Thị Thiết Bị Điện Tử & Công Nghệ Cao Chính Hãng.</p>
                <p class="mb-0">Hotline CSKH: 1800.12B5 &bull; Giấy phép số: 010812B5/GP-BCT</p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom App Script -->
<script src="<?= BASE_URL ?>/js/app.js"></script>
</body>
</html>
