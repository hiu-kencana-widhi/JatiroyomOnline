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
            'menunggu' => \App\Models\PengajuanSurat::where('user_id', $user->id)->where('status', 'menunggu')->count(),
            'selesai' => \App\Models\PengajuanSurat::where('user_id', $user->id)->where('status', 'dikonfirmasi')->count(),
            'ditolak' => \App\Models\PengajuanSurat::where('user_id', $user->id)->where('status', 'ditolak')->count(),
        ];

        $pengajuanTerbaru = \App\Models\PengajuanSurat::where('user_id', $user->id)
            ->with('jenisSurat')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('user.dashboard', compact('stats', 'pengajuanTerbaru'));
    }
}
