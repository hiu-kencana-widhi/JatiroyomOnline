<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitialSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'nama_desa', 'value' => 'Jatiroyom'],
            ['key' => 'kecamatan', 'value' => 'Bodeh'],
            ['key' => 'kabupaten', 'value' => 'Pemalang'],
            ['key' => 'kontak', 'value' => '0812-3456-7890'],
            ['key' => 'email', 'value' => 'pemdes@jatiroyom.desa.id'],
            ['key' => 'profil_desa', 'value' => 'Desa Jatiroyom adalah desa yang asri dan sedang bertransformasi menuju desa digital untuk pelayanan warga yang lebih baik.'],
            ['key' => 'gambar_slider', 'value' => json_encode(['slider1.jpg', 'slider2.jpg'])],
        ];

        foreach ($settings as $setting) {
            \App\Models\Pengaturan::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }

        // Sample Event
        $admin = \App\Models\User::where('role', 'admin')->first();
        if ($admin) {
            \App\Models\AcaraDesa::create([
                'judul' => 'Musyawarah Desa (Musdes)',
                'deskripsi' => 'Pembahasan RKPDes Tahun Anggaran 2026.',
                'tanggal' => now()->addDays(7),
                'lokasi' => 'Balai Desa Jatiroyom',
                'created_by' => $admin->id,
            ]);

            \App\Models\AcaraDesa::create([
                'judul' => 'Posyandu Balita & Lansia',
                'deskripsi' => 'Pemeriksaan kesehatan rutin warga.',
                'tanggal' => now()->addDays(3),
                'lokasi' => 'Polindes Jatiroyom',
                'created_by' => $admin->id,
            ]);
        }
    }
}
