<?php
$pageTitle = 'Hồ Sơ Của Tôi';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Hồ sơ cá nhân</li>
        </ol>
    </nav>

    <div class="row g-4 mb-5 justify-content-center">
        <div class="col-lg-7">
            <div class="card card-glass border-0 shadow-card rounded-4 p-4 p-md-5">
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fs-3 fw-bold text-white" style="width: 64px; height: 64px; background: linear-gradient(135deg, #f43f5e 0%, #fb7185 100%); box-shadow: var(--shadow-rose-glow);">
                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($user['name']) ?></h4>
                        <span class="badge bg-danger rounded-pill px-3 py-1 small text-uppercase"><?= htmlspecialchars($user['role']) ?></span>
                        <span class="text-muted small ms-2"><i class="bi bi-calendar-check me-1"></i>Thành viên từ: <?= substr($user['created_at'], 0, 10) ?></span>
                    </div>
                </div>

                <form action="/profile" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase tracking-wider">Email đăng nhập (Cố định)</label>
                        <input type="email" class="form-control rounded-3" value="<?= htmlspecialchars($user['email']) ?>" readonly disabled style="background-color: var(--bg-canvas-alt);">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase tracking-wider">Họ và tên *</label>
                        <input type="text" name="name" class="form-control rounded-3" required value="<?= htmlspecialchars($user['name']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase tracking-wider">Số điện thoại liên hệ</label>
                        <input type="tel" name="phone" class="form-control rounded-3" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-muted text-uppercase tracking-wider">Địa chỉ nhận hàng mặc định</label>
                        <textarea name="address" class="form-control rounded-3" rows="2"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-rose px-4 py-2 fw-semibold shadow-sm">
                            <i class="bi bi-floppy me-1"></i> Lưu Thông Tin
                        </button>
                        <a href="/orders" class="btn btn-soft-slate px-4 py-2">
                            <i class="bi bi-box-seam me-1"></i> Xem Đơn Hàng Đã Mua
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
