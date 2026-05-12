<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan\LaporanWarga;
use Illuminate\Http\Request;

class KelolaLaporanController extends Controller
{
    /**
     * Menampilkan seluruh laporan warga dengan fungsionalitas penyaringan status
     */
    public function index(Request $request)
    {
        $query = LaporanWarga::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $laporan = $query->paginate(15);

        return view('admin.laporan.index', compact('laporan'));
    }

    /**
     * Memperbarui status penanganan laporan serta menyumbangkan catatan tanggapan
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status'            => 'required|in:Menunggu,Diproses,Selesai,Ditolak',
            'catatan_tanggapan' => 'nullable|string',
        ]);

        $laporan = LaporanWarga::findOrFail($id);
        $laporan->update([
            'status'            => $request->status,
            'catatan_tanggapan' => $request->catatan_tanggapan,
        ]);

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Status penanganan insiden berhasil diperbarui.');
    }
}
