@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.jenis-surat.index') }}" class="text-decoration-none small text-muted">← Kembali ke Daftar</a>
    <h4 class="fw-bold mt-2">Edit Jenis Surat: {{ $jenisSurat->nama_surat }}</h4>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.jenis-surat.update', $jenisSurat->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Kode Surat</label>
                    <input type="text" name="kode_surat" class="form-control @error('kode_surat') is-invalid @enderror" value="{{ old('kode_surat', $jenisSurat->kode_surat) }}" required>
                    @error('kode_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-8 mb-3">
                    <label class="form-label fw-semibold">Nama Surat</label>
                    <input type="text" name="nama_surat" class="form-control @error('nama_surat') is-invalid @enderror" value="{{ old('nama_surat', $jenisSurat->nama_surat) }}" required>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label fw-semibold">Deskripsi Singkat</label>
                    <textarea name="deskripsi" class="form-control" rows="2">{{ old('deskripsi', $jenisSurat->deskripsi) }}</textarea>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label fw-semibold">Field yang Diperlukan</label>
                    <div class="p-3 border rounded-3 bg-light">
                        <div class="row g-3">
                            @foreach($standardFields as $field)
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="field_diperlukan[]" value="{{ $field }}" id="f-{{ $field }}" {{ in_array($field, $jenisSurat->field_diperlukan) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="f-{{ $field }}">
                                        {{ str_replace('_', ' ', ucfirst($field)) }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label fw-semibold">Template HTML (Gunakan placeholder {field})</label>
                    <textarea name="template_html" class="form-control font-monospace" rows="15" required>{{ old('template_html', $jenisSurat->template_html) }}</textarea>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="is_aktif" class="form-select">
                        <option value="1" {{ $jenisSurat->is_aktif ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ !$jenisSurat->is_aktif ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">Perbarui Template</button>
            </div>
        </form>
    </div>
</div>
@endsection
