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

    <h3 class="fw-bold mb-4"><i class="bi bi-box-seam me-2 text-primary"></i>Lịch Sử Đơn Hàng Của Bạn</h3>

    <?php if (empty($orders)): ?>
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white mb-5">
            <div class="text-muted mb-3">
                <i class="bi bi-inbox display-1"></i>
            </div>
            <h4 class="fw-bold">Bạn chưa có đơn hàng nào!</h4>
            <p class="text-muted small mb-4">Các đơn hàng sau khi mua sẽ xuất hiện tại đây để bạn thuận tiện theo dõi tiến độ vận chuyển.</p>
            <div>
                <a href="/products" class="btn btn-primary px-4 py-2">Khám Phá Thiết Bị Mới</a>
            </div>
        </div>
    <?php else: ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-5">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light text-muted small text-uppercase">
                        <tr>
                            <th>Mã đơn</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $ord): ?>
                            <tr>
                                <td class="fw-bold font-monospace text-primary">
                                    <a href="/order/<?= urlencode($ord['order_code']) ?>" class="text-decoration-none">
                                        <?= htmlspecialchars($ord['order_code']) ?>
                                    </a>
                                </td>
                                <td class="small text-muted"><?= htmlspecialchars($ord['created_at']) ?></td>
                                <td class="fw-bold"><?= $ord['formatted_final'] ?></td>
                                <td>
                                    <span class="badge <?= $ord['payment_status'] === 'paid' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $ord['payment_status'] === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' ?>
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
                                    <a href="/order/<?= urlencode($ord['order_code']) ?>" class="btn btn-sm btn-outline-primary">
                                        Chi tiết
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
