<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_warga' => \App\Models\User::where('role', 'user')->count(),
            'permohonan_baru' => \App\Models\PengajuanSurat::where('status', 'menunggu')->count(),
            'surat_terbit' => \App\Models\PengajuanSurat::where('status', 'dikonfirmasi')->count(),
            'acara_aktif' => \App\Models\AcaraDesa::where('is_aktif', true)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
