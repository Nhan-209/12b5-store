-- Seed data for Electronics E-Commerce Store
USE `electro_db`;

-- Default Users: admin (admin@electro.vn / admin123) and customer (customer@gmail.com / user123)
-- Password hashes generated using standard BCRYPT
INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `phone`, `address`, `role`) VALUES
(1, 'Quản Trị Viên', 'admin@electro.vn', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', '0901234567', 'Số 1 Đại Cồ Việt, Hai Bà Trưng, Hà Nội', 'admin'),
(2, 'Nguyễn Văn A', 'customer@gmail.com', '$2y$10$J0pK/1DAyYxzDi5diGbfeCyyHJovwvHmjfqa06eq6ytcn7eTkNdD2', '0987654321', '123 Cầu Giấy, Hà Nội', 'customer'),
(3, 'Trần Thị Mai', 'mai.tran@gmail.com', '$2y$10$w8T0M47c92rW2u8g8XzTceEcm74UvG3pL.d0rN/PqXm4a0mXbYJ0e', '0987654321', 'Số 45 Lê Lợi, Quận Hải Châu, Đà Nẵng', 'customer');

-- Categories
INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `description`) VALUES
(1, 'Điện Thoại Thông Minh', 'dien-thoai-thong-minh', 'bi-phone', 'Điện thoại cao cấp, flagship, tầm trung chính hãng mới nhất'),
(2, 'Laptop & Máy Tính', 'laptop-may-tinh', 'bi-laptop', 'Laptop văn phòng, đồ họa, gaming và ultrabook hiệu năng cao'),
(3, 'Máy Tính Bảng', 'may-tinh-bang', 'bi-tablet', 'Máy tính bảng phục vụ học tập, giải trí, vẽ đồ họa chuyên nghiệp'),
(4, 'Tai Nghe & Âm Thanh', 'tai-nghe-am-thanh', 'bi-headphones', 'Tai nghe bluetooth, chống ồn chủ động ANC, loa không dây cao cấp'),
(5, 'Đồng Hồ Thông Minh', 'dong-ho-thong-minh', 'bi-smartwatch', 'Smartwatch theo dõi sức khỏe, định vị GPS, pin trâu'),
(6, 'Phụ Kiện & Linh Kiện', 'phu-kien-linh-kien', 'bi-cpu', 'Cáp sạc nhanh GaN, pin dự phòng, chuột, bàn phím cơ và màn hình');

-- Brands
INSERT INTO `brands` (`id`, `name`, `slug`, `logo`) VALUES
(1, 'Apple', 'apple', 'apple-logo.png'),
(2, 'Samsung', 'samsung', 'samsung-logo.png'),
(3, 'Sony', 'sony', 'sony-logo.png'),
(4, 'Asus', 'asus', 'asus-logo.png'),
(5, 'Dell', 'dell', 'dell-logo.png'),
(6, 'Lenovo', 'lenovo', 'lenovo-logo.png'),
(7, 'Xiaomi', 'xiaomi', 'xiaomi-logo.png');

-- Products with rich technical specifications
INSERT INTO `products` (`id`, `category_id`, `brand_id`, `name`, `slug`, `sku`, `price`, `original_price`, `stock`, `featured`, `status`, `thumbnail`, `short_description`, `description`, `specs`, `rating`, `review_count`, `sales_count`) VALUES
(1, 1, 1, 'iPhone 16 Pro Max 256GB Titan Tự Nhiên', 'iphone-16-pro-max-256gb', 'APL-IP16PM-256', 34990000.00, 36990000.00, 45, 1, 1, 'iphone16promax.jpg', 
 'Siêu phẩm mới nhất từ Apple trang bị vi xử lý Apple A18 Pro 3nm, khung viền Titanium chuẩn hàng không vũ trụ và nút Điều Khiển Camera (Camera Control).',
 'iPhone 16 Pro Max nâng tầm trải nghiệm công nghệ di động với màn hình Super Retina XDR OLED 6.9 inch, ProMotion 120Hz mượt mà cùng thời lượng pin xuất sắc nhất từ trước đến nay. Hệ thống 3 camera sau gồm cảm biến Fusion 48MP, Ultra Wide 48MP và Telephoto 5x 12MP cho chất lượng ảnh sắc nét đến từng chi tiết.',
 '{"cpu": "Apple A18 Pro 6 nhân", "ram": "8 GB", "storage": "256 GB", "screen": "6.9 inch Super Retina XDR OLED, 120Hz", "camera": "48MP + 48MP + 12MP, Trước 12MP", "battery": "4685 mAh, Sạc nhanh 30W", "os": "iOS 18", "weight": "227 g"}', 5.0, 18, 42),

(2, 1, 2, 'Samsung Galaxy S24 Ultra 5G 256GB AI Phone', 'samsung-galaxy-s24-ultra-256gb', 'SS-S24U-256', 29990000.00, 33990000.00, 38, 1, 1, 's24ultra.jpg',
 'Flagship tích hợp Galaxy AI đột phá, màn hình phẳng Dynamic AMOLED 2X 120Hz phủ kính chống chói Gorilla Armor và bút S-Pen quyền năng.',
 'Samsung Galaxy S24 Ultra trang bị vi xử lý Snapdragon 8 Gen 3 for Galaxy cực kỳ mạnh mẽ, cụm camera 200MP zoom quang học 5x sắc nét cùng hàng loạt tính năng trí tuệ nhân tạo như Khoanh tròn để tìm kiếm, Phiên dịch trực tiếp và Trợ lý Note thông minh.',
 '{"cpu": "Snapdragon 8 Gen 3 for Galaxy", "ram": "12 GB", "storage": "256 GB", "screen": "6.8 inch Dynamic AMOLED 2X, 120Hz QHD+", "camera": "200MP + 50MP + 12MP + 10MP", "battery": "5000 mAh, Sạc 45W", "os": "Android 14, One UI 6.1", "weight": "232 g"}', 4.9, 14, 35),

(3, 2, 1, 'MacBook Pro 14 M3 Pro (18GB / 512GB SSD) Đen Không Gian', 'macbook-pro-14-m3-pro-512gb', 'APL-MBP14-M3P', 49990000.00, 52990000.00, 20, 1, 1, 'macbookpro14.jpg',
 'Sức mạnh đồ họa đỉnh cao với chip Apple M3 Pro 11 CPU / 14 GPU, màn hình Liquid Retina XDR độ sáng 1600 nits đỉnh cao.',
 'MacBook Pro 14 inch M3 Pro là cỗ máy hoàn hảo cho lập trình viên, nhà sáng tạo nội dung và kỹ sư đồ họa. Thời lượng pin lên tới 18 tiếng liên tục, âm thanh 6 loa studio vòm spatial audio và đầy đủ cổng kết nối HDMI, SD Card, MagSafe 3.',
 '{"cpu": "Apple M3 Pro (11-core CPU, 14-core GPU)", "ram": "18 GB Unified Memory", "storage": "512 GB SSD siêu tốc", "screen": "14.2 inch Liquid Retina XDR (3024x1964), 120Hz ProMotion", "ports": "3x Thunderbolt 4, HDMI, MagSafe 3, SDXC", "battery": "70 Wh, Sạc 70W", "os": "macOS Sonoma", "weight": "1.61 kg"}', 5.0, 22, 19),

(4, 2, 4, 'Laptop Gaming ASUS ROG Zephyrus G16 (Core Ultra 9 / RTX 4070 / 32GB / 1TB)', 'asus-rog-zephyrus-g16-gu605', 'ASUS-ROG-G16', 58990000.00, 62990000.00, 15, 1, 1, 'zephyrusg16.jpg',
 'Laptop gaming mỏng nhẹ cao cấp hàng đầu với màn hình ROG Nebula OLED 2.5K 240Hz, card đồ họa NVIDIA GeForce RTX 4070 8GB GDDR6.',
 'ASUS ROG Zephyrus G16 GU605 kết hợp giữa hiệu năng gaming đỉnh bảng và sự thanh lịch của dòng ultrabook mỏng chỉ 1.49cm. Trang bị chip Intel Core Ultra 9 185H thế hệ mới tích hợp NPU AI, hệ thống tản nhiệt 3 quạt Arc Flow và vỏ nhôm CNC cao cấp.',
 '{"cpu": "Intel Core Ultra 9 185H (16 nhân, 22 luồng, up to 5.1GHz)", "ram": "32 GB LPDDR5X 7467MHz", "storage": "1 TB PCIe 4.0 NVMe M.2 SSD", "gpu": "NVIDIA GeForce RTX 4070 8GB GDDR6 (105W TGP)", "screen": "16 inch 2.5K (2560 x 1600) OLED 240Hz 0.2ms DCI-P3 100%", "battery": "90 Wh, Sạc 240W", "weight": "1.85 kg"}', 4.8, 9, 12),

(5, 2, 5, 'Dell XPS 13 Plus 9320 (Core i7-1360P / 16GB / 512GB / 3.5K OLED)', 'dell-xps-13-plus-9320', 'DELL-XPS13P', 41990000.00, 45000000.00, 12, 0, 1, 'dellxps13.jpg',
 'Tuyệt tác ultrabook tương lai với bàn phím liền mạch không viền, thanh chức năng cảm ứng và touchpad vô hình ẩn dưới kính cường lực Gorilla Glass.',
 'Dell XPS 13 Plus thể hiện đẳng cấp doanh nhân với màn hình 3.5K OLED cảm ứng siêu nét, âm thanh 4 loa chất lượng cao, vỏ nhôm nguyên khối phay kim cương cực kỳ sang trọng.',
 '{"cpu": "Intel Core i7-1360P (12 nhân, 16 luồng)", "ram": "16 GB LPDDR5 6000MHz", "storage": "512 GB PCIe Gen4 M.2 SSD", "screen": "13.4 inch 3.5K (3456 x 2160) OLED Touchscreen", "weight": "1.23 kg", "os": "Windows 11 Home bản quyền"}', 4.7, 8, 14),

(6, 3, 1, 'iPad Pro M4 11 inch 256GB Wi-Fi (Tấm nền Ultra Retina XDR Tandem OLED)', 'ipad-pro-m4-11-256gb', 'APL-IPADM4-11', 28990000.00, 30990000.00, 25, 1, 1, 'ipadm4.jpg',
 'Thiết kế mỏng nhất lịch sử Apple chỉ 5.3mm, trang bị chip Apple M4 thế hệ mới và công nghệ màn hình Tandem OLED đột phá.',
 'iPad Pro M4 mang đến hiệu năng đồ họa mạnh mẽ hơn gấp 4 lần thế hệ trước, hỗ trợ Apple Pencil Pro với cử chỉ bóp nhẹ xoay thân bút và bàn phím Magic Keyboard thế hệ mới.',
 '{"cpu": "Apple M4 9 nhân CPU, 10 nhân GPU", "ram": "8 GB Unified RAM", "storage": "256 GB", "screen": "11 inch Ultra Retina Tandem OLED (2420x1668), 120Hz ProMotion", "weight": "444 g", "os": "iPadOS 18"}', 5.0, 15, 28),

(7, 4, 3, 'Tai nghe không dây chống ồn Sony WH-1000XM5 Hi-Res Audio', 'sony-wh-1000xm5-black', 'SONY-WHXM5', 7490000.00, 8990000.00, 50, 1, 1, 'wh1000xm5.jpg',
 'Chuẩn mực chống ồn thế giới với 2 bộ xử lý và 8 micro chuyên dụng, hỗ trợ codec âm thanh độ phân giải cao LDAC và thời lượng pin 30 giờ.',
 'Sony WH-1000XM5 được các audiophile và chuyên gia âm thanh đánh giá cao với khả năng tối ưu hóa chống ồn tự động theo môi trường (Auto NC Optimizer), đàm thoại rõ nét nhờ 4 micro beamforming lọc gió bằng AI.',
 '{"driver": "30mm màng loa sợi carbon", "frequency": "4Hz - 40,000Hz (Hi-Res Audio)", "noise_cancelling": "Dual Processor V1 + HD QN1, 8 Microphones", "battery": "30 giờ bật ANC, sạc nhanh 3 phút nghe 3 giờ", "weight": "250 g"}', 4.9, 32, 67),

(8, 4, 1, 'Tai nghe Apple AirPods Pro 2 (Cổng USB-C / Chống ồn chủ động 2X)', 'airpods-pro-2-usbc', 'APL-APP2-USBC', 5690000.00, 6190000.00, 60, 1, 1, 'airpodspro2.jpg',
 'Trang bị chip Apple H2 mang đến khả năng khử ồn chủ động gấp đôi, chế độ Xuyên Âm thích ứng (Adaptive Audio) và chuẩn sạc USB-C phổ thông.',
 'AirPods Pro thế hệ 2 đem lại trải nghiệm nghe đắm chìm với Âm Thanh Không Gian Cá Nhân Hóa (Personalized Spatial Audio), cảm biến vuốt điều chỉnh âm lượng trực tiếp trên thân tai nghe và khả năng kháng bụi nước IP54.',
 '{"chip": "Apple H2", "battery": "6 giờ (tai nghe), 30 giờ (hộp sạc MagSafe)", "features": "Active Noise Cancellation 2X, Adaptive Audio, Conversation Awareness", "charging": "USB-C, MagSafe, Apple Watch Charger"}', 4.8, 40, 89),

(9, 5, 1, 'Apple Watch Series 10 GPS 46mm Vỏ Nhôm Dây Cao Su', 'apple-watch-series-10-46mm', 'APL-AWS10-46', 11490000.00, 12290000.00, 30, 1, 1, 'applewatchs10.jpg',
 'Đồng hồ thông minh mỏng nhất từ trước tới nay của Apple, màn hình OLED góc nhìn rộng siêu sáng, sạc nhanh 80% chỉ trong 30 phút.',
 'Apple Watch Series 10 bổ sung cảm biến nhiệt độ nước và độ sâu thích hợp cho bơi lội lặn nông, phát hiện ngưng thở khi ngủ được FDA chứng nhận cùng chip S10 SiP mạnh mẽ.',
 '{"chip": "Apple S10 SiP 64-bit", "screen": "OLED Always-On Retina góc nhìn rộng", "features": "ECG điện tâm đồ, SpO2 nồng độ oxy máu, theo dõi giấc ngủ, phát hiện ngã/va chạm xe", "water_resistance": "50m WR50", "battery": "18 giờ sử dụng thông thường"}', 4.9, 11, 23),

(10, 5, 2, 'Samsung Galaxy Watch Ultra 47mm LTE Titan Xám', 'samsung-galaxy-watch-ultra-47mm', 'SS-GWU-47', 15990000.00, 16990000.00, 18, 0, 1, 'galaxywatchultra.jpg',
 'Đồng hồ thể thao dã ngoại siêu bền bỉ với khung Titanium chuẩn quân đội, chống nước 10ATM và pin trâu đến 100 giờ ở chế độ tiết kiệm pin.',
 'Galaxy Watch Ultra sở hữu còi báo động cứu hộ khẩn cấp 86dB, GPS băng tần kép L1+L5 chính xác từng mét kể cả trong hẻm sâu hay rừng rậm, nút kích hoạt nhanh Quick Button tùy biến.',
 '{"cpu": "Exynos W1000 3nm 5 nhân", "screen": "1.5 inch Super AMOLED 3000 nits, Kính Sapphire", "battery": "590 mAh, lên tới 100 giờ", "durability": "Titanium, 10ATM, IP68, MIL-STD-810H", "connectivity": "4G LTE eSIM, Dual GPS L1+L5"}', 4.8, 7, 11),

(11, 6, 7, 'Củ sạc nhanh Xiaomi 67W GaN Siêu Nhỏ Gọn (2C + 1A)', 'cu-sac-nhanh-xiaomi-67w-gan', 'MI-CHARGER-67W', 590000.00, 790000.00, 120, 0, 1, 'charger67w.jpg',
 'Công nghệ bán dẫn GaN thế hệ 3 giúp giảm 40% kích thước, hỗ trợ công suất 67W sạc cùng lúc 3 thiết bị an toàn và ổn định.',
 'Củ sạc nhanh tương thích đa giao thức PD 3.0, QC 4.0+, UFCS sạc được cho cả laptop, máy tính bảng và điện thoại với các lớp bảo vệ quá dòng, quá áp, quá nhiệt thông minh.',
 '{"power": "67W Max", "ports": "2x USB-C + 1x USB-A", "technology": "Gallium Nitride (GaN III)", "protocols": "PD3.0, QC4+, PPS, UFCS"}', 4.9, 58, 145),

(12, 1, 7, 'Xiaomi 14 Ultra 5G 512GB Ống Kính Leica Huyền Thoại', 'xiaomi-14-ultra-512gb', 'MI-14U-512', 26990000.00, 29990000.00, 22, 1, 1, 'xiaomi14ultra.jpg',
 'Đỉnh cao nhiếp ảnh di động với 4 camera 50MP tinh chỉnh bởi Leica, cảm biến chính kích thước 1 inch khẩu độ vô cấp Stepless Variable Aperture.',
 'Xiaomi 14 Ultra trang bị Snapdragon 8 Gen 3, màn hình C8 AMOLED WQHD+ 120Hz 3000 nits, sạc nhanh 90W có dây và 80W không dây tốc độ cao.',
 '{"cpu": "Snapdragon 8 Gen 3", "ram": "16 GB LPDDR5X", "storage": "512 GB UFS 4.0", "camera": "Leica Quad 50MP (Cảm biến 1-inch LYT-900), Tele 3.2x, Periscope 5x", "battery": "5000 mAh, Sạc 90W", "os": "Xiaomi HyperOS"}', 4.8, 16, 21);

-- Discount Coupons
INSERT INTO `coupons` (`id`, `code`, `discount_type`, `discount_value`, `min_order_value`, `expires_at`, `usage_limit`, `used_count`, `status`) VALUES
(1, 'WELCOME2026', 'fixed', 500000.00, 10000000.00, '2026-12-31 23:59:59', 500, 12, 1),
(2, 'TECHSALE10', 'percent', 10.00, 5000000.00, '2026-12-31 23:59:59', 200, 35, 1),
(3, 'VIPMEMBER', 'fixed', 1000000.00, 20000000.00, '2026-12-31 23:59:59', 100, 8, 1);

-- Seed Orders
INSERT INTO `orders` (`id`, `user_id`, `order_code`, `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `payment_method`, `payment_status`, `order_status`, `total_amount`, `discount_amount`, `final_amount`, `notes`, `created_at`) VALUES
(1, 2, 'ORD-2026-0001', 'Nguyễn Văn An', 'customer@gmail.com', '0912345678', 'Số 123 Nguyễn Huệ, Quận 1, TP.HCM', 'cod', 'pending', 'completed', 34990000.00, 500000.00, 34490000.00, 'Giao hàng giờ hành chính', '2026-09-10 10:15:00'),
(2, 2, 'ORD-2026-0002', 'Nguyễn Văn An', 'customer@gmail.com', '0912345678', 'Số 123 Nguyễn Huệ, Quận 1, TP.HCM', 'bank_transfer', 'paid', 'shipping', 7490000.00, 0.00, 7490000.00, 'Gọi trước khi giao', '2026-09-12 14:30:00'),
(3, 3, 'ORD-2026-0003', 'Trần Thị Mai', 'mai.tran@gmail.com', '0987654321', 'Số 45 Lê Lợi, Quận Hải Châu, Đà Nẵng', 'bank_transfer', 'paid', 'processing', 49990000.00, 1000000.00, 48990000.00, 'Đóng gói bọc xốp chống sốc cẩn thận', '2026-09-15 09:00:00'),
(4, 2, 'ORD-2026-0004', 'Nguyễn Văn An', 'customer@gmail.com', '0912345678', 'Số 123 Nguyễn Huệ, Quận 1, TP.HCM', 'cod', 'pending', 'pending', 5690000.00, 0.00, 5690000.00, '', '2026-09-16 16:45:00');

-- Order Items
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_sku`, `unit_price`, `quantity`, `subtotal`) VALUES
(1, 1, 1, 'iPhone 16 Pro Max 256GB Titan Tự Nhiên', 'APL-IP16PM-256', 34990000.00, 1, 34990000.00),
(2, 2, 7, 'Tai nghe không dây chống ồn Sony WH-1000XM5 Hi-Res Audio', 'SONY-WHXM5', 7490000.00, 1, 7490000.00),
(3, 3, 3, 'MacBook Pro 14 M3 Pro (18GB / 512GB SSD) Đen Không Gian', 'APL-MBP14-M3P', 49990000.00, 1, 49990000.00),
(4, 4, 8, 'Tai nghe Apple AirPods Pro 2 (Cổng USB-C / Chống ồn chủ động 2X)', 'APL-APP2-USBC', 5690000.00, 1, 5690000.00);

-- Product Reviews
INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `user_name`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 2, 'Nguyễn Văn An', 5, 'Máy cầm rất nhẹ nhờ viền titan, màu titan tự nhiên cực đẹp. Nút Camera Control dùng tiện lợi, pin trâu dùng cả ngày.', '2026-09-11 15:30:00'),
(2, 3, 3, 'Trần Thị Mai', 5, 'Màn hình hiển thị quá đỉnh, bàn phím gõ êm. Máy chạy render video 4K 10-bit rất mượt mà và mát mẻ.', '2026-09-16 11:20:00'),
(3, 7, 2, 'Nguyễn Văn An', 5, 'Khả năng chống ồn của Sony XM5 không có gì để chê, đệm tai êm ái đeo nhiều tiếng không bị đau tai.', '2026-09-13 18:00:00');
