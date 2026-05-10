<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $stats = [
            'menunggu' => \App\Models\Surat\PengajuanSurat::where('user_id', $user->id)->where('status', 'menunggu')->count(),
            'selesai' => \App\Models\Surat\PengajuanSurat::where('user_id', $user->id)->whereIn('status', ['disetujui', 'siap_diambil', 'selesai'])->count(),
            'ditolak' => \App\Models\Surat\PengajuanSurat::where('user_id', $user->id)->where('status', 'ditolak')->count(),
        ];

        $pengajuanTerbaru = \App\Models\Surat\PengajuanSurat::where('user_id', $user->id)
            ->with('jenisSurat')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('user.dashboard', compact('stats', 'pengajuanTerbaru'));
    }
}
