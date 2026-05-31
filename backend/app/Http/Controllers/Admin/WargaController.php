<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index()
    {
        $warga = \App\Models\User::where('role', 'user')->orderBy('nama_lengkap')->paginate(10);
        return view('admin.warga.index', compact('warga'));
    }

    public function create()
    {
        return view('admin.warga.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'nik' => 'required|digits:16|unique:users,nik',
            'nama_lengkap' => 'required|string|max:100',
            'no_kk' => 'nullable|digits:16',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'rt_rw' => 'nullable|string|max:10',
        ]);

        $data['role'] = 'user';
        \App\Models\User::create($data);

        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil ditambahkan.');
    }

    public function edit(\App\Models\User $warga)
    {
        return view('admin.warga.edit', compact('warga'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\User $warga)
    {
        $data = $request->validate([
            'nik' => 'required|digits:16|unique:users,nik,' . $warga->id,
            'nama_lengkap' => 'required|string|max:100',
            'no_kk' => 'nullable|digits:16',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'rt_rw' => 'nullable|string|max:10',
        ]);

        $warga->update($data);

        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy(\App\Models\User $warga)
    {
        $warga->delete();
        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil dihapus.');
    }
}
