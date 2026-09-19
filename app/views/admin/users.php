<?php
$pageTitle = 'Quản Lý Người Dùng - Admin';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container-fluid px-lg-5 px-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-danger rounded-pill px-3 py-1 small fw-bold">ADMIN USERS</span>
                <h3 class="fw-bold mb-0 text-dark"><i class="bi bi-people me-2 text-danger"></i>Quản Lý Người Dùng</h3>
            </div>
            <span class="text-muted small">Danh sách tài khoản khách hàng và phân quyền quản trị viên 12B5 Store</span>
        </div>
        <div>
            <a href="<?= BASE_URL ?>/admin" class="btn btn-soft-slate btn-sm">
                <i class="bi bi-speedometer2 me-1"></i> Về Dashboard
            </a>
        </div>
    </div>

    <div class="card card-glass border-0 shadow-card rounded-4 p-4 mb-5">
        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead class="table-light text-muted small text-uppercase">
                    <tr>
                        <th>ID</th>
                        <th>Họ và tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Vai trò</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td class="text-muted fw-bold font-monospace">#<?= $u['id'] ?></td>
                            <td class="fw-bold text-dark"><?= htmlspecialchars($u['name']) ?></td>
                            <td><code class="text-dark"><?= htmlspecialchars($u['email']) ?></code></td>
                            <td><?= htmlspecialchars($u['phone'] ?? '-') ?></td>
                            <td class="small text-truncate" style="max-width: 250px;"><?= htmlspecialchars($u['address'] ?? '-') ?></td>
                            <td>
                                <span class="badge <?= $u['role'] === 'admin' ? 'bg-danger' : 'bg-primary' ?> rounded-pill px-3 py-1 text-uppercase">
                                    <?= htmlspecialchars($u['role']) ?>
                                </span>
                            </td>
                            <td class="small text-muted"><?= htmlspecialchars($u['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
