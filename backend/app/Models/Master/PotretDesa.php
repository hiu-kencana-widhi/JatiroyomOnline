<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class PotretDesa extends Model
{
    protected $table = 'potret_desa';
    protected $fillable = ['judul', 'deskripsi', 'gambar', 'is_aktif'];
}
