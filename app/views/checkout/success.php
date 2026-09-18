<?php
$pageTitle = 'Đặt Hàng Thành Công';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <!-- 3-Step Checkout Progress Stepper -->
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white" style="border: 1px solid var(--border-color) !important;">
        <div class="row text-center g-2 small">
            <div class="col-4">
                <div class="p-2 rounded-3 bg-light text-muted">
                    <i class="bi bi-cart-check-fill text-success me-1"></i> 1. Giỏ Hàng
                </div>
            </div>
            <div class="col-4">
                <div class="p-2 rounded-3 bg-light text-muted">
                    <i class="bi bi-geo-alt-fill text-success me-1"></i> 2. Thông Tin & Thanh Toán
                </div>
            </div>
            <div class="col-4">
                <div class="p-2 rounded-3 fw-bold text-danger" style="background: var(--accent-rose-subtle); border: 1px solid var(--accent-rose-border);">
                    <i class="bi bi-check-circle-fill me-1"></i> 3. Hoàn Tất Đơn Hàng
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <!-- Success Notification Card -->
            <div class="card border-0 shadow-card rounded-4 p-4 p-md-5 text-center bg-white mb-4" style="background: linear-gradient(135deg, rgba(255,255,255,0.92) 0%, rgba(255,241,242,0.6) 100%); border: 1px solid var(--accent-rose-border) !important;">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 72px; height: 72px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35);">
                        <i class="bi bi-check2 display-4"></i>
                    </div>
                </div>
                <span class="badge bg-success rounded-pill px-3 py-1 small mb-2">ĐÃ XÁC NHẬN HỆ THỐNG</span>
                <h3 class="fw-bold text-dark mb-2">Đặt Hàng Thành Công!</h3>
                <p class="text-muted">Cảm ơn bạn đã tin tưởng và mua sắm thiết bị tại <strong>12B5 Store</strong>. Mã đơn hàng của bạn là:</p>
                <div class="d-inline-block px-4 py-2 rounded-pill fw-bold fs-4 text-danger font-monospace mb-3" style="background: var(--accent-rose-subtle); border: 1.5px dashed var(--accent-rose-border);">
                    <?= htmlspecialchars($order['order_code']) ?>
                </div>
                <p class="small text-muted mb-0">Thông tin đơn hàng đã được ghi nhận trên hệ thống. Nhân viên CSKH sẽ liên hệ xác nhận đơn hàng.</p>
            </div>

            <!-- VietQR Payment Code if Bank Transfer -->
            <?php if (!empty($qrUrl)): ?>
                <div class="vietqr-card mb-4 text-center">
                    <div class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1 fw-bold small mb-2">
                        <i class="bi bi-patch-check-fill"></i> VietQR Napas 247 Chuẩn Quốc Gia
                    </div>
                    <h5 class="fw-bold text-dark mb-1"><i class="bi bi-qr-code me-2 text-danger"></i>Thanh Toán Chuyển Khoản Qua VietQR</h5>
                    <p class="text-muted small mb-3">Hiển thị mã VietQR để khách hàng quét và thực hiện chuyển khoản thuận tiện qua ứng dụng Mobile Banking bất kỳ:</p>
                    
                    <div class="vietqr-image-container mb-3">
                        <img src="<?= htmlspecialchars($qrUrl) ?>" alt="VietQR Payment" class="img-fluid rounded-3 shadow-xs" style="max-width: 260px;">
                    </div>

                    <div class="bank-detail-box mb-3" style="max-width: 480px; margin: 0 auto;">
                        <div class="bank-copy-row">
                            <span class="text-muted">Ngân hàng thụ hưởng:</span>
                            <strong class="text-dark">MBBank (Ngân Hàng Quân Đội)</strong>
                        </div>
                        <div class="bank-copy-row">
                            <span class="text-muted">Số tài khoản:</span>
                            <div>
                                <strong class="font-monospace text-primary">0901234567</strong>
                                <button type="button" class="btn-copy-code ms-1" onclick="navigator.clipboard.writeText('0901234567'); alert('Đã sao chép số tài khoản MBBank!');">Sao chép</button>
                            </div>
                        </div>
                        <div class="bank-copy-row">
                            <span class="text-muted">Chủ tài khoản:</span>
                            <strong class="text-dark">CONG TY CONG NGHE 12B5 STORE</strong>
                        </div>
                        <div class="bank-copy-row">
                            <span class="text-muted">Số tiền thanh toán:</span>
                            <strong class="text-danger fw-bold fs-6"><?= $order['formatted_final'] ?></strong>
                        </div>
                        <div class="bank-copy-row">
                            <span class="text-muted">Nội dung chuyển khoản:</span>
                            <div>
                                <strong class="font-monospace text-primary"><?= htmlspecialchars($order['order_code']) ?></strong>
                                <button type="button" class="btn-copy-code ms-1" onclick="navigator.clipboard.writeText('<?= htmlspecialchars($order['order_code']) ?>'); alert('Đã sao chép cú pháp đơn hàng!');">Sao chép</button>
                            </div>
                        </div>
                    </div>
                    <div class="small text-muted"><i class="bi bi-info-circle me-1 text-primary"></i> Vui lòng giữ đúng nội dung chuyển khoản để cửa hàng kiểm tra đối soát và tiến hành giao hàng nhanh chóng.</div>
                </div>
            <?php endif; ?>

            <!-- Order Details Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" style="border: 1px solid var(--border-color) !important;">
                <h5 class="fw-bold mb-3 border-bottom pb-2 text-dark"><i class="bi bi-receipt me-2 text-danger"></i>Chi Tiết Đơn Hàng</h5>

                <div class="row g-3 mb-4 small">
                    <div class="col-md-6">
                        <div class="text-muted">Người nhận thiết bị:</div>
                        <div class="fw-bold text-dark"><?= htmlspecialchars($order['customer_name']) ?> (<?= htmlspecialchars($order['customer_phone']) ?>)</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted">Địa chỉ giao hỏa tốc:</div>
                        <div class="fw-bold text-dark"><?= htmlspecialchars($order['shipping_address']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted">Phương thức thanh toán:</div>
                        <div class="fw-bold text-dark"><?= $order['payment_method'] === 'bank_transfer' ? 'Chuyển khoản VietQR Napas 247' : 'Thanh toán COD khi nhận hàng (Đồng kiểm)' ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted">Trạng thái xử lý:</div>
                        <div><span class="badge bg-warning text-dark text-uppercase"><?= htmlspecialchars($order['order_status']) ?></span></div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table small align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Thiết bị điện tử</th>
                                <th>Đơn giá</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td class="fw-semibold text-dark"><?= htmlspecialchars($item['product_name']) ?></td>
                                    <td><?= number_format((float)$item['unit_price'], 0, ',', '.') ?> ₫</td>
                                    <td class="text-center"><span class="badge bg-light text-muted border rounded-pill px-2 py-1">x<?= $item['quantity'] ?></span></td>
                                    <td class="text-end fw-bold text-danger"><?= number_format((float)$item['subtotal'], 0, ',', '.') ?> ₫</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold text-dark">Tổng thanh toán:</td>
                                <td class="text-end fw-extrabold text-danger fs-5"><?= $order['formatted_final'] ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-3">
                <a href="/" class="btn btn-rose px-4 py-2 fw-semibold shadow-sm"><i class="bi bi-house me-1"></i> Về Trang Chủ</a>
                <a href="/orders" class="btn btn-soft-slate px-4 py-2"><i class="bi bi-clock-history me-1"></i> Xem Lịch Sử Đơn</a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
