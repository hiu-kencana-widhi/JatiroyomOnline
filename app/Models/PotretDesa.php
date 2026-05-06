<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PotretDesa extends Model
{
    protected $table = 'potret_desa';
    protected $fillable = ['judul', 'deskripsi', 'gambar', 'is_aktif'];
}
