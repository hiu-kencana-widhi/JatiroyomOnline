<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Master\PotretDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PotretController extends Controller
{
    public function index()
    {
        $potrets = PotretDesa::latest()->get();
        return view('admin.potret.index', compact('potrets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $path = $request->file('gambar')->store('potret', 'public');

        PotretDesa::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $path,
            'is_aktif' => true,
        ]);

        return back()->with('success', 'Potret Desa berhasil ditambahkan.');
    }

    public function update(Request $request, PotretDesa $potret)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($potret->gambar);
            $path = $request->file('gambar')->store('potret', 'public');
            $potret->gambar = $path;
        }

        $potret->judul = $request->judul;
        $potret->deskripsi = $request->deskripsi;
        $potret->save();

        return back()->with('success', 'Potret Desa berhasil diperbarui.');
    }

    public function toggle(PotretDesa $potret)
    {
        $potret->update(['is_aktif' => !$potret->is_aktif]);
        return back()->with('success', 'Status potret berhasil diubah.');
    }

    public function destroy(PotretDesa $potret)
    {
        Storage::disk('public')->delete($potret->gambar);
        $potret->delete();
        return back()->with('success', 'Potret Desa berhasil dihapus.');
    }
}
