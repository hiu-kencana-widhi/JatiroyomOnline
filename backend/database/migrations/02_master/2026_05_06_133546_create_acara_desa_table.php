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
        Schema::create('acara_desa', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');
            $table->string('lokasi', 255)->nullable();
            $table->string('gambar', 255)->nullable()->comment('Path in storage');
            $table->boolean('is_aktif')->default(true);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index('tanggal');
            $table->index('is_aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acara_desa');
    }
};
