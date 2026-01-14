# Flowchart Utama Back2Me

```mermaid
flowchart TD
    A[User buka /back2me] --> B{Sudah login?}
    B -- Tidak --> L[Halaman Login] --> A
    B -- Ya --> C[Halaman Daftar Laporan]

    C -->|Buat laporan baru| D[Form Laporan]
    D --> E[Simpan laporan (status = pending)]
    E --> C

    C -->|Lihat detail laporan| F[Halaman Detail Laporan]

    %% Klaim oleh user lain
    F -->|User lain klik "Klaim"| G[Form Klaim + Upload Bukti]
    G --> H[Set claimed_by, bukti_klaim, status = diproses]

    %% Review oleh pelapor
    H --> I[Pelapor review klaim]
    I -->|Setuju| J[Update pelapor_approval = approved\nstatus = selesai]
    I -->|Tolak| K[Reset klaim,\nstatus = pending] --> C

    %% Konfirmasi penerimaan oleh pengklaim
    J --> M[Pengklaim klik "Konfirmasi Diterima"]
    M --> N[Set confirmed_by, confirmed_at]
    N --> O[Laporan Selesai (arsip)]

    %% Verifikasi petugas / superadmin (opsional/moderasi)
    C -->|Petugas/Superadmin pilih laporan| P[Form Verifikasi Petugas]
    P --> Q[Update status: pending/diproses/selesai/ditolak/expired]
    Q --> C
```
