# ElectroStore - Hệ Thống Thương Mại Điện Tử Thiết Bị Điện Tử
## Đồ Án Tốt Nghiệp: Kiến Trúc Hybrid Microservices (PHP Web Core + Rust High-Performance Engine)

[![ElectroStore CI/CD](https://github.com/your-username/electrostore/actions/workflows/ci.yml/badge.svg)](https://github.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%20%7C%208.3-777bb4?logo=php&logoColor=white)](https://www.php.net/)
[![Rust](https://img.shields.io/badge/Rust-2021%20Edition-black?logo=rust&logoColor=white)](https://www.rust-lang.org/)
[![Database](https://img.shields.io/badge/Database-MySQL%20%2B%20SQLite%20Portable-blue)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 📖 1. Giới Thiệu Dự Án

**ElectroStore** là hệ thống thương mại điện tử chuyên biệt cho ngành hàng thiết bị điện tử và công nghệ cao (Smartphones, Laptops, Máy tính bảng, Thiết bị âm thanh, Đồng hồ thông minh và Linh kiện cao cấp).

Dự án được xây dựng với kiến trúc **Hybrid Microservices**:
1. **PHP Web Application (Core E-Commerce):** Xây dựng theo mô hình kiến trúc MVC sạch (Clean Code), xử lý điều phối logic nghiệp vụ, quản lý phiên làm việc, giỏ hàng, đặt hàng, tạo mã VietQR chuẩn NAPAS 247 và phân quyền tài khoản.
2. **Rust High-Performance Engine (Microservice tại cổng 5000):** Tận dụng sức mạnh tính toán bare-metal và an toàn bộ nhớ của Rust để giải quyết các bài toán tải nặng:
   - **Tìm kiếm mờ (Fuzzy Search):** Kết hợp khoảng cách Levenshtein và đối sánh token thông số kỹ thuật (độ trễ dưới 1ms).
   - **Gợi ý thông minh (Smart Recommender):** Thuật toán Cosine Similarity trên không gian vector đa chiều (CPU, RAM, GPU, phân khúc giá).
   - **Phân tích kinh doanh & Dự báo:** Phân tích tồn kho Pareto ABC (80/20) và dự báo xu hướng doanh thu bằng mô hình Hồi quy tuyến tính (Linear Regression).
   - **Xử lý ảnh hàng loạt (Batch Image Processor Worker).**
3. **Cơ chế Graceful Fallback:** Nếu dịch vụ Rust tạm dừng hoặc chưa khởi động, lớp `RustEngineService` tự động kích hoạt thuật toán dự phòng nội bộ bằng PHP, đảm bảo tính liên tục 100% của website.
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

## 🔑 3. Tài Khoản Thử Nghiệm Sẵn Có

| Vai trò | Email đăng nhập | Mật khẩu mặc định | Quyền hạn |
|---|---|---|---|
| **Quản trị viên (Admin)** | `admin@electro.vn` | `admin123` | Toàn quyền Dashboard, Quản lý SP, Đơn hàng, Users |
| **Khách hàng (Customer)** | `customer@gmail.com` | `user123` | Mua hàng, Giỏ hàng, Đánh giá, Xem lịch sử đơn |

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
│   ├── run_tests.php            # Test runner kiểm thử tự động
│   ├── CartTest.php             # Kiểm thử giỏ hàng & khuyến mãi
│   ├── OrderTest.php            # Kiểm thử giao dịch đơn hàng & tồn kho
│   └── RustEngineClientTest.php # Kiểm thử kết nối và thuật toán Rust
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
