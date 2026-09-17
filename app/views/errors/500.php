<?php
$pageTitle = '500 - Lỗi Hệ Thống';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5 text-center my-auto">
    <div class="card border-0 shadow-sm rounded-4 p-5 bg-white mx-auto" style="max-width: 600px;">
        <div class="display-1 fw-extrabold text-danger mb-3">500</div>
        <h3 class="fw-bold mb-3">Đã xảy ra lỗi hệ thống</h3>
        <p class="text-muted mb-4">
            <?= htmlspecialchars($errorMessage ?? 'Hệ thống đang gặp sự cố tạm thời. Đội ngũ kỹ thuật đã được thông báo.') ?>
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="/" class="btn btn-primary px-4 fw-semibold shadow-sm">
                <i class="bi bi-house-door me-1"></i> Về Trang Chủ
            </a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
