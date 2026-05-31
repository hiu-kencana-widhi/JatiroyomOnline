<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perangkat\PenilaianPerangkat;

class ModerasiPenilaianController extends Controller
{
    /**
     * Menampilkan daftar ulasan dan rating dari masyarakat terhadap aparatur.
     */
    public function index()
    {
        $penilaian = PenilaianPerangkat::with(['perangkat', 'warga'])
            ->latest()
            ->paginate(20);

        return view('admin.penilaian.index', compact('penilaian'));
    }

    /**
     * Mengubah status tayang ulasan di halaman publik.
     */
    public function toggle(PenilaianPerangkat $penilaian)
    {
        $penilaian->status_tampil = !$penilaian->status_tampil;
        $penilaian->save();

        $status = $penilaian->status_tampil ? 'ditampilkan' : 'disembunyikan';
        return back()->with('success', "Ulasan berhasil $status pada antarmuka publik.");
    }

    /**
     * Menghapus ulasan yang mengandung unsur SARA atau spam.
     */
    public function destroy(PenilaianPerangkat $penilaian)
    {
        $penilaian->delete();
        return back()->with('success', 'Ulasan warga berhasil dihapus.');
    }
}
