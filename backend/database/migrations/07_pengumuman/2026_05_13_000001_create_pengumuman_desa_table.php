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
        Schema::create('pengumuman_desa', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi_pengumuman');
            $table->string('tipe_spanduk')->default('info'); // info, peringatan, darurat
            $table->string('file_lampiran')->nullable();
            $table->dateTime('tanggal_selesai');
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumuman_desa');
    }
};
