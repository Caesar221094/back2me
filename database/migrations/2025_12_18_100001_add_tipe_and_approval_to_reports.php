<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Tambah tipe laporan: hilang atau ditemukan
            $table->enum('tipe', ['hilang', 'ditemukan'])->after('judul')->default('hilang');
            
            // Bukti kepemilikan saat claim
            $table->json('bukti_klaim')->nullable()->after('claimed_at');
            $table->text('catatan_klaim')->nullable()->after('bukti_klaim');
            
            // Approval dari pelapor
            $table->enum('pelapor_approval', ['pending', 'approved', 'rejected'])->nullable()->after('catatan_klaim');
            $table->timestamp('pelapor_approved_at')->nullable()->after('pelapor_approval');
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn([
                'tipe',
                'bukti_klaim',
                'catatan_klaim',
                'pelapor_approval',
                'pelapor_approved_at',
            ]);
        });
    }
};
