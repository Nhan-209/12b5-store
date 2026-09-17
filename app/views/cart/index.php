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

    <h3 class="fw-bold mb-4"><i class="bi bi-cart3 me-2 text-primary"></i>Giỏ Hàng Công Nghệ</h3>

    <?php if (empty($cart['items'])): ?>
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white mb-5">
            <div class="text-muted mb-3">
                <i class="bi bi-cart-x display-1 text-secondary"></i>
            </div>
            <h4 class="fw-bold">Giỏ hàng của bạn đang trống!</h4>
            <p class="text-muted small mb-4">Hãy khám phá ngay hàng ngàn sản phẩm công nghệ đỉnh cao với mức giá ưu đãi.</p>
            <div>
                <a href="/products" class="btn btn-primary px-4 py-2 fw-semibold">Khám Phá Sản Phẩm Ngay</a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4 mb-5">
            <!-- Items Table -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Đơn giá</th>
                                    <th style="width: 140px;">Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart['items'] as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-light p-2 rounded-3 text-center" style="width: 50px; height: 50px;">
                                                    <i class="bi bi-device-hdd fs-4 text-primary opacity-75"></i>
                                                </div>
                                                <div>
                                                    <a href="/product/<?= urlencode($item['slug']) ?>" class="text-dark text-decoration-none fw-semibold small line-clamp-1">
                                                        <?= htmlspecialchars($item['name']) ?>
                                                    </a>
                                                    <div class="text-muted small">SKU: <?= htmlspecialchars($item['sku']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-medium small"><?= $item['formatted_price'] ?></td>
                                        <td>
                                            <form action="/cart/update" method="POST" class="d-flex align-items-center">
                                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                                <div class="input-group input-group-sm">
                                                    <button class="btn btn-outline-secondary" type="submit" name="quantity" value="<?= $item['quantity'] - 1 ?>">-</button>
                                                    <input type="number" class="form-control text-center font-monospace" value="<?= $item['quantity'] ?>" readonly style="max-width: 45px;">
                                                    <button class="btn btn-outline-secondary" type="submit" name="quantity" value="<?= $item['quantity'] + 1 ?>" <?= $item['quantity'] >= $item['stock'] ? 'disabled' : '' ?>>+</button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="fw-bold text-primary small"><?= $item['formatted_subtotal'] ?></td>
                                        <td class="text-end">
                                            <form action="/cart/remove" method="POST">
                                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Xóa">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                        <a href="/products" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>

            <!-- Summary & Coupon -->
            <div class="col-lg-4">
                <!-- Coupon box -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-tag-fill me-2 text-primary"></i>Mã Giảm Giá / Khuyến Mãi</h6>
                    <form action="/cart/coupon" method="POST">
                        <div class="input-group mb-2">
                            <input type="text" name="coupon_code" class="form-control form-control-sm text-uppercase font-monospace" placeholder="Nhập mã (VD: WELCOME2026)" value="<?= htmlspecialchars($cart['coupon']['code'] ?? '') ?>">
                            <button class="btn btn-primary btn-sm" type="submit">Áp dụng</button>
                        </div>
                        <div class="small text-muted" style="font-size: 0.75rem;">
                            Gợi ý: Mã <code>WELCOME2026</code> (giảm 500k), <code>TECHSALE10</code> (giảm 10%).
                        </div>
                    </form>
                </div>

                <!-- Order Calculation Summary -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold mb-3">Tóm Tắt Đơn Hàng</h5>

                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Tổng phụ (<?= $cart['total_items'] ?> sản phẩm):</span>
                        <span class="fw-medium"><?= $cart['formatted_subtotal'] ?></span>
                    </div>

                    <?php if ($cart['discount_amount'] > 0): ?>
                        <div class="d-flex justify-content-between mb-2 small text-success">
                            <span>Giảm giá (<?= htmlspecialchars($cart['coupon']['code']) ?>):</span>
                            <span>-<?= $cart['formatted_discount'] ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-muted">Phí vận chuyển:</span>
                        <span class="text-success fw-medium">Miễn phí toàn quốc</span>
                    </div>

                    <div class="border-top pt-3 mb-4 d-flex justify-content-between align-items-baseline">
                        <span class="fw-bold">Tổng Thanh Toán:</span>
                        <span class="fs-4 fw-extrabold text-primary"><?= $cart['formatted_final_amount'] ?></span>
                    </div>

                    <a href="/checkout" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                        <i class="bi bi-lock-fill me-1"></i> Tiến Hành Thanh Toán
                    </a>

                    <div class="text-center mt-3 small text-muted" style="font-size: 0.75rem;">
                        <i class="bi bi-shield-check text-success me-1"></i> Giao dịch bảo mật & an toàn 100%
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
