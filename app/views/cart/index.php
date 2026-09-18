<?php
$pageTitle = 'Giỏ Hàng';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Giỏ hàng của bạn</li>
        </ol>
    </nav>

    <!-- Free Shipping Milestone Progress Bar -->
    <div class="p-3 mb-4 rounded-4" style="background: linear-gradient(135deg, #fff1f2 0%, #f0fdf4 100%); border: 1px solid var(--accent-rose-border);">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="small fw-bold text-dark">
                <i class="bi bi-truck text-danger me-1"></i> Miễn phí vận chuyển hỏa tốc 2 giờ toàn quốc cho đơn hàng từ 5.000.000₫
            </span>
            <span class="badge bg-success rounded-pill px-3 py-1 small">
                <?= ($cart['subtotal'] >= 5000000) ? 'Đủ điều kiện Freeship' : 'Chưa đạt' ?>
            </span>
        </div>
        <div class="progress" style="height: 7px; border-radius: 9999px;">
            <?php 
                $percent = min(100, round(($cart['subtotal'] / 5000000) * 100));
            ?>
            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?= $percent ?>%"></div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-dark"><i class="bi bi-cart3 me-2 text-danger"></i>Giỏ Hàng Công Nghệ (<?= $cart['total_items'] ?> thiết bị)</h3>
        <a href="/products" class="btn btn-soft-slate btn-sm"><i class="bi bi-arrow-left me-1"></i> Tiếp tục mua sắm</a>
    </div>

    <?php if (empty($cart['items'])): ?>
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white mb-5">
            <div class="text-muted mb-3">
                <i class="bi bi-cart-x display-1 text-secondary opacity-50"></i>
            </div>
            <h4 class="fw-bold text-dark">Giỏ hàng của bạn đang trống!</h4>
            <p class="text-muted small mb-4">Khám phá ngay hàng trăm thiết bị công nghệ chính hãng đỉnh cao với mức giá ưu đãi tại 12B5 Store.</p>
            <div>
                <a href="/products" class="btn btn-rose px-4 py-2 fw-semibold">Khám Phá Sản Phẩm Ngay</a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4 mb-5">
            <!-- Items Table -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="border: 1px solid var(--border-color) !important;">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.5px;">Sản phẩm</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.5px;">Đơn giá</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.5px; width: 140px;">Số lượng</th>
                                    <th style="font-size: 0.75rem; letter-spacing: 0.5px;">Thành tiền</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart['items'] as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-light p-1 rounded-3 text-center border d-flex align-items-center justify-content-center flex-shrink-0" style="width: 56px; height: 56px;">
                                                    <img src="<?= htmlspecialchars($item['image_url'] ?? 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=150') ?>" class="rounded-2" style="width: 48px; height: 48px; object-fit: cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                    <i class="bi <?= htmlspecialchars($item['device_icon'] ?? 'bi-laptop') ?> fs-4 text-primary" style="display: none;"></i>
                                                </div>
                                                <div>
                                                    <a href="/product/<?= urlencode($item['slug']) ?>" class="text-dark text-decoration-none fw-bold small line-clamp-1" title="<?= htmlspecialchars($item['name']) ?>">
                                                        <?= htmlspecialchars($item['name']) ?>
                                                    </a>
                                                    <div class="text-muted small">SKU: <span class="font-monospace"><?= htmlspecialchars($item['sku']) ?></span> &bull; <span class="text-success"><i class="bi bi-check2"></i> Còn hàng</span></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-semibold small text-dark"><?= $item['formatted_price'] ?></td>
                                        <td>
                                            <form action="/cart/update" method="POST" class="d-flex align-items-center">
                                                <?= \App\Core\Csrf::field() ?>
                                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                                <div class="input-group input-group-sm">
                                                    <button class="btn btn-outline-secondary rounded-start-pill" type="submit" name="quantity" value="<?= $item['quantity'] - 1 ?>">-</button>
                                                    <input type="number" class="form-control text-center font-monospace fw-bold" value="<?= $item['quantity'] ?>" readonly style="max-width: 45px;">
                                                    <button class="btn btn-outline-secondary rounded-end-pill" type="submit" name="quantity" value="<?= $item['quantity'] + 1 ?>" <?= $item['quantity'] >= $item['stock'] ? 'disabled' : '' ?>>+</button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="fw-bold text-danger small"><?= $item['formatted_subtotal'] ?></td>
                                        <td class="text-end">
                                            <form action="/cart/remove" method="POST">
                                                <?= \App\Core\Csrf::field() ?>
                                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                                <button type="submit" class="btn btn-sm text-danger p-0 border-0 bg-transparent" title="Xóa sản phẩm">
                                                    <i class="bi bi-trash3 fs-5"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Trust Footer under Cart Items -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-3 border-top text-muted small">
                        <div>
                            <i class="bi bi-shield-check text-success me-1"></i> Bảo hành chính hãng & Bao đổi trả 30 ngày
                        </div>
                        <div>
                            <i class="bi bi-qr-code-scan text-primary me-1"></i> Hỗ trợ quét mã VietQR thuận tiện
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary & Coupon Sidebar -->
            <div class="col-lg-4">
                <!-- Coupon Code Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" style="border: 1px solid var(--border-color) !important;">
                    <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-ticket-perforated-fill me-2 text-danger"></i>Mã Ưu Đãi / Khuyến Mãi</h6>
                    <form action="/cart/coupon" method="POST">
                        <?= \App\Core\Csrf::field() ?>
                        <div class="input-group mb-2">
                            <input type="text" name="coupon_code" class="form-control form-control-sm rounded-start-pill text-uppercase font-monospace" placeholder="Nhập mã (TECH2026...)" value="<?= htmlspecialchars($cart['coupon']['code'] ?? '') ?>">
                            <button class="btn btn-rose btn-sm rounded-end-pill px-3" type="submit">Áp Dụng</button>
                        </div>
                    </form>

                    <!-- Quick Coupon Chips -->
                    <div class="d-flex flex-wrap gap-1 mt-2">
                        <span class="badge bg-light text-danger border rounded-pill px-2 py-1 small cursor-pointer" onclick="document.querySelector('input[name=coupon_code]').value='TECH2026'">
                            Mã: TECH2026 (-10%)
                        </span>
                        <span class="badge bg-light text-primary border rounded-pill px-2 py-1 small cursor-pointer" onclick="document.querySelector('input[name=coupon_code]').value='VIP500'">
                            Mã: VIP500 (-500k)
                        </span>
                    </div>

                    <?php if (!empty($cart['coupon'])): ?>
                        <div class="alert alert-success d-flex justify-content-between align-items-center mt-3 mb-0 p-2 rounded-3 small">
                            <span><i class="bi bi-check-circle-fill me-1"></i> Đã áp dụng: <strong><?= htmlspecialchars($cart['coupon']['code']) ?></strong></span>
                            <form action="/cart/coupon" method="POST" class="d-inline">
                                <?= \App\Core\Csrf::field() ?>
                                <input type="hidden" name="coupon_code" value="">
                                <button type="submit" class="btn btn-link btn-sm text-danger p-0" title="Bỏ mã"><i class="bi bi-x-circle-fill"></i></button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Order Summary Breakdown -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="border: 1px solid var(--border-color) !important;">
                    <h6 class="fw-bold mb-3 text-dark">Tóm Tắt Đơn Hàng</h6>

                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-muted">Tổng tiền hàng:</span>
                        <span class="fw-semibold text-dark"><?= $cart['formatted_subtotal'] ?></span>
                    </div>

                    <?php if ($cart['discount_amount'] > 0): ?>
                        <div class="d-flex justify-content-between small mb-2 text-success">
                            <span>Giảm giá khuyến mãi:</span>
                            <span class="fw-bold">-<?= $cart['formatted_discount'] ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between small mb-3">
                        <span class="text-muted">Phí vận chuyển:</span>
                        <span class="text-success fw-semibold"><?= ($cart['subtotal'] >= 5000000) ? 'Miễn phí (Freeship)' : '30.000₫' ?></span>
                    </div>

                    <div class="border-top pt-3 mb-4 d-flex justify-content-between align-items-baseline">
                        <span class="fw-bold text-dark fs-6">Tổng thanh toán:</span>
                        <span class="fs-4 fw-extrabold text-danger"><?= $cart['formatted_final_total'] ?></span>
                    </div>

                    <a href="/checkout" class="btn btn-rose w-100 py-2 fw-bold shadow-sm mb-2">
                        Tiến Hành Đặt Hàng & Thanh Toán <i class="bi bi-arrow-right ms-1"></i>
                    </a>

                    <div class="text-center text-muted small" style="font-size: 0.75rem;">
                        <i class="bi bi-shield-lock-fill text-success me-1"></i> Giao dịch an toàn & Bảo mật 100%
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
