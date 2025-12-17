@echo off
echo ========================================
echo BACK2ME - Setup Database MySQL
echo ========================================
echo.

REM Cek apakah XAMPP terinstall
if exist "C:\xampp\mysql\bin\mysql.exe" (
    echo [OK] Ditemukan MySQL di XAMPP
    "C:\xampp\mysql\bin\mysql.exe" -u root -e "CREATE DATABASE IF NOT EXISTS back2me CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    echo [OK] Database 'back2me' berhasil dibuat
    goto :migrasi
)

REM Cek apakah MySQL standalone terinstall
if exist "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe" (
    echo [OK] Ditemukan MySQL Server 8.0
    "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe" -u root -e "CREATE DATABASE IF NOT EXISTS back2me CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    echo [OK] Database 'back2me' berhasil dibuat
    goto :migrasi
)

echo [ERROR] MySQL tidak ditemukan!
echo.
echo Silakan:
echo 1. Install XAMPP atau MySQL standalone
echo 2. Atau buat database manual lewat phpMyAdmin / MySQL Workbench
echo 3. Nama database: back2me
echo.
pause
exit /b 1

:migrasi
echo.
echo ========================================
echo Menjalankan Migrasi Database...
echo ========================================
php artisan migrate --force
echo.

echo ========================================
echo Menjalankan Seeder...
echo ========================================
php artisan db:seed --class=Back2MeSeeder
echo.

echo ========================================
echo Membuat Storage Link...
echo ========================================
php artisan storage:link
echo.

echo ========================================
echo SELESAI! Database siap digunakan
echo ========================================
echo.
echo Akun testing:
echo - SuperAdmin: admin@back2me.test / password123
echo - Petugas: petugas@back2me.test / password123
echo.
echo Jalankan server dengan: composer run dev
echo Atau: php artisan serve
echo.
pause
