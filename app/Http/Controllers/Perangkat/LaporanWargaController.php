<?php

namespace App\Http\Controllers\Perangkat;

use App\Http\Controllers\Controller;
use App\Models\Laporan\LaporanWarga;
use Illuminate\Http\Request;

class LaporanWargaController extends Controller
{
    /**
     * Menampilkan daftar insiden warga se-desa untuk dipantau oleh perangkat lapangan
     */
    public function index(Request $request)
    {
        $query = LaporanWarga::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $laporan = $query->paginate(15);

        return view('perangkat.laporan.index', compact('laporan'));
    }

    /**
     * Menambahkan kontribusi tanggapan dari peninjauan fisik lapangan
     */
    public function tanggapi(Request $request, $id)
    {
        $request->validate([
            'catatan_tanggapan' => 'required|string',
        ]);

        $laporan = LaporanWarga::findOrFail($id);
        
        // Membubuhkan label nama aparatur pada entri tanggapan
        $namaAparatur = auth()->user()->nama_lengkap ?? 'Aparatur';
        $catatanBaru = "[Aparatur Lapangan - " . $namaAparatur . "]: " . $request->catatan_tanggapan;
        $catatanLama = $laporan->catatan_tanggapan ? $laporan->catatan_tanggapan . "\n\n" : "";

        $laporan->update([
            'catatan_tanggapan' => $catatanLama . $catatanBaru,
            // Jika status masih Menunggu, secara otomatis naikkan ke Diproses saat perangkat memberi progres
            'status'            => $laporan->status === 'Menunggu' ? 'Diproses' : $laporan->status,
        ]);

        return redirect()->route('perangkat.laporan.index')
            ->with('success', 'Tanggapan progres lapangan berhasil ditambahkan ke riwayat laporan.');
    }
}
