# 12B5 Store - Hệ Thống Thương Mại Điện Tử Thiết Bị Điện Tử
## Đồ Án Tốt Nghiệp: Kiến Trúc Hybrid Microservices (PHP Web Core + Rust High-Performance Engine)

[![12B5 Store CI/CD](https://github.com/Nhan-209/12b5-store/actions/workflows/ci.yml/badge.svg)](https://github.com/Nhan-209/12b5-store/actions)
[![PHP](https://img.shields.io/badge/PHP-8.2%20%7C%208.3-777bb4?logo=php&logoColor=white)](https://www.php.net/)
[![Rust](https://img.shields.io/badge/Rust-2021%20Edition-black?logo=rust&logoColor=white)](https://www.rust-lang.org/)
[![Database](https://img.shields.io/badge/Database-MySQL%20(XAMPP)%20%2B%20SQLite%20Portable-blue)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 📖 1. Giới Thiệu Dự Án

**12B5 Store** là hệ thống thương mại điện tử chuyên biệt cho ngành hàng thiết bị điện tử và công nghệ cao (Smartphones, Laptops, Máy tính bảng, Thiết bị âm thanh, Đồng hồ thông minh và Linh kiện cao cấp).

Dự án được xây dựng với kiến trúc **Hybrid Microservices**:
1. **PHP Web Application (Core E-Commerce):** Xây dựng theo mô hình kiến trúc MVC sạch (Clean Code), xử lý điều phối logic nghiệp vụ, quản lý phiên làm việc, giỏ hàng, đặt hàng, tạo mã VietQR chuẩn NAPAS 247 và phân quyền tài khoản.
2. **Rust High-Performance Engine (Microservice tại cổng 5000):** Tận dụng sức mạnh tính toán bare-metal và an toàn bộ nhớ của Rust để giải quyết các bài toán tải nặng:
   - **Tìm kiếm mờ (Fuzzy Search):** Kết hợp khoảng cách Levenshtein và đối sánh token thông số kỹ thuật (độ trễ dưới 1ms).
   - **Gợi ý thông minh (Smart Recommender):** Thuật toán Cosine Similarity trên không gian vector đa chiều (CPU, RAM, GPU, phân khúc giá).
   - **Phân tích kinh doanh & Dự báo:** Phân tích tồn kho Pareto ABC (80/20) và dự báo xu hướng doanh thu bằng mô hình Hồi quy tuyến tính (Linear Regression).
   - **Xử lý ảnh hàng loạt (Batch Image Processor Worker).**
3. **Cơ chế Graceful Fallback:** Nếu dịch vụ Rust tạm dừng hoặc chưa khởi động, lớp `RustEngineService` tự động chuyển sang thuật toán dự phòng nội bộ bằng PHP, đảm bảo các chức năng tìm kiếm và gợi ý duy trì hoạt động ổn định.
4. **Hỗ trợ Dual Database (MySQL + SQLite Portable):** Tự động chuyển sang SQLite nhúng (`database/electro.sqlite`) khi chạy demo trên máy tính trường học mà không cần cài đặt hay cấu hình MySQL Server!
5. **DevOps & Tự động hóa CI/CD:** Toàn bộ quy trình kiểm thử đơn vị, kiểm tra cú pháp PHP và biên dịch chéo Rust nhị phân (Windows `rust_engine.exe` và Linux `rust_engine`) đều được tự động hóa hoàn toàn trên GitHub Actions.

---

## 🚀 2. Hướng Dẫn Khởi Chạy Nhanh (1-Click Run)

### Trên Windows (Máy tính thuyết trình / Máy chấm thi):
Chỉ cần nhấp đúp chuột vào file:
```cmd
start.bat
```
hoặc chạy bằng PowerShell:
```powershell
.\start.ps1
```
Kịch bản sẽ tự động:
1. Nhận diện PHP trong hệ thống hoặc thư mục XAMPP (`C:\xampp\php\php.exe`).
2. Khởi tạo cơ sở dữ liệu SQLite portable.
3. Kích hoạt Rust Engine microservice (hoặc chuyển sang chế độ PHP fallback an toàn).
4. Khởi chạy Web Server tại `http://localhost:8000` và tự động mở trình duyệt web.

### Trên Linux / macOS:
```bash
chmod +x start.sh
./start.sh
```

---

## 🐬 2.1. Hướng Dẫn Sử Dụng MySQL Trên XAMPP (Nếu bạn muốn dùng XAMPP)

Hệ thống được thiết kế cơ chế **Dual Database thông minh (MySQL + SQLite)**:
- Mặc định khi chạy `start.bat`, hệ thống tự động kiểm tra xem MySQL của XAMPP có đang bật hay không.
- Nếu **MySQL đang bật**, web sẽ tự động kết nối và dùng MySQL (`12b5_store`).
- Nếu **MySQL tắt** hoặc máy trường không có XAMPP, web sẽ tự động chuyển sang SQLite nhúng (`database/electro.sqlite`) mà không bị lỗi!

### Các bước nạp CSDL vào MySQL XAMPP:
1. Mở **XAMPP Control Panel**, nhấn **Start** cho cả **Apache** và **MySQL**.
2. Mở trình duyệt truy cập: `http://localhost/phpmyadmin`
3. Nhấn **New** (Mới) -> Nhập tên cơ sở dữ liệu: `12b5_store` (bảng mã `utf8mb4_unicode_ci`) -> Nhấn **Create** (Tạo).
4. Chọn CSDL `12b5_store` vừa tạo -> Chọn tab **Import** (Nhập):
   - Chọn tệp: [database/schema.sql](./database/schema.sql) -> Nhấn **Import** (Thực hiện).
   - Tiếp tục chọn tệp: [database/seed.sql](./database/seed.sql) -> Nhấn **Import** (Thực hiện).
5. **Cách 2 (Siêu tốc bằng dòng lệnh):**
   Bạn chỉ cần mở Terminal/CMD tại thư mục dự án và gõ:
   ```bash
   php database/migrate.php --driver=mysql
   ```
   Lệnh này sẽ tự động tạo database `12b5_store`, tạo đủ các bảng và nạp toàn bộ sản phẩm mẫu!

---

## 🔑 3. Tài Khoản Thử Nghiệm Sẵn Có (Môi Trường Đồ Án / Demo)

| Vai trò | Email đăng nhập | Mật khẩu mặc định | Quyền hạn |
|---|---|---|---|
| **Quản trị viên (Admin)** | `admin@electro.vn` | `admin123` | Toàn quyền Dashboard, Quản lý SP, Đơn hàng, Users |
| **Khách hàng (Customer)** | `customer@gmail.com` | `user123` | Mua hàng, Giỏ hàng, Đánh giá, Xem lịch sử đơn |

> **Lưu ý bảo mật:** Các thông tin đăng nhập trên được thiết lập công khai nhằm phục vụ công tác kiểm thử và chấm điểm đồ án tốt nghiệp trong môi trường nội bộ hoặc offline. Khi đưa vào vận hành thực tế trên Internet, quản trị viên cần đổi mật khẩu mặc định và thu hồi các tài khoản demo.

---

## 📂 4. Cấu Trúc Thư Mục Dự Án

```
doantotnghiep/
├── .github/workflows/
│   └── ci.yml                   # Pipeline CI/CD GitHub Actions
├── app/
│   ├── config/database.php      # Cấu hình Dual Database & Rust Engine
│   ├── controllers/             # Các lớp Controller MVC
│   ├── models/                  # Các lớp Model (Product, Cart, Order, User...)
│   ├── services/                # Các lớp Service (RustEngine, Search, Analytics)
│   └── views/                   # Template giao diện theo từng phân hệ
├── database/
│   ├── schema.sql / seed.sql    # Dữ liệu mẫu MySQL
│   ├── schema_sqlite.sql        # Cấu trúc SQLite Portable
│   ├── seed_sqlite.sql          # Dữ liệu mẫu SQLite
│   ├── electro.sqlite           # Tệp CSDL SQLite sẵn dùng
│   └── migrate.php              # Kịch bản nạp CSDL tự động
├── public/
│   ├── index.php                # Front Controller & Routing Engine
│   ├── css/style.css            # Giao diện Modern Tech Store
│   └── js/app.js                # Xử lý AJAX Live Search & Giỏ hàng
├── rust-engine/
│   ├── Cargo.toml               # Cấu hình đóng gói & tối ưu hóa Rust
│   └── src/
│       ├── main.rs              # Máy chủ HTTP REST API
│       ├── search.rs            # Thuật toán tìm kiếm Levenshtein
│       ├── recommender.rs       # Thuật toán gợi ý Cosine Similarity
│       ├── analytics.rs         # Thuật toán Hồi quy tuyến tính & ABC
│       ├── image_processor.rs   # Xử lý ảnh hàng loạt
│       ├── handlers.rs          # Bộ điều phối API endpoints
│       └── models.rs            # Cấu trúc dữ liệu JSON Serde
├── tests/
│   ├── run_tests.php            # Test runner kiểm thử tự động (20/20 Test Cases)
│   ├── CartTest.php             # Kiểm thử giỏ hàng & khuyến mãi (5 tests)
│   ├── OrderTest.php            # Kiểm thử giao dịch đơn hàng & tồn kho (4 tests)
│   ├── ProductTest.php          # Kiểm thử sản phẩm, bộ lọc & đánh giá đã mua (5 tests)
│   ├── AuthTest.php             # Kiểm thử xác thực & băm mật khẩu Bcrypt (3 tests)
│   └── RustEngineClientTest.php # Kiểm thử kết nối và thuật toán Rust (3 tests)
├── scripts/
│   ├── generate_docx.py         # Kịch bản biên dịch báo cáo sang Word (.docx)
│   ├── verify_project.py        # Kịch bản kiểm tra toàn diện 153 tiêu chí
│   └── init_sqlite.py           # Khởi tạo dữ liệu SQLite từ Python
├── start.bat / start.ps1        # Kịch bản khởi chạy 1-click trên Windows
├── start.sh                     # Kịch bản khởi chạy trên Linux/macOS
├── Bao_cao_DATN_Website_Thuong_Mai_Dien_Tu_Thiet_Bi_Dien_Tu.md   # Báo cáo đồ án 5 chương
└── Bao_cao_DATN_Website_Thuong_Mai_Dien_Tu_Thiet_Bi_Dien_Tu.docx # File Word hoàn chỉnh nộp trường
```

---

## 📑 5. Báo Cáo Đồ Án Tốt Nghiệp

Báo cáo đồ án tốt nghiệp được biên soạn hoàn chỉnh theo chuẩn đào tạo, bao gồm 5 chương chi tiết:
- **File Markdown:** [`Bao_cao_DATN_Website_Thuong_Mai_Dien_Tu_Thiet_Bi_Dien_Tu.md`](./Bao_cao_DATN_Website_Thuong_Mai_Dien_Tu_Thiet_Bi_Dien_Tu.md)
- **File Microsoft Word (nộp chấm điểm):** [`Bao_cao_DATN_Website_Thuong_Mai_Dien_Tu_Thiet_Bi_Dien_Tu.docx`](./Bao_cao_DATN_Website_Thuong_Mai_Dien_Tu_Thiet_Bi_Dien_Tu.docx)
