<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Surat\PengajuanSurat;
use App\Models\Master\AcaraDesa;
use App\Models\Master\JenisSurat;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_warga' => User::where('role', 'user')->count(),
            'permohonan_baru' => PengajuanSurat::where('status', 'menunggu')->count(),
            'surat_terbit' => PengajuanSurat::whereIn('status', ['disetujui', 'siap_diambil', 'selesai'])->count(),
            'acara_aktif' => AcaraDesa::where('is_aktif', true)->count(),
            'total_layanan' => JenisSurat::count(),
        ];

        // Eager load relationships for the recent permohonan
        $recentPermohonan = PengajuanSurat::with(['user', 'jenisSurat'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPermohonan'));
    }
}
