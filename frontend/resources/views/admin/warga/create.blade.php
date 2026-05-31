@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.warga.index') }}" class="text-decoration-none small text-muted">← Kembali ke Daftar</a>
    <h4 class="fw-bold mt-2">Tambah Warga Baru</h4>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.warga.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">NIK (16 Digit)</label>
                    <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" required>
                    @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" required>
                    @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nomor KK</label>
                    <input type="text" name="no_kk" class="form-control @error('no_kk') is-invalid @enderror" value="{{ old('no_kk') }}">
                    @error('no_kk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Agama</label>
                    <input type="text" name="agama" class="form-control" value="{{ old('agama') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">RT/RW</label>
                    <input type="text" name="rt_rw" class="form-control" value="{{ old('rt_rw') }}" placeholder="001/002">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label fw-semibold">Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">Simpan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
