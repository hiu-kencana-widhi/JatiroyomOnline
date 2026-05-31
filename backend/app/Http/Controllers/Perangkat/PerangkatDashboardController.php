<?php

namespace App\Http\Controllers\Perangkat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perangkat\AbsensiPerangkat;
use App\Models\Perangkat\PenilaianPerangkat;

class PerangkatDashboardController extends Controller
{
    /**
     * Menampilkan dasbor mandiri perangkat desa beserta integrasi kamera web.
     */
    public function index()
    {
        $user = auth()->user();
        $today = now()->format('Y-m-d');
        $currentMonth = now()->format('m');
        $currentYear = now()->format('Y');

        // Cek presensi hari ini
        $absensiHariIni = AbsensiPerangkat::where('user_id', $user->id)
            ->where('tanggal', $today)
            ->first();

        // Riwayat absensi bulan berjalan
        $riwayatAbsensi = AbsensiPerangkat::where('user_id', $user->id)
            ->whereYear('tanggal', $currentYear)
            ->whereMonth('tanggal', $currentMonth)
            ->orderBy('tanggal', 'desc')
            ->get();

        // Statistik bulan ini
        $statistik = [
            'hadir' => $riwayatAbsensi->where('status', 'Hadir')->count(),
            'izin' => $riwayatAbsensi->where('status', 'Izin')->count(),
            'sakit' => $riwayatAbsensi->where('status', 'Sakit')->count(),
            'alpa' => $riwayatAbsensi->where('status', 'Alpa')->count(),
        ];

        // Ulasan/Penilaian kinerja dari masyarakat
        $penilaian = PenilaianPerangkat::with('warga')
            ->where('perangkat_id', $user->id)
            ->where('status_tampil', true)
            ->latest()
            ->get();

        $rataRataBintang = $penilaian->avg('rating') ?? 0;

        return view('perangkat.dashboard', compact(
            'absensiHariIni',
            'riwayatAbsensi',
            'statistik',
            'penilaian',
            'rataRataBintang'
        ));
    }
}
