<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggaranDesa extends Model
{
    protected $table = 'anggaran_desa';

    protected $fillable = [
        'judul',
        'file_path',
        'is_active',
        'uploaded_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
