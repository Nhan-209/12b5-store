@echo off
chcp 65001 >nul
title 12B5 Store - Rust High-Performance Engine (Port 5000)
echo =========================================================
echo    12B5 STORE - RUST HIGH-PERFORMANCE ENGINE
echo    Microservice chạy độc lập trên cổng 5000
echo =========================================================
echo.
if exist "bin\windows\rust_engine.exe" (
    echo [OK] Đang khởi chạy binary biên dịch sẵn: bin\windows\rust_engine.exe...
    echo Nhấn Ctrl+C để dừng dịch vụ.
    echo.
    "bin\windows\rust_engine.exe"
) else (
    echo [LỖI] Không tìm thấy bin\windows\rust_engine.exe
    pause
)
