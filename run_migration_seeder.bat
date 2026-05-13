@echo off
echo Running migrations...
php artisan migrate

echo.
echo Running ShopeeProductsSeeder...
php artisan db:seed --class=ShopeeProductsSeeder

echo.
echo Done!
pause
