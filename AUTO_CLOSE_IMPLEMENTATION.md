# 🚀 Implementasi Auto-Close System

## ✅ Yang Sudah Dibuat:

### 1. **Console Command** - Auto-Close Reports
**File:** `app/Console/Commands/CloseExpiredReports.php`
- Command: `php artisan reports:close-expired`
- Fungsi: Otomatis tutup laporan yang expired berdasarkan timeout

### 2. **Scheduler** - Daily Cron Job
**File:** `routes/console.php`
- Jadwal: Setiap hari jam 00:00
- Jalankan command `reports:close-expired` otomatis

### 3. **Migration** - Add 'expired' Status
**File:** `database/migrations/2025_12_18_000005_add_expired_status_to_reports.php`
- Tambah status baru: `expired`
- Status enum sekarang: pending, diproses, selesai, ditolak, **expired**

### 4. **Controller Logic** - Prevent Expired Claims
**File:** `app/Http/Controllers/ReportController.php`
- Cek status `expired` sebelum allow klaim
- Update validasi status untuk include `expired`

### 5. **UI Updates** - Show Expired Badge
**File:** `resources/views/back2me/reports/index.blade.php`
- Tambah option "Expired" di filter
- Badge abu-abu untuk status expired

---

## 📋 Cara Sistem Bekerja:

### **Timeout Klaim (Default: 30 hari)**
```
Laporan pending → 30 hari tidak ada klaim → Status jadi 'expired'
```

### **Auto Close (Default: 90 hari)**
```
Laporan pending → 90 hari tidak ada aktivitas → Status jadi 'expired'
```

### **Scheduler:**
```php
// Jalan otomatis setiap hari jam 00:00
Schedule::command('reports:close-expired')->daily();
```

---

## 🔧 Testing Manual:

### 1. **Test Command:**
```bash
php artisan reports:close-expired
```

### 2. **Test dengan Data Lama:**
```sql
-- Ubah created_at jadi 40 hari lalu
UPDATE reports SET created_at = DATE_SUB(NOW(), INTERVAL 40 DAY) WHERE id = 1;
```

### 3. **Jalankan Command Lagi:**
```bash
php artisan reports:close-expired
# Output: ✅ Berhasil menutup 1 laporan yang expired
```

---

## ⚙️ Cara Mengubah Setting:

### Via Admin Panel:
1. Login sebagai SuperAdmin
2. Akses: http://localhost:8000/back2me/admin/settings
3. Ubah:
   - **Timeout Klaim**: 7-365 hari
   - **Auto Close**: 30-365 hari
4. Simpan

### Setting tersimpan di cache:
- `back2me.claim_timeout_days`
- `back2me.auto_close_days`

---

## 🎯 Next Steps:

### Untuk Jalankan Scheduler (Production):
```bash
# Tambahkan ke Windows Task Scheduler atau cron (Linux)
php artisan schedule:work
```

### Atau jalankan manual setiap hari:
```bash
php artisan reports:close-expired
```

---

**Status: ✅ COMPLETED**
- Timeout Klaim: ✅ Berjalan
- Auto Close: ✅ Berjalan
- UI Badge: ✅ Ditampilkan
- Prevent Klaim: ✅ Divalidasi
