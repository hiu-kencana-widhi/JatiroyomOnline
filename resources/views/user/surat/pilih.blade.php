@extends('layouts.user')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold">Pilih Jenis Surat</h4>
    <p class="text-muted">Silakan pilih jenis surat keterangan yang ingin Anda ajukan.</p>
</div>

<div class="row g-4">
    @forelse($jenisSurat as $item)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm transition-hover">
            <div class="card-body p-4 d-flex flex-column">
                <div class="flex-grow-1">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1 d-inline-block fw-bold small mb-3">
                        {{ $item->kode_surat }}
                    </div>
                    <h5 class="fw-bold mb-2">{{ $item->nama_surat }}</h5>
                    <p class="text-muted small mb-4">{{ $item->deskripsi ?? 'Ajukan surat keterangan ini untuk berbagai keperluan administratif Anda.' }}</p>
                </div>
                <a href="{{ route('user.surat.form', $item->id) }}" class="btn btn-outline-primary w-100 fw-bold mt-auto">
                    Pilih & Isi Form
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="card border-0 shadow-sm p-5">
            <i class="bi bi-file-earmark-x fs-1 text-muted mb-3"></i>
            <p class="text-muted">Maaf, saat ini belum ada jenis surat yang tersedia.</p>
        </div>
    </div>
    @endforelse
</div>

<style>
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        transition: all 0.3s ease;
    }
</style>
@endsection
