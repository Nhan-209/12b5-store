<?php
$pageTitle = 'Chi Tiết Đơn Hàng ' . $order['order_code'];
require __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="/orders" class="text-decoration-none">Đơn hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($order['order_code']) ?></li>
        </ol>
    </nav>

    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-3">
                    <div>
                        <h4 class="fw-bold mb-1">Mã Đơn: <span class="text-primary font-monospace"><?= htmlspecialchars($order['order_code']) ?></span></h4>
                        <span class="text-muted small">Thời gian đặt: <?= htmlspecialchars($order['created_at']) ?></span>
                    </div>
                    <div>
                        <?php 
                        $statusBadge = match($order['order_status']) {
                            'completed' => 'bg-success',
                            'shipping' => 'bg-info text-dark',
                            'processing' => 'bg-primary',
                            'cancelled' => 'bg-danger',
                            default => 'bg-warning text-dark'
                        };
                        ?>
                        <span class="badge <?= $statusBadge ?> px-3 py-2 text-uppercase fs-6"><?= htmlspecialchars($order['order_status']) ?></span>
                    </div>
                </div>

                <!-- Order Status Timeline -->
                <div class="p-3 bg-light rounded-4 mb-4">
                    <div class="row text-center small g-2">
                        <div class="col-3">
                            <i class="bi bi-receipt fs-4 text-success"></i>
                            <div class="fw-bold text-success">Đã Đặt</div>
                        </div>
                        <div class="col-3">
                            <i class="bi bi-box-seam fs-4 <?= in_array($order['order_status'], ['processing', 'shipping', 'completed']) ? 'text-success' : 'text-muted' ?>"></i>
                            <div class="fw-bold <?= in_array($order['order_status'], ['processing', 'shipping', 'completed']) ? 'text-success' : 'text-muted' ?>">Đang Xử Lý</div>
                        </div>
                        <div class="col-3">
                            <i class="bi bi-truck fs-4 <?= in_array($order['order_status'], ['shipping', 'completed']) ? 'text-success' : 'text-muted' ?>"></i>
                            <div class="fw-bold <?= in_array($order['order_status'], ['shipping', 'completed']) ? 'text-success' : 'text-muted' ?>">Đang Giao</div>
                        </div>
                        <div class="col-3">
                            <i class="bi bi-check2-circle fs-4 <?= $order['order_status'] === 'completed' ? 'text-success' : 'text-muted' ?>"></i>
                            <div class="fw-bold <?= $order['order_status'] === 'completed' ? 'text-success' : 'text-muted' ?>">Hoàn Thành</div>
                        </div>
                    </div>
                </div>

                <!-- Product list -->
                <h6 class="fw-bold mb-3">Danh sách thiết bị</h6>
                <div class="table-responsive">
                    <table class="table small align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Thiết bị</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?= htmlspecialchars($item['product_name']) ?></div>
                                        <div class="text-muted" style="font-size: 0.75rem;">SKU: <?= htmlspecialchars($item['product_sku']) ?></div>
                                    </td>
                                    <td><?= number_format((float)$item['unit_price'], 0, ',', '.') ?> ₫</td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td class="text-end fw-bold"><?= number_format((float)$item['subtotal'], 0, ',', '.') ?> ₫</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end text-muted">Tổng phụ:</td>
                                <td class="text-end fw-bold"><?= $order['formatted_total'] ?></td>
                            </tr>
                            <?php if ((float)$order['discount_amount'] > 0): ?>
                                <tr>
                                    <td colspan="3" class="text-end text-success">Giảm giá:</td>
                                    <td class="text-end text-success fw-bold">-<?= $order['formatted_discount'] ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td colspan="3" class="text-end fw-bold fs-6">Tổng cộng thanh toán:</td>
                                <td class="text-end fw-extrabold text-primary fs-5"><?= $order['formatted_final'] ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Customer info sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Thông Tin Giao Nhận</h5>
                <div class="small d-flex flex-column gap-2 mb-4">
                    <div>
                        <div class="text-muted">Người nhận:</div>
                        <div class="fw-bold"><?= htmlspecialchars($order['customer_name']) ?></div>
                    </div>
                    <div>
                        <div class="text-muted">Số điện thoại:</div>
                        <div class="fw-bold"><?= htmlspecialchars($order['customer_phone']) ?></div>
                    </div>
                    <div>
                        <div class="text-muted">Email:</div>
                        <div><?= htmlspecialchars($order['customer_email']) ?></div>
                    </div>
                    <div>
                        <div class="text-muted">Địa chỉ nhận hàng:</div>
                        <div class="fw-bold"><?= htmlspecialchars($order['shipping_address']) ?></div>
                    </div>
                    <?php if (!empty($order['notes'])): ?>
                        <div>
                            <div class="text-muted">Ghi chú:</div>
                            <div class="fst-italic"><?= htmlspecialchars($order['notes']) ?></div>
                        </div>
                    <?php endif; ?>
                </div>

                <h5 class="fw-bold mb-3 border-bottom pb-2">Thanh Toán</h5>
                <div class="small d-flex flex-column gap-2">
                    <div>
                        <div class="text-muted">Hình thức:</div>
                        <div class="fw-bold"><?= $order['payment_method'] === 'bank_transfer' ? 'Chuyển khoản VietQR' : 'COD (Tiền mặt khi giao)' ?></div>
                    </div>
                    <div>
                        <div class="text-muted">Trạng thái:</div>
                        <div>
                            <span class="badge <?= $order['payment_status'] === 'paid' ? 'bg-success' : 'bg-warning text-dark' ?>">
                                <?= $order['payment_status'] === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <a href="/orders" class="btn btn-outline-secondary w-100">
                <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách đơn hàng
            </a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
