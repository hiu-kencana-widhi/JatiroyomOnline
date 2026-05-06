<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class WargaSeeder extends Seeder
{
    public function run(): void
    {
        $dataWarga = [
            [
                'nik' => '3374101234560001',
                'nama_lengkap' => 'Budi Santoso',
                'no_kk' => '3374109876543210',
                'tempat_lahir' => 'Pemalang',
                'tanggal_lahir' => '1985-05-15',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'pekerjaan' => 'Wiraswasta',
                'alamat' => 'Dusun Krajan RT 01 RW 01 Desa Jatiroyom',
                'rt_rw' => '001/001',
                'role' => 'user'
            ],
            [
                'nik' => '3374101234560002',
                'nama_lengkap' => 'Siti Aminah',
                'no_kk' => '3374109876543211',
                'tempat_lahir' => 'Pemalang',
                'tanggal_lahir' => '1990-08-20',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'alamat' => 'Dusun Krajan RT 02 RW 01 Desa Jatiroyom',
                'rt_rw' => '002/001',
                'role' => 'user'
            ],
            [
                'nik' => '3374101234560003',
                'nama_lengkap' => 'Agus Wijaya',
                'no_kk' => '3374109876543212',
                'tempat_lahir' => 'Pekalongan',
                'tanggal_lahir' => '1978-02-10',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'pekerjaan' => 'Petani',
                'alamat' => 'Dusun Tengah RT 01 RW 02 Desa Jatiroyom',
                'rt_rw' => '001/002',
                'role' => 'user'
            ],
            [
                'nik' => '3374101234560004',
                'nama_lengkap' => 'Dewi Lestari',
                'no_kk' => '3374109876543213',
                'tempat_lahir' => 'Pemalang',
                'tanggal_lahir' => '1995-12-25',
                'jenis_kelamin' => 'P',
                'agama' => 'Kristen',
                'pekerjaan' => 'Guru Honorer',
                'alamat' => 'Dusun Selatan RT 03 RW 02 Desa Jatiroyom',
                'rt_rw' => '003/002',
                'role' => 'user'
            ],
            [
                'nik' => '3374101234560005',
                'nama_lengkap' => 'Ramban Supriyadi',
                'no_kk' => '3374109876543214',
                'tempat_lahir' => 'Pemalang',
                'tanggal_lahir' => '1965-07-04',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'pekerjaan' => 'Buruh Harian Lepas',
                'alamat' => 'Dusun Krajan RT 01 RW 01 Desa Jatiroyom',
                'rt_rw' => '001/001',
                'role' => 'user'
            ],
            [
                'nik' => '3374101234560006',
                'nama_lengkap' => 'Iwan Setiawan',
                'no_kk' => '3374109876543215',
                'tempat_lahir' => 'Pemalang',
                'tanggal_lahir' => '1988-11-30',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'pekerjaan' => 'Pedagang',
                'alamat' => 'Dusun Tengah RT 02 RW 02 Desa Jatiroyom',
                'rt_rw' => '002/002',
                'role' => 'user'
            ],
            [
                'nik' => '3374101234560007',
                'nama_lengkap' => 'Ani Sulastri',
                'no_kk' => '3374109876543216',
                'tempat_lahir' => 'Tegal',
                'tanggal_lahir' => '1992-04-12',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'pekerjaan' => 'Karyawan Swasta',
                'alamat' => 'Dusun Selatan RT 01 RW 03 Desa Jatiroyom',
                'rt_rw' => '001/003',
                'role' => 'user'
            ],
            [
                'nik' => '3374101234560008',
                'nama_lengkap' => 'Joko Purwanto',
                'no_kk' => '3374109876543217',
                'tempat_lahir' => 'Pemalang',
                'tanggal_lahir' => '1975-01-01',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'pekerjaan' => 'Tukang Kayu',
                'alamat' => 'Dusun Krajan RT 03 RW 01 Desa Jatiroyom',
                'rt_rw' => '003/001',
                'role' => 'user'
            ],
            [
                'nik' => '3374101234560009',
                'nama_lengkap' => 'Ratna Sari',
                'no_kk' => '3374109876543218',
                'tempat_lahir' => 'Pemalang',
                'tanggal_lahir' => '1998-09-09',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'pekerjaan' => 'Pelajar/Mahasiswa',
                'alamat' => 'Dusun Tengah RT 03 RW 02 Desa Jatiroyom',
                'rt_rw' => '003/002',
                'role' => 'user'
            ],
            [
                'nik' => '3374101234560010',
                'nama_lengkap' => 'Hendra Kurniawan',
                'no_kk' => '3374109876543219',
                'tempat_lahir' => 'Pemalang',
                'tanggal_lahir' => '1982-03-22',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'pekerjaan' => 'Supir',
                'alamat' => 'Dusun Selatan RT 02 RW 03 Desa Jatiroyom',
                'rt_rw' => '002/003',
                'role' => 'user'
            ]
        ];

        foreach ($dataWarga as $warga) {
            $warga['password'] = \Illuminate\Support\Facades\Hash::make('123456');
            User::updateOrCreate(['nik' => $warga['nik']], $warga);
        }
    }
}
