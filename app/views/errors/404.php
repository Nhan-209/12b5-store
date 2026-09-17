<?php
$pageTitle = '404 - Không Tìm Thấy Trang';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5 text-center my-auto">
    <div class="card card-glass border-0 shadow-card rounded-4 p-5 mx-auto" style="max-width: 600px;">
        <div class="display-1 fw-extrabold text-danger mb-3" style="background: linear-gradient(135deg, #f43f5e 0%, #fb7185 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">404</div>
        <h3 class="fw-bold mb-3 text-dark">Không tìm thấy sản phẩm hoặc trang yêu cầu</h3>
        <p class="text-muted mb-4">
            Rất tiếc, thiết bị điện tử bạn đang tìm kiếm có thể đã được cập nhật đường dẫn mới, hết hàng hoặc tạm thời ngừng kinh doanh.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="/" class="btn btn-soft-slate px-4 py-2 fw-medium">
                <i class="bi bi-house-door me-1"></i> Trang Chủ
            </a>
            <a href="/products" class="btn btn-rose px-4 py-2 fw-semibold shadow-sm">
                <i class="bi bi-grid me-1"></i> Khám Phá Sản Phẩm
            </a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
