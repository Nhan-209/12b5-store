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
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fs-3 fw-bold" style="width: 60px; height: 60px;">
                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0"><?= htmlspecialchars($user['name']) ?></h4>
                        <span class="badge bg-secondary text-uppercase"><?= htmlspecialchars($user['role']) ?></span>
                        <span class="text-muted small ms-2">Thành viên từ: <?= substr($user['created_at'], 0, 10) ?></span>
                    </div>
                </div>

                <form action="/profile" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Email đăng nhập (Cố định)</label>
                        <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" readonly disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Họ và tên</label>
                        <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($user['name']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Số điện thoại liên hệ</label>
                        <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-muted">Địa chỉ nhận hàng mặc định</label>
                        <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        Lưu Thông Tin
                    </button>
                    <a href="/orders" class="btn btn-outline-secondary ms-2">Xem Đơn Hàng Đã Mua</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
