@echo off
echo Running migration to update brand and level data...
php artisan migrate

echo.
echo Done! Brand and level data has been updated based on product names.
pause
