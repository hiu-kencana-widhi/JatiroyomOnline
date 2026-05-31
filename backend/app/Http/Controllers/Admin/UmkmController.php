<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    /**
     * Menampilkan daftar seluruh produk usaha warga untuk dimoderasi oleh administrator.
     */
    public function index(Request $request)
    {
        $query = UmkmDesa::with('user')->latest();

        // Pencarian opsional berdasarkan nama usaha atau produk
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('nama_produk', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        // Filter status verifikasi
        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        $umkm = $query->paginate(10)->withQueryString();

        return view('admin.umkm.index', compact('umkm'));
    }

    /**
     * Mengubah status verifikasi produk (Disetujui / Ditolak).
     */
    public function verifikasi(Request $request, string $id)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:Disetujui,Ditolak',
        ]);

        $umkm = UmkmDesa::findOrFail($id);
        $umkm->update([
            'status_verifikasi' => $request->status_verifikasi,
        ]);

        $pesan = $request->status_verifikasi === 'Disetujui' 
            ? 'Produk berhasil disetujui dan kini tayang di etalase publik.' 
            : 'Produk ditolak penayangannya.';

        return redirect()->route('admin.umkm.index')
            ->with('success', $pesan);
    }

    /**
     * Menghapus secara paksa produk yang melanggar aturan portal desa.
     */
    public function destroy(string $id)
    {
        $umkm = UmkmDesa::findOrFail($id);

        if ($umkm->foto_produk && Storage::disk('public')->exists($umkm->foto_produk)) {
            Storage::disk('public')->delete($umkm->foto_produk);
        }

        $umkm->delete();

        return redirect()->route('admin.umkm.index')
            ->with('success', 'Produk usaha berhasil dihapus permanen dari sistem.');
    }
}
