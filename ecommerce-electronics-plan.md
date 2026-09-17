# Xây dựng Website Thương mại Điện tử & Báo cáo Đồ án

## Goal
Xây dựng website bán thiết bị điện tử dựa trên mã nguồn mở có sẵn, tuỳ chỉnh UI bằng MCP Stitch, tối ưu hiệu năng các tác vụ nặng bằng Rust và hoàn thiện báo cáo đồ án tốt nghiệp.

## Tasks
- [x] Task 1: Tìm kiếm, đánh giá và lựa chọn template E-commerce mã nguồn mở (Ưu tiên PHP/HTML) → Verify: Chọn được repo phù hợp và tạo Public Repository trên GitHub của nhóm.
- [x] Task 2: Thiết lập luồng CI/CD (GitHub Actions) để tự động build và kiểm thử mã nguồn, do máy local yếu không thể chạy trực tiếp → Verify: Pipeline GitHub Actions chạy thành công (xanh) cho mã nguồn PHP.
- [x] Task 3: Sử dụng MCP Stitch để tùy chỉnh UI sang domain thiết bị điện tử, sau đó push code lên GitHub → Verify: Code UI mới được push lên và pass quá trình build trên Actions.
- [x] Task 4: Xây dựng core xử lý bằng Rust. Thiết lập workflow GitHub Actions riêng cho Rust để tự động compile và test thay vì build ở local → Verify: Các module Rust build thành công trên môi trường Actions.
- [x] Task 5: Tích hợp service Rust vào hệ thống PHP (qua API/WASM). Đảm bảo toàn bộ dự án sẵn sàng để clone và chạy → Verify: Pipeline tổng hợp chạy thành công, project sẵn sàng để clone xuống máy trường.
- [x] Task 6: Viết Báo cáo Đồ án - Chương 1 & 2 (Giới thiệu, Cơ sở lý thuyết), bổ sung phần về Rust và công cụ thiết kế → Verify: Hoàn thành bản nháp các chương mở đầu.
- [x] Task 7: Viết Báo cáo Đồ án - Chương 3 (Phân tích & Thiết kế), cập nhật kiến trúc mở rộng và luồng tích hợp logic Rust → Verify: Hoàn thành các biểu đồ mô hình hóa kiến trúc mới.
- [x] Task 8: Viết Báo cáo Đồ án - Chương 4 & 5 (Triển khai & Đánh giá), nhấn mạnh hiệu năng cải thiện nhờ Rust → Verify: Hoàn thiện toàn bộ báo cáo đồ án.

## Done When
- [x] Hệ thống E-commerce thiết bị điện tử hoạt động ổn định với giao diện tùy chỉnh và logic Rust.
- [x] File báo cáo đồ án tốt nghiệp hoàn chỉnh phản ánh đúng quy trình và kiến trúc hệ thống mới.

## Notes
- Do cấu hình máy local yếu, **mọi hoạt động build, compile (đặc biệt là Rust) và test đều phải đẩy lên GitHub Actions (CI/CD)**. Máy local chỉ dùng để code và commit.
- Khi cần demo và nộp bài, toàn bộ mã nguồn sẽ được clone về máy tính của trường để chạy thực tế. (Việc thiết lập sẵn CI/CD pipeline cũng là một điểm sáng giá để đưa vào báo cáo).
- Ưu tiên chọn các template bằng PHP và HTML/CSS cơ bản để tận dụng thế mạnh cá nhân.
- Kiến trúc đề xuất: Microservices hoặc sử dụng Rust như một API Server độc lập (worker) xử lý background/heavy load.
