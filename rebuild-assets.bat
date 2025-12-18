@echo off
echo ========================================
echo   REBUILD VITE ASSETS
echo ========================================
echo.

cd /d "%~dp0"

echo [1/2] Building Vite assets...
call npm run build

echo.
echo [2/2] Clearing Laravel caches...
php artisan view:clear
php artisan config:clear

echo.
echo ========================================
echo   BUILD COMPLETE!
echo ========================================
echo.
echo Refresh browser: http://localhost:8000
echo.
pause
