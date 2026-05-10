<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';
    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'aktivitas',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function record($aktivitas, $keterangan = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'aktivitas' => $aktivitas,
            'keterangan' => $keterangan,
        ]);
    }
}
