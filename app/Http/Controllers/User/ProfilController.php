<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LogAktivitas;

class ProfilController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('user.profil', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(auth()->id());
        
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'no_kk' => 'nullable|string|size:16',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'rt_rw' => 'nullable|string|max:10',
        ]);

        try {
            $user->update($data);
            LogAktivitas::record('Update Profil', 'Memperbarui data diri');
            return back()->with('success', 'Profil Anda berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }
}
