<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UmkmDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    /**
     * Menampilkan daftar etalase produk mandiri milik warga aktif beserta form input.
     */
    public function index()
    {
        $umkm = UmkmDesa::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.umkm.index', compact('umkm'));
    }

    /**
     * Menampilkan form pembuatan (dialihkan ke index karena menggunakan layout terpadu).
     */
    public function create()
    {
        return redirect()->route('user.umkm.index');
    }

    /**
     * Menyimpan produk baru yang didaftarkan warga.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'nama_produk' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'foto_produk' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'nomor_whatsapp' => 'required|string|max:30',
        ], [
            'foto_produk.max' => 'Ukuran foto produk maksimal adalah 5MB.',
            'foto_produk.image' => 'Berkas harus berupa gambar (JPG/PNG).',
        ]);

        // Format nomor WhatsApp agar konsisten berawalan 62
        $wa = preg_replace('/[^0-9]/', '', $request->nomor_whatsapp);
        if (str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        }

        $fotoPath = $request->file('foto_produk')->store('umkm', 'public');

        UmkmDesa::create([
            'user_id' => auth()->id(),
            'nama_usaha' => $request->nama_usaha,
            'nama_produk' => $request->nama_produk,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'satuan' => $request->satuan,
            'foto_produk' => $fotoPath,
            'nomor_whatsapp' => $wa,
            'status_verifikasi' => 'Menunggu', // Selalu harus disetujui admin terlebih dahulu
        ]);

        return redirect()->route('user.umkm.index')
            ->with('success', 'Produk berhasil didaftarkan dan sedang menunggu verifikasi oleh pengelola desa.');
    }

    /**
     * Memperbarui informasi produk UMKM warga.
     */
    public function update(Request $request, string $id)
    {
        $umkm = UmkmDesa::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'nama_produk' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'foto_produk' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'nomor_whatsapp' => 'required|string|max:30',
        ]);

        $wa = preg_replace('/[^0-9]/', '', $request->nomor_whatsapp);
        if (str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        }

        $data = [
            'nama_usaha' => $request->nama_usaha,
            'nama_produk' => $request->nama_produk,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'satuan' => $request->satuan,
            'nomor_whatsapp' => $wa,
            // Jika diedit, status verifikasi dikembalikan ke Menunggu untuk ditinjau ulang demi keamanan
            'status_verifikasi' => 'Menunggu',
        ];

        if ($request->hasFile('foto_produk')) {
            // Hapus foto lama
            if ($umkm->foto_produk && Storage::disk('public')->exists($umkm->foto_produk)) {
                Storage::disk('public')->delete($umkm->foto_produk);
            }
            $data['foto_produk'] = $request->file('foto_produk')->store('umkm', 'public');
        }

        $umkm->update($data);

        return redirect()->route('user.umkm.index')
            ->with('success', 'Rincian produk berhasil diperbarui dan dikirim ulang untuk verifikasi pengelola.');
    }

    /**
     * Menghapus produk dari etalase beserta berkas fotonya.
     */
    public function destroy(string $id)
    {
        $umkm = UmkmDesa::where('user_id', auth()->id())->findOrFail($id);

        if ($umkm->foto_produk && Storage::disk('public')->exists($umkm->foto_produk)) {
            Storage::disk('public')->delete($umkm->foto_produk);
        }

        $umkm->delete();

        return redirect()->route('user.umkm.index')
            ->with('success', 'Produk usaha berhasil dihapus secara permanen.');
    }
}
