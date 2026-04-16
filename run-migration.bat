@echo off
echo Running migrations...
echo.

REM Cari PHP di Laragon
set PHP_PATH=

if exist "C:\laragon\bin\php\php-8.3.1-Win32-vs16-x64\php.exe" (
    set PHP_PATH=C:\laragon\bin\php\php-8.3.1-Win32-vs16-x64\php.exe
)

if exist "D:\laragon\bin\php\php-8.3.1-Win32-vs16-x64\php.exe" (
    set PHP_PATH=D:\laragon\bin\php\php-8.3.1-Win32-vs16-x64\php.exe
)

if exist "D:\laragonzo\bin\php\php-8.3.1-Win32-vs16-x64\php.exe" (
    set PHP_PATH=D:\laragonzo\bin\php\php-8.3.1-Win32-vs16-x64\php.exe
)

if "%PHP_PATH%"=="" (
    echo ERROR: PHP not found!
    echo Please check your Laragon installation path.
    pause
    exit /b 1
)

echo Using PHP: %PHP_PATH%
echo.

"%PHP_PATH%" artisan migrate

echo.
echo Done!
pause
