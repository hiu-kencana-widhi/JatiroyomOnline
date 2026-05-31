<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah tipe ENUM pada kolom role menggunakan raw statement agar aman tanpa dependensi doctrine/dbal
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user', 'admin', 'perangkat_desa') DEFAULT 'user'");

        Schema::table('users', function (Blueprint $table) {
            $table->string('jabatan', 100)->nullable()->after('role');
            $table->string('foto_profil')->nullable()->after('jabatan');
            $table->boolean('status_aktif')->default(true)->after('foto_profil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['jabatan', 'foto_profil', 'status_aktif']);
        });

        // Kembalikan ENUM ke kondisi semula
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user', 'admin') DEFAULT 'user'");
    }
};
