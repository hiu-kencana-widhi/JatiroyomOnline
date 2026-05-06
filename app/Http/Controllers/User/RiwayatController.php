<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayat = \App\Models\PengajuanSurat::where('user_id', auth()->id())
            ->with('jenisSurat')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('user.riwayat', compact('riwayat'));
    }

    public function download(\App\Models\PengajuanSurat $pengajuan)
    {
        // Pastikan hanya pemilik yang bisa download
        if ($pengajuan->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$pengajuan->file_drive_url) {
            return back()->with('error', 'File surat belum tersedia.');
        }

        return redirect()->away($pengajuan->file_drive_url);
    }
}
