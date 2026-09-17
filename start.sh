#!/bin/bash
# ElectroStore Turnkey Startup Script for Linux / macOS

echo "========================================================="
echo "   12B5 STORE - KHỞI ĐỘNG HỆ THỐNG TRÌNH DIỄN ĐỒ ÁN"
echo "   Kiến trúc Hybrid: PHP E-Commerce + Rust Engine"
echo "========================================================="
echo ""

if ! command -v php &> /dev/null; then
    echo "[LỖI] Không tìm thấy PHP. Vui lòng cài đặt: sudo apt install php php-sqlite3"
    exit 1
fi

echo "[1/3] Khởi tạo cơ sở dữ liệu SQLite..."
php database/migrate.php --driver=sqlite

echo ""
echo "[2/3] Kiểm tra Rust Microservice..."
if [ -f "bin/linux/rust_engine" ]; then
    chmod +x bin/linux/rust_engine
    ./bin/linux/rust_engine &
    echo "[INFO] Đã chạy Rust Microservice trên port 5000."
elif [ -f "rust-engine/target/release/rust-engine" ]; then
    chmod +x rust-engine/target/release/rust-engine
    ./rust-engine/target/release/rust-engine &
    echo "[INFO] Đã chạy Rust Microservice trên port 5000."
else
    echo "[THÔNG BÁO] Không tìm thấy binary rust_engine. Tự động chạy chế độ PHP Core fallback."
fi

echo ""
echo "[3/3] Khởi chạy Web Server tại http://localhost:8000..."
if which xdg-open > /dev/null; then
  xdg-open http://localhost:8000 &
elif which open > /dev/null; then
  open http://localhost:8000 &
fi

php -S 0.0.0.0:8000 -t public
