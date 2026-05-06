<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuratController extends Controller
{
    public function pilih()
    {
        $jenisSurat = \App\Models\JenisSurat::where('is_aktif', true)->orderBy('nama_surat')->get();
        return view('user.surat.pilih', compact('jenisSurat'));
    }

    public function form(\App\Models\JenisSurat $jenisSurat)
    {
        $user = auth()->user();
        return view('user.surat.form', compact('jenisSurat', 'user'));
    }

    public function kirim(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'data' => 'required|array',
        ]);

        $status = ($request->action === 'draft') ? 'draft' : 'menunggu';

        \App\Models\PengajuanSurat::create([
            'user_id' => auth()->id(),
            'jenis_surat_id' => $request->jenis_surat_id,
            'data_terisi' => $request->data,
            'status' => $status,
        ]);

        if ($status === 'draft') {
            \App\Models\LogAktivitas::record('Simpan Draf', 'Menyimpan draf permohonan surat');
            return redirect()->route('user.riwayat')->with('success', 'Draf permohonan Anda berhasil disimpan. Anda dapat mengirimkannya nanti.');
        }

        \App\Models\LogAktivitas::record('Kirim Permohonan', 'Mengajukan surat baru');
        return redirect()->route('user.riwayat')->with('success', 'Permohonan surat Anda telah berhasil dikirim dan sedang menunggu konfirmasi admin.');
    }
}
