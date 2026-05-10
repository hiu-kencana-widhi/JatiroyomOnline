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
        Schema::create('jenis_surat', function (Blueprint $table) {
            $table->id();
            $table->string('kode_surat', 20)->unique();
            $table->string('nama_surat', 100);
            $table->text('deskripsi')->nullable();
            $table->longText('template_html')->comment('HTML with placeholder {field}');
            $table->json('field_diperlukan')->comment('List of fields required from user');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();

            $table->index('kode_surat');
            $table->index('is_aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_surat');
    }
};
