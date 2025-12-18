# 🔐 Role-Based Access Control (RBAC) - Back2Me

## Overview

Back2Me menggunakan sistem role-based access control dengan 3 role utama:
- **SuperAdmin** - Akses penuh ke semua fitur
- **Petugas** - Verifikasi laporan dan lihat klaim
- **User** - Buat laporan, klaim barang, kelola laporan sendiri

---

## 📋 Permission Matrix

| Fitur | User | Petugas | SuperAdmin |
|-------|------|---------|------------|
| **Dashboard** | ✅ View | ✅ View | ✅ View |
| **Lihat Semua Laporan** | ✅ View | ✅ View | ✅ View |
| **Buat Laporan Baru** | ✅ Create | ❌ Denied | ✅ Create |
| **Edit Laporan Sendiri** | ✅ Edit (pending) | ❌ Denied | ✅ Edit (pending) |
| **Klaim Barang** | ✅ Claim | ❌ View only | ✅ Claim |
| **Approve/Reject Klaim** | ✅ (Pelapor) | ❌ | ✅ (Pelapor) |
| **Verifikasi Laporan** | ❌ | ✅ Verify | ✅ Verify |
| **Konfirmasi Penerimaan** | ✅ (Pengklaim) | ❌ | ✅ (Pengklaim) |
| **Kelola User** | ❌ | ❌ | ✅ Full CRUD |
| **Kelola Kategori** | ❌ | ❌ | ✅ Full CRUD |
| **System Settings** | ❌ | ❌ | ✅ Configure |
| **Export Laporan** | ❌ | ❌ | ✅ Export |

---

## 🎯 Role Capabilities

### 👤 **User (Regular)**

**Dapat melakukan:**
- ✅ Login dan akses dashboard
- ✅ Lihat semua laporan (hilang & ditemukan)
- ✅ Buat laporan baru dengan foto (max 5 foto @ 5MB)
- ✅ Edit laporan sendiri (hanya saat status `pending`)
- ✅ Filter/search laporan (kategori, lokasi, keyword, status)
- ✅ Klaim barang ditemukan dengan upload bukti kepemilikan
- ✅ Approve/reject klaim pada laporan milik sendiri (sebagai pelapor)
- ✅ Konfirmasi penerimaan barang (setelah petugas verify)
- ✅ Lihat notifikasi

**Tidak dapat melakukan:**
- ❌ Ubah status laporan (verify/reject)
- ❌ Akses panel admin
- ❌ Kelola user lain
- ❌ Edit laporan setelah status berubah dari `pending`
- ❌ Klaim laporan sendiri

### 👮 **Petugas**

**Dapat melakukan:**
- ✅ Login dan akses dashboard
- ✅ Lihat semua laporan
- ✅ Filter laporan berdasarkan status (khususnya `diproses`)
- ✅ Verifikasi laporan (ubah status: diproses → selesai/ditolak)
- ✅ Lihat bukti kepemilikan dari pengklaim
- ✅ Cocokkan bukti dengan data laporan
- ✅ Lihat notifikasi klaim baru

**Tidak dapat melakukan:**
- ❌ Buat laporan baru (petugas tidak boleh jadi pelapor)
- ❌ Edit/hapus laporan
- ❌ Klaim barang
- ❌ Akses panel admin
- ❌ Kelola user/kategori
- ❌ Export laporan

**Sidebar Menu (Petugas):**
- Dashboard
- Semua Laporan
- ~~Buat Laporan~~ (hidden)
- Verifikasi (dengan badge count)

### 👑 **SuperAdmin**

**Dapat melakukan:**
- ✅ Semua fitur User
- ✅ Semua fitur Petugas
- ✅ **User Management:**
  - Create, edit, delete user
  - Reset password user
  - Ban/unban user
  - Ubah role user
- ✅ **Category Management:**
  - Create, edit, delete kategori
  - Atur deskripsi kategori
- ✅ **System Settings:**
  - Atur max upload size (1-10 MB)
  - Atur max file count (1-10 files)
  - Atur claim timeout (1-365 hari)
  - Atur auto close period (30-365 hari)
- ✅ **Report Export:**
  - Export laporan bulanan (CSV)
  - Export laporan tahunan (CSV)
  - Statistik per kategori dan status
  - Breakdown per bulan

**Sidebar Menu (SuperAdmin):**
- Dashboard
- Semua Laporan
- Buat Laporan
- Verifikasi (dengan badge count)
- **Admin Section:**
  - Pengguna
  - Kategori
  - Pengaturan
  - Export Laporan

---

## 🛡️ Implementation Details

### 1. **Middleware Protection**

File: `app/Http/Middleware/EnsureRole.php`

```php
// Usage in routes:
Route::middleware('role:superadmin')->group(...);
Route::middleware('role:petugas|superadmin')->group(...);
```

**Routes yang dilindungi:**
- `/back2me/admin/*` → `role:superadmin`
- `/back2me/reports/{id}/verify` → `role:petugas|superadmin`

### 2. **Controller-Level Authorization**

File: `app/Http/Controllers/ReportController.php`

**Create/Store:**
```php
public function create() {
    if (auth()->user()->role === 'petugas') {
        abort(403, 'Petugas tidak diizinkan membuat laporan');
    }
}
```

**Edit/Update:**
```php
public function edit(Report $report) {
    // Block petugas
    if (auth()->user()->role === 'petugas') {
        abort(403);
    }
    // Block non-owner
    if ($report->user_id !== auth()->id()) {
        abort(403);
    }
}
```

**Verify:**
```php
public function verify(Request $request, Report $report) {
    // Cek pelapor sudah approve
    if ($report->pelapor_approval !== 'approved') {
        return redirect()->back()->with('error', 'Pelapor belum approve');
    }
}
```

### 3. **View-Level Conditional Rendering**

File: `resources/views/layouts/sidebar.blade.php`

```blade
@if($role !== 'petugas')
    <li class="menu-item">
        <a href="{{ route('back2me.reports.create') }}">
            Buat Laporan
        </a>
    </li>
@endif

@if(in_array($role, ['petugas','superadmin']))
    <li class="menu-item">
        <a href="...">Verifikasi</a>
    </li>
@endif

@if($role === 'superadmin')
    <!-- Admin Menu Section -->
@endif
```

File: `resources/views/back2me/reports/index.blade.php`

```blade
@if(auth()->user()->role !== 'petugas')
    <a href="{{ route('back2me.reports.create') }}" class="btn-primary">
        Buat Laporan
    </a>
@endif
```

File: `resources/views/back2me/reports/show.blade.php`

```blade
{{-- Klaim form - hanya user, bukan pemilik laporan --}}
@if(auth()->user()->role === 'user' && auth()->id() !== $report->user_id)
    <form method="post" action="{{ route('back2me.reports.claim', $report) }}">
        ...
    </form>
@endif

{{-- Edit button - hanya pemilik, bukan petugas --}}
@if(auth()->id() === $report->user_id && $report->status === 'pending' && auth()->user()->role !== 'petugas')
    <a href="{{ route('back2me.reports.edit', $report) }}" class="btn-secondary">
        Edit Laporan
    </a>
@endif

{{-- Verify form - hanya petugas & superadmin --}}
@if(in_array(auth()->user()->role, ['petugas','superadmin']))
    <form method="post" action="{{ route('back2me.reports.verify', $report) }}">
        ...
    </form>
@endif
```

---

## 🚨 Security Checklist

### ✅ Implemented

- [x] Middleware `role` di routes untuk admin panel
- [x] Controller-level authorization di create/edit/update
- [x] View-level conditional rendering berdasarkan role
- [x] Ban check di middleware (akun ter-ban tidak bisa akses)
- [x] Ownership check (user hanya bisa edit laporan sendiri)
- [x] Status check (edit hanya saat `pending`)
- [x] Approval workflow (3-step: claim → pelapor approve → petugas verify)

### 🔒 Best Practices

1. **Defense in Depth:**
   - Middleware (route level)
   - Controller (business logic level)
   - View (UI level)

2. **Fail-Safe Defaults:**
   - Default role: `user`
   - Banned users: blocked di middleware
   - Unknown role: abort 403

3. **Clear Error Messages:**
   - "Petugas tidak diizinkan membuat laporan"
   - "Anda tidak memiliki akses untuk mengedit laporan ini"
   - "Tidak dapat edit setelah diverifikasi"

---

## 📝 Testing Role Permissions

### Test Petugas Restrictions

```bash
# Login sebagai petugas@back2me.test
# Coba akses:
GET /back2me/reports/create        → 403 Forbidden ✅
POST /back2me/reports               → 403 Forbidden ✅
GET /back2me/admin/users            → 403 Forbidden ✅
GET /back2me/reports/{id}/verify    → 200 OK ✅
```

### Test User Restrictions

```bash
# Login sebagai user@back2me.test
# Coba akses:
GET /back2me/admin/users                → 403 Forbidden ✅
GET /back2me/reports/create             → 200 OK ✅
GET /back2me/reports/{id}/edit          → 200 OK (jika owner) ✅
GET /back2me/reports/{other_user}/edit  → 403 Forbidden ✅
```

### Test SuperAdmin Access

```bash
# Login sebagai admin@back2me.test
# Coba akses:
GET /back2me/admin/users                → 200 OK ✅
GET /back2me/admin/categories           → 200 OK ✅
GET /back2me/admin/settings             → 200 OK ✅
GET /back2me/admin/reports/export       → 200 OK ✅
POST /back2me/reports/{id}/verify       → 200 OK ✅
```

---

## 🎯 Summary

### Pembatasan Utama:

1. **Petugas tidak boleh:**
   - ❌ Buat laporan
   - ❌ Edit laporan
   - ❌ Klaim barang
   - ❌ Akses admin panel

2. **User tidak boleh:**
   - ❌ Verifikasi laporan
   - ❌ Akses admin panel
   - ❌ Edit laporan orang lain
   - ❌ Klaim laporan sendiri

3. **SuperAdmin bisa:**
   - ✅ Semua yang bisa User lakukan
   - ✅ Semua yang bisa Petugas lakukan
   - ✅ Kelola user, kategori, settings
   - ✅ Export laporan

### Workflow Approval (3-Step):

1. **User** klaim dengan bukti kepemilikan
2. **Pelapor** (user yang buat laporan) approve/reject klaim
3. **Petugas/SuperAdmin** verify dan ubah status → selesai/ditolak
4. **Pengklaim** konfirmasi penerimaan barang

---

**Last Updated:** 18 December 2025  
**Laravel Version:** 12  
**Authentication:** Laravel Breeze
