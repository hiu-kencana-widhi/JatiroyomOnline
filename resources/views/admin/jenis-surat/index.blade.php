@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Manajemen Jenis Surat</h4>
    <a href="{{ route('admin.jenis-surat.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Jenis Surat
    </a>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm mb-4">
    {{ session('success') }}
</div>
@endif

<div class="row g-4">
    @forelse($jenisSurat as $item)
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-bold" style="font-size: 0.8rem;">
                        {{ $item->kode_surat }}
                    </div>
                    <span class="badge {{ $item->is_aktif ? 'bg-success' : 'bg-secondary' }} badge-status">
                        {{ $item->is_aktif ? 'AKTIF' : 'NONAKTIF' }}
                    </span>
                </div>
                <h5 class="fw-bold mb-2">{{ $item->nama_surat }}</h5>
                <p class="text-muted small mb-3">{{ $item->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                
                <div class="mb-3">
                    <small class="text-muted d-block mb-1 fw-bold">Field Diperlukan:</small>
                    <div class="d-flex flex-wrap gap-1">
                        @foreach($item->field_diperlukan as $field)
                        <span class="badge bg-light text-dark border fw-normal" style="font-size: 0.7rem;">{{ str_replace('_', ' ', $field) }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0 d-flex justify-content-between gap-2 pb-3">
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.jenis-surat.edit', $item->id) }}" class="btn btn-sm btn-outline-primary px-3">Edit</a>
                    <form action="{{ route('admin.jenis-surat.toggle', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $item->is_aktif ? 'btn-outline-warning' : 'btn-outline-success' }} px-3">
                            {{ $item->is_aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>
                <form action="{{ route('admin.jenis-surat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus jenis surat ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <p class="text-muted">Belum ada data jenis surat.</p>
    </div>
    @endforelse
</div>
@endsection
