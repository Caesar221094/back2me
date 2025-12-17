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
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@back2me.test',
            'role' => 'superadmin',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Petugas',
            'email' => 'petugas@back2me.test',
            'role' => 'petugas',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->count(5)->create();

        $cats = ['Elektronik','Pakaian','Aksesoris','Dokumen'];
        foreach ($cats as $c) {
            Category::create(['nama' => $c]);
        }

        // sample report
        Report::create([
            'user_id' => 3,
            'category_id' => 1,
            'judul' => 'Handphone hilang',
            'deskripsi' => 'Samsung A50 hilang di kampus',
            'lokasi' => 'Perpustakaan',
        ]);
    }
}
