@echo off
chcp 65001 >nul
echo =========================================================
echo    12B5 STORE - KHỞI ĐỘNG HỆ THỐNG TRÌNH DIỄN ĐỒ ÁN
echo    Kiến trúc Hybrid: PHP E-Commerce + Rust Engine
echo =========================================================
echo.

REM =========================================================
REM 1. TÌM KIẾM PHP TRONG HỆ THỐNG HOẶC XAMPP
REM =========================================================
set "PHP_BIN="

where php >nul 2>nul

if %errorlevel% equ 0 (
    set "PHP_BIN=php"
) else if exist "C:\xamppnp\php\php.exe" (
    set "PHP_BIN=C:\xamppnp\php\php.exe"
) else if exist "C:\xampp\php\php.exe" (
    set "PHP_BIN=C:\xampp\php\php.exe"
) else if exist "D:\xampp\php\php.exe" (
    set "PHP_BIN=D:\xampp\php\php.exe"
) else if exist "E:\xampp\php\php.exe" (
    set "PHP_BIN=E:\xampp\php\php.exe"
) else if exist "C:\php\php.exe" (
    set "PHP_BIN=C:\php\php.exe"
) else if exist "C:\tools\php\php.exe" (
    set "PHP_BIN=C:\tools\php\php.exe"
) else (
    echo [LỖI] Không tìm thấy PHP trong PATH hoặc thư mục XAMPP!
    echo.
    echo Đã kiểm tra các vị trí:
    echo   C:\xamppnp\php\php.exe
    echo   C:\xampp\php\php.exe
    echo   D:\xampp\php\php.exe
    echo   E:\xampp\php\php.exe
    echo   C:\php\php.exe
    echo   C:\tools\php\php.exe
    echo.
    echo Quý thầy cô / bạn vui lòng cài đặt PHP
    echo hoặc kiểm tra lại thư mục PHP.
    pause
    exit /b 1
)

echo [INFO] PHP đang sử dụng: %PHP_BIN%
echo.

REM Kiểm tra PHP có hoạt động không
%PHP_BIN% -v >nul 2>nul

if %errorlevel% neq 0 (
    echo [LỖI] PHP được tìm thấy nhưng không thể chạy!
    echo [INFO] Đường dẫn PHP: %PHP_BIN%
    echo.
    pause
    exit /b 1
)

echo [OK] PHP đã sẵn sàng.
echo.

REM =========================================================
REM 2. KIỂM TRA VÀ KHỞI TẠO CƠ SỞ DỮ LIỆU SQLITE
REM =========================================================
echo [1/3] Kiểm tra và khởi tạo Cơ sở dữ liệu SQLite...

if exist "database\migrate.php" (
    %PHP_BIN% database\migrate.php --driver=sqlite

    if %errorlevel% neq 0 (
        echo [LỖI] Không thể khởi tạo Cơ sở dữ liệu SQLite!
        pause
        exit /b 1
    )

    echo [OK] Cơ sở dữ liệu đã sẵn sàng.
) else (
    echo [LỖI] Không tìm thấy file database\migrate.php!
    echo [INFO] Hãy chắc chắn bạn đang chạy file BAT
    echo        từ thư mục gốc của project 12B5 STORE.
    pause
    exit /b 1
)

echo.

REM =========================================================
REM 3. KIỂM TRA RUST HIGH-PERFORMANCE ENGINE
REM =========================================================
echo [2/3] Kiểm tra Rust High-Performance Engine...

if exist "bin\windows\rust_engine.exe" (
    echo [INFO] Khởi chạy Rust Engine Microservice trên cổng 5000...
    start "Rust High-Performance Engine" /B "bin\windows\rust_engine.exe"

    timeout /t 2 /nobreak >nul

    echo [OK] Rust Engine đã được khởi chạy.

) else if exist "rust-engine\target\release\rust-engine.exe" (
    echo [INFO] Khởi chạy Rust Engine Microservice trên cổng 5000...
    start "Rust High-Performance Engine" /B "rust-engine\target\release\rust-engine.exe"

    timeout /t 2 /nobreak >nul

    echo [OK] Rust Engine đã được khởi chạy.

) else (
    echo [THÔNG BÁO] Chưa có file binary Rust Engine biên dịch trước.
    echo Website sẽ tự động chuyển sang chế độ fallback
    echo "PHP Core Engine" mà không phát sinh lỗi!
)

echo.

REM =========================================================
REM 4. KHỞI CHẠY PHP WEB SERVER
REM =========================================================
echo [3/3] Khởi chạy Web Server tại http://localhost:8000...
echo.

if not exist "public" (
    echo [LỖI] Không tìm thấy thư mục public!
    echo [INFO] Hãy chắc chắn file BAT nằm trong thư mục gốc
    echo        của project 12B5 STORE.
    pause
    exit /b 1
)

echo =========================================================
echo    12B5 STORE ĐANG CHẠY
echo =========================================================
echo.
echo    Website:
echo    http://localhost:8000
echo.
echo    PHP:
echo    %PHP_BIN%
echo.
echo    Rust Engine:
echo    http://localhost:5000
echo.
echo    Nhấn Ctrl+C để dừng Web Server.
echo =========================================================
echo.

REM Mở trình duyệt
start "" "http://localhost:8000"

REM Khởi chạy PHP Development Server
%PHP_BIN% -S localhost:8000 -t public

REM =========================================================
REM 5. KẾT THÚC
REM =========================================================
echo.
echo =========================================================
echo    PHP Web Server đã dừng.
echo =========================================================
pause