@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Pengaturan Desa</h4>
    <p class="text-muted">Kelola informasi umum desa yang akan tampil di halaman depan.</p>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm mb-4">
    {{ session('success') }}
</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.pengaturan.update') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Desa</label>
                    <input type="text" name="nama_desa" class="form-control" value="{{ $settings['nama_desa'] ?? '' }}" placeholder="Jatiroyom">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-control" value="{{ $settings['kecamatan'] ?? '' }}" placeholder="Bodeh">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Kabupaten</label>
                    <input type="text" name="kabupaten" class="form-control" value="{{ $settings['kabupaten'] ?? '' }}" placeholder="Pemalang">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nomor Kontak / WhatsApp</label>
                    <input type="text" name="kontak" class="form-control" value="{{ $settings['kontak'] ?? '' }}" placeholder="0812...">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email Desa</label>
                    <input type="email" name="email" class="form-control" value="{{ $settings['email'] ?? '' }}" placeholder="desa@jatiroyom.id">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label fw-bold">Profil Singkat Desa (Tampil di Hero Section)</label>
                    <textarea name="profil_desa" class="form-control" rows="3" placeholder="Deskripsi tentang desa...">{{ $settings['profil_desa'] ?? '' }}</textarea>
                </div>
            </div>

            <div class="mt-4 border-top pt-4">
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>
@endsection
