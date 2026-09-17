<?php
$pageTitle = 'Đăng Nhập';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle d-inline-flex mb-2">
                        <i class="bi bi-person-fill-lock fs-2"></i>
                    </div>
                    <h4 class="fw-bold">Đăng Nhập Hệ Thống</h4>
                    <p class="text-muted small">Truy cập để quản lý đơn hàng hoặc quản trị viên</p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger small py-2"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form action="/login" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Địa chỉ Email</label>
                        <input type="email" name="email" class="form-control" required placeholder="admin@electro.vn hoặc customer@gmail.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-muted">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required placeholder="••••••••">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mb-3 shadow-sm">
                        Đăng Nhập
                    </button>

                    <div class="p-3 bg-light rounded-3 small text-muted mb-3">
                        <div class="fw-bold mb-1">Tài khoản demo sẵn có:</div>
                        <div>&bull; Admin: <code>admin@electro.vn</code> / <code>admin123</code></div>
                        <div>&bull; Khách: <code>customer@gmail.com</code> / <code>user123</code></div>
                    </div>

                    <div class="text-center small text-muted">
                        Chưa có tài khoản? <a href="/register" class="text-primary fw-semibold text-decoration-none">Đăng ký ngay</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
