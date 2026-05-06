@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark">Acara Desa</h3>
        <p class="text-muted mb-0">Kelola publikasi kegiatan dan acara yang berlangsung di Desa Jatiroyom.</p>
    </div>
    <a href="{{ route('admin.acara.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow">
        <i class="bi bi-calendar-plus me-2"></i> Tambah Acara
    </a>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif

<div class="row g-4">
    @forelse($acara as $item)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="position-relative">
                @if($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                    </div>
                @endif
                <div class="position-absolute top-0 end-0 p-3">
                    <span class="badge {{ $item->is_aktif ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3 shadow">
                        {{ $item->is_aktif ? 'Aktif' : 'Draft' }}
                    </span>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1 small fw-bold">
                        <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                    </div>
                </div>
                <h5 class="fw-bold text-dark mb-2">{{ $item->judul }}</h5>
                <p class="text-muted small mb-0"><i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $item->lokasi ?? 'Lokasi tidak ditentukan' }}</p>
                <p class="text-muted small mt-2 mb-0 line-clamp-2">{{ Str::limit($item->deskripsi, 80) }}</p>
            </div>
            <div class="card-footer bg-white border-top-0 p-4 pt-0 d-flex gap-2">
                <a href="{{ route('admin.acara.edit', $item->id) }}" class="btn btn-sm btn-outline-primary rounded-pill flex-grow-1 fw-bold">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                </a>
                <form action="{{ route('admin.acara.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus acara ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle p-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm p-5 text-center">
            <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-5369.jpg" width="200" class="mx-auto mb-3 opacity-50">
            <h5 class="text-muted">Belum ada acara yang terdaftar.</h5>
            <div class="mt-3">
                <a href="{{ route('admin.acara.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold">Tambah Acara Pertama</a>
            </div>
        </div>
    </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $acara->links() }}
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;  
    overflow: hidden;
}
</style>
@endsection
