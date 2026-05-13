@echo off
echo Importing SQL file to update brand and level data...
mysql -u root -p norapadell < update_brand_level.sql
echo.
echo Done! Brand and level data has been updated.
pause
