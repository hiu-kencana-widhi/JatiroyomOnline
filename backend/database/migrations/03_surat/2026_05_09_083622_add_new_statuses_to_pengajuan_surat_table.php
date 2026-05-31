<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengajuan_surat', function (Blueprint $table) {
            $table->enum('status', ['draft', 'menunggu', 'disetujui', 'siap_diambil', 'ditolak', 'selesai'])->default('menunggu')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_surat', function (Blueprint $table) {
            $table->enum('status', ['draft', 'menunggu', 'dikonfirmasi', 'ditolak', 'selesai'])->default('menunggu')->change();
        });
    }
};
