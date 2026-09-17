<?php
$pageTitle = 'Quản Lý Người Dùng - Admin';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h3 class="fw-bold mb-1"><i class="bi bi-people me-2 text-primary"></i>Quản Lý Người Dùng</h3>
            <span class="text-muted small">Danh sách tài khoản khách hàng và quản trị viên</span>
        </div>
        <div>
            <a href="/admin" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Về Dashboard
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-5">
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
                            <td class="text-muted fw-bold">#<?= $u['id'] ?></td>
                            <td class="fw-bold"><?= htmlspecialchars($u['name']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td><?= htmlspecialchars($u['phone'] ?? '-') ?></td>
                            <td class="small text-truncate" style="max-width: 250px;"><?= htmlspecialchars($u['address'] ?? '-') ?></td>
                            <td>
                                <span class="badge <?= $u['role'] === 'admin' ? 'bg-danger' : 'bg-primary' ?> text-uppercase">
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
