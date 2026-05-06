<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    protected $table = 'jenis_surat';

    protected $fillable = [
        'kode_surat',
        'nama_surat',
        'deskripsi',
        'template_html',
        'field_diperlukan',
        'is_aktif',
    ];

    protected $casts = [
        'field_diperlukan' => 'array',
        'is_aktif' => 'boolean',
    ];

    public function pengajuanSurat()
    {
        return $this->hasMany(PengajuanSurat::class);
    }
}
