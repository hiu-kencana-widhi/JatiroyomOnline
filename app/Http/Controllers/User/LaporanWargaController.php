<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Laporan\LaporanWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LaporanWargaController extends Controller
{
    /**
     * Menampilkan daftar riwayat laporan milik pribadi warga
     */
    public function index()
    {
        $laporan = LaporanWarga::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.laporan.index', compact('laporan'));
    }

    /**
     * Menampilkan antarmuka penangkap gambar (Webcam) dan peta GPS
     */
    public function create()
    {
        return view('user.laporan.create');
    }

    /**
     * Memproses gambar base64 dan menyimpannya ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori'      => 'required|string',
            'judul_laporan' => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'foto_base64'   => 'required|string',
            'latitude'      => 'required|string',
            'longitude'     => 'required|string',
            'alamat_lokasi' => 'nullable|string',
        ]);

        try {
            // Ekstraksi Base64 dari jepretan Canvas peramban
            $image_parts = explode(";base64,", $request->foto_base64);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1] ?? 'webp';
            $image_base64 = base64_decode($image_parts[1]);

            // Penamaan berkas yang aman dan unik
            $filename = 'laporan_' . time() . '_' . Str::random(10) . '.' . $image_type;
            
            // Menyimpan berkas fisik ke disk public
            Storage::disk('public')->put('laporan/' . $filename, $image_base64);

            LaporanWarga::create([
                'user_id'       => auth()->id(),
                'kategori'      => $request->kategori,
                'judul_laporan' => $request->judul_laporan,
                'deskripsi'     => $request->deskripsi,
                'foto_bukti'    => 'laporan/' . $filename,
                'latitude'      => $request->latitude,
                'longitude'     => $request->longitude,
                'alamat_lokasi' => $request->alamat_lokasi,
                'status'        => 'Menunggu',
            ]);

            return redirect()->route('user.laporan.index')
                ->with('success', 'Laporan insiden berhasil dikirim dan sedang menunggu tinjauan dari pihak desa.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Terjadi galat saat memproses pengiriman laporan: ' . $e->getMessage());
        }
    }
}
