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
        Schema::create('penilaian_perangkat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perangkat_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('warga_id')->nullable()->constrained('users')->onDelete('set null');
            $table->tinyInteger('rating')->unsigned()->comment('Bintang 1 sampai 5');
            $table->text('ulasan');
            $table->boolean('status_tampil')->default(true)->comment('Moderasi tayang di halaman publik');
            $table->timestamps();

            $table->index('perangkat_id');
            $table->index('status_tampil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_perangkat');
    }
};
