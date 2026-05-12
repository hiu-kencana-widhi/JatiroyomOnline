<?php

namespace Database\Seeders\Auth;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Perangkat\PenilaianPerangkat;
use Illuminate\Support\Facades\Hash;

class PerangkatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perangkatList = [
            [
                'nik' => '002',
                'nama_lengkap' => 'Ahmad Fauzi, S.Kom.',
                'password' => Hash::make('123456'),
                'role' => 'perangkat_desa',
                'jabatan' => 'Sekretaris Desa',
                'status_aktif' => true,
            ],
            [
                'nik' => '003',
                'nama_lengkap' => 'Rina Mulyani, S.E.',
                'password' => Hash::make('123456'),
                'role' => 'perangkat_desa',
                'jabatan' => 'Kaur Keuangan',
                'status_aktif' => true,
            ],
            [
                'nik' => '004',
                'nama_lengkap' => 'Hadi Suwito',
                'password' => Hash::make('123456'),
                'role' => 'perangkat_desa',
                'jabatan' => 'Kepala Dusun Krajan',
                'status_aktif' => true,
            ],
        ];

        foreach ($perangkatList as $p) {
            $user = User::create($p);

            // Tambahkan 1 atau 2 penilaian awal sebagai contoh agar halaman depan langsung terlihat hidup
            PenilaianPerangkat::create([
                'perangkat_id' => $user->id,
                'rating' => 5,
                'ulasan' => 'Pelayanan sangat cepat, ramah, dan sangat membantu urusan administrasi warga.',
                'status_tampil' => true,
            ]);
        }
    }
}
