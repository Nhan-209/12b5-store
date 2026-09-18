# 12B5 Store - Website Thương Mại Điện Tử Thiết Bị Điện Tử
## Đồ Án Tốt Nghiệp: PHP MVC Core + MySQL + Rust Calculation Service

[![12B5 Store CI/CD](https://github.com/Nhan-209/12b5-store/actions/workflows/ci.yml/badge.svg)](https://github.com/Nhan-209/12b5-store/actions)
[![PHP](https://img.shields.io/badge/PHP-8.2%20%7C%208.3-777bb4?logo=php&logoColor=white)](https://www.php.net/)
[![Rust](https://img.shields.io/badge/Rust-2021%20Edition-black?logo=rust&logoColor=white)](https://www.rust-lang.org/)
[![Database](https://img.shields.io/badge/Database-MySQL%20(Primary)%20%7C%20SQLite%20(Backup)-blue)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 1. Tổng Quan Đề Tài (Overview)

**12B5 Store** là hệ thống website thương mại điện tử chuyên doanh thiết bị điện tử và công nghệ cao (Smartphones, Laptops, Tablets, Âm thanh, Smartwatches, Phụ kiện), được thiết kế theo kiến trúc kết hợp:
- **Web Application Core:** Xây dựng bằng PHP thuần theo mô hình MVC (Model - View - Controller), quản lý phiên làm việc (Session), phòng chống tấn công CSRF / Session Fixation, xử lý giỏ hàng, đặt hàng với Database Transaction và tạo mã VietQR động theo chuẩn NAPAS 247.
- **Dịch vụ tính toán phụ trợ (Rust Microservice):** Vận hành độc lập tại cổng 5000, đảm nhận các tác vụ tính toán CPU-bound: tìm kiếm mờ (Fuzzy Search - Levenshtein & Token Matching), gợi ý sản phẩm tương đồng (Cosine Similarity trên vector đặc trưng), và phân tích kinh doanh (Hồi quy tuyến tính, phân tích tồn kho Pareto ABC).
- **Cơ chế Graceful Fallback:** Khi dịch vụ Rust ngoại tuyến, PHP Web Server tự động chuyển sang thuật toán dự phòng nội bộ, đảm bảo hệ thống duy trì hoạt động liên tục.

---

## 2. Yêu Cầu Hệ Thống (Requirements)

- **Hệ điều hành:** Windows 10/11 64-bit hoặc Linux Ubuntu 22.04 LTS / macOS.
- **PHP:** Phiên bản 8.2 trở lên (khuyến nghị PHP 8.3 với các extension: `pdo`, `pdo_mysql`, `pdo_sqlite`, `curl`, `openssl`, `mbstring`).
- **Cơ sở dữ liệu:** MySQL 8.0 (hoặc MariaDB 10.4+) cho môi trường chính; SQLite 3 có sẵn cho môi trường di động.
- **Trình biên dịch Rust (tùy chọn):** Rust 1.80+ (Toolchain 2021 edition) nếu muốn biên dịch từ mã nguồn `rust-engine`.

---

## 3. Cài Đặt & Vận Hành Môi Trường Chính: XAMPP (Primary Setup)

Môi trường phát triển chính của đồ án sử dụng bộ công cụ **XAMPP** (Apache + PHP 8.3 + MySQL 8.0 + phpMyAdmin) chạy cục bộ.

### Bước 1: Khởi động XAMPP
1. Mở **XAMPP Control Panel**.
2. Nhấn **Start** cho hai dịch vụ **Apache** và **MySQL**.

### Bước 2: Tạo Cơ sở dữ liệu và nạp dữ liệu mẫu
- **Cách 1 (Qua giao diện phpMyAdmin):**
  1. Truy cập `http://localhost/phpmyadmin`.
  2. Tạo database mới với tên: `12b5_store` (bảng mã `utf8mb4_unicode_ci`).
  3. Chọn database `12b5_store`, vào tab **Import**:
     - Chọn và nhập file: [`database/schema.sql`](database/schema.sql).
     - Tiếp tục chọn và nhập file: [`database/seed.sql`](database/seed.sql).
- **Cách 2 (Qua dòng lệnh CLI nhanh):**
  Mở terminal tại thư mục gốc của đồ án và thực thi:
  ```bash
  php database/migrate.php --driver=mysql
  ```

### Bước 3: Cấu hình VirtualHost hoặc chạy máy chủ Web
- Nếu cấu hình VirtualHost hoặc đặt thư mục trong `xampp/htdocs/12b5-store`, truy cập: `http://localhost/12b5-store/public/`.
- Hoặc chạy nhanh PHP built-in server trỏ vào thư mục public:
  ```bash
  php -S localhost:8000 -t public
  ```
  Truy cập: `http://localhost:8000`.

---

## 4. Khởi Chạy Dự Phòng 1-Click Portable (Backup Setup)

Nhằm phục vụ việc chấm thi hoặc trình diễn đồ án trên máy tính của Hội đồng mà không cần cài đặt XAMPP hay cấu hình MySQL:

### Trên Windows:
Nhấp đúp chuột vào file:
```cmd
start.bat
```
Hoặc qua PowerShell:
```powershell
.\start.ps1
```

### Trên Linux / macOS:
```bash
chmod +x start.sh
./start.sh
```

**Cơ chế hoạt động:**
- Tự động nhận diện PHP trên máy hoặc trong `C:\xampp\php\php.exe`.
- Tự động nạp CSDL SQLite di động độc lập (`database/electro.sqlite`) với đầy đủ ràng buộc khóa ngoại `PRAGMA foreign_keys = ON`.
- Kiểm tra trạng thái Rust Engine; nếu chưa bật, tự động kích hoạt PHP Fallback Engine.
- Khởi chạy Web Server tại `http://localhost:8000` và mở trình duyệt tự động.

---

## 5. Cơ Sở Dữ Liệu (Database Schema)

Hệ thống được thiết kế theo chuẩn hóa 3NF gồm 10 bảng quan hệ:
- `users`: Tài khoản quản trị viên và khách hàng, mật khẩu băm một chiều Bcrypt.
- `categories`: Danh mục sản phẩm (seed data chuẩn: Smartphones, Laptops, Tablets, v.v.).
- `brands`: Thương hiệu công nghệ (Apple, Samsung, Dell, Asus, Sony, v.v.).
- `products`: Thông tin sản phẩm, giá bán, tồn kho, số lượt bán, trạng thái kinh doanh (hỗ trợ Soft Delete). Cột `specs` lưu định dạng JSON linh hoạt.
- `carts` & `cart_items`: Quản lý giỏ hàng theo session khách hàng hoặc tài khoản.
- `coupons`: Mã giảm giá (chiết khấu theo % hoặc số tiền, giới hạn lượt dùng và đơn tối thiểu).
- `orders` & `order_items`: Đơn hàng và chi tiết các mặt hàng mua, lưu trữ lịch sử giá tại thời điểm đặt hàng.
- `reviews`: Đánh giá xếp hạng 1-5 sao, xác thực điều kiện đã mua hàng thành công (`hasPurchased`).
- `system_logs`: Nhật ký sự kiện hệ thống.

---

## 6. Kiến Trúc Hệ Thống (Architecture)

```
[Trình duyệt Khách hàng / Quản trị viên]
                 │
                 ▼ HTTP
       [public/index.php]  (Front Controller & Router)
                 │
     ┌───────────┴───────────┐
     ▼                       ▼
[Controllers]           [Core / Security]
(Home, Product, Cart,   (Csrf, Session Regenerate,
 Checkout, Admin...)     Input Whitelist, PDO)
     │                       │
     ▼                       ▼
 [Models]               [Services]
 (Product, Order,       (SearchService, RecommendationService,
  Cart, User...)         AnalyticsService, RustEngineService)
     │                       │
     ▼ (SQL / PDO)           ▼ (HTTP REST API / JSON Loopback)
[MySQL 8.0 / SQLite 3]  [Rust Microservice Engine (Port 5000)]
                             ├── GET  /api/health
                             ├── POST /api/search (Levenshtein)
                             ├── POST /api/recommendations (Cosine)
                             ├── POST /api/analytics (Regression & ABC)
                             └── POST /api/image/batch-process
```

---

## 7. Kiểm Thử Tự Động & Đo Lường Hiệu Năng (Testing & Benchmark)

### Chạy bộ kiểm thử tự động (Automated Test Suite):
```bash
php tests/run_tests.php
```
Bộ kiểm thử bao gồm 20 ca kiểm thử bao phủ toàn bộ luồng nghiệp vụ:
- `CartTest.php`: Thêm, sửa, xóa giỏ hàng, áp mã coupon, kiểm tra giới hạn tồn kho.
- `OrderTest.php`: Giao dịch tạo đơn hàng (ACID Transaction), trừ kho an toàn, rollback khi thiếu hàng.
- `ProductTest.php`: Lọc phân trang, đọc thông số JSON, kiểm tra quyền đánh giá đã mua hàng.
- `AuthTest.php`: Xác thực băm Bcrypt, bảo toàn tài khoản quản trị và tự động dọn dẹp dữ liệu test.
- `RustEngineClientTest.php`: Kiểm tra kết nối dịch vụ Rust và cơ chế PHP fallback.

### Đo lường hiệu năng (Benchmark Suite):
```bash
php scripts/benchmark.php
```
Kịch bản đo lường phân định rõ giữa **độ trễ thuật toán CPU thuần** và **độ trễ toàn trình qua HTTP loopback**.

---

## 8. Tài Khoản Thử Nghiệm (Demo Credentials)

| Vai trò | Email đăng nhập | Mật khẩu mặc định | Ghi chú quyền hạn |
|---|---|---|---|
| **Quản trị viên (Admin)** | `admin@electro.vn` | `admin123` | Quản lý sản phẩm, đơn hàng, người dùng, xem báo cáo ABC |
| **Khách hàng (Customer)** | `customer@gmail.com` | `user123` | Mua hàng, xem lịch sử đơn, đánh giá sản phẩm |

*Lưu ý: Các thông tin đăng nhập trên phục vụ kiểm thử và chấm điểm đồ án tốt nghiệp trong môi trường nội bộ. Khi triển khai production, cần thay đổi mật khẩu và thu hồi tài khoản mặc định.*

---

## 9. Báo Cáo Đồ Án Tốt Nghiệp

- **Tài liệu Markdown:** [`Bao_cao_DATN_Website_Thuong_Mai_Dien_Tu_Thiet_Bi_Dien_Tu.md`](Bao_cao_DATN_Website_Thuong_Mai_Dien_Tu_Thiet_Bi_Dien_Tu.md)
- **Tài liệu Microsoft Word (.docx):** [`Bao_cao_DATN_Website_Thuong_Mai_Dien_Tu_Thiet_Bi_Dien_Tu.docx`](Bao_cao_DATN_Website_Thuong_Mai_Dien_Tu_Thiet_Bi_Dien_Tu.docx)
