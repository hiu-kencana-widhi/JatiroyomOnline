<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AcaraController extends Controller
{
    public function index()
    {
        $acara = \App\Models\AcaraDesa::orderBy('tanggal', 'desc')->paginate(10);
        return view('admin.acara.index', compact('acara'));
    }

    public function create()
    {
        return view('admin.acara.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'lokasi' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_aktif' => 'required|boolean',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('acara', 'public');
        }

        $data['created_by'] = auth()->id();
        \App\Models\AcaraDesa::create($data);

        return redirect()->route('admin.acara.index')->with('success', 'Acara berhasil ditambahkan.');
    }

    public function edit(\App\Models\AcaraDesa $acara)
    {
        return view('admin.acara.edit', compact('acara'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\AcaraDesa $acara)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'lokasi' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_aktif' => 'required|boolean',
        ]);

        if ($request->hasFile('gambar')) {
            if ($acara->gambar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($acara->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('acara', 'public');
        }

        $acara->update($data);

        return redirect()->route('admin.acara.index')->with('success', 'Acara berhasil diperbarui.');
    }

    public function destroy(\App\Models\AcaraDesa $acara)
    {
        if ($acara->gambar) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($acara->gambar);
        }
        $acara->delete();
        return redirect()->route('admin.acara.index')->with('success', 'Acara berhasil dihapus.');
    }
}
