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
            <div class="card card-glass border-0 shadow-card rounded-4 p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-3">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">Mã Đơn: <span class="text-danger font-monospace"><?= htmlspecialchars($order['order_code']) ?></span></h4>
                        <span class="text-muted small"><i class="bi bi-clock me-1"></i>Thời gian đặt: <?= htmlspecialchars($order['created_at']) ?></span>
                    </div>
                    <div>
                        <?php 
                        $statusBadge = match($order['order_status']) {
                            'completed' => 'bg-success',
                            'shipping' => 'bg-info',
                            'processing' => 'bg-warning',
                            'cancelled' => 'bg-danger',
                            default => 'bg-secondary'
                        };
                        ?>
                        <span class="badge <?= $statusBadge ?> px-3 py-2 text-uppercase rounded-pill fs-6"><?= htmlspecialchars($order['order_status']) ?></span>
                    </div>
                </div>

                <!-- Order Status Timeline -->
                <div class="p-3 bg-light rounded-4 mb-4 border" style="background: rgba(241, 245, 249, 0.6) !important;">
                    <div class="row text-center small g-2">
                        <div class="col-3">
                            <i class="bi bi-receipt fs-4 text-success"></i>
                            <div class="fw-bold text-success mt-1">Đã Đặt Hàng</div>
                        </div>
                        <div class="col-3">
                            <i class="bi bi-box-seam fs-4 <?= in_array($order['order_status'], ['processing', 'shipping', 'completed']) ? 'text-success' : 'text-muted' ?>"></i>
                            <div class="fw-bold <?= in_array($order['order_status'], ['processing', 'shipping', 'completed']) ? 'text-success' : 'text-muted' ?> mt-1">Đang Đóng Gói</div>
                        </div>
                        <div class="col-3">
                            <i class="bi bi-truck fs-4 <?= in_array($order['order_status'], ['shipping', 'completed']) ? 'text-success' : 'text-muted' ?>"></i>
                            <div class="fw-bold <?= in_array($order['order_status'], ['shipping', 'completed']) ? 'text-success' : 'text-muted' ?> mt-1">Đang Giao Hỏa Tốc</div>
                        </div>
                        <div class="col-3">
                            <i class="bi bi-check2-circle fs-4 <?= $order['order_status'] === 'completed' ? 'text-success' : 'text-muted' ?>"></i>
                            <div class="fw-bold <?= $order['order_status'] === 'completed' ? 'text-success' : 'text-muted' ?> mt-1">Hoàn Thành</div>
                        </div>
                    </div>
                </div>

                <!-- Product list -->
                <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-laptop me-2 text-danger"></i>Danh Sách Thiết Bị Điện Tử</h6>
                <div class="table-responsive">
                    <table class="table small align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Thiết bị</th>
                                <th>Đơn giá</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($item['product_name']) ?></div>
                                        <div class="text-muted small">SKU: <code><?= htmlspecialchars($item['product_sku']) ?></code></div>
                                    </td>
                                    <td><?= number_format((float)$item['unit_price'], 0, ',', '.') ?> ₫</td>
                                    <td class="text-center"><span class="badge bg-light text-muted border rounded-pill px-2 py-1">x<?= $item['quantity'] ?></span></td>
                                    <td class="text-end fw-bold text-danger"><?= number_format((float)$item['subtotal'], 0, ',', '.') ?> ₫</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end text-muted">Tổng phụ:</td>
                                <td class="text-end fw-bold text-dark"><?= $order['formatted_total'] ?></td>
                            </tr>
                            <?php if ((float)$order['discount_amount'] > 0): ?>
                                <tr>
                                    <td colspan="3" class="text-end text-success">Ưu đãi giảm giá:</td>
                                    <td class="text-end text-success fw-bold">-<?= $order['formatted_discount'] ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td colspan="3" class="text-end fw-bold fs-6 text-dark">Tổng cộng thanh toán:</td>
                                <td class="text-end fw-extrabold text-danger fs-5"><?= $order['formatted_final'] ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Customer info sidebar -->
        <div class="col-lg-4">
            <div class="card card-glass border-0 shadow-card rounded-4 p-4 mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2 text-dark"><i class="bi bi-geo-alt me-2 text-danger"></i>Thông Tin Giao Nhận</h5>
                <div class="small d-flex flex-column gap-2 mb-4">
                    <div>
                        <div class="text-muted">Người nhận thiết bị:</div>
                        <div class="fw-bold text-dark"><?= htmlspecialchars($order['customer_name']) ?></div>
                    </div>
                    <div>
                        <div class="text-muted">Số điện thoại:</div>
                        <div class="fw-bold text-dark"><?= htmlspecialchars($order['customer_phone']) ?></div>
                    </div>
                    <div>
                        <div class="text-muted">Email nhận hóa đơn VAT:</div>
                        <div class="text-dark"><?= htmlspecialchars($order['customer_email']) ?></div>
                    </div>
                    <div>
                        <div class="text-muted">Địa chỉ nhận hàng:</div>
                        <div class="fw-bold text-dark"><?= htmlspecialchars($order['shipping_address']) ?></div>
                    </div>
                    <?php if (!empty($order['notes'])): ?>
                        <div>
                            <div class="text-muted">Ghi chú giao hàng:</div>
                            <div class="fst-italic text-dark"><?= htmlspecialchars($order['notes']) ?></div>
                        </div>
                    <?php endif; ?>
                </div>

                <h5 class="fw-bold mb-3 border-bottom pb-2 text-dark"><i class="bi bi-credit-card me-2 text-danger"></i>Thanh Toán</h5>
                <div class="small d-flex flex-column gap-2">
                    <div>
                        <div class="text-muted">Hình thức:</div>
                        <div class="fw-bold text-dark"><?= $order['payment_method'] === 'bank_transfer' ? 'Chuyển khoản VietQR Napas 247' : 'COD (Tiền mặt khi giao & đồng kiểm)' ?></div>
                    </div>
                    <div>
                        <div class="text-muted">Trạng thái:</div>
                        <div>
                            <span class="badge <?= $order['payment_status'] === 'paid' ? 'bg-success' : 'bg-warning text-dark' ?> rounded-pill px-3 py-1">
                                <?= $order['payment_status'] === 'paid' ? '<i class="bi bi-check2 me-1"></i>Đã thanh toán' : 'Chờ thanh toán' ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <a href="/orders" class="btn btn-soft-slate w-100 py-2 fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách đơn hàng
            </a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
