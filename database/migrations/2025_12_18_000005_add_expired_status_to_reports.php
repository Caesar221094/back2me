<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah 'expired' ke enum status
        DB::statement("ALTER TABLE reports MODIFY COLUMN status ENUM('pending','diproses','selesai','ditolak','expired') DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Rollback: hapus 'expired' dari enum
        DB::statement("ALTER TABLE reports MODIFY COLUMN status ENUM('pending','diproses','selesai','ditolak') DEFAULT 'pending'");
    }
};
