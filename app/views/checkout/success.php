<?php
$pageTitle = 'Đặt Hàng Thành Công';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <!-- Success Notification Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 text-center bg-white mb-4">
                <div class="text-success mb-3">
                    <i class="bi bi-check-circle-fill display-2"></i>
                </div>
                <h3 class="fw-bold text-success mb-2">Đặt Hàng Thành Công!</h3>
                <p class="text-muted">Cảm ơn bạn đã tin tưởng và mua sắm tại 12B5 Store. Mã đơn hàng của bạn là:</p>
                <div class="d-inline-block bg-light px-4 py-2 rounded-3 border fw-bold fs-4 text-primary font-monospace mb-3">
                    <?= htmlspecialchars($order['order_code']) ?>
                </div>
                <p class="small text-muted mb-0">Thông tin xác nhận đơn hàng đã được gửi tới email <strong><?= htmlspecialchars($order['customer_email']) ?></strong>.</p>
            </div>

            <!-- VietQR Payment Code if Bank Transfer -->
            <?php if (!empty($qrUrl)): ?>
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4 text-center">
                    <h5 class="fw-bold text-primary mb-2"><i class="bi bi-qr-code me-2"></i>Thanh Toán Chuyển Khoản Qua VietQR</h5>
                    <p class="text-muted small mb-3">Mở ứng dụng ngân hàng bất kỳ (Vietcombank, MBBank, Techcombank, Momo...) và quét mã QR bên dưới để thanh toán tự động:</p>
                    
                    <div class="p-3 bg-light d-inline-block rounded-4 border mb-3 mx-auto">
                        <img src="<?= htmlspecialchars($qrUrl) ?>" alt="VietQR Payment" class="img-fluid rounded-3 shadow-xs" style="max-width: 280px;">
                    </div>

                    <div class="row g-2 justify-content-center small text-start" style="max-width: 400px; margin: 0 auto;">
                        <div class="col-6 text-muted">Ngân hàng:</div>
                        <div class="col-6 fw-bold">MBBank (Quân Đội)</div>
                        <div class="col-6 text-muted">Số tài khoản:</div>
                        <div class="col-6 fw-bold font-monospace">0901234567</div>
                        <div class="col-6 text-muted">Chủ tài khoản:</div>
                        <div class="col-6 fw-bold">CONG TY ELECTRO STORE</div>
                        <div class="col-6 text-muted">Số tiền:</div>
                        <div class="col-6 fw-bold text-danger"><?= $order['formatted_final'] ?></div>
                        <div class="col-6 text-muted">Nội dung chuyển khoản:</div>
                        <div class="col-6 fw-bold font-monospace text-primary"><?= htmlspecialchars($order['order_code']) ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Order Details Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Chi Tiết Đơn Hàng</h5>

                <div class="row g-3 mb-4 small">
                    <div class="col-md-6">
                        <div class="text-muted">Người nhận:</div>
                        <div class="fw-bold"><?= htmlspecialchars($order['customer_name']) ?> (<?= htmlspecialchars($order['customer_phone']) ?>)</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted">Địa chỉ nhận hàng:</div>
                        <div class="fw-bold"><?= htmlspecialchars($order['shipping_address']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted">Phương thức thanh toán:</div>
                        <div class="fw-bold"><?= $order['payment_method'] === 'bank_transfer' ? 'Chuyển khoản VietQR' : 'Thanh toán COD khi nhận hàng' ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted">Trạng thái đơn:</div>
                        <div><span class="badge bg-warning text-dark text-uppercase"><?= htmlspecialchars($order['order_status']) ?></span></div>
                    </div>
                </div>

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
                                    <td class="fw-semibold"><?= htmlspecialchars($item['product_name']) ?></td>
                                    <td><?= number_format((float)$item['unit_price'], 0, ',', '.') ?> ₫</td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td class="text-end fw-bold"><?= number_format((float)$item['subtotal'], 0, ',', '.') ?> ₫</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Tổng thanh toán:</td>
                                <td class="text-end fw-extrabold text-primary fs-6"><?= $order['formatted_final'] ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-3">
                <a href="/" class="btn btn-primary px-4">Về Trang Chủ</a>
                <a href="/orders" class="btn btn-outline-secondary px-4">Xem Lịch Sử Đơn</a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
