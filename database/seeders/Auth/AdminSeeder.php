<?php

namespace Database\Seeders\Auth;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'nik' => '001',
            'nama_lengkap' => 'Administrator Desa',
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
            'role' => 'admin',
        ]);
    }
}
