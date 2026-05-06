<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JenisSuratController extends Controller
{
    public function index()
    {
        $jenisSurat = \App\Models\JenisSurat::orderBy('nama_surat')->get();
        return view('admin.jenis-surat.index', compact('jenisSurat'));
    }

    public function create()
    {
        $standardFields = [
            'nama_lengkap', 'nik', 'no_kk', 'tempat_lahir', 'tanggal_lahir', 
            'jenis_kelamin', 'agama', 'pekerjaan', 'alamat', 'rt_rw'
        ];
        return view('admin.jenis-surat.create', compact('standardFields'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'kode_surat' => 'required|string|max:20|unique:jenis_surat,kode_surat',
            'nama_surat' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'template_html' => 'required|string',
            'field_diperlukan' => 'required|array',
            'is_aktif' => 'required|boolean',
        ]);

        \App\Models\JenisSurat::create($data);

        return redirect()->route('admin.jenis-surat.index')->with('success', 'Jenis surat berhasil ditambahkan.');
    }

    public function edit(\App\Models\JenisSurat $jenisSurat)
    {
        $standardFields = [
            'nama_lengkap', 'nik', 'no_kk', 'tempat_lahir', 'tanggal_lahir', 
            'jenis_kelamin', 'agama', 'pekerjaan', 'alamat', 'rt_rw'
        ];
        return view('admin.jenis-surat.edit', compact('jenisSurat', 'standardFields'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\JenisSurat $jenisSurat)
    {
        $data = $request->validate([
            'kode_surat' => 'required|string|max:20|unique:jenis_surat,kode_surat,' . $jenisSurat->id,
            'nama_surat' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'template_html' => 'required|string',
            'field_diperlukan' => 'required|array',
            'is_aktif' => 'required|boolean',
        ]);

        $jenisSurat->update($data);

        return redirect()->route('admin.jenis-surat.index')->with('success', 'Jenis surat berhasil diperbarui.');
    }

    public function destroy(\App\Models\JenisSurat $jenisSurat)
    {
        $jenisSurat->delete();
        return redirect()->route('admin.jenis-surat.index')->with('success', 'Jenis surat berhasil dihapus.');
    }

    public function toggleStatus(\App\Models\JenisSurat $jenisSurat)
    {
        $jenisSurat->update(['is_aktif' => !$jenisSurat->is_aktif]);
        $status = $jenisSurat->is_aktif ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Jenis surat berhasil $status.");
    }
}
