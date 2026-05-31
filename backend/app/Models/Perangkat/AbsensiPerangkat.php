<?php

namespace App\Models\Perangkat;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AbsensiPerangkat extends Model
{
    protected $table = 'absensi_perangkat';

    protected $fillable = [
        'user_id',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'status',
        'status_konfirmasi_masuk',
        'status_konfirmasi_keluar',
        'foto_masuk',
        'foto_keluar',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    /**
     * Relasi ke model User (Perangkat Desa).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
