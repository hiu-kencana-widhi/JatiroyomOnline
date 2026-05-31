<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengumumanDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    /**
     * Menampilkan daftar riwayat pengumuman desa dengan paginasi.
     */
    public function index()
    {
        $pengumuman = PengumumanDesa::latest()->paginate(10);
        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    /**
     * Menyimpan siaran pengumuman baru beserta lampiran file jika ada.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'isi_pengumuman'  => 'required|string',
            'tipe_spanduk'    => 'required|in:info,peringatan,darurat',
            'tanggal_selesai' => 'required|date|after:today',
            'file_lampiran'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('file_lampiran')) {
            $file = $request->file('file_lampiran');
            $filename = 'surat_' . time() . '_' . $file->getClientOriginalName();
            // Simpan ke storage public/pengumuman
            $filePath = $file->storeAs('pengumuman', $filename, 'public');
        }

        PengumumanDesa::create([
            'judul'           => $request->judul,
            'isi_pengumuman'  => $request->isi_pengumuman,
            'tipe_spanduk'    => $request->tipe_spanduk,
            'tanggal_selesai' => $request->tanggal_selesai,
            'file_lampiran'   => $filePath,
            'status_aktif'    => true,
        ]);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Spanduk pengumuman berhasil diterbitkan dan langsung tayang.');
    }

    /**
     * Memperbarui rincian pengumuman yang sudah ada.
     */
    public function update(Request $request, PengumumanDesa $pengumuman)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'isi_pengumuman'  => 'required|string',
            'tipe_spanduk'    => 'required|in:info,peringatan,darurat',
            'tanggal_selesai' => 'required|date',
            'file_lampiran'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $filePath = $pengumuman->file_lampiran;
        if ($request->hasFile('file_lampiran')) {
            // Hapus file lama jika ada
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $file = $request->file('file_lampiran');
            $filename = 'surat_' . time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('pengumuman', $filename, 'public');
        }

        $pengumuman->update([
            'judul'           => $request->judul,
            'isi_pengumuman'  => $request->isi_pengumuman,
            'tipe_spanduk'    => $request->tipe_spanduk,
            'tanggal_selesai' => $request->tanggal_selesai,
            'file_lampiran'   => $filePath,
        ]);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Rincian siaran pengumuman berhasil diperbarui.');
    }

    /**
     * Mengubah status aktif (toggle) tayang siaran pengumuman.
     */
    public function toggle(PengumumanDesa $pengumuman)
    {
        $pengumuman->update([
            'status_aktif' => !$pengumuman->status_aktif
        ]);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Status tayang pengumuman berhasil diubah.');
    }

    /**
     * Menghapus permanen siaran pengumuman beserta berkas fisiknya.
     */
    public function destroy(PengumumanDesa $pengumuman)
    {
        if ($pengumuman->file_lampiran && Storage::disk('public')->exists($pengumuman->file_lampiran)) {
            Storage::disk('public')->delete($pengumuman->file_lampiran);
        }

        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman beserta berkas lampirannya berhasil dihapus permanen.');
    }
}
