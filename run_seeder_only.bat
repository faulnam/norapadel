@echo off
echo Running ShopeeProductsSeeder to update brand and level data...
php artisan db:seed --class=ShopeeProductsSeeder

echo.
echo Done! Brand and level data has been updated from seeder.
pause
