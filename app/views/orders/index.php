<?php
$pageTitle = 'Lịch Sử Đơn Hàng';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lịch sử đơn hàng</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark"><i class="bi bi-box-seam me-2 text-danger"></i>Lịch Sử Đơn Hàng Của Bạn</h3>
            <span class="text-muted small">Tra cứu tiến độ xử lý và hành trình giao hàng thiết bị công nghệ</span>
        </div>
        <a href="/products" class="btn btn-soft-slate btn-sm"><i class="bi bi-cart-plus me-1"></i> Mua thêm thiết bị</a>
    </div>

    <?php if (empty($orders)): ?>
        <div class="card card-glass border-0 shadow-card rounded-4 p-5 text-center mb-5">
            <div class="mb-3">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 72px; height: 72px; background: var(--accent-rose-subtle); color: var(--accent-rose); border: 1px solid var(--accent-rose-border);">
                    <i class="bi bi-inbox fs-1"></i>
                </div>
            </div>
            <h4 class="fw-bold text-dark">Bạn chưa có đơn hàng nào!</h4>
            <p class="text-muted small mb-4">Các đơn hàng sau khi mua sẽ xuất hiện tại đây để bạn thuận tiện theo dõi tiến độ vận chuyển và bảo hành.</p>
            <div>
                <a href="/products" class="btn btn-rose px-4 py-2 fw-semibold shadow-sm">Khám Phá Thiết Bị Mới</a>
            </div>
        </div>
    <?php else: ?>
        <div class="card card-glass border-0 shadow-card rounded-4 p-4 mb-5">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light text-muted small text-uppercase">
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái giao</th>
                            <th class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $ord): ?>
                            <tr>
                                <td class="fw-bold font-monospace">
                                    <a href="/order/<?= urlencode($ord['order_code']) ?>" class="text-danger text-decoration-none">
                                        <?= htmlspecialchars($ord['order_code']) ?>
                                    </a>
                                </td>
                                <td class="small text-muted"><?= htmlspecialchars($ord['created_at']) ?></td>
                                <td class="fw-bold text-dark"><?= $ord['formatted_final'] ?></td>
                                <td>
                                    <span class="badge <?= $ord['payment_status'] === 'paid' ? 'bg-success' : 'bg-secondary' ?> rounded-pill px-3 py-1">
                                        <?= $ord['payment_status'] === 'paid' ? '<i class="bi bi-check2 me-1"></i>Đã thanh toán' : 'Chờ thanh toán' ?>
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
                                    <a href="/order/<?= urlencode($ord['order_code']) ?>" class="btn btn-sm btn-outline-rose rounded-pill px-3 py-1">
                                        Chi tiết <i class="bi bi-chevron-right ms-1 small"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
