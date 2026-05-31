<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perangkat\PenilaianPerangkat;

class PenilaianController extends Controller
{
    /**
     * Menyimpan ulasan dan rating kinerja dari masyarakat.
     */
    public function store(Request $request)
    {
        $request->validate([
            'perangkat_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'required|string|min:5|max:1000',
        ]);

        PenilaianPerangkat::create([
            'perangkat_id' => $request->perangkat_id,
            'warga_id' => auth()->id(),
            'rating' => $request->rating,
            'ulasan' => $request->ulasan,
            'status_tampil' => false, // Membutuhkan moderasi dari Admin sebelum dipublikasikan
        ]);

        return back()->with('success', 'Apresiasi & ulasan Anda berhasil dikirim! Ulasan akan ditinjau oleh Admin sebelum ditampilkan secara publik.');
    }
}
