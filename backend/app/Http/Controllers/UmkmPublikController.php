<?php

namespace App\Http\Controllers;

use App\Models\UmkmDesa;
use Illuminate\Http\Request;

class UmkmPublikController extends Controller
{
    /**
     * Menampilkan katalog digital produk UMKM desa yang telah lolos verifikasi kepada publik.
     */
    public function index(Request $request)
    {
        $query = UmkmDesa::with('user')->where('status_verifikasi', 'Disetujui')->latest();

        // Fitur pencarian kata kunci
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('nama_produk', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Fitur saringan kategori produk
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Ambil kategori unik yang tersedia untuk ditampilkan sebagai tab filter
        $kategoriList = ['Kuliner', 'Kerajinan', 'Hasil Tani', 'Jasa', 'Lainnya'];

        $umkm = $query->paginate(12)->withQueryString();

        return view('umkm.index', compact('umkm', 'kategoriList'));
    }
}
