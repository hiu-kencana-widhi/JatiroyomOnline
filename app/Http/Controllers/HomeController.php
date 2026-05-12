<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $acara = \App\Models\Master\AcaraDesa::where('is_aktif', true)
            ->where('tanggal', '>=', now())
            ->orderBy('tanggal', 'asc')
            ->take(3)
            ->get();

        $anggaran = \App\Models\Master\AnggaranDesa::where('is_active', true)->first();
        
        $potret = \App\Models\Master\PotretDesa::where('is_aktif', true)->latest()->get();
        
        $settings = \App\Models\System\Pengaturan::getAllCached();

        $perangkat = \App\Models\User::with(['penilaian' => function ($q) {
            $q->where('status_tampil', true)->with('warga')->latest();
        }])->where('role', 'perangkat_desa')
          ->where('status_aktif', true)
          ->get();

        return view('home', compact('acara', 'anggaran', 'settings', 'potret', 'perangkat'));
    }

    public function acara()
    {
        $acara = \App\Models\Master\AcaraDesa::where('is_aktif', true)
            ->orderBy('tanggal', 'desc')
            ->paginate(9);
        
        $settings = \App\Models\System\Pengaturan::getAllCached();

        return view('acara', compact('acara', 'settings'));
    }

    public function anggaran()
    {
        $anggaran = \App\Models\Master\AnggaranDesa::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $settings = \App\Models\System\Pengaturan::getAllCached();

        return view('anggaran', compact('anggaran', 'settings'));
    }

    public function downloadAnggaran(\App\Models\Master\AnggaranDesa $anggaran)
    {
        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($anggaran->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->download($anggaran->file_path, $anggaran->judul . '.' . pathinfo($anggaran->file_path, PATHINFO_EXTENSION));
    }
}
