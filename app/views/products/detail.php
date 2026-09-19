<?php
$pageTitle = $product['name'];
require __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/products" class="text-decoration-none">Sản phẩm</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/products?category=<?= urlencode($product['category_slug']) ?>" class="text-decoration-none"><?= htmlspecialchars($product['category_name']) ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($product['name']) ?></li>
        </ol>
    </nav>

    <div class="row g-4 mb-5">
        <!-- Product Images & Gallery Showcase -->
        <div class="col-lg-5">
            <div class="detail-gallery-card h-100 d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-center w-100 mb-3">
                    <span class="detail-gallery-badge position-static">
                        <i class="bi bi-patch-check-fill me-1"></i> Chính Hãng VN/A
                    </span>
                    <span class="badge bg-light text-muted border rounded-pill px-3 py-1 small">
                        Bảo hành 24 Tháng VIP
                    </span>
                </div>

                <div class="py-4 text-center my-auto">
                    <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid rounded-4 shadow-sm" style="max-height: 320px; object-fit: contain;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="device-fallback-icon mx-auto" style="display: none; width: 120px; height: 120px; font-size: 3.5rem;">
                        <i class="bi <?= htmlspecialchars($product['device_icon']) ?>"></i>
                    </div>
                </div>

                <div class="p-3 bg-light rounded-4 border w-100 text-muted small mt-4">
                    <div class="row g-2 text-center" style="font-size: 0.78rem;">
                        <div class="col-4 border-end">
                            <i class="bi bi-box-seam text-danger d-block fs-6 mb-1"></i>
                            <span>Nguyên Seal VAT</span>
                        </div>
                        <div class="col-4 border-end">
                            <i class="bi bi-arrow-repeat text-success d-block fs-6 mb-1"></i>
                            <span>1 Đổi 1 (30 ngày)</span>
                        </div>
                        <div class="col-4">
                            <i class="bi bi-truck text-primary d-block fs-6 mb-1"></i>
                            <span>Hỏa tốc 2 giờ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Purchase Information -->
        <div class="col-lg-7">
            <div class="detail-info-card">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-light text-muted border rounded-pill px-3 py-1 small fw-bold">
                            <?= htmlspecialchars($product['brand_name']) ?>
                        </span>
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1 small fw-bold">
                            <?= htmlspecialchars($product['category_name']) ?>
                        </span>
                    </div>
                    <span class="text-muted small">Mã SKU: <strong class="text-dark font-monospace"><?= htmlspecialchars($product['sku']) ?></strong></span>
                </div>

                <h2 class="fw-bold mb-2 text-dark"><?= htmlspecialchars($product['name']) ?></h2>

                <!-- Rating & Sales Status -->
                <div class="d-flex flex-wrap align-items-center gap-3 mb-3 pb-2 border-bottom">
                    <div class="text-warning small d-flex align-items-center gap-1">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="bi <?= $i <= round($product['rating']) ? 'bi-star-fill' : 'bi-star' ?>"></i>
                        <?php endfor; ?>
                        <span class="fw-bold text-dark ms-1"><?= $product['rating'] ?>/5.0</span>
                    </div>
                    <span class="text-muted small">(<?= $product['review_count'] ?> đánh giá từ khách hàng đã mua)</span>
                    <span class="text-muted small">&bull;</span>
                    <span class="text-success small fw-semibold"><i class="bi bi-bag-check-fill me-1"></i> Đã bán <?= $product['sales_count'] ?> máy</span>
                </div>

                <!-- Price Box (Pastel Glass) -->
                <div class="p-3 rounded-4 mb-4 d-flex flex-wrap align-items-baseline gap-3" style="background: linear-gradient(135deg, #fff1f2 0%, #fdf2f8 100%); border: 1px solid var(--accent-rose-border);">
                    <span class="fs-2 fw-extrabold text-danger"><?= $product['formatted_price'] ?></span>
                    <?php if ($product['formatted_original_price']): ?>
                        <span class="text-muted text-decoration-line-through fs-5"><?= $product['formatted_original_price'] ?></span>
                        <span class="badge bg-danger rounded-pill px-3 py-1 small fw-bold">Tiết kiệm <?= $product['discount_percent'] ?>%</span>
                    <?php endif; ?>
                    <span class="text-muted small ms-auto d-none d-sm-inline"><i class="bi bi-credit-card text-primary me-1"></i> Trả góp 0% chỉ từ <strong><?= number_format(round($product['price'] / 12), 0, ',', '.') ?>₫/tháng</strong></span>
                </div>

                <!-- Storage / Variant Selection -->
                <div class="mb-3">
                    <label class="fw-bold small text-uppercase text-muted d-block mb-2 tracking-wider">Phiên Bản Bộ Nhớ:</label>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="variant-btn active">
                            <span>256GB</span>
                            <span class="variant-subtext">Tiêu chuẩn</span>
                        </button>
                        <button type="button" class="variant-btn">
                            <span>512GB</span>
                            <span class="variant-subtext">+3.500.000₫</span>
                        </button>
                        <button type="button" class="variant-btn">
                            <span>1TB</span>
                            <span class="variant-subtext">+8.000.000₫</span>
                        </button>
                    </div>
                </div>

                <!-- Color Selection -->
                <div class="mb-4">
                    <label class="fw-bold small text-uppercase text-muted d-block mb-2 tracking-wider">Màu Sắc Thiết Bị:</label>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="color-option-btn active">
                            <span class="color-circle" style="background-color: #94a3b8;"></span> Titan Tự Nhiên
                        </button>
                        <button type="button" class="color-option-btn">
                            <span class="color-circle" style="background-color: #334155;"></span> Titan Đen
                        </button>
                        <button type="button" class="color-option-btn">
                            <span class="color-circle" style="background-color: #f1f5f9;"></span> Titan Trắng
                        </button>
                        <button type="button" class="color-option-btn">
                            <span class="color-circle" style="background-color: #fed7aa;"></span> Titan Sa Mạc
                        </button>
                    </div>
                </div>

                <!-- Promotional Gift & Trade-in Box -->
                <div class="promo-gift-box mb-4">
                    <div class="d-flex align-items-center gap-2 fw-bold text-danger mb-2 small">
                        <i class="bi bi-gift-fill"></i> ƯU ĐÃI ĐẶC QUYỀN KHI MUA TẠI 12B5 STORE:
                    </div>
                    <ul class="list-unstyled mb-0 small text-muted d-flex flex-column gap-1">
                        <li><i class="bi bi-check2-circle text-success me-2"></i> Tặng củ sạc nhanh GaN 35W chính hãng trị giá <strong>690.000₫</strong></li>
                        <li><i class="bi bi-check2-circle text-success me-2"></i> Giảm thêm <strong>500.000₫</strong> khi thanh toán quét mã VietQR thuận tiện</li>
                        <li><i class="bi bi-check2-circle text-success me-2"></i> Trợ giá thu cũ đổi mới (Trade-in) lên đến <strong>2.500.000₫</strong></li>
                        <li><i class="bi bi-check2-circle text-success me-2"></i> Tặng gói bảo dưỡng, vệ sinh thiết bị định kỳ trọn đời máy</li>
                    </ul>
                </div>

                <!-- Stock & Add to Cart Form -->
                <form action="<?= BASE_URL ?>/cart/add" method="POST" class="mb-4">
                    <?= \App\Core\Csrf::field() ?>
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <label class="fw-bold small text-muted text-uppercase mb-0 tracking-wider">Số Lượng:</label>
                        <div class="input-group" style="max-width: 140px;">
                            <button class="btn btn-outline-secondary rounded-start-pill" type="button" onclick="let input = document.getElementById('qty_<?= $product['id'] ?>') || document.getElementById('qtyInput'); if(input.value > 1) input.value--;">-</button>
                            <input type="number" id="qty_<?= $product['id'] ?>" name="quantity" class="form-control text-center font-monospace fw-bold" value="1" min="1" max="<?= $product['stock'] ?>">
                            <button class="btn btn-outline-secondary rounded-end-pill" type="button" onclick="let input = document.getElementById('qty_<?= $product['id'] ?>') || document.getElementById('qtyInput'); if(input.value < <?= $product['stock'] ?>) input.value++;">+</button>
                        </div>
                        <?php if (isset($product['status']) && (int)$product['status'] === 0): ?>
                            <span class="badge bg-secondary px-3 py-2 rounded-pill small">
                                <i class="bi bi-slash-circle me-1"></i> Ngừng kinh doanh
                            </span>
                        <?php else: ?>
                            <span class="small <?= $product['stock'] > 0 ? 'text-success' : 'text-danger' ?>">
                                <i class="bi <?= $product['stock'] > 0 ? 'bi-check-circle-fill' : 'bi-x-circle-fill' ?> me-1"></i>
                                <?= $product['stock'] > 0 ? 'Còn hàng tại 15 showroom (' . $product['stock'] . ' máy sẵn sàng)' : 'Tạm hết hàng' ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-3">
                        <?php if (isset($product['status']) && (int)$product['status'] === 0): ?>
                            <button type="button" class="btn btn-secondary btn-lg px-4 flex-grow-1 fw-bold" disabled>
                                <i class="bi bi-slash-circle me-2"></i> Sản Phẩm Ngừng Kinh Doanh
                            </button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-rose btn-lg px-4 flex-grow-1 fw-bold shadow-sm" <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>
                                <i class="bi bi-cart-plus me-2"></i> Thêm Vào Giỏ Hàng
                            </button>
                            <button type="button" class="btn btn-soft-slate btn-lg px-3 btn-ajax-add-cart" data-product-id="<?= $product['id'] ?>" title="Thêm nhanh tức thì" <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>
                                <i class="bi bi-lightning-charge text-danger"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </form>

                <!-- Guarantee checklist -->
                <div class="border-top pt-3 text-muted small d-flex flex-column gap-2">
                    <div><i class="bi bi-shield-check text-danger me-2"></i>Bảo hành 24 tháng chính hãng tại tất cả TTBH ủy quyền Apple/Samsung/Sony/Dell</div>
                    <div><i class="bi bi-arrow-counterclockwise text-danger me-2"></i>Đổi mới 1-đổi-1 trong 30 ngày nếu phát hiện lỗi từ nhà sản xuất</div>
                    <div><i class="bi bi-truck text-danger me-2"></i>Miễn phí vận chuyển hỏa tốc 2 giờ toàn quốc cho đơn hàng từ 5.000.000₫</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Technical Specifications Table & Full Description -->
    <div class="row g-4 mb-5">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h4 class="fw-bold mb-3 text-dark"><i class="bi bi-file-earmark-text me-2 text-danger"></i>Mô Tả Chi Tiết Sản Phẩm</h4>
                <div class="text-secondary lh-lg" style="font-size: 0.95rem;">
                    <?= nl2br(htmlspecialchars($product['description'] ?? '')) ?>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h4 class="fw-bold mb-3 text-dark"><i class="bi bi-cpu me-2 text-danger"></i>Thông Số Kỹ Thuật Chi Tiết</h4>
                <?php if (!empty($product['specs_array'])): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover small mb-0 align-middle">
                            <tbody>
                                <?php foreach ($product['specs_array'] as $specKey => $specVal): ?>
                                    <tr>
                                        <th class="text-muted fw-semibold text-uppercase" style="width: 38%; font-size: 0.75rem;"><?= htmlspecialchars(str_replace('_', ' ', $specKey)) ?></th>
                                        <td class="fw-semibold text-dark"><?= htmlspecialchars(is_array($specVal) ? implode(', ', $specVal) : $specVal) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted small">Đang cập nhật thông số kỹ thuật chi tiết từ nhà sản xuất.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Smart Related Recommendations via Rust Cosine Similarity -->
    <?php if (!empty($relatedProducts)): ?>
        <div class="mb-5">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">Thiết Bị Cùng Phân Khúc Đề Xuất</h4>
                    <span class="badge <?= $engineInfo['engine'] === 'rust' ? 'bg-warning text-dark' : 'bg-secondary' ?> rounded-pill px-3 py-1">
                        <i class="bi bi-cpu-fill"></i> Vector Cosine Similarity: <?= $engineInfo['engine'] === 'rust' ? 'Rust High-Speed Microservice' : 'PHP Core Engine' ?> (<?= $engineInfo['latency_ms'] ?>ms)
                    </span>
                </div>
                <a href="<?= BASE_URL ?>/products?category=<?= urlencode($product['category_slug']) ?>" class="btn btn-outline-rose btn-sm">Xem thêm cùng loại &rarr;</a>
            </div>

            <div class="row g-3">
                <?php foreach ($relatedProducts as $relProd): ?>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="tech-card">
                            <div class="card-img-wrap py-3">
                                <img src="<?= htmlspecialchars($relProd['image_url'] ?? 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500') ?>" alt="<?= htmlspecialchars($relProd['name']) ?>" class="product-thumb-img" style="max-height: 120px;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="device-fallback-icon" style="display: none; width: 60px; height: 60px; font-size: 1.8rem;">
                                    <i class="bi <?= htmlspecialchars($relProd['device_icon'] ?? 'bi-laptop') ?>"></i>
                                </div>
                            </div>
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small fw-semibold mb-1 w-auto d-inline-block">
                                    <?= htmlspecialchars($relProd['brand_name'] ?? 'Chính Hãng') ?>
                                </span>
                                <h6 class="fw-bold mb-2">
                                    <a href="<?= BASE_URL ?>/product/<?= urlencode($relProd['slug']) ?>" class="text-dark text-decoration-none product-name-clamp">
                                        <?= htmlspecialchars($relProd['name']) ?>
                                    </a>
                                </h6>
                                <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                    <div class="price-current fs-6"><?= $relProd['formatted_price'] ?></div>
                                    <a href="<?= BASE_URL ?>/product/<?= urlencode($relProd['slug']) ?>" class="btn btn-sm btn-outline-rose rounded-pill px-3">Chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Customer Reviews & Feedback Section -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-5">
        <h4 class="fw-bold mb-4 text-dark"><i class="bi bi-chat-heart me-2 text-danger"></i>Đánh Giá & Nhận Xét Từ Khách Hàng</h4>

        <div class="row g-4 mb-4 pb-4 border-bottom align-items-center">
            <div class="col-md-4 text-center border-end">
                <div class="display-3 fw-bold text-danger mb-1"><?= $product['rating'] ?></div>
                <div class="text-warning mb-2">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="bi <?= $i <= round($product['rating']) ? 'bi-star-fill' : 'bi-star' ?>"></i>
                    <?php endfor; ?>
                </div>
                <div class="text-muted small">Dựa trên <?= $product['review_count'] ?> đánh giá thực tế</div>
            </div>

            <div class="col-md-8">
                <?php 
                $isLoggedIn = !empty($_SESSION['user']['id']);
                $hasPurchased = $isLoggedIn ? \App\Models\Product::hasPurchased((int)$_SESSION['user']['id'], (int)$product['id']) : false;
                ?>

                <?php if ($isLoggedIn && $hasPurchased): ?>
                    <!-- Write a review form for verified buyer -->
                    <h6 class="fw-bold mb-2 text-dark"><i class="bi bi-shield-check text-success me-1"></i>Gửi Đánh Giá Của Bạn (Đã xác minh mua hàng)</h6>
                    <form action="<?= BASE_URL ?>/product/review" method="POST" class="row g-2">
                        <?= \App\Core\Csrf::field() ?>
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <div class="col-sm-6">
                            <input type="text" name="user_name" class="form-control form-control-sm rounded-3" placeholder="Họ và tên của bạn *" required value="<?= htmlspecialchars($_SESSION['user']['name'] ?? '') ?>">
                        </div>
                        <div class="col-sm-6">
                            <select name="rating" class="form-select form-select-sm rounded-3">
                                <option value="5">⭐⭐⭐⭐⭐ (5 sao - Cực kỳ hài lòng)</option>
                                <option value="4">⭐⭐⭐⭐ (4 sao - Hài lòng)</option>
                                <option value="3">⭐⭐⭐ (3 sao - Bình thường)</option>
                                <option value="2">⭐⭐ (2 sao - Chưa ưng ý)</option>
                                <option value="1">⭐ (1 sao - Thất vọng)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <textarea name="comment" class="form-control form-control-sm rounded-3" rows="3" placeholder="Chia sẻ cảm nhận thực tế về thiết bị, hiệu năng, đóng gói và thời gian giao hàng..." required></textarea>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-rose btn-sm px-4">Gửi Đánh Giá</button>
                        </div>
                    </form>
                <?php elseif (!$isLoggedIn): ?>
                    <div class="p-3 bg-light rounded-4 border text-center">
                        <i class="bi bi-lock-fill text-muted fs-4 d-block mb-1"></i>
                        <span class="text-muted small">Quý khách vui lòng <a href="<?= BASE_URL ?>/login" class="fw-bold text-danger">Đăng nhập</a> bằng tài khoản đã mua sản phẩm để viết đánh giá.</span>
                    </div>
                <?php else: ?>
                    <div class="p-3 bg-light rounded-4 border text-center">
                        <i class="bi bi-bag-check text-muted fs-4 d-block mb-1"></i>
                        <span class="text-muted small">Chức năng đánh giá chỉ dành cho khách hàng đã mua và hoàn tất đơn hàng cho thiết bị này tại 12B5 Store.</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Reviews List -->
        <div class="d-flex flex-column gap-3">
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $rev): ?>
                    <div class="p-3 bg-light rounded-4 border">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bold small text-dark"><?= htmlspecialchars($rev['user_name']) ?></span>
                                <?php if (!empty($rev['is_verified_purchase'])): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill small" style="font-size: 0.68rem;">
                                        <i class="bi bi-patch-check-fill"></i> Đã mua hàng tại 12B5 Store
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill small" style="font-size: 0.68rem;">
                                        <i class="bi bi-person-check"></i> Khách hàng
                                    </span>
                                <?php endif; ?>
                            </div>
                            <span class="text-muted small" style="font-size: 0.75rem;"><?= htmlspecialchars($rev['created_at'] ?? 'Vừa xong') ?></span>
                        </div>
                        <div class="text-warning small mb-2">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="bi <?= $i <= $rev['rating'] ? 'bi-star-fill' : 'bi-star' ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="mb-0 text-secondary small"><?= nl2br(htmlspecialchars($rev['comment'])) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="p-4 text-center text-muted small bg-light rounded-4">
                    Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên trải nghiệm và chia sẻ!
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
