<?php

namespace App\Http\Controllers\Perangkat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perangkat\AbsensiPerangkat;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    /**
     * Menyimpan data presensi beserta konversi foto Base64 hasil tangkapan web.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:masuk,keluar',
            'image' => 'required|string',
        ]);

        $user = auth()->user();
        // Menggunakan waktu aman absolut server/internet yang kebal manipulasi gawai klien
        $today = now()->format('Y-m-d');
        $currentTime = now()->format('H:i:s');

        // Parse & Decode file gambar Base64
        $imageData = $request->image;
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $type = strtolower($type[1]);
            
            if (!in_array($type, ['jpg', 'jpeg', 'png', 'webp'])) {
                return back()->with('error', 'Format gambar swafoto tidak didukung.');
            }
            
            $decodedData = base64_decode($imageData);
            if ($decodedData === false) {
                return back()->with('error', 'Gagal memproses enkripsi foto swafoto.');
            }
        } else {
            return back()->with('error', 'Tangkapan kamera swafoto tidak valid.');
        }

        // Tentukan path penyimpanan di storage/app/public/absensi
        $fileName = 'absensi/' . $user->id . '_' . $today . '_' . $request->tipe . '_' . time() . '.' . $type;
        Storage::disk('public')->put($fileName, $decodedData);

        // Cari atau buat record presensi untuk hari ini
        $absensi = AbsensiPerangkat::firstOrNew([
            'user_id' => $user->id,
            'tanggal' => $today,
        ]);

        if ($request->tipe === 'masuk') {
            if ($absensi->waktu_masuk) {
                return back()->with('error', 'Anda sudah melakukan presensi masuk untuk hari ini.');
            }
            $absensi->waktu_masuk = $currentTime;
            $absensi->foto_masuk = $fileName;
            $absensi->status = 'Hadir';
            $absensi->status_konfirmasi_masuk = 'Menunggu';
            $pesan = 'Presensi Masuk berhasil dicatat pada pukul ' . $currentTime . ' (Menunggu Konfirmasi Admin)';
        } else {
            if (!$absensi->waktu_masuk) {
                return back()->with('error', 'Anda harus melakukan presensi masuk terlebih dahulu sebelum mencatat kepulangan.');
            }
            if ($absensi->waktu_keluar) {
                return back()->with('error', 'Anda sudah melakukan presensi pulang hari ini.');
            }
            $absensi->waktu_keluar = $currentTime;
            $absensi->foto_keluar = $fileName;
            $absensi->status_konfirmasi_keluar = 'Menunggu';
            $pesan = 'Presensi Pulang berhasil dicatat pada pukul ' . $currentTime . ' (Menunggu Konfirmasi Admin)';
        }

        $absensi->save();

        return back()->with('success', $pesan);
    }
}
