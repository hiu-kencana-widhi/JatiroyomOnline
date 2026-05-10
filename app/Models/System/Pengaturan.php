<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $fillable = [
        'key',
        'value',
    ];

    public static function getAllCached()
    {
        return \Illuminate\Support\Facades\Cache::remember('village_settings', 3600, function () {
            return self::pluck('value', 'key');
        });
    }
}
