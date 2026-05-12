<?php

namespace App\Models\Laporan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LaporanWarga extends Model
{
    use HasFactory;

    protected $table = 'laporan_warga';

    protected $fillable = [
        'user_id',
        'kategori',
        'judul_laporan',
        'deskripsi',
        'foto_bukti',
        'latitude',
        'longitude',
        'alamat_lokasi',
        'status',
        'catatan_tanggapan',
    ];

    /**
     * Relasi ke entitas User (Warga Pelapor)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
