# ElectroStore Turnkey Startup Script for PowerShell
[Console]::OutputEncoding = [System.Text.Encoding]::UTF8

Write-Host "=========================================================" -ForegroundColor Cyan
Write-Host "   12B5 STORE - KHỞI ĐỘNG HỆ THỐNG TRÌNH DIỄN ĐỒ ÁN" -ForegroundColor Yellow
Write-Host "   Kiến trúc Hybrid: PHP E-Commerce + Rust Engine" -ForegroundColor Cyan
Write-Host "=========================================================" -ForegroundColor Cyan
Write-Host ""

# 1. Detect PHP
$phpCmd = "php"
if (-not (Get-Command php -ErrorAction SilentlyContinue)) {
    if (Test-Path "C:\xampp\php\php.exe") {
        $phpCmd = "C:\xampp\php\php.exe"
    } elseif (Test-Path "C:\xamppnp\php\php.exe") {
        $phpCmd = "C:\xamppnp\php\php.exe"
    } elseif (Test-Path "D:\xampp\php\php.exe") {
        $phpCmd = "D:\xampp\php\php.exe"
    } elseif (Test-Path "E:\xampp\php\php.exe") {
        $phpCmd = "E:\xampp\php\php.exe"
    } elseif (Test-Path "C:\php\php.exe") {
        $phpCmd = "C:\php\php.exe"
    } elseif (Test-Path "C:\tools\php\php.exe") {
        $phpCmd = "C:\tools\php\php.exe"
    } else {
        Write-Host "[LỖI] Không tìm thấy PHP trong hệ thống hoặc thư mục XAMPP." -ForegroundColor Red
        Write-Host "Vui lòng cài đặt PHP hoặc thêm đường dẫn php.exe vào PATH." -ForegroundColor Yellow
        Read-Host "Nhấn Enter để thoát..."
        exit 1
    }
}

Write-Host "[1/3] Kiểm tra và khởi tạo Cơ sở dữ liệu SQLite..." -ForegroundColor Green
& $phpCmd database/migrate.php --driver=sqlite

Write-Host "`n[2/3] Kiểm tra Rust High-Performance Engine..." -ForegroundColor Green
$rustBin = $null
if (Test-Path "bin\windows\rust_engine.exe") {
    $rustBin = "bin\windows\rust_engine.exe"
} elseif (Test-Path "rust-engine\target\release\rust-engine.exe") {
    $rustBin = "rust-engine\target\release\rust-engine.exe"
}

if ($rustBin) {
    Write-Host "[INFO] Đang chạy Rust Engine Microservice ngầm trên port 5000..." -ForegroundColor Cyan
    Start-Process -FilePath $rustBin -WindowStyle Hidden
} else {
    Write-Host "[THÔNG BÁO] Không tìm thấy binary rust_engine.exe." -ForegroundColor Yellow
    Write-Host "Hệ thống sẽ chạy với thuật toán dự phòng 'PHP Core Engine' hoàn toàn trơn tru!" -ForegroundColor White
}

Write-Host "`n[3/3] Khởi chạy Web Server tại http://localhost:8000..." -ForegroundColor Green
Start-Process "http://localhost:8000"
& $phpCmd -S localhost:8000 -t public
