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
            <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
        </ol>
    </nav>

    <h3 class="fw-bold mb-4"><i class="bi bi-credit-card-2-front me-2 text-primary"></i>Thông Tin Đặt Hàng & Thanh Toán</h3>

    <form action="/checkout/process" method="POST">
        <div class="row g-4 mb-5">
            <!-- Shipping Information Form -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-geo-alt-fill me-2 text-primary"></i>1. Thông Tin Nhận Hàng</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Họ và tên người nhận *</label>
                            <input type="text" name="customer_name" class="form-control" required value="<?= htmlspecialchars($user['name'] ?? '') ?>" placeholder="Nguyễn Văn A">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Số điện thoại liên hệ *</label>
                            <input type="tel" name="customer_phone" class="form-control" required value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="0901234567">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-muted">Địa chỉ Email nhận thông báo đơn *</label>
                            <input type="email" name="customer_email" class="form-control" required value="<?= htmlspecialchars($user['email'] ?? '') ?>" placeholder="name@example.com">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-muted">Địa chỉ chi tiết nhận hàng *</label>
                            <textarea name="shipping_address" class="form-control" rows="2" required placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-muted">Ghi chú giao hàng (nếu có)</label>
                            <input type="text" name="notes" class="form-control" placeholder="Giao giờ hành chính, gọi trước khi giao 15 phút...">
                        </div>
                    </div>
                </div>

                <!-- Payment Method Selection -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold mb-3"><i class="bi bi-wallet2 me-2 text-primary"></i>2. Phương Thức Thanh Toán</h5>

                    <div class="d-flex flex-column gap-3">
                        <label class="border p-3 rounded-3 d-flex align-items-center gap-3 cursor-pointer">
                            <input class="form-check-input mt-0" type="radio" name="payment_method" value="cod" checked>
                            <i class="bi bi-cash-coin fs-3 text-success"></i>
                            <div>
                                <div class="fw-bold small">Thanh toán khi nhận hàng (COD)</div>
                                <div class="text-muted small">Khách hàng kiểm tra thiết bị và thanh toán tiền mặt cho bưu tá khi nhận hàng.</div>
                            </div>
                        </label>

                        <label class="border p-3 rounded-3 d-flex align-items-center gap-3 cursor-pointer">
                            <input class="form-check-input mt-0" type="radio" name="payment_method" value="bank_transfer">
                            <i class="bi bi-qr-code-scan fs-3 text-primary"></i>
                            <div>
                                <div class="fw-bold small">Chuyển khoản Ngân hàng (Mã QR VietQR Chuẩn)</div>
                                <div class="text-muted small">Hệ thống tạo mã VietQR tự động điền số tiền và nội dung mã đơn hàng.</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Order Items Summary Sidebar -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white sticky-top" style="top: 100px;">
                    <h5 class="fw-bold mb-3">Đơn Hàng (<?= $cart['total_items'] ?> sản phẩm)</h5>

                    <div class="d-flex flex-column gap-3 mb-4 max-vh-50 overflow-y-auto">
                        <?php foreach ($cart['items'] as $item): ?>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-light text-dark border">x<?= $item['quantity'] ?></span>
                                    <div class="small fw-semibold line-clamp-1" style="max-width: 220px;"><?= htmlspecialchars($item['name']) ?></div>
                                </div>
                                <div class="small fw-bold text-primary"><?= $item['formatted_subtotal'] ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="border-top pt-3 mb-2 d-flex justify-content-between small">
                        <span class="text-muted">Tổng phụ:</span>
                        <span class="fw-medium"><?= $cart['formatted_subtotal'] ?></span>
                    </div>

                    <?php if ($cart['discount_amount'] > 0): ?>
                        <div class="d-flex justify-content-between small mb-2 text-success">
                            <span>Giảm giá (<?= htmlspecialchars($cart['coupon']['code']) ?>):</span>
                            <span>-<?= $cart['formatted_discount'] ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between small mb-3">
                        <span class="text-muted">Vận chuyển:</span>
                        <span class="text-success fw-medium">Miễn phí</span>
                    </div>

                    <div class="border-top pt-3 mb-4 d-flex justify-content-between align-items-baseline">
                        <span class="fw-bold">Thành Tiền:</span>
                        <span class="fs-4 fw-extrabold text-primary"><?= $cart['formatted_final_amount'] ?></span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">
                        <i class="bi bi-check2-circle me-2"></i> Xác Nhận Đặt Hàng
                    </button>

                    <p class="text-muted small text-center mt-3 mb-0" style="font-size: 0.75rem;">
                        Bằng việc đặt hàng, bạn đồng ý với Điều khoản dịch vụ và Chính sách bảo mật của 12B5 Store.
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
