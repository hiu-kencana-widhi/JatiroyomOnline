<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perangkat\AbsensiPerangkat;
use App\Models\User;

class RekapAbsensiController extends Controller
{
    /**
     * Menampilkan daftar rekapitulasi presensi seluruh aparatur desa.
     */
    public function index(Request $request)
    {
        $query = AbsensiPerangkat::with('user')->orderBy('tanggal', 'desc');

        // Opsi filter berdasarkan bulan dan tahun
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $absensi = $query->paginate(20)->withQueryString();
        
        // Daftar aparatur untuk dropdown input manual
        $aparaturList = User::where('role', 'perangkat_desa')->where('status_aktif', true)->get();

        return view('admin.absensi.index', compact('absensi', 'aparaturList'));
    }

    /**
     * Mengonfirmasi atau menolak pengajuan kehadiran swafoto aparatur.
     */
    public function konfirmasi(Request $request, AbsensiPerangkat $absensi)
    {
        $request->validate([
            'status' => 'required|in:Hadir,Izin,Sakit,Alpa',
            'status_konfirmasi_masuk' => 'required|in:Terkonfirmasi,Menunggu,Ditolak',
            'status_konfirmasi_keluar' => 'required|in:Terkonfirmasi,Menunggu,Ditolak',
            'catatan' => 'nullable|string|max:500',
        ]);

        $absensi->status = $request->status;
        $absensi->status_konfirmasi_masuk = $request->status_konfirmasi_masuk;
        if ($absensi->waktu_keluar || $request->filled('status_konfirmasi_keluar')) {
            $absensi->status_konfirmasi_keluar = $request->status_konfirmasi_keluar;
        }
        $absensi->catatan = $request->catatan;
        $absensi->save();

        return back()->with('success', 'Status dan konfirmasi presensi aparatur berhasil diperbarui.');
    }

    /**
     * Menyisipkan presensi manual jika aparatur izin, sakit, atau dinas luar tanpa gawai.
     */
    public function storeManual(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Izin,Sakit,Alpa',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_keluar' => 'nullable|date_format:H:i',
            'catatan' => 'nullable|string|max:500',
        ]);

        $absensi = AbsensiPerangkat::firstOrNew([
            'user_id' => $request->user_id,
            'tanggal' => $request->tanggal,
        ]);

        $absensi->status = $request->status;
        $absensi->status_konfirmasi_masuk = 'Terkonfirmasi';
        $absensi->status_konfirmasi_keluar = 'Terkonfirmasi'; // Otomatis terverifikasi karena diinput Admin
        $absensi->catatan = $request->catatan ?: ($request->status !== 'Hadir' ? 'Tidak Hadir' : 'On Time');

        if ($request->filled('waktu_masuk')) {
            $absensi->waktu_masuk = $request->waktu_masuk . ':00';
        }
        if ($request->filled('waktu_keluar')) {
            $absensi->waktu_keluar = $request->waktu_keluar . ':00';
        }

        $absensi->save();

        return back()->with('success', 'Presensi manual aparatur berhasil disisipkan dan dikonfirmasi.');
    }
}
