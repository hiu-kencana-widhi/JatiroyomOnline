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
        Schema::create('pengajuan_surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat')->onDelete('cascade');
            $table->string('nomor_surat', 50)->unique()->nullable()->comment('Filled upon confirmation');
            $table->json('data_terisi');
            $table->enum('status', ['draft', 'menunggu', 'dikonfirmasi', 'ditolak', 'selesai'])->default('menunggu');
            $table->text('catatan_admin')->nullable();
            $table->string('file_drive_id', 100)->nullable();
            $table->string('file_drive_url', 500)->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('jenis_surat_id');
            $table->index('status');
            $table->index('nomor_surat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surat');
    }
};
