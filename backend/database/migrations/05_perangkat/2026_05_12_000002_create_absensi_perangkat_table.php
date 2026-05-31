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
        Schema::create('absensi_perangkat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('waktu_masuk')->nullable();
            $table->time('waktu_keluar')->nullable();
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alpa'])->default('Hadir');
            $table->enum('status_konfirmasi_masuk', ['Menunggu', 'Terkonfirmasi', 'Ditolak'])->default('Menunggu');
            $table->enum('status_konfirmasi_keluar', ['Menunggu', 'Terkonfirmasi', 'Ditolak'])->default('Menunggu');
            $table->string('foto_masuk')->nullable()->comment('Path swafoto pagi saat check-in');
            $table->string('foto_keluar')->nullable()->comment('Path swafoto sore saat check-out');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Memastikan satu perangkat desa hanya memiliki 1 catatan absensi per tanggal
            $table->unique(['user_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_perangkat');
    }
};
