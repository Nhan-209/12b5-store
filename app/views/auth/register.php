<?php
$pageTitle = 'Đăng Ký Tài Khoản';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-6">
            <div class="card card-glass border-0 shadow-card rounded-4 p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 64px; height: 64px; background: var(--accent-rose-subtle); color: var(--accent-rose); border: 1px solid var(--accent-rose-border); box-shadow: var(--shadow-rose-glow);">
                        <i class="bi bi-person-plus-fill fs-2"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-1">Tạo Tài Khoản Khách Hàng</h4>
                    <p class="text-muted small">Đăng ký thành viên 12B5 Store để nhận đặc quyền & theo dõi đơn hàng</p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger small py-2 mb-3"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form action="/register" method="POST">
                    <?= \App\Core\Csrf::field() ?>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase tracking-wider">Họ và tên *</label>
                            <input type="text" name="name" class="form-control rounded-3" required placeholder="Nguyễn Văn B" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase tracking-wider">Số điện thoại</label>
                            <input type="tel" name="phone" class="form-control rounded-3" placeholder="0901234567" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-muted text-uppercase tracking-wider">Email đăng nhập *</label>
                            <input type="email" name="email" class="form-control rounded-3" required placeholder="name@example.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase tracking-wider">Mật khẩu *</label>
                            <input type="password" name="password" class="form-control rounded-3" required placeholder="Tối thiểu 6 ký tự">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase tracking-wider">Xác nhận mật khẩu *</label>
                            <input type="password" name="confirm_password" class="form-control rounded-3" required placeholder="Nhập lại mật khẩu">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-muted text-uppercase tracking-wider">Địa chỉ nhận hàng mặc định</label>
                            <textarea name="address" class="form-control rounded-3" rows="2" placeholder="Số nhà, đường, phường, quận, thành phố..."><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-rose w-100 py-3 fw-bold mb-3 shadow-sm">
                        <i class="bi bi-check2-circle me-1"></i> Hoàn Tất Đăng Ký Tài Khoản
                    </button>

                    <div class="text-center small text-muted">
                        Đã có tài khoản? <a href="/login" class="text-danger fw-semibold text-decoration-none">Đăng nhập ngay</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
