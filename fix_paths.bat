@echo off
cd /d "C:\Users\Admin\Desktop\pc\doantotnghiep\12b5-store\app\views"
for /r %%f in (*.php) do (
    powershell -Command "(Get-Content '%%f' -Raw) -replace 'href=\"/', 'href=\"<?= BASE_URL ?>/' -replace 'action=\"/', 'action=\"<?= BASE_URL ?>/' | Set-Content '%%f' -NoNewline"
)
echo Fixed all paths in PHP files
pause