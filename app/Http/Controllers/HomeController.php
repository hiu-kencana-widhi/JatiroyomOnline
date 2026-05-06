<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $acara = \App\Models\AcaraDesa::where('is_aktif', true)
            ->where('tanggal', '>=', now())
            ->orderBy('tanggal', 'asc')
            ->take(4)
            ->get();

        $anggaran = \App\Models\AnggaranDesa::where('is_active', true)->first();
        
        $potret = \App\Models\PotretDesa::where('is_aktif', true)->latest()->get();
        
        $settings = \App\Models\Pengaturan::pluck('value', 'key');

        return view('home', compact('acara', 'anggaran', 'settings', 'potret'));
    }

    public function downloadAnggaran()
    {
        $anggaran = \App\Models\AnggaranDesa::where('is_active', true)->firstOrFail();
        
        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($anggaran->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->download($anggaran->file_path, $anggaran->judul . '.' . pathinfo($anggaran->file_path, PATHINFO_EXTENSION));
    }
}
