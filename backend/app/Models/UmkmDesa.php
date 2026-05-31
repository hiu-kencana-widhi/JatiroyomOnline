<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UmkmDesa extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang diasosiasikan dengan model.
     *
     * @var string
     */
    protected $table = 'umkm_desa';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'nama_usaha',
        'nama_produk',
        'kategori',
        'deskripsi',
        'harga',
        'satuan',
        'foto_produk',
        'nomor_whatsapp',
        'status_verifikasi',
    ];

    /**
     * Tipe pemetaan (casting) untuk atribut tertentu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'harga' => 'integer',
    ];

    /**
     * Mendapatkan entitas pemilik usaha (User / Warga).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
