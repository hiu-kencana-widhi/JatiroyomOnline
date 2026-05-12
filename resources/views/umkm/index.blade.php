@extends('layouts.app')

@section('title', 'Pasar Digital & UMKM - Desa Jatiroyom')

@section('content')
<!-- Premium Parallax Header -->
<header class="page-header py-5 text-white position-relative overflow-hidden text-center" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.95)), url('{{ asset('image/gambar-umkm-desa-jatiroyom.png') }}'); background-size: cover; background-position: center; min-height: 40vh; display: flex; align-items: center; justify-content: center;">
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary opacity-10"></div>
    <div class="container position-relative z-1">
        <span class="badge bg-success rounded-pill px-4 py-2 mb-3 fw-bold text-uppercase shadow-sm" style="letter-spacing: 2px;">PASAR DIGITAL DESA</span>
        <h1 class="display-4 fw-bold mb-3 tracking-tight">Katalog Etalase <span class="text-success">UMKM</span></h1>
        <p class="lead max-w-2xl mx-auto text-white-50 mb-0" style="max-width: 700px;">
            Dukung pertumbuhan ekonomi lokal dengan membeli produk olahan tani, kuliner khas, dan kerajinan tangan langsung dari tangan kreatif warga Jatiroyom.
        </p>
    </div>
    
    <!-- Wave Divider Bawah -->
    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="line-height: 0;">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="position: relative; display: block; width: calc(100% + 1.3px); height: 50px;">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="#f8fafc"></path>
        </svg>
    </div>
</header>

<section class="py-5 bg-light min-vh-100">
    <div class="container py-4">
        
        <!-- Baris Pencarian dan Saringan Bento Kategori -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-2 mb-4">
                    <form action="{{ route('umkm.index') }}" method="GET" class="d-flex flex-column flex-md-row gap-2">
                        <!-- Pertahankan Kategori Saat Ini Jika Ada -->
                        @if(request('kategori'))
                            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                        @endif
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-0 ps-3"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-0 shadow-none ps-2" placeholder="Cari keripik, kue, anyaman, atau nama toko..." value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold flex-shrink-0 shadow-sm">
                            <i class="bi bi-search me-1"></i> Temukan
                        </button>
                        @if(request('search') || request('kategori'))
                            <a href="{{ route('umkm.index') }}" class="btn btn-light rounded-pill px-3 fw-bold flex-shrink-0 text-secondary border">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Bento Tab Filter Kategori -->
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <a href="{{ route('umkm.index', array_merge(request()->except('kategori', 'page'))) }}" class="btn rounded-pill px-4 py-2 fw-bold transition-all {{ !request('kategori') ? 'btn-success shadow-sm' : 'btn-white bg-white text-secondary shadow-sm hover-lift' }}" style="font-size: 0.9rem;">
                        <i class="bi bi-grid-fill me-1"></i> Semua Kategori
                    </a>
                    @foreach($kategoriList as $kat)
                        <a href="{{ route('umkm.index', array_merge(request()->except('page'), ['kategori' => $kat])) }}" class="btn rounded-pill px-4 py-2 fw-bold transition-all {{ request('kategori') === $kat ? 'btn-success shadow-sm' : 'btn-white bg-white text-secondary shadow-sm hover-lift' }}" style="font-size: 0.9rem;">
                            <i class="bi bi-tag-fill me-1"></i> {{ $kat }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Deretan Kartu Produk Bergaya Bento Grid -->
        <div class="row g-4">
            @forelse($umkm as $item)
            <div class="col-sm-6 col-lg-4">
                <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden h-100 hover-lift transition-all d-flex flex-column position-relative">
                    
                    <!-- Wadah Gambar Bento -->
                    <div class="position-relative overflow-hidden bg-light" style="aspect-ratio: 4/3;">
                        <img src="{{ asset('storage/' . $item->foto_produk) }}" class="w-100 h-100 object-fit-cover transition-all duration-500" alt="{{ $item->nama_produk }}" role="button" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}" style="cursor: zoom-in;">
                        
                        <!-- Lencana Kategori Terapung -->
                        <span class="position-absolute top-0 start-0 m-3 badge bg-white text-dark fw-bold rounded-pill px-3 py-2 shadow-sm border border-light" style="font-size: 0.75rem;">
                            <i class="bi bi-shop text-success me-1"></i> {{ $item->kategori }}
                        </span>

                        <!-- Lencana Terverifikasi -->
                        <span class="position-absolute bottom-0 end-0 m-2 badge bg-success bg-opacity-90 text-white rounded-pill px-2 py-1 shadow-sm small">
                            <i class="bi bi-shield-check"></i> Terverifikasi
                        </span>
                    </div>

                    <!-- Tubuh Rincian Kartu -->
                    <div class="card-body p-4 d-flex flex-column flex-grow-1">
                        <div class="mb-1 text-muted small fw-bold tracking-wide text-uppercase">
                            {{ $item->nama_usaha }}
                        </div>
                        <h4 class="fw-bold text-dark mb-2" style="letter-spacing: -0.5px;">{{ $item->nama_produk }}</h4>
                        <p class="text-secondary small mb-4 flex-grow-1 lh-base" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $item->deskripsi }}
                        </p>

                        <!-- Blok Harga dan Pemesanan WhatsApp Langsung -->
                        <div class="mt-auto pt-3 border-top border-light">
                            <div class="d-flex align-items-baseline justify-content-between mb-3">
                                <span class="text-muted small">Harga Mulai</span>
                                <div class="text-end">
                                    <span class="fs-4 fw-bold text-success">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                    <span class="text-muted small">/ {{ $item->satuan }}</span>
                                </div>
                            </div>

                            <!-- Tombol Pemesanan Generator Tautan WA Instan (100% Nol Potongan) -->
                            <a href="https://wa.me/{{ $item->nomor_whatsapp }}?text=Halo%20{{ urlencode($item->nama_usaha) }},%20saya%20tertarik%20membeli%20produk%20*{{ urlencode($item->nama_produk) }}*%20yang%20dijual%20seharga%20Rp{{ number_format($item->harga, 0, ',', '.') }}%20di%20Pasar%20Digital%20Desa%20Jatiroyom." target="_blank" class="btn btn-success btn-premium rounded-pill fw-bold shadow-sm w-100 py-2 d-flex align-items-center justify-content-center gap-2 text-nowrap">
                                <i class="bi bi-whatsapp fs-5"></i> Beli via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="card border-0 rounded-4 shadow-sm p-5 max-w-md mx-auto bg-white">
                    <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-5369.jpg" width="200" class="mx-auto mb-3 opacity-50" loading="lazy">
                    <h5 class="fw-bold text-dark mb-1">Katalog Masih Kosong</h5>
                    <p class="text-muted mb-0">Belum ada produk pada kategori atau kata kunci yang Anda cari saat ini.</p>
                    @if(request('search') || request('kategori'))
                        <div class="mt-3">
                            <a href="{{ route('umkm.index') }}" class="btn btn-success rounded-pill px-4 fw-bold small">Lihat Seluruh Produk</a>
                        </div>
                    @endif
                </div>
            </div>
            @endforelse
        </div>

        <!-- Paginasi Bento -->
        @if($umkm->hasPages())
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $umkm->links() }}
            </div>
        </div>
        @endif

    </div>
</section>

<!-- Modal Detail Produk di Luar Struktur Grid agar Mobile Bebas Konflik -->
@foreach($umkm as $item)
    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
                <div class="row g-0">
                    <div class="col-md-6 bg-light d-flex align-items-center justify-content-center overflow-hidden" style="min-height: 300px;">
                        <img src="{{ asset('storage/' . $item->foto_produk) }}" class="w-100 h-100 object-fit-cover" alt="{{ $item->nama_produk }}">
                    </div>
                    <div class="col-md-6 d-flex flex-column justify-content-between p-4 p-md-5 bg-white">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold">{{ $item->kategori }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <h3 class="fw-bold text-dark mb-1">{{ $item->nama_produk }}</h3>
                            <p class="text-success fw-bold small mb-3"><i class="bi bi-shop me-1"></i> {{ $item->nama_usaha }}</p>
                            
                            <hr class="border-light my-3">
                            
                            <h6 class="fw-bold text-secondary small text-uppercase mb-2">Deskripsi Lengkap</h6>
                            <p class="text-dark small lh-base mb-4">{{ $item->deskripsi }}</p>
                        </div>
                        
                        <div>
                            <div class="p-3 bg-light rounded-4 mb-4">
                                <span class="text-muted small d-block mb-1">Harga Resmi Penjual</span>
                                <span class="fs-3 fw-bold text-success">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                <span class="text-muted small">/ {{ $item->satuan }}</span>
                            </div>

                            <a href="https://wa.me/{{ $item->nomor_whatsapp }}?text=Halo%20{{ urlencode($item->nama_usaha) }},%20saya%20tertarik%20membeli%20produk%20*{{ urlencode($item->nama_produk) }}*%20yang%20dijual%20seharga%20Rp{{ number_format($item->harga, 0, ',', '.') }}%20di%20Pasar%20Digital%20Desa%20Jatiroyom." target="_blank" class="btn btn-success btn-premium rounded-pill fw-bold shadow-sm w-100 py-3 d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-whatsapp fs-4"></i> Hubungi Penjual via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
