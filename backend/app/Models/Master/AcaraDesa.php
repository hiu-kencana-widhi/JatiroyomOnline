<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class AcaraDesa extends Model
{
    protected $table = 'acara_desa';

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'lokasi',
        'gambar',
        'is_aktif',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_aktif' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
