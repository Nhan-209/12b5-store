<?php
$pageTitle = 'Đăng Ký Tài Khoản';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle d-inline-flex mb-2">
                        <i class="bi bi-person-plus-fill fs-2"></i>
                    </div>
                    <h4 class="fw-bold">Tạo Tài Khoản Khách Hàng</h4>
                    <p class="text-muted small">Đăng ký để nhận ưu đãi và quản lý đơn hàng dễ dàng</p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger small py-2"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form action="/register" method="POST">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Họ và tên *</label>
                            <input type="text" name="name" class="form-control" required placeholder="Nguyễn Văn B" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Số điện thoại</label>
                            <input type="tel" name="phone" class="form-control" placeholder="0901234567" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-muted">Email đăng nhập *</label>
                            <input type="email" name="email" class="form-control" required placeholder="name@example.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Mật khẩu *</label>
                            <input type="password" name="password" class="form-control" required placeholder="Tối thiểu 6 ký tự">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Xác nhận mật khẩu *</label>
                            <input type="password" name="confirm_password" class="form-control" required placeholder="Nhập lại mật khẩu">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-muted">Địa chỉ nhận hàng mặc định</label>
                            <textarea name="address" class="form-control" rows="2" placeholder="Số nhà, đường, phường, quận, thành phố..."><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mb-3 shadow-sm">
                        Đăng Ký Tài Khoản
                    </button>

                    <div class="text-center small text-muted">
                        Đã có tài khoản? <a href="/login" class="text-primary fw-semibold text-decoration-none">Đăng nhập ngay</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
