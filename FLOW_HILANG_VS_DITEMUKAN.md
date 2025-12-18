# 🔄 Perbedaan Flow: BARANG HILANG vs BARANG DITEMUKAN

## 📊 Overview

Back2Me mendukung 2 tipe laporan dengan **flow yang sama**, hanya berbeda konteks:

| Tipe | Pelapor | Pengklaim | Tujuan |
|------|---------|-----------|---------|
| **HILANG** | Pemilik yang kehilangan | Penemu yang menemukan | Cari orang yang menemukan barang |
| **DITEMUKAN** | Penemu yang menemukan | Pemilik yang kehilangan | Cari pemilik asli barang |

---

## 🔴 TIPE 1: BARANG HILANG

### Konteks
Pemilik **kehilangan** barang → Buat laporan untuk **minta bantuan** orang menemukan

### Flow Lengkap

```
┌─────────────────────────────────────────────────────────────────┐
│  STEP 1: Pemilik Lapor Kehilangan                               │
└─────────────────────────────────────────────────────────────────┘

👤 Budi (Pemilik): 
   "HP Samsung A50 saya hilang di kampus!"
   
   📝 Isi Laporan:
   ├─ Tipe: HILANG 🔴
   ├─ Judul: "HP Samsung A50 Hilang"
   ├─ Deskripsi: "Warna biru, casing hitam, ada stiker BTS"
   ├─ Lokasi: "Parkiran Gedung A"
   └─ Foto: [foto HP saat masih ada / foto similar]
   
   📌 Status: PENDING
   💭 Harapan: "Semoga ada yang menemukan dan klaim"


┌─────────────────────────────────────────────────────────────────┐
│  STEP 2: Penemu Menemukan & Klaim                               │
└─────────────────────────────────────────────────────────────────┘

👤 Siti (Penemu):
   "Eh, saya menemukan HP di parkiran. Mungkin ini yang Budi cari?"
   
   🔍 Aksi:
   ├─ Lihat Laporan Budi
   ├─ Klik "Klaim Barang Ini"
   └─ Upload Bukti:
      ├─ Foto HP yang ditemukan (bukti fisik)
      └─ Catatan: "Saya temukan HP ini jam 14.00 di parkiran,
                   warna biru, ada stiker BTS"
   
   📌 Status: DIPROSES
   🔔 Notifikasi ke: Budi (pemilik/pelapor)


┌─────────────────────────────────────────────────────────────────┐
│  STEP 3: Pemilik Verifikasi & Approve                           │
└─────────────────────────────────────────────────────────────────┘

👤 Budi (Pemilik/Pelapor):
   🔍 Cek foto & catatan dari Siti
   
   ✅ SCENARIO A: APPROVE
      Budi: "Ya, ini HP saya! Foto dan deskripsi cocok"
      
      Aksi:
      ├─ Klik "Setujui Klaim"
      ├─ Status: SELESAI ✅
      ├─ Kontak Siti muncul otomatis:
      │  ├─ 📱 0821-9876-5432
      │  ├─ 💬 WhatsApp: 6282198765432
      │  └─ 📧 siti@back2me.test
      └─ Budi hubungi Siti untuk ambil HP
   
   ❌ SCENARIO B: REJECT
      Budi: "Bukan HP saya, warnanya beda"
      
      Aksi:
      ├─ Klik "Tolak Klaim"
      ├─ Status: PENDING (kembali terbuka)
      └─ Orang lain bisa klaim lagi


┌─────────────────────────────────────────────────────────────────┐
│  STEP 4: COD & Konfirmasi Penerimaan                            │
└─────────────────────────────────────────────────────────────────┘

📱 Budi chat Siti via WhatsApp:
   "Halo kak, saya Budi pemilik HP. Bisa ketemu kapan?"

💬 Siti reply:
   "Bisa besok jam 10 di kantin kampus"

📦 COD (Cash On Delivery):
   ├─ Budi & Siti bertemu
   ├─ Siti serahkan HP
   └─ Budi terima HP

✅ Konfirmasi:
   ├─ Budi login → buka laporan
   ├─ Klik "Barang Sudah Diterima"
   └─ Status: SELESAI + CONFIRMED

✨ Case closed! HP kembali ke Budi
```

### Summary HILANG

| Step | Aktor | Aksi |
|------|-------|------|
| 1 | **Pemilik** (Budi) | Lapor kehilangan |
| 2 | **Penemu** (Siti) | Klaim dengan bukti temuan |
| 3 | **Pemilik** (Budi) | Approve/reject klaim |
| 4 | **Pemilik** (Budi) | Konfirmasi penerimaan |

**Hasil:** HP kembali ke Budi (pemilik) ✅

---

## 🟢 TIPE 2: BARANG DITEMUKAN

### Konteks
Penemu **menemukan** barang orang lain → Buat laporan untuk **cari pemilik asli**

### Flow Lengkap

```
┌─────────────────────────────────────────────────────────────────┐
│  STEP 1: Penemu Lapor Penemuan                                  │
└─────────────────────────────────────────────────────────────────┘

👤 Siti (Penemu):
   "Saya menemukan dompet coklat di perpustakaan!"
   
   📝 Isi Laporan:
   ├─ Tipe: DITEMUKAN 🟢
   ├─ Judul: "Dompet Coklat Ditemukan"
   ├─ Deskripsi: "Dompet kulit coklat merk Braun Buffel, ada KTP"
   ├─ Lokasi: "Perpustakaan Lantai 2"
   └─ Foto: [foto dompet yang ditemukan - aktual]
   
   📌 Status: PENDING
   💭 Harapan: "Semoga pemiliknya cepat klaim"


┌─────────────────────────────────────────────────────────────────┐
│  STEP 2: Pemilik Asli Klaim                                     │
└─────────────────────────────────────────────────────────────────┘

👤 Andi (Pemilik Asli):
   "Eh, ini dompet saya yang hilang kemarin!"
   
   🔍 Aksi:
   ├─ Lihat Laporan Siti
   ├─ Klik "Klaim Barang Ini"
   └─ Upload Bukti Kepemilikan:
      ├─ Foto KTP yang di dalam dompet
      ├─ Foto struk pembelian dompet (jika ada)
      └─ Catatan: "Ini dompet saya, di dalam ada KTP 
                   atas nama Andi Wijaya NIK 3201xxx"
   
   📌 Status: DIPROSES
   🔔 Notifikasi ke: Siti (penemu/pelapor)


┌─────────────────────────────────────────────────────────────────┐
│  STEP 3: Penemu Verifikasi & Approve                            │
└─────────────────────────────────────────────────────────────────┘

👤 Siti (Penemu/Pelapor):
   🔍 Cek bukti dari Andi
   
   ✅ SCENARIO A: APPROVE
      Siti: "Ya, KTP nya cocok dengan yang di dompet!"
      
      Aksi:
      ├─ Klik "Setujui Klaim"
      ├─ Status: SELESAI ✅
      ├─ Kontak Andi muncul otomatis:
      │  ├─ 📱 0813-5555-6666
      │  ├─ 💬 WhatsApp: 6281355556666
      │  └─ 📧 andi@back2me.test
      └─ Siti hubungi Andi untuk serahkan dompet
   
   ❌ SCENARIO B: REJECT
      Siti: "KTP tidak cocok, bukan pemiliknya"
      
      Aksi:
      ├─ Klik "Tolak Klaim"
      ├─ Status: PENDING (kembali terbuka)
      └─ Orang lain bisa klaim lagi


┌─────────────────────────────────────────────────────────────────┐
│  STEP 4: COD & Konfirmasi Penerimaan                            │
└─────────────────────────────────────────────────────────────────┘

📱 Siti chat Andi via WhatsApp:
   "Halo pak, saya Siti yang menemukan dompet. Bisa ketemu kapan?"

💬 Andi reply:
   "Wah terima kasih! Bisa sore ini jam 3 di kantin?"

📦 COD (Cash On Delivery):
   ├─ Siti & Andi bertemu
   ├─ Siti serahkan dompet
   └─ Andi terima dompet

✅ Konfirmasi:
   ├─ Andi login → buka laporan
   ├─ Klik "Barang Sudah Diterima"
   └─ Status: SELESAI + CONFIRMED

✨ Case closed! Dompet kembali ke Andi
```

### Summary DITEMUKAN

| Step | Aktor | Aksi |
|------|-------|------|
| 1 | **Penemu** (Siti) | Lapor penemuan |
| 2 | **Pemilik** (Andi) | Klaim dengan bukti kepemilikan |
| 3 | **Penemu** (Siti) | Approve/reject klaim |
| 4 | **Pemilik** (Andi) | Konfirmasi penerimaan |

**Hasil:** Dompet kembali ke Andi (pemilik) ✅

---

## 🔄 Perbandingan Detail

### Perbedaan Utama

| Aspek | HILANG 🔴 | DITEMUKAN 🟢 |
|-------|-----------|--------------|
| **Pelapor** | Pemilik yang kehilangan | Penemu yang menemukan |
| **Konteks Laporan** | "Saya kehilangan [barang]" | "Saya menemukan [barang]" |
| **Foto Laporan** | Foto barang saat masih ada (atau similar) | Foto barang yang ditemukan (aktual) |
| **Yang Klaim** | Orang yang **menemukan** barang | Orang yang **kehilangan** (pemilik asli) |
| **Bukti Klaim** | Foto barang yang ditemukan | Bukti kepemilikan (KTP, struk, foto lama, dll) |
| **Yang Approve** | Pemilik asli (pelapor) | Penemu (pelapor) |
| **Tujuan Approve** | "Ya, ini barang saya yang hilang" | "Ya, ini pemilik yang benar" |
| **Badge Color** | 🟡 Amber (kuning) | 🟢 Green (hijau) |
| **Hasil Akhir** | Pemilik **terima kembali** barang | Pemilik **terima kembali** barang |

### Persamaan

✅ **Flow teknis persis sama:**
1. Pelapor buat laporan → **PENDING**
2. User lain klaim dengan bukti → **DIPROSES**
3. Pelapor approve klaim → **SELESAI** (kontak muncul)
4. COD → Konfirmasi → **CONFIRMED**

✅ **Fitur sama:**
- Upload foto (max 5)
- Bukti kepemilikan wajib
- Kontak otomatis setelah approve
- Notifikasi real-time
- Konfirmasi penerimaan

---

## 💡 Contoh Real Case

### Case 1: HP HILANG 📱

```
Budi kehilangan HP → Lapor (HILANG)
      ↓
Siti menemukan HP di parkiran → Klaim dengan foto HP
      ↓
Budi cek foto → Approve ("ini HP saya!")
      ↓
Kontak Siti muncul → Budi chat via WA
      ↓
Ketemu di kantin → Siti serahkan HP
      ↓
HP kembali ke Budi ✅
```

### Case 2: Dompet DITEMUKAN 💰

```
Siti menemukan dompet → Lapor (DITEMUKAN)
      ↓
Andi kehilangan dompet → Klaim dengan foto KTP
      ↓
Siti cek KTP → Approve ("ini pemiliknya!")
      ↓
Kontak Andi muncul → Siti chat via WA
      ↓
Ketemu di perpus → Siti serahkan dompet
      ↓
Dompet kembali ke Andi ✅
```

**Hasil sama:** Barang kembali ke pemilik asli! 🎉

---

## 🤔 FAQ

### Q1: Kalau saya kehilangan HP, tipe apa yang dipilih?
**A:** **HILANG** - karena Anda yang kehilangan barang

### Q2: Kalau saya menemukan dompet, tipe apa?
**A:** **DITEMUKAN** - karena Anda yang menemukan barang

### Q3: Siapa yang berhak approve klaim?
**A:** **Selalu pelapor** (yang buat laporan awal)
- Laporan HILANG → Pemilik yang approve
- Laporan DITEMUKAN → Penemu yang approve

### Q4: Bedanya apa di sistem?
**A:** Hanya visual:
- **HILANG:** 🟡 Badge kuning "Hilang"
- **DITEMUKAN:** 🟢 Badge hijau "Ditemukan"

### Q5: Flow proses beda?
**A:** **TIDAK!** Flow persis sama, hanya konteks berbeda

### Q6: Kalau salah pilih tipe, bisa edit?
**A:** Bisa edit selama status masih **PENDING**. Setelah ada klaim, tidak bisa edit lagi.

### Q7: Boleh buat 2 laporan sekaligus (HILANG + DITEMUKAN)?
**A:** Boleh! Misalnya:
- Laporan 1: HP hilang (HILANG)
- Laporan 2: Menemukan jaket (DITEMUKAN)

### Q8: Siapa yang dapat notifikasi?
**A:**
- **HILANG:** Pemilik dapat notif saat ada yang klaim
- **DITEMUKAN:** Penemu dapat notif saat ada yang klaim

---

## 🎯 Kesimpulan

### Inti Utama:

1. **Flow teknis sama** untuk HILANG dan DITEMUKAN
2. **Perbedaan hanya konteks:**
   - Siapa yang buat laporan (pemilik vs penemu)
   - Siapa yang klaim (penemu vs pemilik)
   - Jenis bukti (foto temuan vs bukti kepemilikan)

3. **Tujuan akhir sama:** Barang kembali ke pemilik asli!

### Decision Tree Sederhana:

```
Pertanyaan: Apa yang terjadi dengan barang?

├─ Saya KEHILANGAN barang
│  └─ Pilih: HILANG 🔴
│     └─ Harapan: Ada yang menemukan & klaim
│
└─ Saya MENEMUKAN barang orang lain
   └─ Pilih: DITEMUKAN 🟢
      └─ Harapan: Pemilik asli klaim
```

---

## 📊 Statistics Flow

### Average Time to Resolve:

**Scenario HILANG:**
- Pemilik lapor: 5 menit
- Penemu klaim: 10 menit
- Pemilik approve: 5 menit
- COD: 1-24 jam
- **Total:** 1-2 hari ⚡

**Scenario DITEMUKAN:**
- Penemu lapor: 5 menit
- Pemilik klaim: 15 menit (cari bukti)
- Penemu approve: 5 menit
- COD: 1-24 jam
- **Total:** 1-2 hari ⚡

**Success Rate:** 90%+ jika bukti valid dan koordinasi lancar

---

## 🚀 Tips Sukses

### Untuk Pelapor HILANG:
1. ✅ Deskripsi detail (warna, merk, ciri khas)
2. ✅ Upload foto jelas (jika punya)
3. ✅ Cepat approve jika bukti valid
4. ✅ Isi nomor WA untuk koordinasi

### Untuk Pelapor DITEMUKAN:
1. ✅ Foto barang yang ditemukan
2. ✅ Sebutkan ciri-ciri di deskripsi
3. ✅ Cek bukti kepemilikan dengan teliti
4. ✅ Isi nomor WA untuk koordinasi

### Untuk Pengklaim:
1. ✅ Upload bukti jelas (foto/dokumen)
2. ✅ Catatan min 20 karakter (jelaskan detail)
3. ✅ Respons cepat setelah approve
4. ✅ Koordinasi COD via WA/HP

---

**Last Updated:** 18 December 2025  
**Version:** 2.0 (Simplified Workflow)
