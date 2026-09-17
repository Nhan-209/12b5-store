<?php
$pageTitle = 'Đăng Nhập';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-5">
            <div class="card card-glass border-0 shadow-card rounded-4 p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 64px; height: 64px; background: var(--accent-rose-subtle); color: var(--accent-rose); border: 1px solid var(--accent-rose-border); box-shadow: var(--shadow-rose-glow);">
                        <i class="bi bi-person-fill-lock fs-2"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-1">Đăng Nhập 12B5 Store</h4>
                    <p class="text-muted small">Truy cập tài khoản để quản lý đơn hàng hoặc quản trị viên</p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger small py-2 mb-3"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form action="/login" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase tracking-wider">Địa chỉ Email *</label>
                        <input type="email" name="email" class="form-control rounded-3" required placeholder="admin@electro.vn hoặc customer@gmail.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-semibold text-muted text-uppercase tracking-wider mb-0">Mật khẩu *</label>
                        </div>
                        <input type="password" name="password" class="form-control rounded-3" required placeholder="••••••••">
                    </div>

                    <button type="submit" class="btn btn-rose w-100 py-3 fw-bold mb-3 shadow-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Đăng Nhập Hệ Thống
                    </button>

                    <div class="p-3 bg-light rounded-4 small text-muted mb-3 border" style="background: rgba(241, 245, 249, 0.7) !important;">
                        <div class="fw-bold text-dark mb-1"><i class="bi bi-info-circle text-danger me-1"></i> Tài khoản trải nghiệm sẵn có:</div>
                        <div>&bull; Admin: <code>admin@electro.vn</code> / <code>admin123</code></div>
                        <div>&bull; Khách: <code>customer@gmail.com</code> / <code>user123</code></div>
                    </div>

                    <div class="text-center small text-muted">
                        Chưa có tài khoản? <a href="/register" class="text-danger fw-semibold text-decoration-none">Đăng ký thành viên mới</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
