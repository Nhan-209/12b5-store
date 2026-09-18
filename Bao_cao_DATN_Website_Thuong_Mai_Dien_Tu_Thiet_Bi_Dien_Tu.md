# BÁO CÁO ĐỒ ÁN TỐT NGHIỆP
## ĐỀ TÀI: XÂY DỰNG WEBSITE THƯƠNG MẠI ĐIỆN TỬ THIẾT BỊ ĐIỆN TỬ VỚI KIẾN TRÚC HYBRID PHP VÀ RUST ENGINE HIỆU NĂNG CAO

**Cơ sở đào tạo:** KHOA KỸ THUẬT – CÔNG NGHỆ  
**Chuyên ngành:** CÔNG NGHỆ THÔNG TIN  
**Thời gian thực hiện:** Tháng 09 Năm 2026  

---

### LỜI CẢM ƠN

Trong suốt quá trình học tập, rèn luyện và hoàn thiện đồ án tốt nghiệp này, em đã nhận được sự quan tâm, chỉ dẫn tận tình và động viên to lớn từ quý thầy cô, gia đình cùng bạn bè. 

Trước hết, em xin bày tỏ lòng biết ơn sâu sắc đến Ban Giám hiệu nhà trường và quý thầy cô Khoa Kỹ thuật – Công nghệ, những người đã truyền dạy cho em nền tảng kiến thức vững chắc về công nghệ thông tin, lập trình web, cấu trúc dữ liệu và kiến trúc hệ thống phần mềm trong suốt khóa học.

Đặc biệt, em xin gửi lời cảm ơn trân trọng nhất đến Thầy/Cô giáo viên hướng dẫn. Nhờ sự định hướng tận tâm, những góp ý xác đáng về tư duy phân tích hệ thống, cách thiết kế cơ sở dữ liệu quan hệ, phương pháp tối ưu hóa kiến trúc Hybrid đa ngôn ngữ (PHP kết hợp Rust) và quy trình tự động hóa CI/CD, em mới có thể hoàn thành đề tài một cách trọn vẹn và đạt tiêu chuẩn khoa học cao.

Sau cùng, em xin gửi lời cảm ơn đến gia đình và các bạn cùng lớp đã luôn là chỗ dựa tinh thần, hỗ trợ thử nghiệm hệ thống và đóng góp nhiều phản hồi quý báu. Dù đã rất nỗ lực, đồ án chắc chắn khó tránh khỏi những thiếu sót nhất định. Em kính mong nhận được ý kiến nhận xét và chỉ bảo của quý thầy cô trong Hội đồng chấm đồ án để sản phẩm được hoàn thiện hơn nữa.

*TP. Hồ Chí Minh, tháng 09 năm 2026*  
**Sinh viên thực hiện**  
*(Ký và ghi rõ họ tên)*

---

## MỤC LỤC

- **CHƯƠNG 1: GIỚI THIỆU**
  - 1.1. Lý do chọn đề tài
  - 1.2. Mục tiêu nghiên cứu
  - 1.3. Phạm vi đề tài
  - 1.4. Phương pháp nghiên cứu và thực hiện
  - 1.5. Cấu trúc của đồ án
- **CHƯƠNG 2: CƠ SỞ LÝ THUYẾT VÀ CÔNG NGHỆ**
  - 2.1. Nền tảng phát triển ứng dụng Web (PHP, HTML5, CSS3, JavaScript, Bootstrap 5)
  - 2.2. Mô hình kiến trúc phần mềm MVC (Model - View - Controller)
  - 2.3. Cơ sở dữ liệu quan hệ (MySQL và SQLite) cùng kỹ thuật PDO
  - 2.4. Ngôn ngữ Rust và vai trò trong hệ thống Web hiệu năng cao
  - 2.5. Giao tiếp liên dịch vụ (RESTful API & Microservices)
  - 2.6. Tự động hóa tích hợp và triển khai liên tục (CI/CD với GitHub Actions)
  - 2.7. Cơ sở lý thuyết các thuật toán thông minh trong TMĐT
    - 2.7.1. Thuật toán gợi ý Cosine Similarity trên không gian vector đặc trưng
    - 2.7.2. Thuật toán tìm kiếm xấp xỉ chuỗi (Fuzzy Search kết hợp Levenshtein Distance và Token Matching)
    - 2.7.3. Thuật toán hồi quy tuyến tính (Linear Regression) dự báo xu hướng doanh thu
    - 2.7.4. Phương pháp phân tích tồn kho ABC (Nguyên lý Pareto 80/20)
- **CHƯƠNG 3: PHÂN TÍCH VÀ THIẾT KẾ HỆ THỐNG**
  - 3.1. Khảo sát hiện trạng nghiệp vụ bán lẻ thiết bị điện tử
  - 3.2. Phân tích yêu cầu hệ thống
    - 3.2.1. Các tác nhân tham gia hệ thống
    - 3.2.2. Bảng đặc tả yêu cầu chức năng (F01 - F16)
    - 3.2.3. Bảng đặc tả yêu cầu phi chức năng (NF01 - NF08)
  - 3.3. Mô hình hóa hệ thống bằng ngôn ngữ UML
    - 3.3.1. Biểu đồ Use Case tổng quát và chi tiết
    - 3.3.2. Biểu đồ hoạt động (Activity Diagram) quy trình đặt hàng
    - 3.3.3. Biểu đồ lớp (Class Diagram)
    - 3.3.4. Biểu đồ tuần tự (Sequence Diagram) xử lý đơn hàng & gọi Rust Engine
  - 3.4. Thiết kế kiến trúc tổng thể Hybrid Microservices
  - 3.5. Thiết kế cơ sở dữ liệu quan hệ (ERD & Danh mục bảng)
  - 3.6. Thiết kế giao diện người dùng (UI/UX Design System)
- **CHƯƠNG 4: TRIỂN KHAI VÀ KIỂM THỬ HỆ THỐNG**
  - 4.1. Môi trường triển khai và vận hành
  - 4.2. Quy trình cài đặt và cấu hình hệ thống
    - 4.2.1. Cấu hình cơ sở dữ liệu linh hoạt (Dual MySQL / SQLite Portable)
    - 4.2.2. Xây dựng luồng CI/CD GitHub Actions kiểm thử và biên dịch đa nền tảng
  - 4.3. Mô tả chi tiết các chức năng đã hoàn thiện
    - 4.3.1. Phân hệ khách hàng (Cửa hàng, Giỏ hàng, VietQR, Tra cứu đơn)
    - 4.3.2. Phân hệ quản trị (Dashboard KPIs, Quản lý sản phẩm, Đơn hàng, Phân tích ABC)
    - 4.3.3. Rust Microservice Engine (Health, Search, Recommender, Analytics, Batch Worker)
  - 4.4. Kiểm thử hệ thống (Kế hoạch kiểm thử & Ma trận 20 Test Cases)
  - 4.5. Đánh giá và so sánh thực nghiệm hiệu năng (Benchmark PHP vs Rust Engine)
- **CHƯƠNG 5: ĐÁNH GIÁ, KẾT LUẬN VÀ HƯỚNG PHÁT TRIỂN**
  - 5.1. Đánh giá kết quả đạt được đối chiếu với mục tiêu ban đầu
  - 5.2. Kết luận khoa học và thực tiễn
  - 5.3. Hạn chế của hệ thống hiện tại
  - 5.4. Hướng phát triển mở rộng trong tương lai
- **TÀI LIỆU THAM KHẢO**
- **PHỤ LỤC: DANH MỤC API ENDPOINTS CỦA RUST ENGINE**

---

# CHƯƠNG 1: GIỚI THIỆU

## 1.1. Lý do chọn đề tài

Trong kỷ nguyên chuyển đổi số và bùng nổ công nghệ thông tin hiện nay, ngành thương mại điện tử (E-Commerce) đã trở thành trụ cột quan trọng của nền kinh tế số toàn cầu nói chung và Việt Nam nói riêng. Trong số các ngành hàng mua sắm trực tuyến, nhóm ngành **Thiết bị điện tử và Công nghệ cao** (bao gồm điện thoại thông minh, máy tính xách tay, máy tính bảng, thiết bị âm thanh, đồng hồ thông minh và linh kiện phần cứng) chiếm tỷ trọng doanh thu hàng đầu và có tốc độ tăng trưởng vượt bậc.

Khác với các mặt hàng tiêu dùng đơn giản (như thời trang, đồ gia dụng), thiết bị điện tử có các đặc thù kỹ thuật rất phức tạp:
1. **Thông số kỹ thuật đa chiều (Multi-dimensional Specs):** Khách hàng khi mua laptop hoặc điện thoại thường so sánh kỹ lưỡng các thông số như thế hệ CPU, dung lượng RAM, chuẩn bộ nhớ SSD, công nghệ tấm nền màn hình (OLED/IPS, tần số quét 120Hz/240Hz), công suất sạc và card đồ họa (GPU).
2. **Giá trị đơn hàng cao:** Đòi hỏi quy trình xác thực minh bạch, hỗ trợ tạo mã thanh toán chuyển khoản ngân hàng tự động (VietQR chuẩn NAPAS 247) và theo dõi trạng thái đơn hàng xuyên suốt.
3. **Áp lực tính toán và xử lý dữ liệu lớn:** Khi danh mục sản phẩm và lượng truy cập tăng cao, các tác vụ tính toán nặng như: tìm kiếm mờ (fuzzy search) kết hợp nhiều tiêu chí lọc, gợi ý sản phẩm tương đồng dựa trên thông số kỹ thuật (Content-Based Recommendation), xử lý ảnh hàng loạt (batch image resizing/format conversion) và tổng hợp báo cáo kinh doanh (phân tích Pareto ABC, dự báo doanh thu) nếu chỉ chạy trên ngôn ngữ kịch bản thông thường như PHP thuần sẽ dễ dẫn đến hiện tượng quá tải CPU, phản hồi chậm và tiêu hao nhiều bộ nhớ RAM.

Xuất phát từ thực tiễn trên, đồ án lựa chọn đề tài: **“Xây dựng Website Thương mại Điện tử Thiết bị Điện tử với Kiến trúc Hybrid PHP và Rust Engine Hiệu Năng Cao”**. Đề tài phát huy tối đa thế mạnh của **PHP** trong việc xây dựng ứng dụng web nhanh chóng, dễ bảo trì theo mô hình MVC, đồng thời tích hợp dịch vụ phụ trợ bằng **Rust** – một ngôn ngữ lập trình hệ thống hiện đại, an toàn bộ nhớ (memory-safe), tốc độ thực thi bare-metal – nhằm tối ưu hóa hiệu năng tính toán thuật toán trong môi trường thương mại điện tử.

## 1.2. Mục tiêu nghiên cứu

Đồ án hướng tới các mục tiêu cụ thể sau:
- **Về mặt nghiệp vụ:** Xây dựng hoàn chỉnh một hệ thống website thương mại điện tử chuyên biệt cho thiết bị điện tử với đầy đủ luồng nghiệp vụ từ phía khách hàng (tìm kiếm, lọc thông số, xem chi tiết, giỏ hàng, áp mã giảm giá, thanh toán COD / VietQR, theo dõi đơn hàng) đến phân hệ quản trị viên (quản lý sản phẩm, tồn kho, đơn hàng, người dùng, xem báo cáo doanh thu).
- **Về mặt công nghệ & kiến trúc:**
  - Thiết kế kiến trúc dạng **Hybrid Microservices**: Ứng dụng web PHP đóng vai trò Core Web Application, giao tiếp với dịch vụ **Rust Engine** qua giao thức HTTP RESTful API.
  - Xây dựng cơ chế **Graceful Fallback**: Trong trường hợp dịch vụ Rust bảo trì hoặc ngoại tuyến, hệ thống PHP tự động kích hoạt thuật toán dự phòng nội bộ, đảm bảo tính liên tục và độ ổn định cao của hệ sinh thái web.
  - Hỗ trợ cơ sở dữ liệu linh hoạt (Dual Driver): Chạy tối ưu trên **MySQL** khi triển khai production và tự động fallback sang **SQLite** khi mang đồ án chạy trình diễn trên máy tính của trường hoặc máy chấm thi với cấu hình tối thiểu mà không cần cài đặt phức tạp.
- **Về mặt kỹ thuật thông minh:**
  - Hiện thực hóa thuật toán tìm kiếm mờ (Fuzzy Search) kết hợp khoảng cách Levenshtein và đối sánh token đặc tả kỹ thuật.
  - Hiện thực hóa thuật toán gợi ý thông minh dựa trên độ tương đồng Cosine (Cosine Similarity) trên vector đặc trưng của thiết bị.
  - Hiện thực hóa thuật toán dự báo doanh thu bằng mô hình Hồi quy tuyến tính (Linear Regression) và phân loại quản trị hàng tồn kho ABC theo nguyên lý Pareto (80/20).
- **Về mặt tự động hóa (DevOps):**
  - Thiết lập luồng **CI/CD hoàn chỉnh bằng GitHub Actions** để tự động kiểm thử mã nguồn PHP và biên dịch chéo (cross-compile) dịch vụ Rust sang các file nhị phân độc lập trên Windows (`.exe`) và Linux (`ELF`), giúp người dùng trên máy tính cấu hình yếu vẫn có thể phát triển phần mềm hiệu quả.

## 1.3. Phạm vi đề tài

- **Đối tượng người dùng:**
  - *Khách vãng lai (Guest):* Xem danh mục thiết bị, tìm kiếm nâng cao, lọc theo khoảng giá/thương hiệu, xem thông số kỹ thuật chi tiết, thêm vào giỏ hàng, đặt hàng không cần tài khoản hoặc đăng ký tài khoản mới.
  - *Khách hàng đã đăng nhập (Customer):* Quản lý thông tin giao hàng mặc định, xem lịch sử đơn hàng, theo dõi tiến độ xử lý và gửi đánh giá nhận xét sản phẩm.
  - *Quản trị viên (Admin):* Quản lý vòng đời sản phẩm, cập nhật tồn kho, duyệt và cập nhật trạng thái đơn hàng, quản lý danh mục/hãng sản xuất và giám sát hiệu năng hệ thống qua Dashboard.
- **Danh mục sản phẩm thực tế:** 6 ngành hàng điện tử cốt lõi (Điện thoại thông minh, Laptop & Máy tính, Máy tính bảng, Tai nghe & Âm thanh, Đồng hồ thông minh, Phụ kiện & Linh kiện cao cấp) với dữ liệu mẫu chi tiết về cấu hình phần cứng.
- **Thanh toán:** Tích hợp thanh toán khi nhận hàng (COD) và cơ chế tạo mã **VietQR** động theo chuẩn NAPAS 247 tương thích với mọi ứng dụng ngân hàng tại Việt Nam.

## 1.4. Phương pháp nghiên cứu và thực hiện

Đồ án được thực hiện bằng cách kết hợp phương pháp nghiên cứu lý thuyết và phương pháp thực nghiệm công nghệ:
1. **Khảo sát & Phân tích:** Nghiên cứu nghiệp vụ các hệ thống bán lẻ công nghệ hàng đầu (Thế Giới Di Động, FPT Shop, CellphoneS) để trích xuất các thuộc tính dữ liệu và luồng hành vi mua sắm của khách hàng.
2. **Thiết kế hệ thống:** Áp dụng phương pháp phân tích hướng đối tượng (OOAD) và ngôn ngữ mô hình hóa UML (Use Case, Activity, Class, Sequence Diagram), thiết kế cơ sở dữ liệu chuẩn hóa cấp 3NF.
3. **Phát triển phần mềm theo mô hình lặp:** Xây dựng phần mềm theo từng phân hệ chức năng độc lập, viết mã sạch (Clean Code), không phụ thuộc vào các framework cồng kềnh nhằm giữ cho ứng dụng nhẹ, sáng sủa và dễ bảo trì.
4. **Kiểm thử tự động & Đo lường thực nghiệm:** Thiết lập bộ kiểm thử đơn vị (Unit Test) cho các quy trình cốt lõi, chạy đo kiểm benchmark thời gian đáp ứng (latency) và thông lượng giữa PHP và Rust.

## 1.5. Cấu trúc của đồ án

Báo cáo tốt nghiệp được cấu trúc thành 5 chương chặt chẽ:
- **Chương 1: Giới thiệu:** Trình bày bối cảnh, lý do chọn đề tài, mục tiêu, phạm vi và phương pháp thực hiện.
- **Chương 2: Cơ sở lý thuyết và công nghệ:** Trình bày nền tảng lý thuyết về PHP MVC, cơ sở dữ liệu quan hệ, ngôn ngữ Rust, kiến trúc Microservice, CI/CD GitHub Actions và các thuật toán tính toán thông minh.
- **Chương 3: Phân tích và thiết kế hệ thống:** Trình bày khảo sát hiện trạng, đặc tả yêu cầu chức năng/phi chức năng, sơ đồ UML, thiết kế kiến trúc Hybrid, sơ đồ cơ sở dữ liệu ERD và thiết kế giao diện UI.
- **Chương 4: Triển khai và kiểm thử hệ thống:** Trình bày môi trường cài đặt, quy trình cấu hình dual database, thiết lập CI/CD, mô tả chi tiết chức năng, ma trận 20 test case và phân tích thực nghiệm benchmark hiệu năng.
- **Chương 5: Đánh giá, kết luận và hướng phát triển:** Tổng kết kết quả đạt được so với mục tiêu, nêu bật đóng góp, chỉ ra hạn chế và lộ trình phát triển tiếp theo.

---

# CHƯƠNG 2: CƠ SỞ LÝ THUYẾT VÀ CÔNG NGHỆ

## 2.1. Nền tảng phát triển ứng dụng Web

### 2.1.1. HTML5, CSS3 và JavaScript thuần
- **HTML5 (HyperText Markup Language 5):** Định nghĩa cấu trúc ngữ nghĩa cho trang web bán thiết bị điện tử với các thẻ ngữ nghĩa chuẩn (`<header>`, `<nav>`, `<main>`, `<article>`, `<section>`, `<footer>`).
- **CSS3:** Xây dựng hệ thống giao diện hiện đại thông qua các biến màu sắc tùy biến (CSS Variables), hệ thống lưới linh hoạt (Flexbox, CSS Grid) và hiệu ứng chuyển động mượt mà (transitions/transforms) khi di chuột qua thẻ sản phẩm.
- **JavaScript (ES6+):** Xử lý tương tác phía máy khách (Client-side) bao gồm kiểm tra tính hợp lệ dữ liệu biểu mẫu trước khi gửi đi, gửi yêu cầu AJAX bất đồng bộ để tìm kiếm trực tiếp (Live Search với kỹ thuật debounce), cập nhật giỏ hàng tức thời không cần tải lại toàn bộ trang và hiển thị thông báo Toast.

### 2.1.2. Bootstrap 5.3
Bootstrap 5.3 là thư viện giao diện nguồn mở hàng đầu thế giới. Việc ứng dụng Bootstrap 5.3 mang lại các lợi ích vượt trội:
- Hệ thống lưới 12 cột tương thích toàn diện trên thiết bị di động, máy tính bảng và màn hình máy tính bàn lớn.
- Bỏ hoàn toàn sự phụ thuộc vào jQuery, tăng tốc độ phân giải DOM trên trình duyệt.
- Tận dụng các thành phần giao diện chuyên nghiệp: Navbar, Modal, Dropdown, Accordion, Card, Toast và bộ icon vector sắc nét Bootstrap Icons.

### 2.1.3. PHP 8.x
PHP (PHP: Hypertext Preprocessor) là ngôn ngữ lập trình kịch bản phía máy chủ mạnh mẽ và phổ biến nhất trong hệ sinh thái thương mại điện tử toàn cầu. Phiên bản PHP 8.x mang lại nhiều cải tiến quan trọng về hiệu năng và cú pháp:
- Cơ chế biên dịch thời gian thực JIT (Just-In-Time Compilation) giúp tăng hiệu suất xử lý mã lệnh.
- Hệ thống kiểu dữ liệu nghiêm ngặt (Type Hinting, Union Types, Return Types), biểu thức `match`, hàm xử lý chuỗi hiện đại (`str_starts_with`, `str_contains`).
- Cơ chế quản lý phiên làm việc (`$_SESSION`) an toàn và tích hợp sẵn chuẩn mã hóa băm mật khẩu `PASSWORD_DEFAULT` (sử dụng thuật toán Bcrypt) với chi phí mã hóa (cost) cao, bảo vệ an toàn thông tin người dùng trước các cuộc tấn công tra từ điển (Rainbow Tables).

## 2.2. Mô hình kiến trúc phần mềm MVC (Model - View - Controller)

Hệ thống được tổ chức nhất quán theo mẫu kiến trúc kinh điển **MVC**, giúp phân tách rõ ràng trách nhiệm của từng thành phần:
- **Model (Tầng dữ liệu & nghiệp vụ cốt lõi):** Chứa các lớp đại diện cho đối tượng nghiệp vụ như `Product`, `Category`, `Brand`, `Cart`, `Order`, `User`. Tầng Model chịu trách nhiệm truy vấn, cập nhật dữ liệu từ cơ sở dữ liệu và đảm bảo các ràng buộc toàn vẹn (như kiểm tra số lượng tồn kho trước khi đặt hàng).
- **View (Tầng hiển thị giao diện):** Sử dụng các file template PHP kết hợp HTML để trình bày dữ liệu đến người dùng cuối. View hoàn toàn không chứa các câu lệnh truy vấn SQL trực tiếp nhằm duy trì tính độc lập giao diện.
- **Controller (Tầng điều hướng & phối hợp):** Tiếp nhận các yêu cầu HTTP từ Router, trích xuất tham số, kích hoạt các dịch vụ (Services) hoặc Model tương ứng, sau đó lựa chọn View thích hợp để hiển thị hoặc trả về dữ liệu JSON cho các lệnh gọi API.

## 2.3. Cơ sở dữ liệu quan hệ (MySQL và SQLite) cùng kỹ thuật PDO

### 2.3.1. PDO (PHP Data Objects)
PDO là lớp giao tiếp cơ sở dữ liệu hướng đối tượng trừu tượng hóa có sẵn trong nhân PHP. Đồ án sử dụng PDO làm cầu nối thống nhất với các ưu điểm quyết định:
- **Tính di động (Portability):** Cung cấp chung một tập hàm API truy vấn (`prepare`, `execute`, `fetch`, `fetchAll`, `beginTransaction`, `commit`) cho nhiều hệ quản trị cơ sở dữ liệu khác nhau.
- **Phòng chống tấn công SQL Injection:** Toàn bộ tham số người dùng nhập vào đều được thực thi qua cơ chế Tham số hóa (Prepared Statements) và ràng buộc giá trị (`bindValue` / `execute([$param])`), kết hợp cấu hình `PDO::ATTR_EMULATE_PREPARES => false` nhằm ngăn chặn nguy cơ chèn mã độc vào câu lệnh SQL.

### 2.3.2. Cơ chế linh hoạt Dual Database (MySQL + SQLite Fallback)
Một cải tiến kiến trúc sáng giá trong đồ án này là khả năng vận hành **Dual Database Driver**:
- Trong môi trường thông thường hoặc production, hệ thống kết nối với **MySQL 8.0** để tận dụng các tính năng cơ sở dữ liệu quan hệ mạnh mẽ, khóa ngoại (Foreign Keys) và chỉ mục tốc độ cao.
- Trong trường hợp triển khai trên máy tính trình diễn của trường học hoặc máy chấm bài không được cài đặt sẵn máy chủ MySQL Server, lớp `Database.php` tự động nhận diện và chuyển sang tệp cơ sở dữ liệu **SQLite** nhúng gọn nhẹ (`database/electro.sqlite`) mà không cần bất kỳ thao tác cấu hình phức tạp nào.

## 2.4. Ngôn ngữ Rust và vai trò trong hệ thống Web hiệu năng cao

Rust là ngôn ngữ lập trình hệ thống được phát triển bởi Mozilla Research, liên tục nhiều năm liền được cộng đồng lập trình viên thế giới bình chọn là ngôn ngữ được yêu thích nhất (Stack Overflow Developer Survey).

Các đặc tính cốt lõi của Rust được ứng dụng trong đồ án:
- **An toàn bộ nhớ không cần bộ thu gom rác (Memory Safety without Garbage Collector):** Nhờ hệ thống quyền sở hữu (Ownership System) và quy tắc vay mượn (Borrow Checker) được kiểm tra ngay tại thời điểm biên dịch, Rust đảm bảo không xảy ra hiện tượng rò rỉ bộ nhớ (memory leaks), truy cập con trỏ null (null pointer dereferences) hay xung đột truy cập vùng nhớ (data races).
- **Tốc độ thực thi bare-metal:** Rust biên dịch trực tiếp ra mã máy nhị phân bản địa (Native Machine Code), đạt hiệu năng tương đương với C/C++ nhưng độ an toàn vượt trội.
- **Khả năng xử lý tác vụ hiệu năng cao:** Rust cung cấp hệ sinh thái tính toán hiệu năng cao với chi phí tài nguyên cực thấp, thích hợp để xây dựng các microservice chuyên trách các thuật toán phức tạp.

Trong đề tài này, **Rust** không thay thế PHP trong việc render HTML hay quản lý phiên người dùng, mà đóng vai trò một **High-Performance Engine** chuyên trách tiếp nhận và xử lý các bài toán tiêu hao năng lực tính toán lớn.

## 2.5. Giao tiếp liên dịch vụ (RESTful API & Microservices)

Hệ thống được tổ chức theo kiến trúc **Microservices thu nhỏ (Hybrid Microservice)**:
- Dịch vụ **Web Core (PHP)** lắng nghe tại cổng `8000`.
- Dịch vụ **Rust High-Performance Engine** vận hành độc lập như một daemon tại cổng `5000`.
- Hai dịch vụ trao đổi thông tin với nhau thông qua chuẩn giao thức **RESTful API** với định dạng gói tin chuẩn **JSON (JavaScript Object Notation)** qua giao thức HTTP/1.1.
- Để đảm bảo hệ thống không bị "treo" (blocking) nếu dịch vụ Rust gặp sự cố, lớp `RustEngineService` trong PHP được thiết lập giá trị thời gian chờ tối đa (timeout) là 1500ms kết hợp thuật toán dự phòng tự động chuyển sang chế độ fallback nội bộ.

## 2.6. Tự động hóa tích hợp và triển khai liên tục (CI/CD với GitHub Actions)

Một trong những hạn chế lớn thường gặp của sinh viên là cấu hình máy tính cá nhân bị yếu, dung lượng ổ cứng hạn chế, gây khó khăn lớn khi phải cài đặt các chuỗi công cụ biên dịch nặng (Rust Toolchain, LLVM, Cargo) và chạy các bài kiểm thử tự động.

Để giải quyết triệt để rào cản này, đồ án đã ứng dụng triết lý DevOps hiện đại bằng cách thiết lập **Luồng tự động hóa CI/CD (Continuous Integration / Continuous Deployment)** thông qua nền tảng đám mây **GitHub Actions**:
- Mỗi khi mã nguồn được commit và push lên kho lưu trữ GitHub, máy chủ đám mây của GitHub (với cấu hình tiêu chuẩn cao) sẽ tự động kích hoạt:
  1. Khởi tạo môi trường kiểm thử PHP 8.3, kiểm tra cú pháp toàn bộ tệp tin (`php -l`), nạp cơ sở dữ liệu thử nghiệm và chạy bộ Unit Test.
  2. Khởi tạo chuỗi công cụ Rust Toolchain, kiểm tra lỗi mã (`cargo check`), chạy kiểm thử đơn vị (`cargo test`).
  3. Thực hiện biên dịch chéo đa nền tảng (Cross-platform Release Build) để xuất bản trực tiếp các file thực thi đã được tối ưu hóa: `rust_engine.exe` (cho môi trường máy tính Windows của trường học) và `rust_engine` (cho môi trường máy chủ Linux).
  4. Đóng gói và lưu trữ Artifacts giúp nhóm phát triển hoặc người chấm đồ án chỉ cần tải về và chạy ngay lập tức mà không phải tốn thời gian biên dịch tại chỗ.

## 2.7. Cơ sở lý thuyết các thuật toán thông minh trong TMĐT

### 2.7.1. Thuật toán gợi ý Cosine Similarity trên không gian vector đặc trưng
Để gợi ý các thiết bị điện tử có cấu hình và phân khúc tương đồng cho khách hàng, hệ thống áp dụng kỹ thuật lọc dựa trên nội dung (Content-Based Filtering) bằng độ đo tương đồng Cosine giữa hai vector đặc trưng của sản phẩm:

$$\text{Cosine Similarity}(A, B) = \cos(\theta) = \frac{A \cdot B}{\|A\| \|B\|} = \frac{\sum_{i=1}^{n} A_i B_i}{\sqrt{\sum_{i=1}^{n} A_i^2} \sqrt{\sum_{i=1}^{n} B_i^2}}$$

Trong đó:
- Vector đặc trưng của thiết bị $A$ và $B$ được xây dựng từ:
  - Trọng số danh mục sản phẩm (Category Weight = 2.5)
  - Trọng số thương hiệu sản xuất (Brand Weight = 2.0)
  - Phân khúc giá chuẩn hóa theo hàm logarit cơ số 10: $Tier = \min(6.0, \max(1.0, \log_{10}(Price) / 1.5))$
  - Các thuộc tính thông số kỹ thuật (CPU, RAM, GPU, tấm nền màn hình).
- Giá trị tương đồng nằm trong khoảng $[0, 1]$. Giá trị càng tiến gần tới $1.0$ thể hiện hai thiết bị có cấu hình và phân khúc càng tương đồng nhau.

### 2.7.2. Thuật toán tìm kiếm xấp xỉ chuỗi (Fuzzy Search kết hợp Levenshtein Distance và Token Matching)
Người tiêu dùng khi tìm kiếm thiết bị điện tử thường gõ sai chính tả hoặc gõ tắt (ví dụ: gõ "iphne", "macbok", "smasung"). Hệ thống áp dụng thuật toán tìm kiếm mờ (Fuzzy Search) đa tầng kết hợp:
1. **Đối sánh cụm từ chính xác (Exact phrase matching):** Ưu tiên cao nhất khi cụm từ người dùng khớp trọn vẹn với tên hoặc mã SKU của thiết bị.
2. **Đối sánh từ tố (Token Matching & Overlap):** Chuỗi truy vấn và tên thiết bị được chuẩn hóa (chuyển chữ thường, loại bỏ ký tự đặc biệt) và phân tách thành các token. Hệ thống tính tỷ lệ giao thoa giữa các tập token để nhận diện sản phẩm dù thứ tự các từ có bị đảo lộn.
3. **Kiểm tra chuỗi con (Substring Containment):** Xác định sự xuất hiện của các token truy vấn trong tên hoặc mô tả ngắn của thiết bị.
4. **Khoảng cách chỉnh sửa Levenshtein (Levenshtein Distance):** Đối với các từ khóa bị gõ sai ký tự, hệ thống tính toán số phép biến đổi tối thiểu (thêm, xóa, thay thế một ký tự) để biến chuỗi $s_1$ thành chuỗi $s_2$:

$$\operatorname{lev}(s_1, s_2) = \begin{cases} 
|s_1| & \text{nếu } |s_2| = 0, \\
|s_2| & \text{nếu } |s_1| = 0, \\
\operatorname{lev}(\operatorname{tail}(s_1), \operatorname{tail}(s_2)) & \text{nếu } s_1[0] = s_2[0], \\
1 + \min \begin{cases} 
\operatorname{lev}(\operatorname{tail}(s_1), s_2) \\
\operatorname{lev}(s_1, \operatorname{tail}(s_2)) \\
\operatorname{lev}(\operatorname{tail}(s_1), \operatorname{tail}(s_2))
\end{cases} & \text{trường hợp khác.}
\end{cases}$$

Điểm tương thích tổng hợp (`match_score`) được tính toán dựa trên trọng số tích hợp giữa độ trùng khớp token và khoảng cách Levenshtein, cho phép sắp xếp danh sách kết quả trả về với độ chính xác cao và độ trễ phản hồi thấp.

### 2.7.3. Thuật toán hồi quy tuyến tính (Linear Regression) dự báo xu hướng doanh thu
Tại Dashboard quản trị, để hỗ trợ chủ cửa hàng dự đoán quy mô doanh số trong những ngày tiếp theo dựa trên chuỗi dữ liệu lịch sử các đơn hàng thành công, hệ thống áp dụng mô hình Hồi quy tuyến tính đơn biến:

$$\hat{y} = \beta_0 + \beta_1 x$$

Với các hệ số góc ($\beta_1$) và hệ số chặn ($\beta_0$) được tính bằng phương pháp bình phương bé nhất (Ordinary Least Squares - OLS):

$$\beta_1 = \frac{\sum_{i=1}^{n} (x_i - \bar{x})(y_i - \bar{y})}{\sum_{i=1}^{n} (x_i - \bar{x})^2}, \quad \beta_0 = \bar{y} - \beta_1 \bar{x}$$

### 2.7.4. Phương pháp phân tích tồn kho ABC (Nguyên lý Pareto 80/20)
Quản trị kho thiết bị điện tử đòi hỏi sự phân bổ dòng vốn hợp lý do các thiết bị flagship (như MacBook Pro M3, iPhone 16 Pro Max, RTX 4070) có giá trị vốn rất lớn. Hệ thống áp dụng thuật toán phân loại ABC:
- **Nhóm A (Sản phẩm cốt lõi):** Chiếm khoảng 15-20% số lượng mẫu mã nhưng đóng góp từ 70-80% tổng giá trị doanh số của cửa hàng.
- **Nhóm B (Sản phẩm phụ trợ):** Chiếm khoảng 30% số lượng mẫu mã và đóng góp 15-20% tổng giá trị.
- **Nhóm C (Sản phẩm phổ thông / Phụ kiện):** Chiếm khoảng 50% số lượng mẫu mã nhưng chỉ đóng góp dưới 10% tổng giá trị doanh thu.

---

# CHƯƠNG 3: PHÂN TÍCH VÀ THIẾT KẾ HỆ THỐNG

## 3.1. Khảo sát hiện trạng nghiệp vụ bán lẻ thiết bị điện tử

Qua khảo sát thực tế tại các cửa hàng kinh doanh máy tính và thiết bị di động quy mô vừa và nhỏ, quy trình quản lý thủ công bộc lộ nhiều điểm nghẽn nghiêm trọng:
- **Dữ liệu cấu hình phân tán:** Các thông số kỹ thuật (RAM, SSD, Card màn hình) thường được ghi chép trong file Excel hoặc sổ tay, dẫn đến tình trạng nhân viên tư vấn sai thông số cho khách hàng.
- **Xung đột tồn kho:** Khi khách hàng đặt mua online nhưng hệ thống không có cơ chế khóa giao dịch hoặc trừ tồn kho tự động theo thời gian thực, dễ dẫn đến tình trạng bán trùng một sản phẩm đã hết hàng.
- **Khó khăn trong tra cứu và đối soát thanh toán:** Khách hàng chuyển khoản ngân hàng phải chụp ảnh màn hình biên lai gửi qua mạng xã hội để nhân viên tra cứu thủ công, tốn nhiều thời gian và tiềm ẩn rủi ro làm giả biên lai.
- **Thiếu công cụ phân tích tự động:** Người quản lý không nắm bắt được sản phẩm nào thuộc nhóm chủ lực đem lại dòng tiền cao nhất để kịp thời nhập hàng bổ sung.

Hệ thống đề xuất giải quyết toàn bộ các vướng mắc trên thông qua nền tảng web tập trung kết hợp các thuật toán tự động hóa thông minh.

## 3.2. Phân tích yêu cầu hệ thống

### 3.2.1. Các tác nhân tham gia hệ thống
1. **Khách vãng lai (Guest):** Người dùng truy cập website nhưng chưa đăng nhập. Có quyền xem danh sách sản phẩm, sử dụng thanh tìm kiếm thông minh, lọc thiết bị theo thông số/giá cả, xem chi tiết, thêm hàng vào giỏ và đăng ký tài khoản.
2. **Khách hàng (Customer):** Người dùng đã xác thực tài khoản. Có đầy đủ quyền của khách vãng lai, đồng thời có quyền quản lý thông tin cá nhân, thực hiện đặt hàng, áp mã giảm giá, xem mã thanh toán VietQR, theo dõi lịch sử đơn hàng và gửi đánh giá nhận xét.
3. **Quản trị viên (Admin):** Người điều hành hệ thống. Có toàn quyền quản lý kho hàng (thêm, sửa, xóa sản phẩm, cấu hình thông số kỹ thuật), quản trị đơn hàng (chuyển trạng thái xử lý, xác nhận thanh toán), quản trị danh mục/thương hiệu, quản trị tài khoản người dùng và xem báo cáo tài chính trên Dashboard.

### 3.2.2. Bảng đặc tả yêu cầu chức năng (F01 - F16)

| Mã | Tên chức năng | Tác nhân | Mô tả chi tiết |
|---|---|---|---|
| **F01** | Đăng ký tài khoản | Guest | Khách nhập họ tên, email, mật khẩu, số điện thoại; hệ thống kiểm tra định dạng và băm mật khẩu bằng Bcrypt. |
| **F02** | Đăng nhập / Đăng xuất | Guest, Customer, Admin | Xác thực thông tin qua session bảo mật, tự động chuyển hướng đúng vai trò. |
| **F03** | Duyệt danh mục thiết bị | Guest, Customer | Hiển thị sản phẩm theo danh mục: Điện thoại, Laptop, Tablet, Âm thanh, Smartwatch, Phụ kiện. |
| **F04** | Tìm kiếm thông minh | Guest, Customer | Tìm kiếm từ khóa theo tên, mô tả, thông số phần cứng với tốc độ cao dưới 1ms qua Rust Engine. |
| **F05** | Bộ lọc đa tiêu chí | Guest, Customer | Lọc kết hợp theo danh mục, thương hiệu, khoảng giá min-max và sắp xếp linh hoạt. |
| **F06** | Xem chi tiết sản phẩm | Guest, Customer | Hiển thị thông số phần cứng chi tiết (CPU, RAM, GPU, Screen...), tình trạng tồn kho, chính sách bảo hành. |
| **F07** | Gợi ý thiết bị tương đồng | Guest, Customer | Hiển thị các sản phẩm cùng phân khúc và đặc tính kỹ thuật qua thuật toán Cosine Similarity của Rust. |
| **F08** | Quản lý giỏ hàng | Guest, Customer | Thêm sản phẩm, điều chỉnh số lượng tức thì qua AJAX, kiểm tra ràng buộc không vượt quá tồn kho thực tế. |
| **F09** | Áp dụng mã giảm giá | Customer, Guest | Nhập mã coupon (giảm theo % hoặc số tiền cố định), kiểm tra giá trị đơn hàng tối thiểu và chiết khấu ngay. |
| **F10** | Đặt hàng & Thanh toán | Customer, Guest | Nhập thông tin nhận hàng, chọn phương thức COD hoặc Chuyển khoản VietQR, thực thi giao dịch cơ sở dữ liệu an toàn. |
| **F11** | Tạo mã VietQR động | Customer, Guest | Tự động tạo ảnh mã QR ngân hàng chuẩn NAPAS 247 có nhúng sẵn số tiền chính xác và mã đơn hàng. |
| **F12** | Đánh giá & Nhận xét | Customer | Gửi đánh giá số sao (1-5 sao) và nhận xét trải nghiệm sau khi trải nghiệm sản phẩm. |
| **F13** | Theo dõi đơn hàng | Customer, Admin | Tra cứu hành trình đơn hàng qua timeline trực quan (Đã đặt, Đang đóng gói, Đang giao, Hoàn thành). |
| **F14** | Quản trị thiết bị (CRUD) | Admin | Thêm mới, chỉnh sửa thông số kỹ thuật, cập nhật giá bán, số lượng tồn kho và xóa sản phẩm. |
| **F15** | Quản trị đơn hàng | Admin | Xem danh sách đơn, xem chi tiết hàng hóa, cập nhật trạng thái đơn hàng và trạng thái thanh toán. |
| **F16** | Dashboard & Báo cáo ABC | Admin | Xem tổng doanh thu, dự báo doanh thu ngày tiếp theo qua Hồi quy tuyến tính, phân tích tồn kho Pareto ABC. |

### 3.2.3. Bảng đặc tả yêu cầu phi chức năng (NF01 - NF08)

| Mã | Nhóm yêu cầu | Nội dung tiêu chuẩn |
|---|---|---|
| **NF01** | **Hiệu năng & Độ trễ** | Thời gian phản hồi các tác vụ tính toán tìm kiếm và gợi ý của Rust Engine đạt mức thấp dưới vài mili-giây; thời gian tải trang trung bình dưới 500ms. |
| **NF02** | **An toàn & Bảo mật** | Mật khẩu được mã hóa băm một chiều qua Bcrypt; phòng vệ trước SQL Injection nhờ Prepared Statements và tắt giả lập câu lệnh PDO; bảo vệ chống XSS bằng `htmlspecialchars()`; trang bị lớp bảo vệ chống tấn công CSRF cho tất cả biểu mẫu POST và chống Session Fixation bằng `session_regenerate_id(true)`. |
| **NF03** | **Toàn vẹn dữ liệu** | Sử dụng Database Transactions (ACID) khi tạo đơn hàng, đảm bảo việc trừ tồn kho và tạo chi tiết đơn hàng diễn ra đồng thời, tự động rollback nếu có sự cố. |
| **NF04** | **Tính sẵn sàng cao** | Áp dụng cơ chế Graceful Fallback: nếu dịch vụ Rust tạm dừng, hệ thống PHP tự kích hoạt module tính toán dự phòng nội bộ, không làm gián đoạn người dùng. |
| **NF05** | **Tính di động (Portability)** | Hỗ trợ Dual Database Driver: chạy trên MySQL hoặc SQLite nhúng độc lập, tương thích trên cả môi trường Windows và Linux. |
| **NF06** | **Khả năng tương thích** | Giao diện chuẩn Responsive Web Design, hiển thị hoàn hảo trên các trình duyệt hiện đại (Chrome, Edge, Firefox, Safari) và mọi kích thước màn hình từ 360px đến 4K. |
| **NF07** | **Tự động hóa CI/CD** | Mọi thay đổi mã nguồn được kiểm thử cú pháp và biên dịch chéo tự động thông qua GitHub Actions trên đám mây. |
| **NF08** | **Khả năng bảo trì** | Mã nguồn phân lớp rõ ràng theo mô hình MVC, tách biệt tầng giao dịch và dịch vụ tính toán, tuân thủ nguyên tắc Clean Code. |

## 3.3. Mô hình hóa hệ thống bằng ngôn ngữ UML

### 3.3.1. Biểu đồ Use Case tổng quát
Biểu đồ Use Case phân định rõ ranh giới tương tác giữa người dùng và hệ thống:
- **Tác nhân Khách vãng lai:** Thực hiện các Use Case tra cứu sản phẩm, tìm kiếm, lọc thiết bị, quản lý giỏ hàng tạm thời và đăng ký tài khoản.
- **Tác nhân Khách hàng:** Kế thừa quyền từ khách vãng lai, đồng thời thực hiện các Use Case thanh toán giỏ hàng, áp mã giảm giá, theo dõi trạng thái đơn hàng và gửi đánh giá sản phẩm.
- **Tác nhân Quản trị viên:** Thực hiện các Use Case quản trị kho hàng, cấu hình thiết bị, xử lý đơn hàng, quản lý tài khoản người dùng và xem Dashboard phân tích hiệu năng.

### 3.3.2. Biểu đồ hoạt động (Activity Diagram) quy trình đặt hàng
Luồng hoạt động quy trình đặt hàng:
1. Khách hàng lựa chọn sản phẩm từ danh mục hoặc kết quả tìm kiếm.
2. Khách hàng nhấn "Thêm vào giỏ hàng" (kiểm tra tồn kho qua AJAX).
3. Khách hàng chuyển sang trang Giỏ hàng, nhập mã giảm giá (nếu có).
4. Khách hàng nhấn "Tiến hành thanh toán", nhập thông tin người nhận và địa chỉ.
5. Khách hàng lựa chọn phương thức thanh toán (COD hoặc Chuyển khoản VietQR).
6. Hệ thống bắt đầu Transaction cơ sở dữ liệu:
   - Kiểm tra lại tồn kho của từng sản phẩm trong giỏ hàng.
   - Nếu một sản phẩm không đủ tồn kho $\rightarrow$ Hủy giao dịch (Rollback), thông báo lỗi cho khách hàng.
   - Nếu tất cả đủ hàng $\rightarrow$ Khởi tạo bản ghi `orders`, thêm các bản ghi `order_items`, trừ tồn kho `products.stock`, tăng số lượng đã bán `products.sales_count`, xóa giỏ hàng $\rightarrow$ Xác nhận giao dịch (Commit).
7. Hệ thống chuyển hướng sang trang Hoàn tất đơn hàng (hiển thị mã VietQR nếu là chuyển khoản ngân hàng).

### 3.3.3. Biểu đồ lớp (Class Diagram)
Hệ thống gồm các lớp chính:
- `Database`: Quản lý kết nối PDO Singleton với cơ chế tự động chuyển đổi MySQL/SQLite.
- `Product`: Quản lý thông tin thiết bị, cấu hình thông số kỹ thuật (specs), tồn kho và lọc dữ liệu.
- `Category` & `Brand`: Đại diện cho danh mục ngành hàng và các thương hiệu sản xuất công nghệ.
- `Cart`: Quản lý danh sách thiết bị đang chọn mua, tính tổng phụ và áp dụng chiết khấu coupon.
- `Order`: Thực thi các giao dịch đặt hàng nguyên tử và tra cứu lịch sử mua sắm.
- `User`: Quản lý hồ sơ người dùng, xác thực đăng nhập và phân quyền (Customer / Admin).
- `RustEngineService`: Cung cấp các phương thức giao tiếp mạng qua HTTP REST API tới Rust Microservice và điều phối logic fallback nội bộ.

### 3.3.4. Biểu đồ tuần tự (Sequence Diagram) xử lý đơn hàng & gọi Rust Engine
Biểu đồ mô tả sự phối hợp giữa Client (Trình duyệt), PHP Controller, Rust Engine Service và Database:
1. Client gửi yêu cầu tìm kiếm `GET /products?q=MacBook` đến `ProductController`.
2. `ProductController` gọi `RustEngineService->search($products, $query)`.
3. `RustEngineService` gửi yêu cầu HTTP POST đến `http://127.0.0.1:5000/api/search`.
4. Rust Engine xử lý tính toán native trên bộ nhớ, tính điểm Levenshtein và đối sánh token, trả về danh sách sản phẩm kèm điểm số tương thích `match_score` với độ trễ phản hồi thấp.
5. PHP Controller tiếp nhận kết quả JSON, render dữ liệu ra View và phản hồi về Client.

## 3.4. Thiết kế kiến trúc tổng thể Hybrid Microservices

Hệ thống được thiết kế theo mô hình kiến trúc phân tán hai dịch vụ (Two-tier Hybrid Services Architecture):

```
+--------------------------------------------------------------------------+
|                        TRÌNH DUYỆT NGƯỜI DÙNG                            |
|             (HTML5, CSS3, Bootstrap 5.3, JavaScript ES6+)                |
+-----------------------------------+--------------------------------------+
                                    |
                           HTTP Requests (8000)
                                    |
                                    v
+--------------------------------------------------------------------------+
|             CORE WEB APPLICATION (PHP 8.x - MVC PATTERN)                 |
|                                                                          |
|  +-------------------+  +---------------------+  +--------------------+  |
|  |    Controllers    |  |       Models        |  |       Views        |  |
|  | - HomeController  |  | - Product, Category |  | - Home, Catalog    |  |
|  | - ProductControl. |  | - Cart, Order       |  | - Cart, Checkout   |  |
|  | - CartController  |  | - User, Database    |  | - Admin Dashboard  |  |
|  +---------+---------+  +----------+----------+  +--------------------+  |
|            |                       |                                     |
|            |                       +------------------+                  |
|            v                                          |                  |
|  +---------------------------------------+            |                  |
|  |           SERVICE LAYER               |            |                  |
|  |  - RustEngineService (HTTP Client)    |            |                  |
|  |  - SearchService, RecommenderService  |            |                  |
|  |  - AnalyticsService (Fallback Engine) |            |                  |
|  +-------------------+-------------------+            |                  |
+----------------------|--------------------------------|------------------+
                       |                                |
        REST API (HTTP/JSON - 5000)           SQL Queries (PDO)
                       |                                |
                       v                                v
+-----------------------------------------+  +-----------------------------+
|    RUST HIGH-PERFORMANCE ENGINE         |  |      DATABASE ENGINE        |
|                                         |  |                             |
|  - Fuzzy Search (Levenshtein + Token)   |  |  [Primary] MySQL 8.0        |
|  - Recommender (Cosine Similarity)      |  |              hoặc           |
|  - Business Analytics (ABC + Lin. Reg.) |  |  [Portable] SQLite 3        |
|  - Batch Image Processor Worker         |  |                             |
+-----------------------------------------+  +-----------------------------+
```

## 3.5. Thiết kế cơ sở dữ liệu quan hệ (ERD & Danh mục bảng)

Cơ sở dữ liệu bao gồm 11 bảng chuẩn hóa:

1. **`users` (Tài khoản người dùng):** Lưu trữ định danh `id`, `name`, `email` (Unique), `password_hash` (Bcrypt), `phone`, `address`, `role` ('customer', 'admin'), `created_at`.
2. **`categories` (Danh mục ngành hàng):** `id`, `name`, `slug`, `icon`, `description`.
3. **`brands` (Thương hiệu sản xuất):** `id`, `name`, `slug`, `logo`.
4. **`products` (Thiết bị điện tử):** `id`, `category_id`, `brand_id`, `name`, `slug`, `sku` (Unique), `price`, `original_price`, `stock`, `featured`, `status`, `thumbnail`, `short_description`, `description`, `specs` (Lưu trữ JSON các thông số phần cứng), `rating`, `review_count`, `sales_count`.
5. **`carts` & `cart_items` (Giỏ hàng):** Thiết kế lược đồ hỗ trợ lưu trữ trạng thái giỏ hàng theo phiên hoặc người dùng. Trong phiên bản hiện tại, nhằm tối ưu hóa độ trễ I/O cơ sở dữ liệu và tăng tốc độ phản hồi cho các thao tác thêm/sửa giỏ hàng, hệ thống lưu trữ giỏ hàng trong PHP Session (`$_SESSION['cart']`); hai bảng này được định nghĩa sẵn trong cấu trúc CSDL nhằm phục vụ khả năng mở rộng lưu trữ giỏ hàng đồng bộ đa thiết bị (Persistent Multi-Device Cart) trong tương lai.
6. **`orders` (Đơn hàng):** `id`, `user_id`, `order_code` (Mã đơn duy nhất), `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `payment_method` ('cod', 'bank_transfer'), `payment_status` ('pending', 'paid'), `order_status` ('pending', 'processing', 'shipping', 'completed', 'cancelled'), `total_amount`, `discount_amount`, `final_amount`, `notes`, `created_at`.
7. **`order_items` (Chi tiết đơn hàng):** `id`, `order_id`, `product_id`, `product_name`, `product_sku`, `unit_price`, `quantity`, `subtotal`. Đơn giá được lưu tĩnh tại thời điểm mua nhằm đảm bảo tính toàn vẹn của lịch sử kế toán.
8. **`coupons` (Mã khuyến mãi):** `id`, `code`, `discount_type` ('fixed', 'percent'), `discount_value`, `min_order_value`, `expires_at`, `status`.
9. **`reviews` (Đánh giá người dùng):** `id`, `product_id`, `user_id`, `user_name`, `rating`, `comment`, `created_at`.
10. **`system_logs` (Nhật ký hệ thống):** Lưu vết hiệu năng và lịch sử gọi dịch vụ.

## 3.6. Thiết kế giao diện người dùng (UI/UX Design System)

Giao diện được thiết kế theo phong cách công nghệ cao hiện đại (Modern Tech Store Aesthetic):
- **Bảng màu chủ đạo:** Màu xanh đen công nghệ (`#0b1329`), màu xanh điểm nhấn công nghệ (`#2563eb`), màu cam hiệu năng cao của Rust (`#f97316`) và nền sáng sạch sẽ (`#f8fafc`).
- **Thẻ sản phẩm (Tech Card):** Bố cục trực quan hiển thị nổi bật hình ảnh, tỷ lệ giảm giá, tên thiết bị, các huy hiệu thông số cốt lõi (CPU, RAM, màn hình), giá bán niêm yết và nút thêm nhanh vào giỏ hàng.
- **Thanh tìm kiếm toàn cục:** Tích hợp ô gợi ý trực tiếp (Live Dropdown) hiển thị ngay độ trễ xử lý của Rust Engine tính bằng mili-giây.

---

# CHƯƠNG 4: TRIỂN KHAI VÀ KIỂM THỬ HỆ THỐNG

## 4.1. Môi trường triển khai và vận hành

| Thành phần | Công nghệ / Phiên bản | Mục đích sử dụng |
|---|---|---|
| **Hệ điều hành** | Windows 10/11 hoặc Linux Ubuntu 22.04 | Môi trường phát triển và máy chấm thi tại trường |
| **Web Server** | PHP Built-in Web Server / Apache 2.4 | Tiếp nhận HTTP Request trên cổng 8000 |
| **Ngôn ngữ Web** | PHP 8.2 / 8.3 | Xử lý logic MVC, quản lý phiên và điều phối dữ liệu |
| **Ngôn ngữ Engine** | Rust 1.80+ (Toolchain 2021 edition) | Biên dịch dịch vụ tính toán hiệu năng cao độc lập |
| **Cơ sở dữ liệu** | MySQL 8.0 & SQLite 3 Portable | Lưu trữ dữ liệu quan hệ với cơ chế chuyển đổi thông minh |
| **CI/CD Platform** | GitHub Actions Cloud Runners | Tự động hóa build, test và cross-compile release |
| **Thư viện Giao diện**| Bootstrap 5.3.3 & Bootstrap Icons | Xây dựng giao diện responsive tương thích mọi thiết bị |

## 4.2. Quy trình cài đặt và cấu hình hệ thống

### 4.2.1. Cấu hình cơ sở dữ liệu linh hoạt (Dual Database)
Người dùng có thể khởi chạy hệ thống chỉ với 1 bước đơn giản thông qua file kịch bản tự động `start.bat` (trên Windows) hoặc `start.sh` (trên Linux/macOS):
```bash
# Khởi chạy trên Windows
start.bat

# Hoặc khởi chạy thủ công qua lệnh PHP
php database/migrate.php --driver=sqlite
php -S localhost:8000 -t public
```

### 4.2.2. Xây dựng luồng CI/CD GitHub Actions kiểm thử và biên dịch đa nền tảng
Quy trình CI/CD được định nghĩa trong `.github/workflows/ci.yml`:
1. **Job `test-php`:** Kiểm tra toàn bộ cú pháp file PHP, nạp cơ sở dữ liệu và chạy bộ kiểm thử `tests/run_tests.php`.
2. **Job `build-rust`:** Chạy đồng thời trên máy ảo Windows (`windows-latest`) và Linux (`ubuntu-latest`), tự động chạy `cargo test` và biên dịch tối ưu hóa `cargo build --release`, xuất bản file thực thi sẵn sàng tải xuống.

## 4.3. Mô tả chi tiết các chức năng đã hoàn thiện

### 4.3.1. Phân hệ khách hàng
- **Trang chủ:** Hiển thị banner công nghệ, lưới danh mục nhanh, danh sách thiết bị nổi bật và khu vực "Gợi ý thông minh dành cho bạn" được tính toán tức thì bởi Rust Engine.
- **Trang danh mục & Tìm kiếm:** Tích hợp bộ lọc đa chiều (danh mục, hãng, khoảng giá) và thanh tìm kiếm từ khóa với thời gian phản hồi cực nhanh.
- **Trang chi tiết sản phẩm:** Bảng thông số kỹ thuật chi tiết theo từng linh kiện (CPU, RAM, GPU, Màn hình, Pin), ảnh sản phẩm, kiểm tra số lượng tồn kho theo thời gian thực và danh sách sản phẩm tương đồng đề xuất.
- **Giỏ hàng & Thanh toán:** Thêm/sửa/xóa sản phẩm bằng AJAX, áp dụng mã khuyến mãi (`WELCOME2026`, `TECHSALE10`), lựa chọn thanh toán COD hoặc hiển thị mã VietQR động để quét chuyển khoản tự động.
- **Lịch sử đơn hàng:** Khách hàng theo dõi chi tiết các đơn đã đặt và tiến độ giao hàng qua timeline 4 bước trực quan.

### 4.3.2. Phân hệ quản trị (Admin)
- **Dashboard quản trị:** Hiển thị tức thời trạng thái kết nối tới Rust Engine, độ trễ xử lý (ms), tổng doanh thu thực tế, dự báo doanh thu ngày tiếp theo qua mô hình Hồi quy tuyến tính, bảng phân tích tồn kho Pareto ABC và danh sách đơn hàng mới nhất.
- **Quản lý sản phẩm:** Thêm thiết bị mới với biểu mẫu thông số kỹ thuật hoàn chỉnh, cập nhật giá bán, số lượng tồn kho và xóa sản phẩm.
- **Quản lý đơn hàng:** Xem chi tiết người nhận, danh sách thiết bị đặt mua và cập nhật trạng thái đơn (Chờ xử lý $\rightarrow$ Đang đóng gói $\rightarrow$ Đang giao $\rightarrow$ Hoàn thành $\rightarrow$ Hủy đơn).

### 4.3.3. Rust Microservice Engine
Dịch vụ Rust vận hành độc lập, cung cấp 5 endpoints RESTful API chuẩn hóa:
1. `GET /api/health`: Trả về trạng thái hoạt động, số luồng xử lý và thời gian hoạt động liên tục (uptime).
2. `POST /api/search`: Tiếp nhận danh sách sản phẩm và từ khóa, trả về danh sách đã chấm điểm độ phù hợp theo khoảng cách Levenshtein.
3. `POST /api/recommendations`: Nhận mã sản phẩm mục tiêu, trích xuất vector đặc trưng và tính toán độ tương đồng Cosine để trả về top 4 thiết bị tương đồng nhất.
4. `POST /api/analytics`: Phân tích chuỗi thời gian doanh thu bằng Hồi quy tuyến tính và phân loại tồn kho ABC theo nguyên lý Pareto.
5. `POST /api/image/batch-process`: Xử lý tính toán thông số nén ảnh và chuyển đổi định dạng hàng loạt.

## 4.4. Kiểm thử hệ thống (Kế hoạch kiểm thử & Ma trận 20 Test Cases)

Để đảm bảo chất lượng phần mềm và độ tin cậy của toàn bộ các luồng nghiệp vụ, đồ án áp dụng chiến lược kiểm thử đa tầng kết hợp giữa kiểm thử tự động hóa mã nguồn và kiểm thử chấp nhận chức năng tổng thể:

1. **Bộ kiểm thử tự động hóa mã nguồn (Automated Test Suite):** Hệ thống xây dựng 20 ca kiểm thử đơn vị và tích hợp tự động (`tests/run_tests.php`) chạy độc lập qua CLI và được tích hợp trong pipeline GitHub Actions CI/CD. Bộ kiểm thử bao gồm 5 nhóm kiểm thử chuyên biệt:
   - `CartTest.php` (5 test cases): Kiểm thử toàn diện logic giỏ hàng (thêm sản phẩm, cập nhật số lượng, xóa khỏi giỏ, áp dụng mã giảm giá hợp lệ, từ chối mã giảm giá hết hạn hoặc đã đạt giới hạn sử dụng `used_count >= usage_limit`).
   - `OrderTest.php` (4 test cases): Kiểm thử tính toàn vẹn của giao dịch đặt hàng (transaction tạo đơn thành công, trừ tồn kho an toàn `WHERE stock >= ?`, tự động rollback bảo toàn dữ liệu khi tồn kho không đủ, chuyển đổi trạng thái đơn hàng).
   - `ProductTest.php` (5 test cases): Kiểm thử truy vấn và phân quyền đánh giá (lấy danh sách phân trang, lọc theo danh mục & thương hiệu, lọc theo khoảng giá, xác thực tồn kho, kiểm tra điều kiện chỉ khách hàng đã hoàn thành mua hàng mới được phép gửi đánh giá `hasPurchased`).
   - `AuthTest.php` (3 test cases): Kiểm thử xác thực và an toàn mật khẩu (băm mật khẩu bằng Bcrypt `password_hash`, xác thực đăng nhập thành công với thông tin chính xác, từ chối đăng nhập khi sai mật khẩu).
   - `RustEngineClientTest.php` (3 test cases): Kiểm thử tính sẵn sàng và khả năng chịu lỗi (kiểm tra trạng thái kết nối `isAvailable`, tự động chuyển mạch sang tìm kiếm dự phòng khi Rust Engine ngoại tuyến, chuyển mạch sang gợi ý tương đồng dự phòng khi Rust Engine ngoại tuyến).

2. **Ma trận kiểm thử chức năng tổng thể (End-to-End Acceptance Test Matrix):** Kiểm thử luồng tương tác thực tế của người dùng trên giao diện và đối soát dữ liệu với cơ sở dữ liệu:

| Mã TC | Phân hệ | Tình huống kiểm thử | Dữ liệu đầu vào | Kết quả kỳ vọng | Kết quả thực tế |
|---|---|---|---|---|---|
| **TC01** | Xác thực | Đăng ký tài khoản mới hợp lệ | Nhập đầy đủ họ tên, email mới, mật khẩu | Tạo tài khoản thành công, mật khẩu được băm Bcrypt | **Đạt** |
| **TC02** | Xác thực | Đăng ký với email đã tồn tại | Nhập email trùng với tài khoản sẵn có | Báo lỗi email đã được sử dụng, từ chối tạo trùng | **Đạt** |
| **TC03** | Xác thực | Đăng nhập tài khoản đúng | Email và mật khẩu chính xác | Đăng nhập thành công, tạo session mới chống fixation | **Đạt** |
| **TC04** | Xác thực | Đăng nhập sai mật khẩu | Nhập sai mật khẩu | Báo lỗi thông tin đăng nhập không hợp lệ | **Đạt** |
| **TC05** | Tìm kiếm | Tìm kiếm tên thiết bị chính xác | Từ khóa "iPhone 16" | Trả về sản phẩm iPhone 16 với điểm tương thích cao nhất | **Đạt** |
| **TC06** | Tìm kiếm | Tìm kiếm sai chính tả (Fuzzy) | Từ khóa "iphne pro" | Rust Engine tự động sửa lỗi và trả về iPhone Pro | **Đạt** |
| **TC07** | Tìm kiếm | Tìm kiếm theo thông số phần cứng | Từ khóa "RTX 4070" | Trả về Laptop Gaming ASUS ROG Zephyrus G16 | **Đạt** |
| **TC08** | Lọc dữ liệu| Lọc sản phẩm theo thương hiệu | Chọn hãng "Apple" | Chỉ hiển thị các thiết bị do Apple sản xuất | **Đạt** |
| **TC09** | Lọc dữ liệu| Lọc theo khoảng giá | Nhập giá từ 20.000.000 đến 35.000.000 | Chỉ hiển thị các thiết bị nằm trong khoảng giá | **Đạt** |
| **TC10** | Giỏ hàng | Thêm sản phẩm vào giỏ hàng | Sản phẩm còn tồn kho, kèm CSRF token | Sản phẩm xuất hiện trong giỏ, cập nhật số lượng badge | **Đạt** |
| **TC11** | Giỏ hàng | Thêm sản phẩm vượt quá tồn kho | Nhập số lượng 99999 | Từ chối thêm, hiển thị thông báo vượt tồn kho | **Đạt** |
| **TC12** | Giỏ hàng | Cập nhật số lượng sản phẩm | Tăng/giảm số lượng trong giỏ | Thành tiền và tổng phụ tự động cập nhật chính xác | **Đạt** |
| **TC13** | Khuyến mãi | Áp dụng mã giảm giá hợp lệ | Nhập mã "WELCOME2026" cho đơn > 10 triệu | Giảm trực tiếp 500.000đ vào tổng thanh toán | **Đạt** |
| **TC14** | Đặt hàng | Đặt hàng thành công (COD) | Nhập đủ thông tin nhận hàng, chọn COD | Tạo đơn hàng, trừ tồn kho, xóa giỏ hàng | **Đạt** |
| **TC15** | Đặt hàng | Đặt hàng chuyển khoản VietQR | Chọn phương thức Chuyển khoản | Hiển thị mã VietQR động chứa đúng số tiền và mã đơn | **Đạt** |
| **TC16** | Đặt hàng | Rollback đơn khi thiếu hàng | Hai khách hàng cùng mua chiếc máy cuối | Khách thứ hai bị từ chối, không tạo đơn lỗi | **Đạt** |
| **TC17** | Phân quyền | Khách thường truy cập `/admin` | Truy cập đường dẫn quản trị | Chặn truy cập, chuyển hướng về trang đăng nhập | **Đạt** |
| **TC18** | Quản trị | Thêm thiết bị điện tử mới | Nhập tên, giá, hãng, danh mục, specs | Thiết bị xuất hiện ngay trên trang danh mục | **Đạt** |
| **TC19** | Quản trị | Cập nhật trạng thái đơn hàng | Đổi trạng thái sang "shipping" | Cập nhật cơ sở dữ liệu, timeline hiển thị đang giao | **Đạt** |
| **TC20** | Chịu lỗi | Tắt dịch vụ Rust Engine | Gửi yêu cầu tìm kiếm khi Rust offline | Tự động chuyển sang PHP Fallback, kết quả vẫn chính xác | **Đạt** |

*Toàn bộ 20/20 Test Cases chức năng và 20/20 ca kiểm thử tự động hóa đều đạt kết quả mong đợi (100% Pass).*

## 4.5. Đánh giá và so sánh thực nghiệm hiệu năng (Benchmark PHP Fallback vs Rust Engine)

### 4.5.1. Phương pháp luận và kịch bản thực nghiệm
Để đánh giá khách quan và minh bạch sự chênh lệch hiệu năng giữa việc xử lý tính toán cục bộ bằng PHP thuần (PHP Fallback Engine) và việc ủy nhiệm tác vụ cho dịch vụ chuyên biệt (Rust High-Performance Engine), đồ án xây dựng kịch bản đo lường thực nghiệm độc lập thông qua script `scripts/benchmark.php`.

Kịch bản thực nghiệm được thiết kế theo hai cấp độ:
1. **Đo lường thuật toán vi mô (In-Memory Algorithmic Micro-Benchmark):** Đo lường trực tiếp thời gian CPU xử lý các phép toán tổ hợp, ma trận và khoảng cách chuỗi trên cùng một tập dữ liệu đầu vào (từ 50 đến 1.000 bản ghi thông số kỹ thuật thiết bị điện tử) với số lần lặp lại từ 200 đến 500 lần để tính giá trị trung bình.
2. **Phân tích độ trễ luồng yêu cầu Web tổng thể (End-to-End Request Latency Breakdown):** Phân tích chi tiết các thành phần đóng góp vào tổng thời gian phản hồi của một yêu cầu HTTP thực tế đến người dùng.

### 4.5.2. Kết quả đo lường vi mô các thuật toán cốt lõi
Dữ liệu đo lường thực nghiệm từ script `scripts/benchmark.php` cho thấy sự phân hóa rõ rệt về đặc tính tính toán:
- **Thuật toán tìm kiếm xấp xỉ chuỗi (Fuzzy Search - Levenshtein & Token Matching):**
  - *Dịch vụ Rust Engine:* Do được biên dịch trực tiếp ra mã máy nhị phân bản địa (Native Machine Code) và tối ưu hóa cấp độ con trỏ mảng không có chi phí Garbage Collection, Rust hoàn tất việc đối sánh từ khóa và tính khoảng cách sửa đổi Levenshtein cho danh mục sản phẩm trong thời gian dưới mili-giây (~0.5 - 2.0 ms tùy kích thước tập dữ liệu).
  - *PHP Fallback:* PHP xử lý theo mô hình thông dịch kịch bản; việc lặp qua các mảng liên kết lồng nhau và tính toán `levenshtein()` tốn trung bình ~10 - 25 ms.
- **Tính toán ma trận độ tương đồng Cosine (Cosine Similarity Vector Space):**
  - *Dịch vụ Rust Engine:* Các phép nhân vô hướng vector và chuẩn hóa độ dài vector $\vec{A} \cdot \vec{B} / (\|\vec{A}\| \|\vec{B}\|)$ được trình biên dịch `rustc` tự động vector hóa (tận dụng chỉ lệnh SIMD của CPU trong bản build release). Thời gian tìm top 4 sản phẩm tương đồng nhất trong toàn bộ danh mục chỉ mất khoảng ~0.8 - 1.5 ms.
  - *PHP Fallback:* Cần thực hiện các vòng lặp `foreach` trên các mảng thuộc tính đặc trưng, đạt độ trễ ~15 - 30 ms.
- **Phân tích dữ liệu kinh doanh (Hồi quy tuyến tính & Phân loại Pareto ABC):**
  - *Dịch vụ Rust Engine:* Thuật toán sắp xếp O(N log N) để tính tỷ trọng doanh thu tích lũy và công thức bình phương tối thiểu O(N) hoàn tất tức thì trong khoảng ~0.5 - 1.2 ms.
  - *PHP Fallback:* Hoàn tất trong khoảng ~8 - 18 ms.

### 4.5.3. Phân tích phân rã độ trễ yêu cầu Web thực tế (End-to-End Latency Breakdown)
Trong môi trường thực tế của một website thương mại điện tử, tổng thời gian phản hồi (Client Response Time) từ góc nhìn của trình duyệt người dùng được cấu thành từ nhiều giai đoạn:
1. **Truy vấn cơ sở dữ liệu (Database Query Latency - MySQL/SQLite):** ~5 - 15 ms cho việc truy vấn lấy danh sách sản phẩm và thông số kỹ thuật qua PDO Prepared Statements.
2. **Giao tiếp liên tiến trình qua mạng nội bộ (Loopback IPC Overhead):** ~0.5 - 2 ms cho việc đóng gói JSON trong PHP qua `curl`, truyền qua giao diện Loopback `127.0.0.1:5000` và giải tuần tự hóa JSON trong Rust (`serde_json`).
3. **Thời gian tính toán lõi của Rust Engine:** ~0.5 - 2 ms.
4. **Dựng giao diện và xuất mã HTML (PHP View Rendering):** ~3 - 8 ms.

Như vậy, tổng thời gian xử lý một yêu cầu web tìm kiếm hay gợi ý thông minh dao động trong khoảng lý tưởng từ **10 ms đến 30 ms**. Việc đưa Rust vào xử lý tính toán không nhằm triệt tiêu hoàn toàn độ trễ mạng hay độ trễ CSDL, mà giữ vai trò then chốt trong việc:
- Giải phóng tiến trình Web PHP khỏi các vòng lặp tính toán nặng CPU, giúp PHP Web Server duy trì khả năng tiếp nhận các kết nối khác.
- Đảm bảo độ trễ tính toán không bị bùng nổ theo cấp số nhân khi số lượng thuộc tính và sản phẩm tăng lên hàng nghìn bản ghi.
- Giữ mức tiêu thụ bộ nhớ RAM của dịch vụ Rust cực kỳ khiêm tốn (~5 - 10 MB RAM), độc lập hoàn toàn với vòng đời của các tiến trình PHP.

---

# CHƯƠNG 5: ĐÁNH GIÁ, KẾT LUẬN VÀ HƯỚNG PHÁT TRIỂN

## 5.1. Đánh giá kết quả đạt được đối chiếu với mục tiêu ban đầu

Đối chiếu với các mục tiêu đề ra tại Chương 1, đồ án đã hoàn thành đầy đủ các yêu cầu kỹ thuật và nghiệp vụ trọng tâm:

| Mục tiêu đề ra | Mức độ hoàn thành | Kết quả minh chứng thực tế |
|---|---|---|
| Xây dựng website TMĐT thiết bị điện tử | **Hoàn thành tốt** | Đầy đủ giao diện responsive, 6 ngành hàng, giỏ hàng AJAX, checkout VietQR. |
| Kiến trúc Hybrid PHP kết hợp Rust Engine | **Hoàn thành tốt** | Dịch vụ Rust độc lập xử lý tìm kiếm, gợi ý, phân tích; giao tiếp qua REST API. |
| Cơ chế Graceful Fallback dự phòng | **Hoàn thành tốt** | Tự động chuyển sang thuật toán PHP nội bộ khi Rust tắt, không phát sinh lỗi. |
| Khả năng chạy Portable trên máy trường | **Hoàn thành tốt** | Hỗ trợ Dual Database (MySQL + SQLite tự động); kịch bản 1-click `start.bat`. |
| Tự động hóa CI/CD với GitHub Actions | **Hoàn thành tốt** | Pipeline kiểm thử PHP và biên dịch chéo Rust nhị phân cho cả Windows và Linux. |
| Thuật toán thông minh (Cosine, Levenshtein, ABC)| **Hoàn thành tốt** | Hiện thực hóa và kiểm thử toán học chính xác cả trên Rust và PHP fallback. |

## 5.2. Kết luận khoa học và thực tiễn

Đồ án “Xây dựng Website Thương mại Điện tử Thiết bị Điện tử với Kiến trúc Hybrid PHP và Rust Engine Hiệu Năng Cao” đã chứng minh tính khả thi, hiệu quả và giá trị thực tiễn to lớn của việc kết hợp ngôn ngữ lập trình web truyền thống (PHP) với ngôn ngữ lập trình hệ thống hiện đại (Rust).

Những đóng góp chính của đề tài:
1. **Minh chứng giải pháp dung hòa giữa tốc độ phát triển và hiệu năng:** Lập trình viên có thể tận dụng sự tiện lợi, nhanh chóng của PHP để phát triển giao diện và nghiệp vụ kinh doanh, đồng thời tận dụng sức mạnh tính toán của Rust để giải quyết các nút thắt cổ chai về hiệu năng (bottlenecks).
2. **Giải pháp kiến trúc linh hoạt, chi phí thấp:** Hệ thống có thể vận hành trơn tru trên các máy tính cấu hình khiêm tốn nhờ cơ chế SQLite Portable và quy trình biên dịch tự động trên đám mây GitHub Actions.
3. **Ứng dụng thành công các thuật toán thông minh vào thương mại điện tử:** Không dừng lại ở một trang web CRUD thông thường, đồ án đã tích hợp thành công thuật toán học máy cơ bản (Cosine Similarity cho gợi ý, Hồi quy tuyến tính cho dự báo, Pareto ABC cho quản trị kho hàng).

## 5.3. Hạn chế của hệ thống hiện tại

Mặc dù đã đạt được những kết quả rất tích cực, hệ thống vẫn tồn tại một số hạn chế cần tiếp tục hoàn thiện:
- Phương thức thanh toán trực tuyến mới dừng lại ở việc tạo mã VietQR tĩnh theo đơn hàng mà chưa kết nối Webhook ngân hàng thời gian thực (như SeAPay, PayOS hoặc Casso) để tự động đổi trạng thái "Đã thanh toán" mà không cần quản trị viên duyệt tay.
- Chưa tích hợp dịch vụ tính phí vận chuyển thời gian thực từ các đơn vị giao vận (Giao Hàng Nhanh, Giao Hàng Tiết Kiệm, Viettel Post).
- Dịch vụ Rust Engine hiện đang lưu dữ liệu trong bộ nhớ (In-memory computation) cho từng lượt yêu cầu thay vì duy trì một bộ nhớ đệm phân tán như Redis.

## 5.4. Hướng phát triển mở rộng trong tương lai

Trong các giai đoạn phát triển tiếp theo, hệ thống có thể được nâng cấp theo các hướng:
1. **Tích hợp Webhook thanh toán tự động:** Kết nối API ngân hàng để hệ thống tự động xác nhận đơn hàng ngay khi tiền vào tài khoản trong vòng 3 giây.
2. **Ứng dụng Rust WebAssembly (WASM):** Đóng gói một phần module Rust thành WebAssembly để thực thi trực tiếp các tác vụ xử lý đồ họa hoặc lọc thông số ngay trên trình duyệt của khách hàng.
3. **Hệ thống gợi ý lai (Hybrid Recommendation System):** Kết hợp lọc dựa trên nội dung (Content-Based) với lọc cộng tác (Collaborative Filtering) dựa trên ma trận hành vi của toàn bộ người dùng.
4. **Triển khai hạ tầng đám mây dạng Container (Docker & Kubernetes):** Đóng gói PHP Core và Rust Engine thành các Docker container độc lập, tự động co giãn (Auto-scaling) khi lưu lượng truy cập tăng đột biến trong các đợt Flash Sale.

---

# TÀI LIỆU THAM KHẢO

1. Nguyễn Văn A, *Giáo trình Kỹ thuật Lập trình Web và Cơ sở dữ liệu*, Nhà xuất bản Thông tin và Truyền thông, Hà Nội, 2023.
2. Steve Klabnik and Carol Nichols, *The Rust Programming Language (Covers Rust 2021)*, No Starch Press, San Francisco, 2023.
3. Luke Welling and Laura Thomson, *PHP and MySQL Web Development (5th Edition)*, Addison-Wesley Professional, 2017.
4. Martin Fowler, *Patterns of Enterprise Application Architecture*, Addison-Wesley Professional, 2002.
5. Robert C. Martin, *Clean Architecture: A Craftsman's Guide to Software Structure and Design*, Prentice Hall, 2017.
6. Christopher D. Manning, Prabhakar Raghavan, and Hinrich Schütze, *Introduction to Information Retrieval*, Cambridge University Press, 2008 (Tài liệu về thuật toán Vector Space Model và Cosine Similarity).
7. Vilfredo Pareto, *Cours d'Économie Politique*, Université de Lausanne, 1896 (Lý thuyết nguyên lý phân phối 80/20 và phân tích quản trị tồn kho ABC).
8. Trang tài liệu trực tuyến chính thức của ngôn ngữ Rust: https://doc.rust-lang.org/
9. Trang tài liệu trực tuyến chính thức của ngôn ngữ PHP: https://www.php.net/manual/en/
10. Tiêu chuẩn đặc tả kỹ thuật mã thanh toán VietQR quốc gia: https://vietqr.net/

---

# PHỤ LỤC: DANH MỤC API ENDPOINTS CỦA RUST ENGINE

Dịch vụ Rust High-Performance Engine cung cấp các giao diện lập trình ứng dụng RESTful API sau:

### 1. `GET /api/health`
- **Mục đích:** Kiểm tra trạng thái hoạt động của Engine và các luồng làm việc.
- **Phản hồi mẫu:**
```json
{
  "status": "ok",
  "service": "rust-engine-microservice",
  "version": "0.1.0",
  "uptime_seconds": 1240,
  "worker_threads": 1
}
```

### 2. `POST /api/search`
- **Mục đích:** Tìm kiếm mờ thông minh theo khoảng cách Levenshtein và đối sánh token thông số kỹ thuật.
- **Body yêu cầu:**
```json
{
  "query": "macbook pro m3",
  "min_price": 30000000.0,
  "max_price": 60000000.0,
  "products": [ ... ]
}
```
- **Phản hồi mẫu:**
```json
{
  "count": 1,
  "results": [
    {
      "id": 3,
      "name": "MacBook Pro 14 M3 Pro",
      "price": 49990000.0,
      "match_score": 19.0
    }
  ]
}
```

### 3. `POST /api/recommendations`
- **Mục đích:** Tính toán độ tương đồng Cosine giữa vector đặc trưng của thiết bị mục tiêu và toàn bộ sản phẩm trong danh mục.
- **Body yêu cầu:**
```json
{
  "target_id": 1,
  "limit": 4,
  "products": [ ... ]
}
```
- **Phản hồi mẫu:**
```json
{
  "recommendations": [
    {
      "product_id": 2,
      "similarity": 0.8954,
      "product": { ... }
    }
  ]
}
```

### 4. `POST /api/analytics`
- **Mục đích:** Dự báo doanh thu bằng Hồi quy tuyến tính và phân loại tồn kho ABC.
- **Phản hồi mẫu:**
```json
{
  "total_revenue": 98170000.0,
  "total_orders": 4,
  "completed_orders_count": 3,
  "forecast_next_day_revenue": 35200000.0,
  "trend_slope": 1420000.0,
  "abc_analysis": {
    "class_a_count": 2,
    "class_b_count": 4,
    "class_c_count": 6,
    "top_revenue_items": [ ... ]
  }
}
```
