<?php
$pageTitle = 'Quản Lý Đơn Hàng - Admin';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container-fluid px-lg-5 px-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-danger rounded-pill px-3 py-1 small fw-bold">ADMIN ORDERS</span>
                <h3 class="fw-bold mb-0 text-dark"><i class="bi bi-receipt me-2 text-danger"></i>Quản Lý Đơn Hàng</h3>
            </div>
            <span class="text-muted small">Cập nhật trạng thái đóng gói, tiến độ vận chuyển và đối soát VietQR</span>
        </div>
        <div>
            <a href="/admin" class="btn btn-soft-slate btn-sm">
                <i class="bi bi-speedometer2 me-1"></i> Về Dashboard
            </a>
        </div>
    </div>

    <!-- Status filter tabs -->
    <div class="d-flex gap-2 mb-4 overflow-x-auto pb-2">
        <a href="/admin/orders" class="btn btn-sm rounded-pill px-3 <?= empty($status) ? 'btn-rose' : 'btn-soft-slate' ?>">Tất cả</a>
        <a href="/admin/orders?status=pending" class="btn btn-sm rounded-pill px-3 <?= $status === 'pending' ? 'btn-rose' : 'btn-soft-slate' ?>">Chờ xử lý</a>
        <a href="/admin/orders?status=processing" class="btn btn-sm rounded-pill px-3 <?= $status === 'processing' ? 'btn-rose' : 'btn-soft-slate' ?>">Đang đóng gói</a>
        <a href="/admin/orders?status=shipping" class="btn btn-sm rounded-pill px-3 <?= $status === 'shipping' ? 'btn-rose' : 'btn-soft-slate' ?>">Đang giao</a>
        <a href="/admin/orders?status=completed" class="btn btn-sm rounded-pill px-3 <?= $status === 'completed' ? 'btn-rose' : 'btn-soft-slate' ?>">Hoàn thành</a>
        <a href="/admin/orders?status=cancelled" class="btn btn-sm rounded-pill px-3 <?= $status === 'cancelled' ? 'btn-rose' : 'btn-soft-slate' ?>">Đã hủy</a>
    </div>

    <div class="card card-glass border-0 shadow-card rounded-4 p-4 mb-5">
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
                        <th class="text-end">Cập nhật</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr><td colspan="8" class="text-center py-4 text-muted">Không có đơn hàng nào trong mục này.</td></tr>
                    <?php else: ?>
                        <?php foreach ($orders as $ord): ?>
                            <tr>
                                <td class="fw-bold font-monospace">
                                    <a href="/order/<?= urlencode($ord['order_code']) ?>" class="text-danger text-decoration-none">
                                        <?= htmlspecialchars($ord['order_code']) ?>
                                    </a>
                                </td>
                                <td>
                                    <div class="fw-semibold small text-dark"><?= htmlspecialchars($ord['customer_name']) ?></div>
                                    <div class="text-muted small"><?= htmlspecialchars($ord['customer_phone']) ?></div>
                                </td>
                                <td class="small text-truncate" style="max-width: 200px;" title="<?= htmlspecialchars($ord['shipping_address']) ?>">
                                    <?= htmlspecialchars($ord['shipping_address']) ?>
                                </td>
                                <td class="small">
                                    <span class="badge bg-light text-muted border rounded-pill px-2 py-1"><?= $ord['payment_method'] === 'bank_transfer' ? 'VietQR' : 'COD' ?></span>
                                </td>
                                <td class="fw-bold text-danger"><?= $ord['formatted_final'] ?></td>
                                <td>
                                    <span class="badge <?= $ord['payment_status'] === 'paid' ? 'bg-success' : 'bg-warning text-dark' ?> rounded-pill px-3 py-1">
                                        <?= $ord['payment_status'] === 'paid' ? 'Đã thu' : 'Chưa thu' ?>
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    $statusBadge = match($ord['order_status']) {
                                        'completed' => 'bg-success',
                                        'shipping' => 'bg-info',
                                        'processing' => 'bg-warning',
                                        'cancelled' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $statusBadge ?> text-uppercase rounded-pill px-3 py-1"><?= htmlspecialchars($ord['order_status']) ?></span>
                                </td>
                                <td class="text-end">
                                    <form action="/admin/orders/update-status" method="POST" class="d-inline-flex align-items-center gap-1">
                                        <?= \App\Core\Csrf::field() ?>
                                        <input type="hidden" name="order_id" value="<?= $ord['id'] ?>">
                                        <select name="status" class="form-select form-select-sm rounded-pill" style="width: 125px;" title="Trạng thái đơn hàng">
                                            <option value="pending" <?= $ord['order_status'] === 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                                            <option value="processing" <?= $ord['order_status'] === 'processing' ? 'selected' : '' ?>>Đang đóng gói</option>
                                            <option value="shipping" <?= $ord['order_status'] === 'shipping' ? 'selected' : '' ?>>Đang giao</option>
                                            <option value="completed" <?= $ord['order_status'] === 'completed' ? 'selected' : '' ?>>Hoàn thành</option>
                                            <option value="cancelled" <?= $ord['order_status'] === 'cancelled' ? 'selected' : '' ?>>Hủy đơn</option>
                                        </select>
                                        <select name="payment_status" class="form-select form-select-sm rounded-pill" style="width: 105px;" title="Trạng thái thanh toán">
                                            <option value="pending" <?= $ord['payment_status'] === 'pending' ? 'selected' : '' ?>>Chưa thu</option>
                                            <option value="paid" <?= $ord['payment_status'] === 'paid' ? 'selected' : '' ?>>Đã thu</option>
                                            <option value="failed" <?= $ord['payment_status'] === 'failed' ? 'selected' : '' ?>>Thất bại</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-outline-rose rounded-pill px-2" title="Lưu trạng thái">
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
