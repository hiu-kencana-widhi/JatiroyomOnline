@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.jenis-surat.index') }}" class="text-decoration-none small text-muted">← Kembali ke Daftar</a>
    <h4 class="fw-bold mt-2">Buat Jenis Surat Baru</h4>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.jenis-surat.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Kode Surat</label>
                    <input type="text" name="kode_surat" class="form-control @error('kode_surat') is-invalid @enderror" placeholder="MISAL: SKU, SKTM, SKD" required>
                    @error('kode_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-8 mb-3">
                    <label class="form-label fw-semibold">Nama Surat</label>
                    <input type="text" name="nama_surat" class="form-control @error('nama_surat') is-invalid @enderror" placeholder="Contoh: Surat Keterangan Usaha" required>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label fw-semibold">Deskripsi Singkat</label>
                    <textarea name="deskripsi" class="form-control" rows="2"></textarea>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label fw-semibold">Pilih Field yang Diperlukan</label>
                    <div class="p-3 border rounded-3 bg-light">
                        <div class="row g-3">
                            @foreach($standardFields as $field)
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="field_diperlukan[]" value="{{ $field }}" id="f-{{ $field }}">
                                    <label class="form-check-label" for="f-{{ $field }}">
                                        {{ str_replace('_', ' ', ucfirst($field)) }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <small class="text-muted mt-2 d-block">* Field yang dipilih akan otomatis muncul di form pengajuan warga.</small>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label fw-semibold">Template HTML (Gunakan placeholder {field})</label>
                    <textarea name="template_html" class="form-control font-monospace" rows="15" placeholder="<html>... {nama_lengkap} ...</html>" required></textarea>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="is_aktif" class="form-select">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">Simpan Template</button>
            </div>
        </form>
    </div>
</div>
@endsection
