@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Manajemen Potret Desa</h4>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="bi bi-plus-lg me-1"></i> Tambah Potret
    </button>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm mb-4">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger border-0 shadow-sm mb-4">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li><i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row g-4">
    @forelse($potrets as $p)
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="position-relative">
                <img src="{{ asset('storage/' . $p->gambar) }}" class="card-img-top" style="height: 200px; object-fit: cover;" loading="lazy">
                <div class="position-absolute top-0 end-0 p-2">
                    <span class="badge {{ $p->is_aktif ? 'bg-success' : 'bg-secondary' }}">
                        {{ $p->is_aktif ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <h5 class="fw-bold mb-2">{{ $p->judul }}</h5>
                <p class="text-muted small mb-0">{{ Str::limit($p->deskripsi, 100) }}</p>
            </div>
            <div class="card-footer bg-white border-0 d-flex justify-content-between pb-3">
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-primary px-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $p->id }}">Edit</button>
                    <form action="{{ route('admin.potret.toggle', $p->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $p->is_aktif ? 'btn-outline-warning' : 'btn-outline-success' }} px-3">
                            {{ $p->is_aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>
                <form action="{{ route('admin.potret.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus potret ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.potret.update', $p->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Potret Desa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="judul" class="form-control" value="{{ $p->judul }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3">{{ $p->deskripsi }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ganti Gambar (Opsional)</label>
                            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                            @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Format: JPG, PNG. Max 5MB. Biarkan kosong jika tidak ingin mengubah gambar.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <p class="text-muted">Belum ada potret desa yang diunggah.</p>
    </div>
    @endforelse
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.potret.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Potret Desa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" class="form-control" placeholder="Misal: Lembah Hijau Jatiroyom" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Ceritakan keindahan lokasi ini..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Gambar</label>
                        <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*" required>
                        @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted">Format: JPG, PNG. Max 5MB.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Unggah Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    @if($errors->any())
        var addModal = new bootstrap.Modal(document.getElementById('addModal'));
        addModal.show();
    @endif
</script>
@endsection
