<?php
$pageTitle = 'Thanh Toán Đơn Hàng';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="/cart" class="text-decoration-none">Giỏ hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thanh toán đơn hàng</li>
        </ol>
    </nav>

    <!-- 3-Step Checkout Progress Stepper -->
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white" style="border: 1px solid var(--border-color) !important;">
        <div class="row text-center g-2 small">
            <div class="col-4">
                <div class="p-2 rounded-3 bg-light text-muted">
                    <i class="bi bi-cart-check-fill text-success me-1"></i> 1. Giỏ Hàng
                </div>
            </div>
            <div class="col-4">
                <div class="p-2 rounded-3 fw-bold text-danger" style="background: var(--accent-rose-subtle); border: 1px solid var(--accent-rose-border);">
                    <i class="bi bi-geo-alt-fill me-1"></i> 2. Thông Tin & Thanh Toán
                </div>
            </div>
            <div class="col-4">
                <div class="p-2 rounded-3 bg-light text-muted">
                    <i class="bi bi-check-circle me-1"></i> 3. Hoàn Tất Đơn Hàng
                </div>
            </div>
        </div>
    </div>

    <h3 class="fw-bold mb-4 text-dark"><i class="bi bi-credit-card-2-front me-2 text-danger"></i>Đặt Hàng & Thanh Toán Trực Tuyến</h3>

    <form action="/checkout/process" method="POST">
        <?= \App\Core\Csrf::field() ?>
        <div class="row g-4 mb-5">
            <!-- Left Form Area -->
            <div class="col-lg-7">
                <!-- 1. Shipping Information -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" style="border: 1px solid var(--border-color) !important;">
                    <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-geo-alt-fill me-2 text-danger"></i>1. Địa Chỉ Nhận Hàng</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Họ và tên người nhận *</label>
                            <input type="text" name="customer_name" class="form-control rounded-3" required value="<?= htmlspecialchars($user['name'] ?? '') ?>" placeholder="Nguyễn Văn A">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Số điện thoại liên hệ *</label>
                            <input type="tel" name="customer_phone" class="form-control rounded-3" required value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="0901234567">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Địa chỉ Email nhận hóa đơn điện tử *</label>
                            <input type="email" name="customer_email" class="form-control rounded-3" required value="<?= htmlspecialchars($user['email'] ?? '') ?>" placeholder="name@example.com">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Địa chỉ chi tiết nhận thiết bị *</label>
                            <textarea name="shipping_address" class="form-control rounded-3" rows="2" required placeholder="Số nhà, tên đường, tòa nhà/phường xã, quận huyện, tỉnh thành..."><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Ghi chú giao hàng (nếu có)</label>
                            <input type="text" name="notes" class="form-control rounded-3" placeholder="Giao giờ hành chính, gọi trước 15 phút, đồng kiểm thiết bị...">
                        </div>
                    </div>
                </div>

                <!-- 2. Payment Method & VietQR Showcase -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" style="border: 1px solid var(--border-color) !important;">
                    <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-wallet2 me-2 text-danger"></i>2. Phương Thức Thanh Toán</h5>

                    <div class="d-flex flex-column gap-3 mb-3">
                        <label class="p-3 rounded-4 border d-flex align-items-center gap-3 cursor-pointer" style="background: #f8fafc; transition: all 0.2s;">
                            <input class="form-check-input mt-0" type="radio" name="payment_method" value="cod" checked onchange="document.getElementById('vietqrBox').style.display='none';">
                            <div class="p-2 rounded-3 bg-success bg-opacity-10 text-success fs-4">
                                <i class="bi bi-cash-coin"></i>
                            </div>
                            <div>
                                <div class="fw-bold small text-dark">Thanh toán khi nhận hàng (COD)</div>
                                <div class="text-muted small">Khách hàng được mở hộp đồng kiểm thiết bị cùng bưu tá trước khi thanh toán tiền mặt.</div>
                            </div>
                        </label>

                        <label class="p-3 rounded-4 border d-flex align-items-center gap-3 cursor-pointer" style="background: #fff1f2; border-color: var(--accent-rose-border) !important; transition: all 0.2s;">
                            <input class="form-check-input mt-0" type="radio" name="payment_method" value="bank_transfer" onchange="document.getElementById('vietqrBox').style.display='block';">
                            <div class="p-2 rounded-3 bg-danger bg-opacity-10 text-danger fs-4">
                                <i class="bi bi-qr-code-scan"></i>
                            </div>
                            <div>
                                <div class="fw-bold small text-danger">Chuyển khoản Ngân hàng (Mã VietQR NAPAS 247)</div>
                                <div class="text-muted small">Hiển thị mã VietQR để khách hàng quét và thực hiện chuyển khoản thuận tiện qua ứng dụng ngân hàng bất kỳ.</div>
                            </div>
                        </label>
                    </div>

                    <!-- Dynamic VietQR Instruction Box -->
                    <div id="vietqrBox" class="vietqr-card mt-3" style="display: none;">
                        <div class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1 fw-bold small mb-2">
                            <i class="bi bi-patch-check-fill"></i> VietQR Napas 247 Chuẩn Quốc Gia
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Quét Mã VietQR Để Thanh Toán Ngay</h6>
                        <p class="text-muted small mb-3">Mở ứng dụng Mobile Banking của bạn để quét mã QR bên dưới:</p>

                        <div class="vietqr-image-container">
                            <div class="p-3 bg-white border rounded-3 text-center">
                                <i class="bi bi-qr-code display-3 text-dark"></i>
                                <div class="small fw-bold text-danger mt-2">12B5 STORE VIETQR</div>
                            </div>
                        </div>

                        <div class="bank-detail-box">
                            <div class="bank-copy-row">
                                <span class="text-muted">Ngân hàng thụ hưởng:</span>
                                <strong class="text-dark">MBBank (Ngân Hàng Quân Đội)</strong>
                            </div>
                            <div class="bank-copy-row">
                                <span class="text-muted">Số tài khoản:</span>
                                <div>
                                    <strong class="font-monospace text-primary">0912345678</strong>
                                    <button type="button" class="btn-copy-code ms-1" onclick="navigator.clipboard.writeText('0912345678'); alert('Đã sao chép số tài khoản!');">Sao chép</button>
                                </div>
                            </div>
                            <div class="bank-copy-row">
                                <span class="text-muted">Chủ tài khoản:</span>
                                <strong class="text-dark">CONG TY TNHH THIET BI DIEN TU 12B5</strong>
                            </div>
                            <div class="bank-copy-row">
                                <span class="text-muted">Số tiền thanh toán:</span>
                                <strong class="text-danger fw-bold"><?= $cart['formatted_final_total'] ?></strong>
                            </div>
                            <div class="bank-copy-row">
                                <span class="text-muted">Nội dung chuyển khoản:</span>
                                <div>
                                    <strong class="font-monospace text-dark">12B5 <?= htmlspecialchars($user['phone'] ?? 'ORDER') ?></strong>
                                    <button type="button" class="btn-copy-code ms-1" onclick="navigator.clipboard.writeText('12B5 <?= htmlspecialchars($user['phone'] ?? 'ORDER') ?>'); alert('Đã sao chép nội dung!');">Sao chép</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Company VAT Invoice Checkbox -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="border: 1px solid var(--border-color) !important;">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="vatToggle" onchange="document.getElementById('vatFields').style.display = this.checked ? 'block' : 'none';">
                        <label class="form-check-label small fw-bold text-dark" for="vatToggle">
                            <i class="bi bi-receipt-cutoff me-1 text-primary"></i> Yêu cầu xuất Hóa Đơn Điện Tử VAT Doanh Nghiệp
                        </label>
                    </div>

                    <div id="vatFields" class="row g-2 mt-2" style="display: none;">
                        <div class="col-md-6">
                            <input type="text" class="form-control form-control-sm rounded-3" placeholder="Mã số thuế doanh nghiệp (MST)">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control form-control-sm rounded-3" placeholder="Tên công ty / Doanh nghiệp">
                        </div>
                        <div class="col-12">
                            <input type="text" class="form-control form-control-sm rounded-3" placeholder="Địa chỉ đăng ký kinh doanh">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar: Order Summary -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white sticky-top" style="top: 100px; border: 1px solid var(--border-color) !important;">
                    <h5 class="fw-bold mb-3 text-dark">Đơn Hàng Của Bạn (<?= $cart['total_items'] ?> thiết bị)</h5>

                    <div class="d-flex flex-column gap-3 mb-4" style="max-height: 280px; overflow-y: auto;">
                        <?php foreach ($cart['items'] as $item): ?>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-light text-muted border rounded-pill small">x<?= $item['quantity'] ?></span>
                                    <div class="small fw-semibold text-dark line-clamp-1" style="max-width: 220px;" title="<?= htmlspecialchars($item['name']) ?>">
                                        <?= htmlspecialchars($item['name']) ?>
                                    </div>
                                </div>
                                <div class="small fw-bold text-danger"><?= $item['formatted_subtotal'] ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-muted">Tổng tiền hàng:</span>
                        <span class="fw-medium text-dark"><?= $cart['formatted_subtotal'] ?></span>
                    </div>

                    <?php if ($cart['discount_amount'] > 0): ?>
                        <div class="d-flex justify-content-between small mb-2 text-success">
                            <span>Ưu đãi (<?= htmlspecialchars($cart['coupon']['code']) ?>):</span>
                            <span class="fw-bold">-<?= $cart['formatted_discount'] ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between small mb-3">
                        <span class="text-muted">Phí giao hàng hỏa tốc:</span>
                        <span class="text-success fw-bold"><?= ($cart['subtotal'] >= 5000000) ? '0 ₫ (Miễn phí)' : '30.000 ₫' ?></span>
                    </div>

                    <div class="border-top pt-3 mb-4 d-flex justify-content-between align-items-baseline">
                        <span class="fw-bold text-dark fs-6">Tổng thanh toán:</span>
                        <span class="fs-3 fw-extrabold text-danger"><?= $cart['formatted_final_total'] ?></span>
                    </div>

                    <button type="submit" class="btn btn-rose w-100 py-3 fw-bold shadow-sm mb-3">
                        <i class="bi bi-shield-check me-2"></i> Xác Nhận Đặt Hàng Ngay
                    </button>

                    <div class="p-3 bg-light rounded-4 border text-muted small" style="font-size: 0.78rem;">
                        <div class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Hàng chính hãng nguyên seal xuất kho trực tiếp</div>
                        <div class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Đồng kiểm trước khi thanh toán</div>
                        <div><i class="bi bi-check2 text-success me-1"></i> Hỗ trợ đổi trả miễn phí trong 30 ngày</div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
