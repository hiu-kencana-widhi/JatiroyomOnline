<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnggaranController extends Controller
{
    public function index()
    {
        $anggaran = \App\Models\Master\AnggaranDesa::orderBy('created_at', 'desc')->get();
        return view('admin.anggaran.index', compact('anggaran'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,xls,xlsx|max:5120',
        ]);

        // Nonaktifkan anggaran lain
        \App\Models\Master\AnggaranDesa::where('is_active', true)->update(['is_active' => false]);

        $path = $request->file('file')->store('anggaran', 'public');

        \App\Models\Master\AnggaranDesa::create([
            'judul' => $request->judul,
            'file_path' => $path,
            'is_active' => true,
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('admin.anggaran.index')->with('success', 'File anggaran berhasil diunggah dan diaktifkan.');
    }

    public function destroy(\App\Models\Master\AnggaranDesa $anggaran)
    {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($anggaran->file_path);
        $anggaran->delete();
        return redirect()->route('admin.anggaran.index')->with('success', 'Data anggaran berhasil dihapus.');
    }
}
