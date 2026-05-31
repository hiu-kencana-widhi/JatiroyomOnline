<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Surat\PengajuanSurat;
use App\Models\Perangkat\AbsensiPerangkat;
use App\Models\Perangkat\PenilaianPerangkat;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nik',
        'nama_lengkap',
        'no_kk',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'alamat',
        'rt_rw',
        'password',
        'role',
        'jabatan',
        'foto_profil',
        'status_aktif',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
            'status_aktif' => 'boolean',
        ];
    }

    public function pengajuanSurat()
    {
        return $this->hasMany(PengajuanSurat::class);
    }

    /**
     * Relasi riwayat absensi (khusus role perangkat_desa).
     */
    public function absensi()
    {
        return $this->hasMany(AbsensiPerangkat::class, 'user_id');
    }

    /**
     * Relasi ulasan/penilaian yang diterima (khusus role perangkat_desa).
     */
    public function penilaian()
    {
        return $this->hasMany(PenilaianPerangkat::class, 'perangkat_id');
    }
}
