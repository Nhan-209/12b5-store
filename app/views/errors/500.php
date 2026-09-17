<?php
$pageTitle = '500 - Lỗi Hệ Thống';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5 text-center my-auto">
    <div class="card card-glass border-0 shadow-card rounded-4 p-5 mx-auto" style="max-width: 600px;">
        <div class="display-1 fw-extrabold text-danger mb-3" style="background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">500</div>
        <h3 class="fw-bold mb-3 text-dark">Đã xảy ra sự cố hệ thống</h3>
        <p class="text-muted mb-4">
            <?= htmlspecialchars($errorMessage ?? 'Hệ thống đang gặp sự cố kết nối tạm thời. Đội ngũ kỹ thuật 12B5 Store đã được thông báo để xử lý.') ?>
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="/" class="btn btn-rose px-4 py-2 fw-semibold shadow-sm">
                <i class="bi bi-house-door me-1"></i> Về Trang Chủ
            </a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
