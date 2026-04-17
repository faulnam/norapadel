@echo off
echo ========================================
echo  Clear Cache Laravel
echo ========================================
echo.

echo [1/4] Clearing config cache...
php artisan config:clear
echo.

echo [2/4] Clearing application cache...
php artisan cache:clear
echo.

echo [3/4] Clearing route cache...
php artisan route:clear
echo.

echo [4/4] Clearing view cache...
php artisan view:clear
echo.

echo ========================================
echo  Cache cleared successfully!
echo ========================================
echo.
echo Sekarang coba buka checkout lagi:
echo http://127.0.0.1:8000/customer/checkout
echo.
pause
