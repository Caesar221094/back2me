<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Report;
use Illuminate\Support\Facades\Hash;

class Back2MeSeeder extends Seeder
{
    public function run(): void
    {
        // ===== USERS =====
        // 1. SuperAdmin
        $admin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@back2me.test',
            'role' => 'superadmin',
            'password' => Hash::make('password123'),
        ]);

        // 2. Petugas
        $petugas = User::factory()->create([
            'name' => 'Petugas Ahmad',
            'email' => 'petugas@back2me.test',
            'role' => 'petugas',
            'password' => Hash::make('password123'),
        ]);

        // 3-7. Regular Users (untuk test claim/approval)
        $user1 = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@back2me.test',
            'role' => 'user',
            'password' => Hash::make('password123'),
        ]);

        $user2 = User::factory()->create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@back2me.test',
            'role' => 'user',
            'password' => Hash::make('password123'),
        ]);

        $user3 = User::factory()->create([
            'name' => 'Andi Wijaya',
            'email' => 'andi@back2me.test',
            'role' => 'user',
            'password' => Hash::make('password123'),
        ]);

        $user4 = User::factory()->create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi@back2me.test',
            'role' => 'user',
            'password' => Hash::make('password123'),
        ]);

        $user5 = User::factory()->create([
            'name' => 'Rudi Hartono',
            'email' => 'rudi@back2me.test',
            'role' => 'user',
            'password' => Hash::make('password123'),
        ]);

        // ===== CATEGORIES =====
        $elektronik = Category::create(['nama' => 'Elektronik', 'deskripsi' => 'HP, laptop, charger, earphone']);
        $pakaian = Category::create(['nama' => 'Pakaian', 'deskripsi' => 'Jaket, kaos, sepatu, tas']);
        $aksesoris = Category::create(['nama' => 'Aksesoris', 'deskripsi' => 'Jam tangan, kacamata, gelang']);
        $dokumen = Category::create(['nama' => 'Dokumen', 'deskripsi' => 'KTP, SIM, ijazah, sertifikat']);
        $kendaraan = Category::create(['nama' => 'Kendaraan', 'deskripsi' => 'Motor, mobil, sepeda']);

        // ===== SAMPLE REPORTS =====
        
        // 1. Barang HILANG - HP (pending)
        Report::create([
            'user_id' => $user1->id,
            'category_id' => $elektronik->id,
            'tipe' => 'hilang',
            'judul' => 'HP Samsung A50 Hilang di Kampus',
            'deskripsi' => 'HP Samsung A50 warna biru, casing hitam dengan stiker BTS. Hilang di area parkiran kampus sekitar pukul 14.00. Ada screensaver foto keluarga.',
            'lokasi' => 'Parkiran Kampus Gedung A',
            'status' => 'pending',
        ]);

        // 2. Barang DITEMUKAN - Dompet (pending)
        Report::create([
            'user_id' => $user2->id,
            'category_id' => $aksesoris->id,
            'tipe' => 'ditemukan',
            'judul' => 'Dompet Coklat Ditemukan di Perpustakaan',
            'deskripsi' => 'Dompet kulit warna coklat merk Braun Buffel. Ditemukan di meja baca perpustakaan lantai 2. Isi: beberapa kartu dan uang.',
            'lokasi' => 'Perpustakaan Lantai 2',
            'status' => 'pending',
        ]);

        // 3. Barang HILANG - Jaket (pending)
        Report::create([
            'user_id' => $user3->id,
            'category_id' => $pakaian->id,
            'tipe' => 'hilang',
            'judul' => 'Jaket Hitam Adidas Hilang',
            'deskripsi' => 'Jaket hoodie Adidas hitam ukuran M. Ada tulisan nama "ANDI" di bagian dalam label. Hilang saat main futsal.',
            'lokasi' => 'Lapangan Futsal Kampus',
            'status' => 'pending',
        ]);

        // 4. Barang DITEMUKAN - Kunci Motor (pending)
        Report::create([
            'user_id' => $user4->id,
            'category_id' => $kendaraan->id,
            'tipe' => 'ditemukan',
            'judul' => 'Kunci Motor Honda Ditemukan',
            'deskripsi' => 'Kunci motor Honda Beat dengan gantungan kunci mini Doraemon. Ditemukan di kantin.',
            'lokasi' => 'Kantin Kampus',
            'status' => 'pending',
        ]);

        // 5. Barang HILANG - Laptop (diproses - sudah diklaim)
        Report::create([
            'user_id' => $user1->id,
            'category_id' => $elektronik->id,
            'tipe' => 'hilang',
            'judul' => 'Laptop Asus X441U Hilang di Kelas',
            'deskripsi' => 'Laptop Asus X441U warna hitam dengan stiker coding di belakang layar. Serial number: ABC123XYZ. Hilang saat kuliah di ruang 301.',
            'lokasi' => 'Ruang Kelas 301',
            'status' => 'diproses',
            'claimed_by' => $user5->id,
            'claimed_at' => now()->subHours(2),
            'catatan_klaim' => 'Ini laptop saya, ada stiker Python dan JavaScript di belakang. Serial numbernya cocok dengan yang saya catat saat beli.',
            'pelapor_approval' => 'pending',
        ]);

        // 6. Barang DITEMUKAN - KTP (selesai - sudah diklaim & verified)
        Report::create([
            'user_id' => $user2->id,
            'category_id' => $dokumen->id,
            'tipe' => 'ditemukan',
            'judul' => 'KTP atas nama Ahmad Fauzi Ditemukan',
            'deskripsi' => 'KTP atas nama Ahmad Fauzi. NIK: 3201xxxxxxxxxx. Ditemukan di toilet gedung B.',
            'lokasi' => 'Toilet Gedung B Lantai 1',
            'status' => 'selesai',
            'claimed_by' => $user3->id,
            'claimed_at' => now()->subDays(1),
            'catatan_klaim' => 'Ini KTP saya, saya tadi pagi ke toilet dan lupa taruh di situ. Nama dan NIK cocok dengan identitas saya.',
            'pelapor_approval' => 'approved',
            'pelapor_approved_at' => now()->subDays(1)->addHours(1),
        ]);

        // 7. Barang HILANG - Tas (ditolak)
        Report::create([
            'user_id' => $user4->id,
            'category_id' => $pakaian->id,
            'tipe' => 'hilang',
            'judul' => 'Tas Ransel Nike Hitam Hilang',
            'deskripsi' => 'Tas ransel Nike warna hitam dengan logo swoosh putih. Isi: buku tulis dan kotak makan.',
            'lokasi' => 'Musholla Kampus',
            'status' => 'ditolak',
        ]);

        // 8. Barang DITEMUKAN - Kacamata (pending)
        Report::create([
            'user_id' => $user5->id,
            'category_id' => $aksesoris->id,
            'tipe' => 'ditemukan',
            'judul' => 'Kacamata Hitam Ditemukan di Parkiran',
            'deskripsi' => 'Kacamata hitam merk Rayban (model Wayfarer). Frame hitam glossy. Ditemukan di parkiran motor.',
            'lokasi' => 'Parkiran Motor Area C',
            'status' => 'pending',
        ]);

        // 9. Barang HILANG - Charger (pending)
        Report::create([
            'user_id' => $user3->id,
            'category_id' => $elektronik->id,
            'tipe' => 'hilang',
            'judul' => 'Charger iPhone Original Hilang',
            'deskripsi' => 'Charger iPhone original warna putih dengan kabel lightning sepanjang 1 meter. Hilang di ruang multimedia.',
            'lokasi' => 'Ruang Multimedia Gedung D',
            'status' => 'pending',
        ]);

        // 10. Barang DITEMUKAN - Jam Tangan (pending)
        Report::create([
            'user_id' => $user1->id,
            'category_id' => $aksesoris->id,
            'tipe' => 'ditemukan',
            'judul' => 'Jam Tangan Casio Ditemukan',
            'deskripsi' => 'Jam tangan Casio G-Shock warna hitam. Model digital dengan banyak tombol. Ditemukan di gym.',
            'lokasi' => 'Gym Kampus',
            'status' => 'pending',
        ]);
    }
}
