# QA Testing Flow - Back2Me Lost & Found System

Dokumentasi ini untuk Quality Assurance dalam menguji Back2Me sistem. Mencakup flow testing per role, checklist features, dan test scenarios end-to-end.

---

## 📋 Persiapan Testing

### 1. Setup Database
```bash
php artisan migrate
php artisan db:seed --class=Back2MeSeeder
php artisan storage:link
```

### 2. Akun Testing (Tersedia di Seeder)
| Role | Email | Password |
|------|-------|----------|
| SuperAdmin | admin@back2me.test | password123 |
| Petugas | petugas@back2me.test | password123 |
| User | user1@back2me.test - user5@back2me.test | password123 |

### 3. Environment
- Browser: Chrome/Firefox terbaru
- Server: http://localhost:8000
- Database: MySQL back2me

---

## 🔐 1. AUTHENTICATION TESTING

### T1.1 - Login Valid
**Steps:**
1. Buka http://localhost:8000/login
2. Masukkan email: admin@back2me.test
3. Masukkan password: password123
4. Klik "Log in"

**Expected:**
- Redirect ke dashboard
- Tampil nama user di header

**Status:** ☐ Pass ☐ Fail

---

### T1.2 - Login Invalid Password
**Steps:**
1. Buka http://localhost:8000/login
2. Masukkan email: admin@back2me.test
3. Masukkan password: salah123
4. Klik "Log in"

**Expected:**
- Tetap di login, muncul error "These credentials do not match our records"

**Status:** ☐ Pass ☐ Fail

---

### T1.3 - Logout & Redirect
**Steps:**
1. Login sebagai user
2. Klik dropdown profil → Logout
3. Perhatikan redirect

**Expected:**
- Redirect ke halaman login
- Flash message "Berhasil logout"

**Status:** ☐ Pass ☐ Fail

---

## 👤 2. USER ROLE TESTING

### T2.1 - Buat Laporan
**Steps:**
1. Login sebagai user1@back2me.test
2. Klik "Buat Laporan"
3. Isi:
   - Judul: "Kunci mobil hilang"
   - Kategori: Aksesoris
   - Deskripsi: "Kunci Toyota merah hilang di parkiran kampus"
   - Lokasi: "Parkiran B, Lantai 2"
   - Upload 2-3 foto
4. Klik "Kirim Laporan"

**Expected:**
- Berhasil disimpan
- Redirect ke daftar laporan
- Flash "Laporan dibuat"
- Status baru: "pending"

**Status:** ☐ Pass ☐ Fail

---

### T2.2 - Edit Laporan (Status Pending)
**Steps:**
1. Buka laporan milik sendiri dengan status "pending"
2. Klik tombol "Edit"
3. Ubah judul menjadi "Kunci mobil hilang (UPDATED)"
4. Klik "Simpan"

**Expected:**
- Berhasil diupdate
- Redirect ke detail laporan
- Judul berubah

**Status:** ☐ Pass ☐ Fail

---

### T2.3 - Edit Laporan (Status Bukan Pending) - Harus Ditolak
**Steps:**
1. Buka laporan dengan status "diproses" atau "selesai"
2. Coba akses /back2me/reports/{id}/edit

**Expected:**
- Error: "Tidak dapat edit setelah diverifikasi"
- Redirect kembali

**Status:** ☐ Pass ☐ Fail

---

### T2.4 - Cari & Filter Laporan
**Steps:**
1. Buka halaman /back2me/reports
2. Test pencarian:
   - Ketik "kunci" di search
   - Klik Filter → hanya laporan dengan "kunci" tampil
3. Test filter kategori:
   - Pilih "Elektronik"
   - Klik Filter → hanya laporan elektronik tampil
4. Test filter status:
   - Pilih "selesai"
   - Klik Filter → hanya laporan selesai tampil

**Expected:**
- Semua filter bekerja
- Reset button membersihkan filter

**Status:** ☐ Pass ☐ Fail

---

### T2.5 - Klaim Laporan (User Biasa Saja)
**Steps:**
1. Login sebagai user2@back2me.test
2. Cari laporan milik user1 dengan status "pending"
3. Buka detail laporan
4. Klik "Klaim barang ini"

**Expected:**
- Status laporan berubah jadi "diproses"
- Muncul pesan "Klaim terkirim, menunggu verifikasi petugas"
- Badge "Diklaim: user2" muncul di daftar laporan
- Di detail laporan muncul badge "Sudah diklaim"

**Status:** ☐ Pass ☐ Fail

---

### T2.6 - Klaim Laporan (Superadmin/Petugas Tidak Boleh)
**Steps:**
1. Login sebagai petugas@back2me.test (role petugas)
2. Cari laporan dengan status "pending"
3. Klik "Klaim barang ini"

**Expected:**
- Error: "Hanya pengguna biasa yang dapat melakukan klaim"

**Status:** ☐ Pass ☐ Fail

---

### T2.7 - Klaim Laporan Milik Sendiri (Tidak Boleh)
**Steps:**
1. Login sebagai user1@back2me.test
2. Buka laporan milik sendiri
3. Klik "Klaim barang ini"

**Expected:**
- Error: "Anda tidak dapat mengklaim laporan yang Anda buat sendiri"

**Status:** ☐ Pass ☐ Fail

---

### T2.8 - Klaim Laporan Sudah Diklaim (Tidak Boleh)
**Steps:**
1. Login sebagai user3@back2me.test
2. Buka laporan yang sudah diklaim user2
3. Klik "Klaim barang ini"

**Expected:**
- Error: "Sudah ada klaim"

**Status:** ☐ Pass ☐ Fail

---

### T2.9 - Konfirmasi Penerimaan Barang
**Steps:**
1. Login sebagai user2 (pengklaim)
2. Buka laporan yang sudah "selesai" dan diklaim oleh user2
3. Klik "Konfirmasi barang diterima"

**Expected:**
- Tombol hilang
- Flash "Terima kasih! Konfirmasi penerimaan barang berhasil"
- Notifikasi dikirim ke user1 (pembuat laporan)

**Status:** ☐ Pass ☐ Fail

---

## 👮 3. PETUGAS ROLE TESTING

### T3.1 - Verifikasi & Ubah Status Laporan
**Steps:**
1. Login sebagai petugas@back2me.test
2. Buka laporan dengan status "diproses"
3. Di panel "Verifikasi Petugas", ubah status → "selesai"
4. Klik "Perbarui Status"

**Expected:**
- Status laporan berubah jadi "selesai"
- Flash "Status diperbarui"
- User pengklaim bisa lihat tombol konfirmasi

**Status:** ☐ Pass ☐ Fail

---

### T3.2 - Tolak Klaim (Ubah Status Ditolak)
**Steps:**
1. Login sebagai petugas@back2me.test
2. Buka laporan dengan status "diproses"
3. Ubah status → "ditolak"
4. Klik "Perbarui Status"

**Expected:**
- Status laporan jadi "ditolak"
- User pengklaim tidak bisa konfirmasi
- Notifikasi ke pembuat laporan

**Status:** ☐ Pass ☐ Fail

---

### T3.3 - Petugas Tidak Bisa Edit/Delete Laporan
**Steps:**
1. Login sebagai petugas@back2me.test
2. Buka laporan
3. Coba akses /back2me/reports/{id}/edit

**Expected:**
- Tidak ada tombol edit/delete
- Hanya bisa verifikasi status

**Status:** ☐ Pass ☐ Fail

---

## 🛡️ 4. SUPERADMIN ROLE TESTING

### T4.1 - Kelola Akun Pengguna (Create)
**Steps:**
1. Login sebagai admin@back2me.test
2. Akses /back2me/admin/users
3. Klik "Tambah Pengguna"
4. Isi:
   - Nama: "Test User"
   - Email: "testuser.unique@back2me.test" (email harus unik)
   - Role: user
   - Password: password123
5. Klik "Simpan Pengguna"

**Expected:**
- User berhasil dibuat
- Redirect ke daftar user
- Flash "Akun dibuat"
- User baru tampil di list dengan role badge

**Status:** ☐ Pass ☐ Fail

---

### T4.2 - Kelola Akun Pengguna (Edit)
**Steps:**
1. Akses /back2me/admin/users
2. Klik "Edit" pada user manapun
3. Ubah nama → "Updated Name"
4. Ubah role → "petugas"
5. Klik "Simpan Perubahan"

**Expected:**
- Perubahan tersimpan
- Redirect ke daftar
- Nama dan role terupdate

**Status:** ☐ Pass ☐ Fail

---

### T4.3 - Ban/Unban User
**Steps:**
1. Edit user
2. Centang "Blokir pengguna ini"
3. Klik "Simpan Perubahan"
4. Login dengan user yang di-ban

**Expected:**
- Checkbox tersimpan
- User yang di-ban tidak bisa login (error 403 "Akun diblokir")

**Status:** ☐ Pass ☐ Fail

---

### T4.4 - Reset Password User
**Steps:**
1. Akses /back2me/admin/users
2. Klik "Reset PW" pada user
3. Confirm popup

**Expected:**
- Flash "Password di-reset (password123)"
- User bisa login dengan password baru "password123"

**Status:** ☐ Pass ☐ Fail

---

### T4.5 - Kelola Kategori (Create)
**Steps:**
1. Akses /back2me/admin/categories
2. Klik "Tambah Kategori"
3. Isi:
   - Nama: "Perhiasan"
   - Deskripsi: "Jam tangan, gelang, kalung"
4. Klik "Simpan Kategori"

**Expected:**
- Kategori berhasil dibuat
- Tampil di daftar kategori

**Status:** ☐ Pass ☐ Fail

---

### T4.6 - Kelola Kategori (Edit & Delete)
**Steps:**
1. Edit kategori
2. Ubah deskripsi
3. Klik "Simpan"
4. Hapus kategori dengan tombol trash

**Expected:**
- Edit berhasil tersimpan
- Delete berhasil, kategori hilang dari list

**Status:** ☐ Pass ☐ Fail

---

### T4.7 - Pengaturan Sistem
**Steps:**
1. Akses /back2me/admin/settings
2. Ubah nilai:
   - Max upload size: 2048 (2MB)
   - Max upload files: 3
   - Claim timeout: 15 hari
   - Auto close: 60 hari
3. Klik "Simpan"

**Expected:**
- Pengaturan tersimpan
- Nilai di-cache

**Status:** ☐ Pass ☐ Fail

---

### T4.8 - Export Laporan Bulanan
**Steps:**
1. Akses /back2me/admin/reports/export
2. Pilih tahun: 2025, Bulan: 12
3. Klik "Unduh CSV Bulanan"

**Expected:**
- File CSV ter-download
- Berisi: statistik (total, pending, diproses, selesai, ditolak)
- Detail laporan (ID, Judul, Pelapor, Kategori, Lokasi, Status, Tanggal)

**Status:** ☐ Pass ☐ Fail

---

### T4.9 - Export Laporan Tahunan
**Steps:**
1. Akses /back2me/admin/reports/export
2. Pilih tahun: 2025
3. Klik "Unduh CSV Tahunan"

**Expected:**
- File CSV ter-download
- Berisi breakdown per bulan + detail laporan

**Status:** ☐ Pass ☐ Fail

---

## 🔐 5. ROLE-BASED ACCESS CONTROL (RBAC) TESTING

### T5.1 - User Tidak Bisa Akses Admin
**Steps:**
1. Login sebagai user1@back2me.test
2. Coba akses /back2me/admin/users

**Expected:**
- Error 403 Forbidden
- Tidak bisa akses halaman admin

**Status:** ☐ Pass ☐ Fail

---

### T5.2 - Petugas Tidak Bisa Akses Admin
**Steps:**
1. Login sebagai petugas@back2me.test
2. Coba akses /back2me/admin/categories

**Expected:**
- Error 403 Forbidden

**Status:** ☐ Pass ☐ Fail

---

### T5.3 - Superadmin Bisa Akses Semua
**Steps:**
1. Login sebagai admin@back2me.test
2. Akses /back2me/reports, /back2me/admin/users, /back2me/admin/categories, /back2me/admin/settings

**Expected:**
- Semua halaman bisa diakses tanpa error

**Status:** ☐ Pass ☐ Fail

---

## 📊 6. DASHBOARD TESTING

### T6.1 - Dashboard Menampilkan Statistik
**Steps:**
1. Login (role apapun)
2. Buka /dashboard

**Expected:**
- Tampil kartu statistik: Total, Pending, Diproses, Selesai, Ditolak, Diklaim
- Aktivitas terbaru (5 laporan terakhir)
- Aksi cepat sesuai role

**Status:** ☐ Pass ☐ Fail

---

### T6.2 - Quick Actions Sesuai Role
**Steps:**
1. Dashboard user: harus ada "Buat Laporan", "Lihat Laporan"
2. Dashboard petugas: harus ada "Verifikasi Klaim"
3. Dashboard superadmin: harus ada "Kelola Pengguna", "Kategori", "Settings", "Export"

**Expected:**
- Link aksi sesuai role

**Status:** ☐ Pass ☐ Fail

---

## 📸 7. FILE UPLOAD TESTING

### T7.1 - Upload Foto Laporan (Valid)
**Steps:**
1. Login user
2. Buat laporan
3. Upload 3 foto JPG/PNG (masing-masing < 5MB)
4. Simpan

**Expected:**
- Foto ter-upload
- Foto tampil di galeri detail laporan
- Path tersimpan di database

**Status:** ☐ Pass ☐ Fail

---

### T7.2 - Upload Foto > Max Size (Ditolak)
**Steps:**
1. Buat laporan
2. Upload file > 5MB

**Expected:**
- Error: "validation.image" atau "The foto.* field must be less than 5120 kilobytes."

**Status:** ☐ Pass ☐ Fail

---

### T7.3 - Upload File Non-Image (Ditolak)
**Steps:**
1. Buat laporan
2. Upload file PDF/txt

**Expected:**
- Error: "The foto.* field must be an image."

**Status:** ☐ Pass ☐ Fail

---

## 🔔 8. NOTIFIKASI TESTING

### T8.1 - Notifikasi Saat User Klaim
**Steps:**
1. Login user1 (pembuat laporan)
2. Tab lain: Login user2
3. User2 klaim laporan milik user1
4. Perhatikan icon notifikasi user1

**Expected:**
- User1 mendapat notifikasi "Laporan #X diklaim oleh user2"
- Notifikasi muncul di tabel `notifications`

**Status:** ☐ Pass ☐ Fail

---

### T8.2 - Notifikasi Saat Status Berubah
**Steps:**
1. Petugas ubah status laporan → "selesai"
2. Perhatikan notifikasi ke pengklaim

**Expected:**
- Notifikasi tersimpan di database

**Status:** ☐ Pass ☐ Fail

---

## 🏗️ 9. END-TO-END SCENARIO

### Skenario: Laporan Hilang → Klaim → Verifikasi → Konfirmasi

**Flow Lengkap:**

1. **User A membuat laporan** (T2.1)
   - Judul: "Tas backpack merah hilang"
   - Upload foto
   - Status: pending

2. **User B melihat daftar laporan** (T2.4)
   - Filter kategori, cari laporan User A
   - Buka detail

3. **User B mengklaim laporan** (T2.5)
   - Klik klaim
   - Status berubah: pending → diproses
   - User A dapat notifikasi

4. **Petugas memverifikasi klaim** (T3.1)
   - Login petugas
   - Buka laporan
   - Ubah status: diproses → selesai

5. **User B mengkonfirmasi penerimaan** (T2.9)
   - Login User B
   - Klik "Konfirmasi barang diterima"
   - User A dapat notifikasi konfirmasi
   - Proses selesai

**Expected:** Semua langkah berhasil tanpa error

**Status:** ☐ Pass ☐ Fail

---

## 📝 10. UI/UX & RESPONSIVE TESTING

### T10.1 - Responsive Mobile
**Steps:**
1. Buka aplikasi di device mobile atau DevTools mobile mode
2. Test navigasi, form, tombol

**Expected:**
- Layout responsive
- Tombol mudah diklik
- Text readable

**Status:** ☐ Pass ☐ Fail

---

### T10.2 - Form Validation Feedback
**Steps:**
1. Submit form kosong
2. Perhatikan error message

**Expected:**
- Error message muncul per field
- Input field highlight merah
- Pesan jelas dalam bahasa Indonesia

**Status:** ☐ Pass ☐ Fail

---

### T10.3 - Flash Messages
**Steps:**
1. Lakukan aksi (create, update, delete)
2. Perhatikan flash message

**Expected:**
- Flash message muncul dengan jelas
- Alert success/error sesuai hasil

**Status:** ☐ Pass ☐ Fail

---

## ✅ HASIL TESTING

| No | Test Case | Status | Notes |
|----|-----------|--------|-------|
| 1  | T1.1 - Login Valid | ☐ | |
| 2  | T1.2 - Login Invalid | ☐ | |
| 3  | T1.3 - Logout | ☐ | |
| 4  | T2.1 - Buat Laporan | ☐ | |
| 5  | T2.2 - Edit Laporan (Pending) | ☐ | |
| 6  | T2.3 - Edit Laporan (Non-Pending) | ☐ | |
| 7  | T2.4 - Cari & Filter | ☐ | |
| 8  | T2.5 - Klaim Laporan | ☐ | |
| 9  | T2.6 - Klaim (Petugas Ditolak) | ☐ | |
| 10 | T2.7 - Klaim Laporan Sendiri | ☐ | |
| 11 | T2.8 - Klaim Sudah Diklaim | ☐ | |
| 12 | T2.9 - Konfirmasi Penerimaan | ☐ | |
| 13 | T3.1 - Verifikasi Status | ☐ | |
| 14 | T3.2 - Tolak Klaim | ☐ | |
| 15 | T3.3 - Petugas Tidak Edit | ☐ | |
| 16 | T4.1 - Create User | ☐ | |
| 17 | T4.2 - Edit User | ☐ | |
| 18 | T4.3 - Ban User | ☐ | |
| 19 | T4.4 - Reset Password | ☐ | |
| 20 | T4.5 - Create Kategori | ☐ | |
| 21 | T4.6 - Edit/Delete Kategori | ☐ | |
| 22 | T4.7 - Pengaturan Sistem | ☐ | |
| 23 | T4.8 - Export Bulanan | ☐ | |
| 24 | T4.9 - Export Tahunan | ☐ | |
| 25 | T5.1 - User Tidak Akses Admin | ☐ | |
| 26 | T5.2 - Petugas Tidak Akses Admin | ☐ | |
| 27 | T5.3 - Superadmin Akses Semua | ☐ | |
| 28 | T6.1 - Dashboard Statistik | ☐ | |
| 29 | T6.2 - Quick Actions | ☐ | |
| 30 | T7.1 - Upload Foto Valid | ☐ | |
| 31 | T7.2 - Upload Foto > Max Size | ☐ | |
| 32 | T7.3 - Upload File Non-Image | ☐ | |
| 33 | T8.1 - Notifikasi Klaim | ☐ | |
| 34 | T8.2 - Notifikasi Status | ☐ | |
| 35 | T9 - End-to-End Flow | ☐ | |
| 36 | T10.1 - Responsive Mobile | ☐ | |
| 37 | T10.2 - Form Validation | ☐ | |
| 38 | T10.3 - Flash Messages | ☐ | |

---

## 📌 NOTES

- **Database Reset:** Jalankan `php artisan migrate:fresh --seed` jika perlu reset data
- **Seeder:** Back2MeSeeder membuat 5 user biasa + admin + petugas + 4 kategori + 1 sample laporan
- **Pagination:** Beberapa halaman punya pagination (20 users, 10 laporan per halaman)
- **Notification:** Database-only, cek tabel `notifications` untuk verify notifikasi tersimpan
- **Cache:** Pengaturan sistem disimpan di cache, bukan .env

---

**Tanggal Testing:** _________________

**Tester Name:** _________________

**Overall Status:** ☐ PASS ☐ FAIL

**Notes/Issues:** 

