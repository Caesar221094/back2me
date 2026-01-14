# LAPORAN PROYEK
## APLIKASI BACK2ME: SISTEM INFORMASI LOST & FOUND BERBASIS WEB DENGAN ROLE-BASED ACCESS CONTROL

### Sekolah Tinggi Teknologi Informasi NIIT
### Tahun Akademik 2022/2023

---

## KATA PENGANTAR

Segala puji dan syukur penulis panjatkan ke hadirat Allah SWT atas rahmat dan karunia-Nya sehingga penulis dapat menyelesaikan laporan proyek dengan judul **"Aplikasi Back2Me: Sistem Informasi Lost & Found Berbasis Web dengan Role-Based Access Control"** tepat pada waktunya.

Proyek ini disusun sebagai salah satu syarat kelulusan mata kuliah Proyek di Sekolah Tinggi Teknologi Informasi NIIT. Laporan ini juga diharapkan dapat menjadi salah satu luaran yang siap dipublikasikan dalam bentuk Buku ber-ISBN, serta dapat dikembangkan lebih lanjut menjadi artikel jurnal nasional maupun Hak Kekayaan Intelektual (HKI).

Dalam proses penyusunan laporan ini, penulis mendapatkan banyak bantuan, bimbingan, dan dukungan dari berbagai pihak. Untuk itu, pada kesempatan ini penulis menyampaikan terima kasih kepada:

1. Allah SWT atas kesehatan dan kelapangan waktu yang diberikan.
2. Bapak/Ibu Dosen pembimbing Proyek yang telah memberikan arahan, masukan, dan koreksi selama proses pengerjaan.
3. Pimpinan dan seluruh civitas akademika STTI NIIT yang telah menyediakan fasilitas dan kesempatan untuk melaksanakan proyek ini.
4. Rekan-rekan mahasiswa yang telah memberikan bantuan, dukungan, serta diskusi konstruktif selama proses pengembangan sistem Back2Me.
5. Semua pihak yang tidak dapat penulis sebutkan satu per satu yang telah membantu secara langsung maupun tidak langsung.

Penulis menyadari bahwa laporan ini masih jauh dari sempurna. Oleh karena itu, kritik dan saran yang membangun sangat penulis harapkan demi perbaikan dan pengembangan di masa yang akan datang. Semoga laporan ini dapat memberikan manfaat, baik bagi penulis sendiri, pihak kampus, maupun pembaca secara umum.


**Jakarta, Desember 2025**  
Penulis

---

## ABSTRAK

Kehilangan dan penemuan barang di lingkungan kampus merupakan permasalahan yang sering terjadi dan berulang. Selama ini proses pencatatan dan penyebaran informasi barang hilang maupun ditemukan masih dilakukan secara manual, misalnya melalui papan pengumuman fisik, grup pesan instan, atau informasi lisan. Cara ini memiliki beberapa kelemahan, antara lain informasi mudah hilang, sulit ditelusuri kembali, tidak terstruktur, serta rentan terjadi miskomunikasi.

Penelitian/proyek ini menghasilkan **Back2Me**, sebuah aplikasi web sistem informasi *lost & found* yang dirancang untuk memfasilitasi proses pelaporan barang hilang dan penemuan barang di lingkungan kampus. Aplikasi ini dibangun menggunakan framework **Laravel** dengan arsitektur berbasis **Model-View-Controller (MVC)**, memanfaatkan **Laravel Breeze** untuk autentikasi, **Tailwind CSS** untuk antarmuka, serta **MySQL** sebagai basis data. Sistem menerapkan **role-based access control** dengan tiga peran utama, yaitu *superadmin*, *petugas*, dan *user* (mahasiswa/dosen), sehingga setiap aktivitas sesuai dengan kewenangan dan tanggung jawab masing-masing.

Metodologi pengembangan yang digunakan mengacu pada konsep **System Development Life Cycle (SDLC)** dengan tahapan analisis kebutuhan, perancangan sistem, implementasi, serta pengujian fungsional. Fitur utama Back2Me meliputi: pembuatan laporan barang hilang/ditemukan, klaim barang oleh user, proses verifikasi dan perubahan status oleh petugas, konfirmasi penerimaan barang oleh pemilik, manajemen kategori dan pengguna oleh superadmin, serta notifikasi internal berbasis database.

Hasil pengujian menunjukkan bahwa sistem mampu menangani skenario utama proses *lost & found* di kampus, mulai dari pelaporan, pencarian, klaim, verifikasi, hingga konfirmasi penerimaan barang. Penerapan role-based access control berhasil membatasi akses fitur sesuai peran, sehingga meningkatkan keamanan dan kejelasan alur kerja. Dengan demikian, Back2Me dapat menjadi solusi digital yang membantu kampus dalam mengelola data barang hilang dan ditemukan secara lebih terstruktur, transparan, dan mudah ditelusuri.

**Kata kunci**: Sistem Informasi, Lost and Found, Laravel, Role-Based Access Control, SDLC, Web Application

---

## BAB I
# PENDAHULUAN

### 1.1 Latar Belakang

Kehilangan barang pribadi seperti telepon genggam, dompet, kartu identitas, maupun peralatan belajar merupakan kejadian yang cukup sering dialami oleh mahasiswa, dosen, maupun staf di lingkungan kampus. Di sisi lain, tidak jarang barang-barang tersebut sebenarnya ditemukan oleh pihak lain, namun pemiliknya sulit diidentifikasi atau dihubungi karena tidak adanya media informasi yang terpusat dan terstruktur.

Selama ini proses penanganan barang hilang dan ditemukan (*lost and found*) di banyak perguruan tinggi masih dilakukan secara manual, misalnya melalui pengumuman di papan informasi fisik, penyebaran pesan melalui grup aplikasi perpesanan, atau komunikasi lisan. Pendekatan manual ini memiliki sejumlah kelemahan:

1. Informasi tidak terdokumentasi dengan baik dan sulit ditelusuri kembali.
2. Tidak ada mekanisme pencarian berdasarkan kategori, lokasi, atau status barang.
3. Risiko duplikasi informasi dan kebingungan terkait status barang (misalnya sudah kembali ke pemilik atau belum).
4. Tidak ada jejak proses klaim dan verifikasi, sehingga berpotensi menimbulkan sengketa atau klaim palsu.

Seiring dengan perkembangan teknologi informasi dan meningkatnya kebutuhan digitalisasi layanan kampus, dibutuhkan suatu sistem informasi *lost & found* berbasis web yang mampu mengelola data barang hilang dan ditemukan secara terpusat, transparan, dan mudah diakses. Sistem ini diharapkan dapat menjadi sarana yang mempermudah proses pelaporan, pencarian, klaim, serta verifikasi barang oleh pihak terkait.

Berdasarkan permasalahan tersebut, penulis mengembangkan aplikasi **Back2Me**, yaitu sebuah sistem informasi *lost & found* berbasis web dengan dukungan **role-based access control** yang memisahkan peran dan hak akses antara *superadmin*, *petugas*, dan *user*. Dengan adanya sistem ini, diharapkan proses penanganan barang hilang dan ditemukan di lingkungan kampus menjadi lebih efektif, efisien, dan dapat dipertanggungjawabkan.

### 1.2 Rumusan Masalah

Berdasarkan latar belakang di atas, maka rumusan masalah dalam proyek ini adalah sebagai berikut:

1. Bagaimana merancang dan membangun sistem informasi *lost & found* berbasis web yang dapat digunakan untuk mencatat dan mengelola laporan barang hilang maupun ditemukan di lingkungan kampus?
2. Bagaimana menerapkan mekanisme **role-based access control** sehingga setiap pengguna (superadmin, petugas, user) memiliki hak akses dan fungsi yang sesuai dengan perannya?
3. Bagaimana merancang alur kerja (workflow) klaim barang yang melibatkan pelapor, pengklaim, dan petugas, sehingga proses verifikasi dapat berjalan dengan jelas dan terdokumentasi?
4. Bagaimana mengimplementasikan fitur pencarian dan filter laporan agar pengguna dapat dengan mudah menemukan data barang hilang/ditemukan berdasarkan kata kunci, kategori, lokasi, dan status?

### 1.3 Tujuan Proyek

Tujuan dari proyek pengembangan sistem Back2Me ini adalah:

1. Menghasilkan aplikasi web sistem informasi *lost & found* yang dapat digunakan sebagai media terpusat untuk pelaporan dan pengelolaan barang hilang maupun ditemukan di lingkungan kampus.
2. Menerapkan **role-based access control** pada sistem sehingga hak akses dan fitur yang tersedia bagi pengguna sesuai dengan perannya (superadmin, petugas, user).
3. Menyediakan alur proses klaim, verifikasi, dan konfirmasi penerimaan barang yang jelas, terdokumentasi, dan dapat diawasi oleh petugas.
4. Menyediakan fitur pencarian dan filter laporan berdasarkan kata kunci, kategori, lokasi, dan status untuk mempermudah pengguna menemukan informasi yang relevan.
5. Mendokumentasikan seluruh proses analisis, perancangan, implementasi, dan pengujian sistem dalam bentuk laporan yang sesuai dengan pedoman penulisan proyek di STTI NIIT.

### 1.4 Manfaat Proyek

Adapun manfaat yang diharapkan dari proyek ini adalah:

1. **Bagi Kampus**: Memiliki sistem informasi terpusat untuk mengelola data barang hilang dan ditemukan, sehingga meningkatkan pelayanan kepada civitas akademika dan mengurangi potensi kehilangan permanen.
2. **Bagi Mahasiswa/Dosen**: Mempermudah pelaporan dan pencarian barang hilang/ditemukan, sehingga kemungkinan barang kembali ke pemilik menjadi lebih besar.
3. **Bagi Petugas**: Membantu proses verifikasi klaim dan pencatatan status barang secara lebih terstruktur, dengan riwayat aktivitas yang terdokumentasi.
4. **Bagi Pengembang (Mahasiswa)**: Menjadi wahana penerapan ilmu yang telah dipelajari, khususnya dalam pengembangan sistem informasi berbasis web, perancangan basis data, konsep keamanan dan otorisasi, serta penulisan karya ilmiah.

---

## BAB II
# KONSEP DAN ANALISIS SISTEM

### 2.1 Landasan Teori

#### 2.1.1 Sistem Informasi

Sistem informasi adalah suatu sistem yang terdiri dari komponen-komponen yang saling berhubungan untuk mengumpulkan, memproses, menyimpan, dan mendistribusikan informasi guna mendukung pengambilan keputusan dan pengendalian dalam suatu organisasi. Dalam konteks ini, Back2Me berfungsi sebagai sistem informasi yang mengelola data barang hilang dan ditemukan di lingkungan kampus.

#### 2.1.2 Aplikasi Web

Aplikasi web merupakan aplikasi yang diakses melalui jaringan menggunakan protokol HTTP/HTTPS dan dijalankan pada browser. Keunggulan aplikasi web antara lain kemudahan akses tanpa instalasi khusus di sisi klien, pemeliharaan terpusat di sisi server, dan kemudahan integrasi dengan layanan lain.

#### 2.1.3 Model-View-Controller (MVC)

Laravel sebagai framework utama Back2Me menerapkan pola arsitektur **Model-View-Controller (MVC)**, yang memisahkan logika aplikasi (Model dan Controller) dari lapisan presentasi (View). Pola ini membantu menjaga keteraturan struktur kode, memudahkan pengembangan, dan meningkatkan kemampuan pemeliharaan sistem.

#### 2.1.4 Role-Based Access Control (RBAC)

Role-Based Access Control (RBAC) adalah mekanisme pengendalian akses yang memberikan hak akses kepada pengguna berdasarkan peran (role) yang dimilikinya. Dalam Back2Me, terdapat tiga peran utama, yaitu **superadmin**, **petugas**, dan **user**. Masing-masing peran memiliki hak akses berbeda terhadap fitur sistem, misalnya superadmin dapat mengelola akun pengguna dan kategori, petugas dapat memverifikasi laporan dan klaim, sedangkan user dapat membuat laporan dan melakukan klaim.

#### 2.1.5 SDLC (System Development Life Cycle)

Pengembangan Back2Me mengacu pada konsep **System Development Life Cycle (SDLC)** dengan tahapan utama: perencanaan, analisis kebutuhan, perancangan, implementasi, dan pengujian. Meskipun penerapan di proyek ini bersifat adaptif, prinsip-prinsip SDLC tetap digunakan sebagai kerangka umum dalam menyusun aktivitas pengembangan.

#### 2.1.6 UML (Unified Modeling Language)

Unified Modeling Language (UML) adalah bahasa pemodelan standar yang digunakan untuk memvisualisasikan, menspesifikasikan, membangun, dan mendokumentasikan artefak sistem perangkat lunak. Diagram UML yang relevan untuk Back2Me antara lain **Use Case Diagram**, **Activity Diagram**, **Sequence Diagram**, dan **Class Diagram**.

#### 2.1.7 Framework Laravel

Laravel merupakan framework PHP modern yang mendukung pengembangan aplikasi web dengan sintaks yang ekspresif dan elegan. Fitur utama yang dimanfaatkan dalam Back2Me antara lain routing, Eloquent ORM, migrasi database, autentikasi, middleware, dan sistem notifikasi.

### 2.2 Penelitian dan Sistem Terkait

Beberapa penelitian dan sistem terkait yang menjadi referensi dalam pengembangan Back2Me antara lain:

1. Sistem informasi *lost and found* berbasis web di lingkungan kampus yang memfasilitasi pelaporan barang hilang dan ditemukan.
2. Penerapan role-based access control pada aplikasi web untuk memisahkan hak akses admin, petugas, dan user.
3. Penggunaan Laravel sebagai framework utama dalam pengembangan sistem informasi kampus.
4. Implementasi notifikasi internal berbasis database untuk menggantikan notifikasi melalui email atau SMS.

(Detail sitasi dan referensi lengkap akan disusun pada bagian Daftar Pustaka, minimal 9 referensi dari jurnal, buku, atau prosiding 10 tahun terakhir.)

### 2.3 Analisis Masalah

Permasalahan utama yang hendak dipecahkan oleh Back2Me dapat dirangkum sebagai berikut:

1. Tidak adanya sistem terpusat untuk mencatat dan mengelola data barang hilang dan ditemukan di kampus.
2. Ketiadaan mekanisme klaim yang jelas dan terdokumentasi antara pelapor, pengklaim, dan petugas.
3. Sulitnya melakukan pencarian barang berdasarkan kategori, lokasi, dan status melalui media pengumuman manual.
4. Potensi penyalahgunaan informasi atau klaim palsu jika tidak ada peran petugas yang melakukan verifikasi.

### 2.4 Analisis Kebutuhan Tingkat Tinggi

Berdasarkan analisis masalah, kebutuhan tingkat tinggi (high-level requirements) dari sistem Back2Me adalah:

1. Sistem harus mampu menyimpan dan menampilkan data laporan barang hilang/ditemukan beserta foto pendukung.
2. Sistem harus menyediakan mekanisme klaim barang oleh user lain dengan menyertakan bukti kepemilikan.
3. Sistem harus mendukung proses verifikasi dan perubahan status laporan oleh petugas dan/atau pelapor.
4. Sistem harus mengelola peran pengguna dan hak akses melalui mekanisme role-based access control.
5. Sistem harus menyediakan fitur pencarian dan filter berdasarkan kata kunci, kategori, lokasi, dan status.

---

## BAB III
# ANALISIS KEBUTUHAN SISTEM

### 3.1 Kebutuhan Fungsional

Berikut adalah beberapa kebutuhan fungsional utama sistem Back2Me:

1. **Manajemen Autentikasi**
   - Sistem harus menyediakan fitur registrasi dan login pengguna.
   - Sistem harus membedakan peran pengguna menjadi superadmin, petugas, dan user.

2. **Manajemen Laporan**
   - User dapat membuat laporan barang hilang maupun ditemukan.
   - User hanya dapat mengedit laporan yang dibuat sendiri dan masih berstatus pending.
   - Laporan menyimpan informasi judul, deskripsi, lokasi, kategori, tipe (hilang/ditemukan), foto, dan status.

3. **Klaim Barang**
   - User (bukan pemilik laporan) dapat melakukan klaim terhadap laporan tertentu.
   - User harus mengunggah bukti kepemilikan berupa foto dan mengisi catatan klaim.
   - Sistem menyimpan data klaim, termasuk pengklaim, waktu klaim, bukti, dan catatan.

4. **Verifikasi dan Status**
   - Pelapor dapat menyetujui atau menolak klaim yang masuk.
   - Petugas dapat melakukan override status laporan jika ditemukan indikasi penipuan atau kesalahan.
   - Sistem mengelola status laporan: pending, diproses, selesai, ditolak, dan (opsional) expired.

5. **Konfirmasi Penerimaan Barang**
   - Pengklaim dapat melakukan konfirmasi bahwa barang benar-benar telah diterima.
   - Sistem mencatat waktu dan identitas pihak yang melakukan konfirmasi.

6. **Manajemen Pengguna (Superadmin)**
   - Superadmin dapat melihat daftar pengguna.
   - Superadmin dapat membuat, mengedit, menghapus, melakukan ban/unban, dan reset password pengguna.

7. **Manajemen Kategori (Superadmin)**
   - Superadmin dapat membuat, mengedit, dan menghapus kategori barang.

8. **Pengaturan Sistem (Superadmin)**
   - Superadmin dapat mengatur batas ukuran upload, jumlah maksimal file, dan parameter lain terkait workflow.

9. **Pencarian dan Filter**
   - Pengguna dapat mencari laporan berdasarkan kata kunci pada judul dan deskripsi.
   - Pengguna dapat memfilter laporan berdasarkan kategori, tipe, lokasi, dan status.

10. **Notifikasi Internal**
    - Sistem mengirim notifikasi internal ketika terjadi peristiwa penting (misalnya laporan diklaim, klaim disetujui, barang dikonfirmasi diterima).

### 3.2 Kebutuhan Non-Fungsional

Beberapa kebutuhan non-fungsional Back2Me antara lain:

1. **Keamanan**
   - Sistem harus menerapkan autentikasi dan otorisasi yang baik.
   - Hanya pengguna yang terautentikasi yang dapat mengakses modul utama Back2Me.
   - Banned user tidak boleh mengakses fitur Back2Me.

2. **Kinerja**
   - Sistem mampu menangani jumlah laporan dan pengguna yang wajar di lingkungan kampus tanpa penurunan kinerja signifikan.

3. **Kegunaan (Usability)**
   - Antarmuka harus sederhana, responsif, dan mudah digunakan oleh mahasiswa maupun petugas.

4. **Portabilitas**
   - Aplikasi dapat dijalankan pada server web dengan dukungan PHP dan MySQL standar.

5. **Keandalan (Reliability)**
   - Data laporan dan klaim harus tersimpan secara konsisten dan aman di basis data.

---

## BAB IV
# PERANCANGAN SISTEM

### 4.1 Use Case Diagram

Use Case Diagram Back2Me menggambarkan interaksi antara tiga aktor utama (superadmin, petugas, user) dengan sistem. Secara garis besar, use case meliputi:

- Use case untuk **User**: registrasi, login, membuat laporan, mengedit laporan pending, melihat daftar laporan, melakukan klaim, mengkonfirmasi penerimaan barang.
- Use case untuk **Petugas**: melihat laporan dan klaim, memverifikasi dan mengubah status laporan.
- Use case untuk **Superadmin**: manajemen pengguna, manajemen kategori, pengaturan sistem, serta akses ke fitur monitoring.

(Diagram lengkap dapat dilampirkan pada bagian Lampiran.)

### 4.2 Activity Diagram

Activity Diagram digunakan untuk memodelkan alur aktivitas utama, seperti:

1. Alur pembuatan laporan barang hilang/ditemukan.
2. Alur klaim barang oleh user lain.
3. Alur verifikasi klaim oleh pelapor.
4. Alur override status oleh petugas.

Setiap activity diagram menggambarkan langkah-langkah yang dilakukan aktor dan sistem, termasuk *decision point* ketika klaim disetujui atau ditolak.

### 4.3 Sequence Diagram

Sequence Diagram menggambarkan interaksi berurutan antara objek (user, controller, model, view, database) untuk skenario tertentu, misalnya:

- Sequence Diagram proses klaim laporan.
- Sequence Diagram proses verifikasi klaim.
- Sequence Diagram proses konfirmasi penerimaan barang.

### 4.4 Class Diagram

Class Diagram Back2Me minimal memuat kelas-kelas utama:

- **User**: menyimpan data pengguna (nama, email, password, role, status ban, kontak).
- **Report**: menyimpan data laporan (user_id, category_id, judul, deskripsi, lokasi, foto, status, klaim, konfirmasi).
- **Category**: menyimpan data kategori barang.
- **Notification** (secara konseptual): menyimpan data notifikasi internal.

Relasi antara kelas-kelas tersebut sebagian besar berbentuk one-to-many, misalnya user memiliki banyak laporan, kategori memiliki banyak laporan, dan satu laporan dapat memiliki satu relasi klaim.

---

## BAB V
# PERANCANGAN BASIS DATA

### 5.1 Desain Tabel Utama

Beberapa tabel utama dalam basis data Back2Me antara lain:

1. **users**
   - Kolom utama: id, name, email, password, role, is_banned, phone, whatsapp, timestamps.
   - Menyimpan data akun pengguna dan peran masing-masing.

2. **categories**
   - Kolom utama: id, nama, deskripsi, timestamps.
   - Menyimpan kategori barang (Elektronik, Pakaian, Aksesoris, Dokumen, Kendaraan, dll.).

3. **reports**
   - Kolom utama: id, user_id, category_id, judul, tipe (hilang/ditemukan), deskripsi, lokasi, foto (JSON), status, claimed_by, claimed_at, bukti_klaim (JSON), catatan_klaim, pelapor_approval, pelapor_approved_at, confirmed_by, confirmed_at, timestamps.
   - Menyimpan data laporan barang beserta status klaim dan konfirmasi.

4. **notifications** (bila digunakan)
   - Menyimpan notifikasi internal sistem untuk user/petugas.

### 5.2 Entity Relationship Diagram (ERD)

ERD Back2Me menggambarkan relasi antar entitas seperti berikut:

- Entitas **User** berelasi one-to-many dengan **Report** (satu user dapat membuat banyak laporan).
- Entitas **Category** berelasi one-to-many dengan **Report** (satu kategori dapat dimiliki banyak laporan).
- Entitas **User** (sebagai pengklaim) juga berelasi dengan **Report** melalui atribut claimed_by.

(ERD lengkap dalam bentuk gambar dapat disertakan pada bagian Lampiran.)

---

## BAB VI
# PERANCANGAN ANTARMUKA (UI)

### 6.1 Desain Halaman Utama Back2Me

Halaman utama Back2Me menampilkan daftar laporan barang hilang dan ditemukan dengan informasi singkat seperti judul, kategori, lokasi, status, dan badge klaim. Tersedia fitur pencarian dan filter untuk memudahkan pengguna dalam menemukan laporan tertentu.

### 6.2 Desain Halaman Form Laporan

Form pembuatan laporan berisi input:

- Judul laporan
- Tipe (hilang/ditemukan)
- Kategori barang
- Deskripsi
- Lokasi
- Upload foto (maksimal 5 file, ukuran maksimal 5 MB per file)

### 6.3 Desain Halaman Detail Laporan

Halaman detail menampilkan informasi lengkap laporan, galeri foto, status klaim, bukti klaim (jika ada), serta aksi yang dapat dilakukan sesuai role pengguna, seperti klaim barang, approve/reject klaim, dan konfirmasi penerimaan.

### 6.4 Desain Halaman Admin dan Petugas

Superadmin memiliki halaman khusus untuk mengelola pengguna, kategori, dan pengaturan sistem, sedangkan petugas memiliki tampilan daftar laporan dan klaim yang perlu diverifikasi.

(Mockup dan screenshot antarmuka dapat dimasukkan pada bagian Lampiran.)

---

## BAB VII
# IMPLEMENTASI SISTEM

### 7.1 Teknologi yang Digunakan

Implementasi Back2Me menggunakan teknologi berikut:

- **Bahasa Pemrograman**: PHP (Laravel), JavaScript.
- **Framework Backend**: Laravel (versi sesuai proyek).
- **Framework Frontend**: Laravel Breeze, Tailwind CSS.
- **Basis Data**: MySQL.
- **Tools Pendukung**: Composer, NPM, Vite, Git.

### 7.2 Struktur Proyek

Struktur direktori utama Back2Me mengikuti standar Laravel, dengan beberapa penyesuaian untuk modul Back2Me, antara lain:

- Direktori **routes**: berkas `back2me.php` yang memuat seluruh routing fitur Back2Me.
- Direktori **app/Http/Controllers**: berisi `ReportController` dan controller admin seperti `UserController`, `CategoryController`, `SettingsController`, dan `ReportExportController`.
- Direktori **app/Models**: berisi model `User`, `Category`, dan `Report`.
- Direktori **resources/views/back2me**: berisi file blade untuk tampilan.

### 7.3 Implementasi Fitur Utama

1. **Autentikasi & Role-Based Access Control**
   - Menggunakan Laravel Breeze untuk login/registrasi.
   - Middleware `EnsureRole` digunakan untuk membatasi akses berdasarkan role.

2. **Pembuatan dan Pengelolaan Laporan**
   - Implementasi terdapat pada `ReportController` dengan metode `index`, `create`, `store`, `edit`, `update`, dan `show`.
   - Validasi upload foto dengan batasan jumlah file dan ukuran.

3. **Klaim Barang dan Verifikasi**
   - Metode `claim`, `approveClaim`, dan `rejectClaim` mengatur alur klaim dan approval oleh pelapor.
   - Petugas dapat melakukan override status melalui metode `verify`.

4. **Konfirmasi Penerimaan**
   - Metode `confirmReceipt` mengatur proses konfirmasi bahwa barang telah diterima oleh pengklaim.

5. **Manajemen Pengguna dan Kategori (Superadmin)**
   - `UserController` dan `CategoryController` menyediakan fungsi CRUD pengguna dan kategori.

### 7.4 Pengujian Sistem

Pengujian dilakukan menggunakan:

- **Pengujian Fungsional Manual**: memastikan setiap fitur berjalan sesuai skenario.
- **Pengujian Otomatis (Feature Test)**: menggunakan PHPUnit untuk menguji middleware role, workflow laporan, klaim, dan verifikasi.

Hasil pengujian menunjukkan bahwa:

- User hanya dapat mengakses fitur yang sesuai dengan rolenya.
- Workflow klaim dan verifikasi berjalan sesuai desain (pending → diproses → selesai/ditolak).
- Validasi form dan upload file bekerja dengan baik.

---

## BAB VIII
# PENUTUP

### 8.1 Kesimpulan

Berdasarkan hasil analisis, perancangan, implementasi, dan pengujian yang telah dilakukan, dapat diambil beberapa kesimpulan sebagai berikut:

1. Aplikasi Back2Me berhasil dibangun sebagai sistem informasi *lost & found* berbasis web yang dapat digunakan untuk mengelola laporan barang hilang dan ditemukan di lingkungan kampus.
2. Penerapan role-based access control dengan tiga peran utama (superadmin, petugas, user) mampu membatasi akses fitur sesuai kewenangan masing-masing, sehingga meningkatkan keamanan dan kejelasan alur kerja.
3. Workflow klaim dan verifikasi yang melibatkan pelapor, pengklaim, dan petugas berhasil diimplementasikan sehingga proses pengembalian barang menjadi lebih terstruktur dan terdokumentasi.
4. Fitur pencarian dan filter laporan berdasarkan kata kunci, kategori, lokasi, dan status mempermudah pengguna dalam menemukan informasi yang relevan.

### 8.2 Saran

Untuk pengembangan lebih lanjut, beberapa saran yang dapat dipertimbangkan adalah:

1. Menambahkan integrasi notifikasi melalui email atau aplikasi pesan instan untuk mempercepat pemberitahuan kepada pengguna.
2. Menyediakan aplikasi mobile (Android/iOS) agar pengguna dapat lebih mudah mengakses sistem.
3. Mengembangkan fitur pelacakan statistik, seperti jumlah laporan per bulan, kategori barang paling sering hilang, dan tingkat keberhasilan pengembalian barang.
4. Menambahkan modul integrasi dengan sistem kepegawaian atau sistem akademik kampus untuk validasi identitas pengguna.

---

## DAFTAR PUSTAKA

*(Contoh format, silakan disesuaikan dengan sumber yang digunakan dan gaya APA)*

- Laudon, K. C., & Laudon, J. P. (2018). *Management Information Systems: Managing the Digital Firm*. Pearson.
- Pressman, R. S. (2014). *Software Engineering: A Practitioner's Approach*. McGraw-Hill.
- Sommerville, I. (2015). *Software Engineering* (10th ed.). Pearson.
- Kruchten, P. (2003). *The Rational Unified Process: An Introduction*. Addison-Wesley.
- Dokumentasi Resmi Laravel. (2025). Diakses dari https://laravel.com/docs
- Dokumentasi Resmi Tailwind CSS. (2025). Diakses dari https://tailwindcss.com/docs
- Artikel dan jurnal terkait sistem informasi lost and found (ditambahkan sesuai studi pustaka aktual).

---

## TENTANG PENULIS

*(Diisi sesuai data penulis/anggota kelompok)*

Nama      : ....................................................  
NIM       : ....................................................  
Program   : ....................................................  
Institusi : Sekolah Tinggi Teknologi Informasi NIIT

---

## LAMPIRAN

- Lampiran 1: Use Case Diagram Back2Me
- Lampiran 2: Activity Diagram
- Lampiran 3: Sequence Diagram
- Lampiran 4: Class Diagram dan ERD
- Lampiran 5: Screenshot Antarmuka Aplikasi
- Lampiran 6: Contoh Data Uji dan Hasil Pengujian
