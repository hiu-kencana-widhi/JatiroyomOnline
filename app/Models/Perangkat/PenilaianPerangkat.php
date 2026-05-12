<?php

namespace App\Models\Perangkat;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PenilaianPerangkat extends Model
{
    protected $table = 'penilaian_perangkat';

    protected $fillable = [
        'perangkat_id',
        'warga_id',
        'rating',
        'ulasan',
        'status_tampil',
    ];

    protected function casts(): array
    {
        return [
            'status_tampil' => 'boolean',
            'rating' => 'integer',
        ];
    }

    /**
     * Relasi ke User sebagai Perangkat Desa yang dinilai.
     */
    public function perangkat()
    {
        return $this->belongsTo(User::class, 'perangkat_id');
    }

    /**
     * Relasi ke User sebagai Warga yang memberikan penilaian.
     */
    public function warga()
    {
        return $this->belongsTo(User::class, 'warga_id');
    }
}
