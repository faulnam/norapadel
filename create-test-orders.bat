@echo off
echo ========================================
echo Test Order Creation Commands
echo ========================================
echo.
echo This script will create test orders with different statuses
echo to test the new Biteship API key.
echo.

echo [1] Create completed order
echo [2] Create cancelled order
echo [3] Create multiple completed orders (5 orders)
echo [4] Create multiple cancelled orders (5 orders)
echo [5] Exit
echo.

set /p choice="Enter your choice (1-5): "

if "%choice%"=="1" (
    echo.
    echo Creating completed order...
    php artisan order:create-test completed
) else if "%choice%"=="2" (
    echo.
    echo Creating cancelled order...
    php artisan order:create-test cancelled
) else if "%choice%"=="3" (
    echo.
    echo Creating 5 completed orders...
    for /L %%i in (1,1,5) do (
        echo Creating order %%i of 5...
        php artisan order:create-test completed
    )
    echo.
    echo All 5 completed orders created!
) else if "%choice%"=="4" (
    echo.
    echo Creating 5 cancelled orders...
    for /L %%i in (1,1,5) do (
        echo Creating order %%i of 5...
        php artisan order:create-test cancelled
    )
    echo.
    echo All 5 cancelled orders created!
) else if "%choice%"=="5" (
    echo.
    echo Exiting...
    exit /b 0
) else (
    echo.
    echo Invalid choice. Please run the script again.
)

echo.
echo ========================================
echo Done! Press any key to exit...
pause > nul
