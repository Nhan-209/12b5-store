@echo off
chcp 65001 >nul
echo =========================================================
echo    12B5 STORE - KHỞI ĐỘNG HỆ THỐNG TRÌNH DIỄN ĐỒ ÁN
echo    Kiến trúc Hybrid: PHP E-Commerce + Rust Engine
echo =========================================================
echo.

REM 1. Tìm kiếm PHP trong hệ thống hoặc XAMPP
set PHP_BIN=php
where php >nul 2>nul
if %errorlevel% neq 0 (
    if exist "C:\xampp\php\php.exe" (
        set PHP_BIN="C:\xampp\php\php.exe"
    ) else if exist "C:\xamppnp\php\php.exe" (
        set PHP_BIN="C:\xamppnp\php\php.exe"
    ) else if exist "D:\xampp\php\php.exe" (
        set PHP_BIN="D:\xampp\php\php.exe"
    ) else if exist "E:\xampp\php\php.exe" (
        set PHP_BIN="E:\xampp\php\php.exe"
    ) else if exist "C:\php\php.exe" (
        set PHP_BIN="C:\php\php.exe"
    ) else if exist "C:\tools\php\php.exe" (
        set PHP_BIN="C:\tools\php\php.exe"
    ) else (
        echo [LỖI] Không tìm thấy PHP trong PATH hoặc thư mục XAMPP!
        echo Quý thầy cô / bạn vui lòng cài đặt PHP hoặc mở XAMPP và thêm PHP vào PATH.
        pause
        exit /b 1
    )
)

echo [1/3] Kiểm tra và khởi tạo Cơ sở dữ liệu SQLite...
%PHP_BIN% database\migrate.php --driver=sqlite
echo [OK] Cơ sở dữ liệu đã sẵn sàng.

echo.
echo [2/3] Kiểm tra Rust High-Performance Engine...
if exist "bin\windows\rust_engine.exe" (
    echo [INFO] Khởi chạy Rust Engine Microservice trên cổng 5000...
    start "Rust High-Performance Engine" /B "bin\windows\rust_engine.exe"
) else if exist "rust-engine\target\release\rust-engine.exe" (
    echo [INFO] Khởi chạy Rust Engine Microservice trên cổng 5000...
    start "Rust High-Performance Engine" /B "rust-engine\target\release\rust-engine.exe"
) else (
    echo [THÔNG BÁO] Chưa có file binary Rust Engine biên dịch trước.
    echo Website sẽ tự động chuyển sang chế độ fallback "PHP Core Engine" mà không phát sinh lỗi!
)

echo.
echo [3/3] Khởi chạy Web Server tại http://localhost:8000...
start "" "http://localhost:8000"
%PHP_BIN% -S localhost:8000 -t public
pause
