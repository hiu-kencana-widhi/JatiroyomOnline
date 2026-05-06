@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.acara.index') }}" class="text-decoration-none small text-muted">← Kembali ke Daftar</a>
    <h4 class="fw-bold mt-2">Edit Acara Desa</h4>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.acara.update', $acara->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label fw-semibold">Judul Acara</label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $acara->judul) }}" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Tanggal Acara</label>
                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $acara->tanggal ? $acara->tanggal->format('Y-m-d') : '') }}" required>
                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi', $acara->lokasi) }}">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $acara->deskripsi) }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Ganti Gambar/Poster (Optional)</label>
                    <input type="file" name="gambar" class="form-control">
                    @if($acara->gambar)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $acara->gambar) }}" class="rounded shadow-sm" style="height: 100px;">
                        </div>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="is_aktif" class="form-select">
                        <option value="1" {{ $acara->is_aktif ? 'selected' : '' }}>Aktif (Tampil di Beranda)</option>
                        <option value="0" {{ !$acara->is_aktif ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">Perbarui Acara</button>
            </div>
        </form>
    </div>
</div>
@endsection
