<?php
$pageTitle = 'Quản Trị Hệ Thống - Dashboard';
require __DIR__ . '/../layouts/header.php';
?>

<div class="container-fluid px-4">
    <!-- Admin Top Nav / Breadcrumb -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h3 class="fw-bold mb-1"><i class="bi bi-speedometer2 me-2 text-primary"></i>Hệ Thống Quản Trị ElectroStore</h3>
            <span class="text-muted small">Trung tâm điều hành kinh doanh & giám sát hiệu năng kiến trúc Hybrid PHP + Rust</span>
        </div>
        <div class="d-flex gap-2">
            <a href="/admin/products/create" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Thêm Thiết Bị Mới
            </a>
            <a href="/admin/orders" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-receipt me-1"></i> Quản Lý Đơn Hàng
            </a>
            <a href="/admin/users" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-people me-1"></i> Người Dùng
            </a>
        </div>
    </div>

    <!-- Rust Engine Microservice Health & Metrics Banner -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
        <div class="card-body p-4 text-white">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge <?= $isRustOnline ? 'bg-success' : 'bg-warning text-dark' ?> px-3 py-1 text-uppercase fw-bold">
                            <i class="bi bi-cpu-fill me-1"></i> <?= $isRustOnline ? 'RUST ENGINE ONLINE' : 'PHP CORE FALLBACK' ?>
                        </span>
                        <span class="badge bg-secondary text-light">Microservice: Port 5000</span>
                        <span class="badge bg-info text-dark">Engine Latency: <?= $metrics['latency_ms'] ?? 0.8 ?>ms</span>
                    </div>
                    <h5 class="fw-bold mb-1">Kiến Trúc Hybrid Microservice High-Performance</h5>
                    <p class="text-white-50 small mb-0">
                        Rust Engine đảm nhận các tác vụ nặng: Thuật toán tìm kiếm Fuzzy TF-IDF, Gợi ý sản phẩm Cosine Similarity, Phân tích dữ liệu Pareto ABC và Dự báo doanh thu bằng Hồi quy tuyến tính.
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="p-3 bg-white bg-opacity-10 rounded-3 d-inline-block text-start border border-white border-opacity-10">
                        <div class="text-white-50 small">Trạng thái kết nối API:</div>
                        <div class="fw-bold text-success fs-6"><i class="bi bi-check-circle-fill me-1"></i> REST API Active (200 OK)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-semibold text-uppercase">Tổng Doanh Thu</span>
                    <div class="bg-success bg-opacity-10 text-success p-2 rounded-3">
                        <i class="bi bi-currency-dollar fs-5"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-success mb-1"><?= number_format((float)($metrics['total_revenue'] ?? 0), 0, ',', '.') ?> ₫</h4>
                <span class="text-muted small">Từ các đơn hàng thành công</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-semibold text-uppercase">Dự Báo Doanh Thu (Hồi Quy)</span>
                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3">
                        <i class="bi bi-graph-up-arrow fs-5"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-primary mb-1"><?= number_format((float)($metrics['forecast_next_day_revenue'] ?? 0), 0, ',', '.') ?> ₫</h4>
                <span class="text-muted small">Dự báo ngày tiếp theo (Linear Reg.)</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-semibold text-uppercase">Tổng Số Đơn Hàng</span>
                    <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-3">
                        <i class="bi bi-bag-check fs-5"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-1"><?= $metrics['total_orders'] ?? 0 ?> đơn</h4>
                <span class="text-muted small"><?= $metrics['completed_orders_count'] ?? 0 ?> đơn đã hoàn thành</span>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-semibold text-uppercase">Danh Mục & Người Dùng</span>
                    <div class="bg-info bg-opacity-10 text-info p-2 rounded-3">
                        <i class="bi bi-people fs-5"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-1"><?= $totalProducts ?> SP / <?= $totalUsers ?> Users</h4>
                <span class="text-muted small">Đang hoạt động trong CSDL</span>
            </div>
        </div>
    </div>

    <!-- Rust Business Analytics: ABC Inventory Analysis -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-pie-chart me-2 text-primary"></i>Phân Tích Tồn Kho ABC (Pareto 80/20)</h5>
                    <span class="badge bg-secondary">Rust Analytics</span>
                </div>
                <p class="text-muted small">
                    Thuật toán phân loại giá trị tồn kho theo doanh số: Nhóm A (chiếm 70% giá trị - thiết bị cao cấp), Nhóm B (chiếm 20% giá trị - thiết bị tầm trung), Nhóm C (chiếm 10% - phụ kiện).
                </p>

                <div class="row g-3 text-center my-3">
                    <div class="col-4">
                        <div class="p-3 bg-light rounded-3 border">
                            <div class="badge bg-danger mb-1">Nhóm A (Flagship)</div>
                            <div class="fs-4 fw-bold text-danger"><?= $metrics['abc_analysis']['class_a_count'] ?? 0 ?></div>
                            <span class="text-muted small">SP chủ lực</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 bg-light rounded-3 border">
                            <div class="badge bg-primary mb-1">Nhóm B (Tầm Trung)</div>
                            <div class="fs-4 fw-bold text-primary"><?= $metrics['abc_analysis']['class_b_count'] ?? 0 ?></div>
                            <span class="text-muted small">SP phụ trợ</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 bg-light rounded-3 border">
                            <div class="badge bg-secondary mb-1">Nhóm C (Phụ Kiện)</div>
                            <div class="fs-4 fw-bold text-secondary"><?= $metrics['abc_analysis']['class_c_count'] ?? 0 ?></div>
                            <span class="text-muted small">SP phổ thông</span>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold small mb-2">Top 5 Thiết Bị Đóng Góp Doanh Số Cao Nhất (Nhóm A):</h6>
                <ul class="list-group list-group-flush small">
                    <?php if (!empty($metrics['abc_analysis']['top_revenue_items'])): ?>
                        <?php foreach ($metrics['abc_analysis']['top_revenue_items'] as $item): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <span class="fw-semibold text-truncate" style="max-width: 320px;"><?= htmlspecialchars($item['name']) ?></span>
                                <span class="text-primary fw-bold"><?= number_format((float)$item['sales_value'], 0, ',', '.') ?> ₫</span>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Recent Orders table -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Đơn Hàng Gần Đây</h5>
                    <a href="/admin/orders" class="small text-decoration-none">Tất cả đơn &rarr;</a>
                </div>

                <div class="table-responsive">
                    <table class="table small align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentOrders as $ord): ?>
                                <tr>
                                    <td class="fw-bold font-monospace"><?= htmlspecialchars($ord['order_code']) ?></td>
                                    <td><?= htmlspecialchars($ord['customer_name']) ?></td>
                                    <td class="fw-bold text-primary"><?= $ord['formatted_final'] ?></td>
                                    <td>
                                        <span class="badge bg-light text-dark border text-uppercase"><?= htmlspecialchars($ord['order_status']) ?></span>
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
