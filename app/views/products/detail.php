<?php
$pageTitle = $product['name'];
require __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="/products" class="text-decoration-none">Sản phẩm</a></li>
            <li class="breadcrumb-item"><a href="/products?category=<?= urlencode($product['category_slug']) ?>" class="text-decoration-none"><?= htmlspecialchars($product['category_name']) ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($product['name']) ?></li>
        </ol>
    </nav>

    <div class="row g-4 mb-5">
        <!-- Product Images Gallery -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-white h-100 d-flex align-items-center justify-content-center" style="min-height: 380px;">
                <i class="bi bi-device-hdd display-1 text-primary opacity-75"></i>
                <div class="mt-4 text-muted small">
                    <i class="bi bi-shield-check text-success me-1"></i> Sản phẩm chính hãng 100% nguyên seal
                </div>
            </div>
        </div>

        <!-- Product Purchase Information -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-semibold">
                        <?= htmlspecialchars($product['brand_name']) ?> &bull; <?= htmlspecialchars($product['category_name']) ?>
                    </span>
                    <span class="text-muted small">Mã SP: <strong><?= htmlspecialchars($product['sku']) ?></strong></span>
                </div>

                <h2 class="fw-bold mb-3"><?= htmlspecialchars($product['name']) ?></h2>

                <!-- Rating -->
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="text-warning">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="bi <?= $i <= round($product['rating']) ? 'bi-star-fill' : 'bi-star' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <span class="fw-bold"><?= $product['rating'] ?></span>
                    <span class="text-muted small">(<?= $product['review_count'] ?> đánh giá từ khách hàng)</span>
                    <span class="text-muted small">| Đã bán: <?= $product['sales_count'] ?></span>
                </div>

                <!-- Price Box -->
                <div class="p-3 bg-light rounded-4 mb-4 d-flex align-items-baseline gap-3">
                    <span class="fs-2 fw-extrabold text-primary"><?= $product['formatted_price'] ?></span>
                    <?php if ($product['formatted_original_price']): ?>
                        <span class="text-muted text-decoration-line-through fs-5"><?= $product['formatted_original_price'] ?></span>
                        <span class="badge bg-danger">Tiết kiệm <?= $product['discount_percent'] ?>%</span>
                    <?php endif; ?>
                </div>

                <!-- Short description -->
                <p class="text-muted mb-4">
                    <?= nl2br(htmlspecialchars($product['short_description'] ?? '')) ?>
                </p>

                <!-- Stock & Add to Cart Form -->
                <form action="/cart/add" method="POST" class="mb-4">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <label class="fw-bold small text-muted text-uppercase mb-0">Số Lượng:</label>
                        <div class="input-group" style="max-width: 140px;">
                            <button class="btn btn-outline-secondary" type="button" onclick="let input = document.getElementById('qtyInput'); if(input.value > 1) input.value--;">-</button>
                            <input type="number" id="qtyInput" name="quantity" class="form-control text-center font-monospace fw-bold" value="1" min="1" max="<?= $product['stock'] ?>">
                            <button class="btn btn-outline-secondary" type="button" onclick="let input = document.getElementById('qtyInput'); if(input.value < <?= $product['stock'] ?>) input.value++;">+</button>
                        </div>
                        <span class="small <?= $product['stock'] > 0 ? 'text-success' : 'text-danger' ?>">
                            <i class="bi <?= $product['stock'] > 0 ? 'bi-check-circle-fill' : 'bi-x-circle-fill' ?> me-1"></i>
                            <?= $product['stock'] > 0 ? 'Còn hàng trong kho (' . $product['stock'] . ' sản phẩm)' : 'Tạm hết hàng' ?>
                        </span>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary btn-lg px-4 flex-grow-1 fw-bold shadow-sm" <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>
                            <i class="bi bi-cart-plus me-2"></i> Thêm Vào Giỏ Hàng
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-lg px-3 btn-ajax-add-cart" data-product-id="<?= $product['id'] ?>" title="Thêm nhanh">
                            <i class="bi bi-lightning-charge"></i>
                        </button>
                    </div>
                </form>

                <!-- Guarantee checklist -->
                <div class="border-top pt-3 text-muted small d-flex flex-column gap-2">
                    <div><i class="bi bi-shield-check text-primary me-2"></i>Bảo hành 12 tháng tại các trung tâm bảo hành ủy quyền</div>
                    <div><i class="bi bi-arrow-counterclockwise text-primary me-2"></i>Đổi mới trong 30 ngày nếu có lỗi do nhà sản xuất</div>
                    <div><i class="bi bi-truck text-primary me-2"></i>Miễn phí vận chuyển toàn quốc cho đơn hàng từ 5.000.000đ</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Technical Specifications Table & Full Description -->
    <div class="row g-4 mb-5">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h4 class="fw-bold mb-3"><i class="bi bi-file-text me-2 text-primary"></i>Mô Tả Chi Tiết Sản Phẩm</h4>
                <div class="text-muted lh-lg">
                    <?= nl2br(htmlspecialchars($product['description'] ?? '')) ?>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h4 class="fw-bold mb-3"><i class="bi bi-cpu me-2 text-primary"></i>Thông Số Kỹ Thuật</h4>
                <?php if (!empty($product['specs_array'])): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover small mb-0">
                            <tbody>
                                <?php foreach ($product['specs_array'] as $specKey => $specVal): ?>
                                    <tr>
                                        <th class="text-muted fw-semibold text-uppercase" style="width: 35%;"><?= htmlspecialchars(str_replace('_', ' ', $specKey)) ?></th>
                                        <td class="fw-medium"><?= htmlspecialchars(is_array($specVal) ? implode(', ', $specVal) : $specVal) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted small">Chưa có thông số kỹ thuật chi tiết.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Smart Related Recommendations via Rust Cosine Similarity -->
    <?php if (!empty($relatedProducts)): ?>
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="fw-bold mb-1">Thiết Bị Cùng Phân Khúc Đề Xuất</h4>
                    <span class="badge <?= $engineInfo['engine'] === 'rust' ? 'bg-warning text-dark' : 'bg-secondary' ?>">
                        <i class="bi bi-cpu-fill"></i> Cosine Similarity: <?= $engineInfo['engine'] === 'rust' ? 'Rust High-Speed Engine' : 'PHP Core Engine' ?> (<?= $engineInfo['latency_ms'] ?>ms)
                    </span>
                </div>
                <a href="/products?category=<?= urlencode($product['category_slug']) ?>" class="small text-primary text-decoration-none">Xem thêm cùng loại &rarr;</a>
            </div>

            <div class="row g-3">
                <?php foreach ($relatedProducts as $rel): ?>
                    <div class="col-6 col-md-3">
                        <div class="tech-card p-3">
                            <div class="text-center py-2">
                                <i class="bi bi-device-hdd display-6 text-primary opacity-75"></i>
                            </div>
                            <h6 class="fw-bold small mb-2">
                                <a href="/product/<?= urlencode($rel['slug']) ?>" class="text-dark text-decoration-none line-clamp-2">
                                    <?= htmlspecialchars($rel['name']) ?>
                                </a>
                            </h6>
                            <div class="mt-auto pt-2 d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-primary small"><?= $rel['formatted_price'] ?? number_format((float)$rel['price'], 0, ',', '.') . ' ₫' ?></span>
                                <a href="/product/<?= urlencode($rel['slug']) ?>" class="btn btn-sm btn-outline-primary py-0 px-2">Xem</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Customer Reviews Section -->
    <div id="reviews" class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-5">
        <h4 class="fw-bold mb-4"><i class="bi bi-chat-left-text me-2 text-primary"></i>Đánh Giá & Nhận Xét Từ Khách Hàng</h4>

        <div class="row g-4">
            <!-- Review submission form -->
            <div class="col-lg-5 border-end">
                <h6 class="fw-bold mb-3">Gửi đánh giá của bạn</h6>
                <form action="/product/review" method="POST">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label small text-muted">Đánh giá số sao:</label>
                        <select name="rating" class="form-select form-select-sm">
                            <option value="5">⭐⭐⭐⭐⭐ (5/5 - Cực kỳ hài lòng)</option>
                            <option value="4">⭐⭐⭐⭐ (4/5 - Rất tốt)</option>
                            <option value="3">⭐⭐⭐ (3/5 - Bình thường)</option>
                            <option value="2">⭐⭐ (2/5 - Kém)</option>
                            <option value="1">⭐ (1/5 - Rất tệ)</option>
                        </select>
                    </div>

                    <?php if (empty($_SESSION['user'])): ?>
                        <div class="mb-3">
                            <label class="form-label small text-muted">Họ và tên:</label>
                            <input type="text" name="user_name" class="form-control form-control-sm" placeholder="Nhập tên của bạn" required>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label small text-muted">Nội dung nhận xét:</label>
                        <textarea name="comment" class="form-control form-control-sm" rows="3" placeholder="Chia sẻ cảm nhận về thiết kế, hiệu năng, màn hình, pin..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm px-4">Gửi Nhận Xét</button>
                </form>
            </div>

            <!-- Review list -->
            <div class="col-lg-7">
                <?php if (empty($reviews)): ?>
                    <p class="text-muted small">Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên để lại nhận xét!</p>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($reviews as $rev): ?>
                            <div class="p-3 bg-light rounded-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold small"><?= htmlspecialchars($rev['user_name']) ?></span>
                                    <div class="text-warning small">
                                        <?php for ($s = 1; $s <= 5; $s++): ?>
                                            <i class="bi <?= $s <= (int)$rev['rating'] ? 'bi-star-fill' : 'bi-star' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <p class="small text-muted mb-1"><?= nl2br(htmlspecialchars($rev['comment'])) ?></p>
                                <span class="text-muted" style="font-size: 0.75rem;"><?= htmlspecialchars($rev['created_at']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
