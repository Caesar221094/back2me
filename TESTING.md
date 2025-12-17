# 🧪 Panduan Testing Back2Me

## 📋 Persiapan Awal

### 1. Setup Database MySQL

```powershell
# Pastikan MySQL sudah running (XAMPP, WAMP, atau standalone MySQL)
# Buat database baru
mysql -u root -p
```

Di MySQL console:
```sql
CREATE DATABASE back2me CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 2. Setup Laravel

```powershell
# Generate application key jika belum ada
php artisan key:generate

# Jalankan migrasi database
php artisan migrate

# Seed data testing (SuperAdmin, Petugas, dan User sample)
php artisan db:seed --class=Back2MeSeeder

# Buat symlink untuk upload foto
php artisan storage:link

# Install dependencies frontend
npm install

# Build assets
npm run build
```

### 3. Jalankan Server

**Opsi 1 - Dev Server (Recommended):**
```powershell
composer run dev
```
Ini akan jalankan 4 proses sekaligus:
- Server (http://localhost:8000)
- Queue worker
- Log viewer (Pail)
- Vite dev server (hot reload)

**Opsi 2 - Manual:**
```powershell
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

---

## 👥 Akun Testing Default

Setelah `php artisan db:seed --class=Back2MeSeeder`:

| Role | Email | Password |
|------|-------|----------|
| **SuperAdmin** | admin@back2me.test | password123 |
| **Petugas** | petugas@back2me.test | password123 |
| **User** | (cek database, ada 5 user) | password123 |

---

## ✅ Checklist Testing per Role

### 🔴 **SUPERADMIN** - Fitur yang Harus Dicek

#### A. Kelola Akun Petugas
1. Login sebagai SuperAdmin
2. Akses: `/back2me/admin/users`
3. **Test Create:** Klik "Tambah User" → pilih role `petugas` → simpan
4. **Test Edit:** Ubah nama/role user → simpan
5. **Test Ban:** Centang "Is Banned" → simpan → logout → coba login dengan user yang di-ban (harus ditolak)
6. **Test Reset Password:** Klik "Reset Password" → password jadi `password123`
7. **Test Delete:** Hapus user (pastikan tidak ada laporan terkait)

#### B. Kelola Akun User
- Sama seperti kelola petugas, tapi pilih role `user`
- Test ban user yang sudah punya laporan
- Test reset password user

#### C. Kelola Kategori Barang
1. Akses: `/back2me/admin/categories`
2. **Test Create:** Tambah kategori baru (contoh: "Kendaraan", "Dokumen")
3. **Test Edit:** Ubah nama/deskripsi kategori
4. **Test Delete:** Hapus kategori yang tidak dipakai
5. **Test Validation:** Coba buat kategori dengan nama yang sudah ada (harus error)

#### D. Pengaturan Sistem
1. Akses: `/back2me/admin/settings`
2. **Test Update Settings:**
   - Ubah batas upload (1-10 MB)
   - Ubah jumlah maksimal file (1-10 file)
   - Ubah timeout klaim (1-365 hari)
   - Ubah auto close (30-365 hari)
3. Simpan → cek apakah tersimpan

#### E. Export Laporan
1. Akses: `/back2me/admin/reports/export`
2. **Test Export Bulanan:**
   - Pilih tahun dan bulan
   - Download CSV
   - Buka file → cek ada statistik dan detail laporan
3. **Test Export Tahunan:**
   - Pilih tahun
   - Download CSV
   - Cek ada breakdown per bulan

#### F. Verifikasi Laporan (SuperAdmin juga bisa)
- Akses laporan yang diklaim
- Ubah status jadi "selesai" atau "ditolak"

---

### 🟡 **PETUGAS** - Fitur yang Harus Dicek

#### A. Verifikasi Laporan
1. Login sebagai Petugas
2. Akses: `/back2me/reports`
3. **Test Filter:** Filter berdasarkan status "diproses"
4. Buka laporan yang diklaim user
5. **Test Verify:**
   - Ubah status → "selesai" (artinya disetujui)
   - Ubah status → "ditolak" (artinya klaim tidak valid)

#### B. Mencocokkan Bukti Klaim
1. Lihat detail laporan
2. Cek foto yang diupload pelapor
3. Bandingkan dengan bukti kepemilikan dari pengklaim
4. Putuskan: setujui atau tolak

#### C. Notifikasi
1. Saat ada user yang klaim barang
2. Cek notifikasi di dashboard (icon lonceng/bell)
3. Klik notifikasi → langsung ke laporan

---

### 🟢 **USER** - Fitur yang Harus Dicek

#### A. Melapor Barang Hilang/Ditemukan
1. Login sebagai User
2. Akses: `/back2me/reports/create`
3. **Test Create Report:**
   - Isi judul (contoh: "Dompet coklat hilang")
   - Pilih kategori
   - Isi deskripsi detail
   - Isi lokasi (contoh: "Parkiran kampus")
   - Upload foto (max 5 foto, max 5MB per foto)
   - Simpan

#### B. Melihat Daftar Barang
1. Akses: `/back2me/reports`
2. **Test View:** Lihat semua laporan (hilang & ditemukan)
3. **Test Pagination:** Scroll ke bawah → klik halaman berikutnya

#### C. Pencarian Barang
1. Di halaman `/back2me/reports`
2. **Test Search by Keyword:**
   - Ketik kata kunci di search box
   - Klik cari
3. **Test Filter by Kategori:**
   - Pilih kategori dari dropdown
   - Klik cari
4. **Test Filter by Status:**
   - Pilih status (pending/diproses/selesai)
   - Klik cari
5. **Test Filter by Lokasi:**
   - Ketik lokasi di search box
   - Klik cari

#### D. Melakukan Klaim Barang
1. Buka detail laporan barang yang ditemukan
2. **Test Claim:**
   - Klik tombol "Klaim Barang Ini"
   - Status berubah jadi "diproses"
   - Notifikasi terkirim ke pelapor & petugas
3. **Test Duplicate Claim:** Coba klaim lagi → harus ada error "Sudah ada klaim"

#### E. Melihat Status Laporan
1. Akses laporan milik sendiri
2. **Test Status Display:**
   - Pending: badge kuning
   - Diproses: badge biru
   - Selesai: badge hijau
   - Ditolak: badge merah

#### F. Mengedit Laporan
1. Buka laporan milik sendiri dengan status "pending"
2. **Test Edit:**
   - Klik tombol "Edit"
   - Ubah judul/deskripsi/foto
   - Simpan
3. **Test Edit Restriction:** Coba edit laporan yang statusnya "diproses" → harus ditolak

#### G. Konfirmasi Penerimaan Barang
1. Setelah petugas ubah status jadi "selesai"
2. Buka detail laporan yang sudah diklaim
3. **Test Confirmation:**
   - Klik tombol "Konfirmasi Penerimaan Barang"
   - Barang sudah diterima → status final
   - Notifikasi terkirim ke pelapor

#### H. Notifikasi
1. **Test Receive Notification:**
   - Saat laporan diklaim orang lain
   - Saat status diubah petugas
   - Saat barang dikonfirmasi diterima
2. Klik icon notifikasi
3. Lihat list notifikasi
4. Klik notifikasi → langsung ke laporan

---

## 🧪 Testing Workflow Lengkap (End-to-End)

### Scenario 1: User Lapor Barang Hilang → User Lain Klaim → Petugas Verifikasi → Konfirmasi

**Step 1: User A lapor barang hilang**
```
1. Login sebagai user pertama (user1@back2me.test)
2. Create report: "HP Samsung A50 hilang"
3. Upload foto HP
4. Lokasi: "Perpustakaan lantai 2"
5. Kategori: Elektronik
6. Submit
```

**Step 2: User B klaim barang**
```
1. Logout → Login sebagai user kedua (user2@back2me.test)
2. Cari laporan "HP Samsung"
3. Buka detail
4. Klik "Klaim Barang Ini"
5. Status berubah "diproses"
```

**Step 3: Petugas verifikasi**
```
1. Logout → Login sebagai petugas (petugas@back2me.test)
2. Lihat notifikasi baru (ada klaim)
3. Buka detail laporan
4. Cek foto dan data
5. Ubah status:
   - "selesai" jika valid
   - "ditolak" jika tidak valid
```

**Step 4: User B konfirmasi penerimaan**
```
1. Logout → Login kembali sebagai user2@back2me.test
2. Buka laporan yang sudah "selesai"
3. Klik "Konfirmasi Penerimaan Barang"
4. Case closed ✅
```

---

## 🐛 Common Issues & Troubleshooting

### Error: "Connection refused"
```powershell
# Cek MySQL sudah running
# Di XAMPP: Start MySQL
# Atau jalankan: net start MySQL80 (Windows Service)
```

### Error: "SQLSTATE[HY000] [1049] Unknown database"
```powershell
# Buat database manual
mysql -u root -p
CREATE DATABASE back2me;
EXIT;
php artisan migrate
```

### Error: "Class 'role' not found"
```powershell
# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### Error: "Storage link not found" (404 pada gambar)
```powershell
php artisan storage:link
```

### Error: "Vite manifest not found"
```powershell
npm install
npm run build
```

---

## 📊 Automated Testing

Jalankan test suite:

```powershell
# Run all tests
composer run test

# Run specific test
php artisan test --filter=RoleProtectionTest

# Run with coverage
php artisan test --coverage
```

**Test Files:**
- `tests/Feature/RoleProtectionTest.php` - Test role middleware
- `tests/Feature/ReportCreationTest.php` - Test create report
- `tests/Feature/PetugasVerifyTest.php` - Test verify workflow

---

## ✅ Feature Completion Checklist

### SuperAdmin (100%)
- [x] Kelola akun petugas
- [x] Kelola akun user (reset password, ban)
- [x] Kelola kategori barang
- [x] Pengaturan sistem (batas upload, timeout)
- [x] Export laporan bulanan/tahunan

### Petugas (100%)
- [x] Verifikasi laporan
- [x] Ubah status laporan
- [x] Lihat bukti klaim

### User (100%)
- [x] Melapor barang hilang/ditemukan
- [x] Lihat daftar barang
- [x] Pencarian (kategori, lokasi, keyword, status)
- [x] Klaim barang
- [x] Lihat status laporan
- [x] Notifikasi (database)
- [x] Edit laporan (sebelum diverifikasi)
- [x] Konfirmasi penerimaan barang

---

## 🎯 Testing Priority

**Priority 1 (CRITICAL):**
1. Login/Logout semua role
2. Create report + upload foto
3. Claim report
4. Verify report (petugas)
5. Role protection (akses tidak sah harus ditolak)

**Priority 2 (HIGH):**
1. Edit report
2. Filter & search
3. Konfirmasi penerimaan
4. Notifikasi

**Priority 3 (MEDIUM):**
1. User management (ban, reset password)
2. Category management
3. Settings

**Priority 4 (LOW):**
1. Export reports
2. Pagination
3. UI/UX polish

---

**Happy Testing! 🚀**
