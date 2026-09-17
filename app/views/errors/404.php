<?php
$pageTitle = '404 - Không Tìm Thấy Trang';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5 text-center my-auto">
    <div class="card border-0 shadow-sm rounded-4 p-5 bg-white mx-auto" style="max-width: 600px;">
        <div class="display-1 fw-extrabold text-primary mb-3">404</div>
        <h3 class="fw-bold mb-3">Không tìm thấy sản phẩm hoặc trang yêu cầu</h3>
        <p class="text-muted mb-4">
            Rất tiếc, thiết bị bạn đang tìm kiếm có thể đã được gỡ bỏ, đổi tên hoặc đường dẫn truy cập không chính xác.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="/" class="btn btn-outline-primary px-4 fw-medium">
                <i class="bi bi-house-door me-1"></i> Trang Chủ
            </a>
            <a href="/products" class="btn btn-primary px-4 fw-semibold shadow-sm">
                <i class="bi bi-grid me-1"></i> Xem Tất Cả Sản Phẩm
            </a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
