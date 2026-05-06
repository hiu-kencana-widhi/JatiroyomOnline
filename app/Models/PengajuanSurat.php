<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    protected $table = 'pengajuan_surat';

    protected $fillable = [
        'user_id',
        'jenis_surat_id',
        'nomor_surat',
        'data_terisi',
        'status',
        'catatan_admin',
        'file_drive_id',
        'file_drive_url',
    ];

    protected $casts = [
        'data_terisi' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }
}
