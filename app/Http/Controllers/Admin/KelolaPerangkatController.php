<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KelolaPerangkatController extends Controller
{
    /**
     * Menampilkan daftar perangkat desa.
     */
    public function index()
    {
        $perangkat = User::where('role', 'perangkat_desa')->latest()->get();
        return view('admin.perangkat.index', compact('perangkat'));
    }

    /**
     * Menyimpan data aparatur baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|unique:users,nik',
            'nama_lengkap' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'pin' => 'required|digits:6',
        ]);

        User::create([
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'role' => 'perangkat_desa',
            'jabatan' => $request->jabatan,
            'password' => Hash::make($request->pin),
            'status_aktif' => true,
        ]);

        return back()->with('success', 'Aparatur Desa baru berhasil ditambahkan.');
    }

    /**
     * Memperbarui data aparatur, status aktif, atau reset PIN.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'status_aktif' => 'required|boolean',
            'pin' => 'nullable|digits:6',
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->jabatan = $request->jabatan;
        $user->status_aktif = $request->status_aktif;

        if ($request->filled('pin')) {
            $user->password = Hash::make($request->pin);
        }

        $user->save();

        return back()->with('success', 'Data Aparatur berhasil diperbarui.');
    }

    /**
     * Menghapus akun aparatur desa.
     */
    public function destroy(User $user)
    {
        if ($user->role !== 'perangkat_desa') {
            return back()->with('error', 'Aksi tidak diizinkan.');
        }

        $user->delete();
        return back()->with('success', 'Akun Aparatur berhasil dihapus.');
    }
}
