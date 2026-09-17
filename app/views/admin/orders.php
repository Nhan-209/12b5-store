<?php
$pageTitle = 'Quản Lý Đơn Hàng - Admin';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h3 class="fw-bold mb-1"><i class="bi bi-receipt me-2 text-primary"></i>Quản Lý Đơn Hàng</h3>
            <span class="text-muted small">Cập nhật trạng thái xử lý, vận chuyển và đối soát thanh toán</span>
        </div>
        <div>
            <a href="/admin" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Về Dashboard
            </a>
        </div>
    </div>

    <!-- Status filter tabs -->
    <div class="d-flex gap-2 mb-4 overflow-x-auto pb-2">
        <a href="/admin/orders" class="btn btn-sm <?= empty($status) ? 'btn-primary' : 'btn-outline-secondary' ?>">Tất cả</a>
        <a href="/admin/orders?status=pending" class="btn btn-sm <?= $status === 'pending' ? 'btn-primary' : 'btn-outline-secondary' ?>">Chờ xử lý</a>
        <a href="/admin/orders?status=processing" class="btn btn-sm <?= $status === 'processing' ? 'btn-primary' : 'btn-outline-secondary' ?>">Đang đóng gói</a>
        <a href="/admin/orders?status=shipping" class="btn btn-sm <?= $status === 'shipping' ? 'btn-primary' : 'btn-outline-secondary' ?>">Đang giao</a>
        <a href="/admin/orders?status=completed" class="btn btn-sm <?= $status === 'completed' ? 'btn-primary' : 'btn-outline-secondary' ?>">Hoàn thành</a>
        <a href="/admin/orders?status=cancelled" class="btn btn-sm <?= $status === 'cancelled' ? 'btn-primary' : 'btn-outline-secondary' ?>">Đã hủy</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-5">
        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead class="table-light text-muted small text-uppercase">
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Địa chỉ giao</th>
                        <th>Phương thức</th>
                        <th>Tổng tiền</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái đơn</th>
                        <th>Cập nhật</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr><td colspan="8" class="text-center py-4 text-muted">Không có đơn hàng nào trong mục này.</td></tr>
                    <?php else: ?>
                        <?php foreach ($orders as $ord): ?>
                            <tr>
                                <td class="fw-bold font-monospace text-primary">
                                    <a href="/order/<?= urlencode($ord['order_code']) ?>" class="text-decoration-none">
                                        <?= htmlspecialchars($ord['order_code']) ?>
                                    </a>
                                </td>
                                <td>
                                    <div class="fw-semibold small"><?= htmlspecialchars($ord['customer_name']) ?></div>
                                    <div class="text-muted small"><?= htmlspecialchars($ord['customer_phone']) ?></div>
                                </td>
                                <td class="small text-truncate" style="max-width: 200px;" title="<?= htmlspecialchars($ord['shipping_address']) ?>">
                                    <?= htmlspecialchars($ord['shipping_address']) ?>
                                </td>
                                <td class="small">
                                    <?= $ord['payment_method'] === 'bank_transfer' ? 'VietQR' : 'COD' ?>
                                </td>
                                <td class="fw-bold"><?= $ord['formatted_final'] ?></td>
                                <td>
                                    <span class="badge <?= $ord['payment_status'] === 'paid' ? 'bg-success' : 'bg-warning text-dark' ?>">
                                        <?= $ord['payment_status'] === 'paid' ? 'Đã thu' : 'Chưa thu' ?>
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    $statusBadge = match($ord['order_status']) {
                                        'completed' => 'bg-success',
                                        'shipping' => 'bg-info text-dark',
                                        'processing' => 'bg-primary',
                                        'cancelled' => 'bg-danger',
                                        default => 'bg-warning text-dark'
                                    };
                                    ?>
                                    <span class="badge <?= $statusBadge ?> text-uppercase"><?= htmlspecialchars($ord['order_status']) ?></span>
                                </td>
                                <td>
                                    <form action="/admin/orders/update-status" method="POST" class="d-flex align-items-center gap-1">
                                        <input type="hidden" name="order_id" value="<?= $ord['id'] ?>">
                                        <select name="status" class="form-select form-select-sm" style="width: 125px;">
                                            <option value="pending" <?= $ord['order_status'] === 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                                            <option value="processing" <?= $ord['order_status'] === 'processing' ? 'selected' : '' ?>>Đang đóng gói</option>
                                            <option value="shipping" <?= $ord['order_status'] === 'shipping' ? 'selected' : '' ?>>Đang giao</option>
                                            <option value="completed" <?= $ord['order_status'] === 'completed' ? 'selected' : '' ?>>Hoàn thành</option>
                                            <option value="cancelled" <?= $ord['order_status'] === 'cancelled' ? 'selected' : '' ?>>Hủy đơn</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-outline-primary" title="Lưu">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
