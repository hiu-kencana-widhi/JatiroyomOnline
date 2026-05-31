<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumumanDesa extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang dipetakan oleh model ini.
     *
     * @var string
     */
    protected $table = 'pengumuman_desa';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'isi_pengumuman',
        'tipe_spanduk',
        'file_lampiran',
        'tanggal_selesai',
        'status_aktif',
    ];

    /**
     * Pendaftaran konversi tipe data (type casting).
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_selesai' => 'datetime',
        'status_aktif'    => 'boolean',
    ];
}
