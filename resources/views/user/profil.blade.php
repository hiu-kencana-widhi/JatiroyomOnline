@extends('layouts.user')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-dark">Profil Saya</h3>
    <p class="text-muted">Pastikan data kependudukan Anda selalu terbaru untuk mempermudah pengajuan surat.</p>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
    <div class="d-flex align-items-center">
        <i class="bi bi-check-circle-fill fs-4 me-2"></i>
        <div><strong>Berhasil!</strong> {{ session('success') }}</div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
    <div class="d-flex align-items-center">
        <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
        <div><strong>Maaf!</strong> {{ session('error') }}</div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm text-center p-4 h-100">
            <div class="card-body">
                <div class="bg-primary text-white rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center shadow-lg" style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: 700;">
                    {{ substr($user->nama_lengkap, 0, 1) }}
                </div>
                <h4 class="fw-bold mb-1">{{ $user->nama_lengkap }}</h4>
                <p class="text-muted mb-4">NIK: {{ $user->nik }}</p>
                <hr class="my-4 opacity-25">
                <div class="text-start">
                    <div class="mb-3">
                        <small class="text-muted d-block">No. Kartu Keluarga</small>
                        <span class="fw-bold">{{ $user->no_kk ?? '-' }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Terdaftar Sejak</small>
                        <span class="fw-bold">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="bg-light p-3 rounded-4 mt-4">
                        <small class="text-muted d-block mb-1">Status Akun</small>
                        <span class="badge bg-success rounded-pill px-3">Terverifikasi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm overflow-hidden h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold">Edit Informasi Kependudukan</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('user.profil.update') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">NIK (Tetap)</label>
                            <input type="text" class="form-control bg-light border-0" value="{{ $user->nik }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                            @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">No. Kartu Keluarga</label>
                            <input type="text" name="no_kk" class="form-control @error('no_kk') is-invalid @enderror" value="{{ old('no_kk', $user->no_kk) }}">
                            @error('no_kk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control @error('pekerjaan') is-invalid @enderror" value="{{ old('pekerjaan', $user->pekerjaan) }}">
                            @error('pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $user->tempat_lahir) }}">
                            @error('tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '') }}">
                            @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                                <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">RT / RW</label>
                            <input type="text" name="rt_rw" class="form-control @error('rt_rw') is-invalid @enderror" value="{{ old('rt_rw', $user->rt_rw) }}" placeholder="Contoh: 001/002">
                            @error('rt_rw') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-uppercase text-muted">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill fw-bold shadow">
                            <i class="bi bi-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
