# 🚀 QUICK START - Back2Me Setup

## ⚡ Setup Otomatis (Windows)

```cmd
setup-database.bat
```

Script ini akan:
1. ✅ Deteksi instalasi MySQL (XAMPP/Standalone)
2. ✅ Buat database `back2me`
3. ✅ Jalankan migrasi
4. ✅ Seed data testing
5. ✅ Buat storage link

---

## 🔧 Setup Manual

### 1. Buat Database MySQL

**Via phpMyAdmin (XAMPP):**
1. Buka http://localhost/phpmyadmin
2. Klik tab "Databases"
3. Nama database: `back2me`
4. Collation: `utf8mb4_unicode_ci`
5. Klik "Create"

**Via MySQL Command Line:**
```sql
CREATE DATABASE back2me CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Konfigurasi .env

File `.env` sudah dikonfigurasi untuk MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=back2me
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan `DB_PASSWORD` jika MySQL Anda pakai password.

### 3. Jalankan Migrasi & Seeder

```powershell
php artisan migrate
php artisan db:seed --class=Back2MeSeeder
php artisan storage:link
```

### 4. Jalankan Server

**Development (Recommended):**
```powershell
composer run dev
```

**Atau manual:**
```powershell
php artisan serve
# Di terminal lain:
npm run dev
```

---

## 👥 Akun Testing

| Role | Email | Password |
|------|-------|----------|
| SuperAdmin | admin@back2me.test | password123 |
| Petugas | petugas@back2me.test | password123 |
| User | (ada 5 user di database) | password123 |

---

## 📖 Dokumentasi Lengkap

- **Testing Guide**: Lihat [TESTING.md](TESTING.md)
- **API Routes**: Lihat [routes/back2me.php](routes/back2me.php)
- **AI Instructions**: Lihat [.github/copilot-instructions.md](.github/copilot-instructions.md)

---

## 🐛 Troubleshooting

### MySQL tidak terdeteksi
```powershell
# Cek lokasi MySQL
where mysql
# Atau cek service
Get-Service | Where-Object {$_.Name -like "*mysql*"}
```

### Error "Unknown database"
Database belum dibuat. Buat manual via phpMyAdmin atau MySQL Workbench.

### Error "Vite manifest not found"
```powershell
npm install
npm run build
```

### Storage link error (Windows)
Jalankan PowerShell/CMD sebagai Administrator:
```powershell
php artisan storage:link
```

---

## 🎯 Next Steps

1. ✅ Buka browser: http://localhost:8000
2. ✅ Login dengan akun testing
3. ✅ Ikuti checklist di [TESTING.md](TESTING.md)
4. ✅ Test semua fitur per role

**Happy Coding! 🚀**
