<?php
$pageTitle = 'Quản Trị Hệ Thống - Dashboard';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container-fluid px-lg-5 px-3">
    <!-- Admin Top Nav / Breadcrumb -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-danger rounded-pill px-3 py-1 small fw-bold">ADMIN CONSOLE</span>
                <h3 class="fw-bold mb-0 text-dark"><i class="bi bi-speedometer2 me-2 text-danger"></i>Hệ Thống Quản Trị 12B5 Store</h3>
            </div>
            <span class="text-muted small">Trung tâm quản lý bán hàng, theo dõi đơn hàng, tồn kho và phân tích doanh thu cửa hàng</span>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="/admin/products/create" class="btn btn-rose btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Thêm Thiết Bị Mới
            </a>
            <a href="/admin/orders" class="btn btn-soft-slate btn-sm">
                <i class="bi bi-receipt me-1"></i> Quản Lý Đơn Hàng
            </a>
            <a href="/admin/users" class="btn btn-soft-slate btn-sm">
                <i class="bi bi-people me-1"></i> Quản Lý Người Dùng
            </a>
        </div>
    </div>

    <!-- Business Operation Highlights Banner -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #fff1f2 60%, #f1f5f9 100%); border: 1px solid rgba(251, 113, 133, 0.25) !important;">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">
                <div class="col-md-8">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1 fw-bold small">
                            <i class="bi bi-graph-up-arrow me-1"></i> TỔNG QUAN VẬN HÀNH
                        </span>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1 small fw-semibold">
                            <i class="bi bi-clock-history me-1"></i> Giờ Mở Cửa (08:00 - 22:00)
                        </span>
                    </div>
                    <h5 class="fw-bold mb-1 text-dark">Báo Cáo Tình Hình Kinh Doanh & Điều Hành Kho Hàng</h5>
                    <p class="text-muted small mb-0">
                        Dữ liệu được cập nhật theo thời gian thực: Tự động tổng hợp doanh thu bán lẻ, phân loại danh mục sản phẩm chủ lực và kiểm soát lượng hàng tồn kho.
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="p-3 bg-white rounded-4 d-inline-block text-start border shadow-xs">
                        <div class="text-muted small">Tình trạng kho hàng:</div>
                        <div class="fw-bold text-success fs-6"><i class="bi bi-check-circle-fill me-1"></i> Đảm bảo cung ứng (Sẵn sàng)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Summary Cards with Frosted Pastel Styling -->
    <div class="row g-4 mb-4">
        <!-- Revenue Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100" style="border: 1px solid var(--border-color) !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Tổng Doanh Thu</span>
                    <div class="p-2 rounded-3 bg-success bg-opacity-10 text-success fs-5">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-success mb-1"><?= number_format((float)($metrics['total_revenue'] ?? 0), 0, ',', '.') ?> ₫</h4>
                <span class="text-muted small">Từ các đơn hàng thành công</span>
            </div>
        </div>

        <!-- Linear Regression Forecast Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100" style="border: 1px solid var(--border-color) !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Dự Báo Doanh Thu (Rust)</span>
                    <div class="p-2 rounded-3 bg-danger bg-opacity-10 text-danger fs-5">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-danger mb-1"><?= number_format((float)($metrics['forecast_next_day_revenue'] ?? 0), 0, ',', '.') ?> ₫</h4>
                <span class="text-muted small">Dự báo chu kỳ kế tiếp (Hồi quy)</span>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100" style="border: 1px solid var(--border-color) !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Tổng Đơn Hàng</span>
                    <div class="p-2 rounded-3 bg-primary bg-opacity-10 text-primary fs-5">
                        <i class="bi bi-bag-check"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-1 text-dark"><?= $metrics['total_orders'] ?? 0 ?> đơn</h4>
                <span class="text-muted small"><?= $metrics['completed_orders_count'] ?? 0 ?> đơn đã giao thành công</span>
            </div>
        </div>

        <!-- Catalog & Users Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100" style="border: 1px solid var(--border-color) !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Kho Hàng & Khách Hàng</span>
                    <div class="p-2 rounded-3 bg-info bg-opacity-10 text-info fs-5">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-1 text-dark"><?= $totalProducts ?> SP / <?= $totalUsers ?> Users</h4>
                <span class="text-muted small">Dữ liệu đồng bộ trong CSDL</span>
            </div>
        </div>
    </div>

    <!-- Rust Business Analytics: ABC Inventory Analysis & Recent Orders -->
    <div class="row g-4 mb-5">
        <!-- Pareto ABC Analysis -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100" style="border: 1px solid var(--border-color) !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pie-chart-fill me-2 text-danger"></i>Phân Loại Danh Mục Hàng Hoá ABC (80/20)</h5>
                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1 small fw-bold">Tối Ưu Tồn Kho</span>
                </div>
                <p class="text-muted small">
                    Phân loại nhóm hàng tồn kho theo tỷ trọng đóng góp doanh thu: <strong>Nhóm A</strong> (70% giá trị - Flagship), <strong>Nhóm B</strong> (20% giá trị - Tầm trung), <strong>Nhóm C</strong> (10% - Phụ kiện).
                </p>

                <div class="row g-3 text-center my-3">
                    <div class="col-4">
                        <div class="p-3 rounded-4 border" style="background: #fff1f2; border-color: var(--accent-rose-border) !important;">
                            <div class="badge bg-danger rounded-pill mb-1 small">Nhóm A (Flagship)</div>
                            <div class="fs-4 fw-bold text-danger"><?= $metrics['abc_analysis']['class_a_count'] ?? 0 ?></div>
                            <span class="text-muted small">SP chủ lực</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded-4 border" style="background: #f0fdf4; border-color: #bbf7d0 !important;">
                            <div class="badge bg-success rounded-pill mb-1 small">Nhóm B (Tầm trung)</div>
                            <div class="fs-4 fw-bold text-success"><?= $metrics['abc_analysis']['class_b_count'] ?? 0 ?></div>
                            <span class="text-muted small">SP phụ trợ</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded-4 border" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                            <div class="badge bg-secondary rounded-pill mb-1 small">Nhóm C (Phổ thông)</div>
                            <div class="fs-4 fw-bold text-secondary"><?= $metrics['abc_analysis']['class_c_count'] ?? 0 ?></div>
                            <span class="text-muted small">Phụ kiện kèm</span>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold small mb-2 text-dark">Top Thiết Bị Đóng Góp Doanh Số Cao Nhất (Nhóm A):</h6>
                <ul class="list-group list-group-flush small">
                    <?php if (!empty($metrics['abc_analysis']['top_revenue_items'])): ?>
                        <?php foreach ($metrics['abc_analysis']['top_revenue_items'] as $item): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-bottom">
                                <span class="fw-semibold text-truncate text-dark" style="max-width: 320px;"><?= htmlspecialchars($item['name']) ?></span>
                                <span class="text-danger fw-bold"><?= number_format((float)$item['sales_value'], 0, ',', '.') ?> ₫</span>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Recent Orders table -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100" style="border: 1px solid var(--border-color) !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-clock-history me-2 text-primary"></i>Đơn Hàng Gần Đây</h5>
                    <a href="/admin/orders" class="btn btn-soft-slate btn-sm">Xem tất cả &rarr;</a>
                </div>

                <div class="table-responsive">
                    <table class="table small align-middle mb-0">
                        <thead class="table-light text-muted">
                            <tr>
                                <th style="font-size: 0.75rem;">Mã Đơn</th>
                                <th style="font-size: 0.75rem;">Khách Hàng</th>
                                <th style="font-size: 0.75rem;">Tổng Tiền</th>
                                <th style="font-size: 0.75rem;">Trạng Thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentOrders as $ord): ?>
                                <tr>
                                    <td class="fw-bold font-monospace text-primary"><?= htmlspecialchars($ord['order_code']) ?></td>
                                    <td class="fw-medium text-dark"><?= htmlspecialchars($ord['customer_name']) ?></td>
                                    <td class="fw-bold text-danger"><?= $ord['formatted_final'] ?></td>
                                    <td>
                                        <span class="badge bg-light text-dark border rounded-pill px-2 py-1 text-uppercase" style="font-size: 0.7rem;">
                                            <?= htmlspecialchars($ord['order_status']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
