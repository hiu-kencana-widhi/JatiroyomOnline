@extends('layouts.app')

@section('title', 'Pasar Digital & UMKM - Desa Jatiroyom')

@section('styles')
<style>
    .page-header {
        position: relative;
        min-height: 60vh;
        margin-top: -76px;
        display: flex;
        align-items: center;
        background: linear-gradient(rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.6)), url('{{ asset('image/gambar-umkm-desa-jatiroyom.png') }}?v={{ time() }}') !important;
        background-size: cover !important;
        background-position: center !important;
        background-attachment: fixed !important;
        color: white;
        overflow: hidden;
        transition: margin-top 0.35s ease-in-out;
        transform: translateZ(0);
        padding-top: 76px; /* Offset for navbar height */
    }

    .page-header-content {
        z-index: 10;
        animation: fadeInUp 1s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateZ(0);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px) translateZ(0); }
        to { opacity: 1; transform: translateY(0) translateZ(0); }
    }

    .page-header.pushed {
        margin-top: 0 !important;
    }

    /* Transparent Navbar for this page */
    .navbar {
        background-color: transparent !important;
        backdrop-filter: none !important;
        box-shadow: none !important;
        transition: all 0.35s ease-in-out;
    }

    .navbar.scrolled {
        background: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(12px) !important;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05) !important;
    }

    .navbar .nav-link, .navbar .navbar-brand span {
        color: white !important;
    }

    .navbar.scrolled .nav-link, .navbar.scrolled .navbar-brand span {
        color: #334155 !important;
    }

    .navbar .navbar-brand i {
        color: white !important;
    }

    .navbar.scrolled .navbar-brand i {
        color: var(--primary-color) !important;
    }

    .navbar .navbar-toggler {
        border-color: rgba(255,255,255,0.5) !important;
        background: rgba(255,255,255,0.1) !important;
    }

    .navbar.scrolled .navbar-toggler {
        border-color: rgba(0,0,0,0.1) !important;
        background: transparent !important;
    }

    .navbar.scrolled .navbar-toggler-icon {
        filter: none;
    }

    .navbar .navbar-toggler-icon {
        filter: brightness(0) invert(1);
    }

    /* Mobile Menu Fix */
    @media (max-width: 991.98px) {
        .navbar.expanded {
            background-color: white !important;
            backdrop-filter: blur(12px) !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
        }
        .navbar.expanded .nav-link, 
        .navbar.expanded .navbar-brand span,
        .navbar.expanded .navbar-brand i {
            color: #334155 !important;
        }
        .navbar.expanded .navbar-toggler-icon {
            filter: none !important;
        }
    }

    .bento-card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }
    .bento-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important;
    }
    .bento-img {
        height: 240px;
        object-fit: cover;
        width: 100%;
    }
    .glass-modal .modal-content {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 24px;
        border: none;
    }
</style>
@endsection

@section('content')
<!-- Premium Parallax Header -->
<section class="page-header text-center">
    <div class="container page-header-content">
        <span class="badge bg-success rounded-pill px-4 py-2 mb-3 fw-bold text-uppercase shadow-sm" style="letter-spacing: 2px;">PASAR DIGITAL DESA</span>
        <h1 class="fw-bold mb-3 tracking-tight" style="font-size: clamp(2.2rem, 5vw, 3.5rem); font-family: 'Outfit', sans-serif;">Katalog Etalase <span class="text-success">UMKM</span></h1>
        <p class="lead max-w-2xl mx-auto text-white-50 mb-0" style="max-width: 700px; font-size: clamp(1rem, 2vw, 1.25rem);">
            Dukung ekonomi lokal dengan membeli produk unggulan, kuliner khas, dan kerajinan tangan warga Jatiroyom.
        </p>
    </div>
    
    <!-- Wave Divider Bawah -->
    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="line-height: 0; z-index: 5;">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="position: relative; display: block; width: calc(100% + 1.3px); height: 80px; transform: rotate(180deg);">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="#f8fafc"></path>
        </svg>
    </div>
</section>

<section class="py-5 min-vh-100" style="background-color: #f8fafc;">
    <div class="container py-4">
        
        <!-- Baris Pencarian dan Saringan Bento Kategori -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10 page-header-content">
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
                    <a href="{{ route('umkm.index', array_merge(request()->except('kategori', 'page'))) }}" class="btn rounded-pill px-4 py-2 fw-bold transition-all {{ !request('kategori') ? 'btn-success shadow-sm' : 'btn-white bg-white text-secondary shadow-sm hover-lift border' }}" style="font-size: 0.9rem;">
                        <i class="bi bi-grid-fill me-1"></i> Semua Kategori
                    </a>
                    @foreach($kategoriList as $kat)
                        <a href="{{ route('umkm.index', array_merge(request()->except('page'), ['kategori' => $kat])) }}" class="btn rounded-pill px-4 py-2 fw-bold transition-all {{ request('kategori') === $kat ? 'btn-success shadow-sm' : 'btn-white bg-white text-secondary shadow-sm hover-lift border' }}" style="font-size: 0.9rem;">
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
                <div class="card bento-card shadow-sm bg-white h-100 d-flex flex-column position-relative">
                    
                    <!-- Wadah Gambar Bento -->
                    <div class="position-relative overflow-hidden bg-light">
                        @if($item->foto_produk)
                            <img src="{{ asset('storage/' . $item->foto_produk) }}" class="bento-img transition-all duration-500" alt="{{ $item->nama_produk }}" role="button" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}" style="cursor: zoom-in;" onerror="this.src='https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=600';">
                        @else
                            <div class="bento-img bg-success bg-opacity-10 d-flex align-items-center justify-content-center">
                                <i class="bi bi-shop text-success display-4"></i>
                            </div>
                        @endif
                        
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
                    <div class="card-body p-4 d-flex flex-column flex-grow-1 text-start">
                        <div class="mb-1 text-muted small fw-bold tracking-wide text-uppercase d-flex align-items-center gap-1">
                            <i class="bi bi-person-check text-success"></i> {{ $item->nama_usaha }}
                        </div>
                        <h5 class="fw-bold text-dark mb-2" style="font-family: 'Outfit', sans-serif;">{{ $item->nama_produk }}</h5>
                        <p class="text-secondary small mb-4 flex-grow-1 lh-base" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $item->deskripsi }}
                        </p>

                        <!-- Blok Harga dan Pemesanan WhatsApp Langsung -->
                        <div class="mt-auto pt-3 border-top border-light">
                            <div class="d-flex align-items-baseline justify-content-between mb-3">
                                <span class="text-muted small">Harga Mulai</span>
                                <div class="text-end">
                                    <span class="fs-5 fw-bold text-success">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                    <span class="text-muted small">/ {{ $item->satuan }}</span>
                                </div>
                            </div>

                            <!-- Tombol Pemesanan Generator Tautan WA Instan (100% Nol Potongan) -->
                            <a href="https://wa.me/{{ $item->nomor_whatsapp }}?text=Halo%20{{ urlencode($item->nama_usaha) }},%20saya%20tertarik%20membeli%20produk%20*{{ urlencode($item->nama_produk) }}*%20yang%20dijual%20seharga%20Rp{{ number_format($item->harga, 0, ',', '.') }}%20di%20Pasar%20Digital%20Desa%20Jatiroyom." target="_blank" class="btn btn-success rounded-pill fw-bold shadow-sm w-100 py-2 d-flex align-items-center justify-content-center gap-2 text-nowrap">
                                <i class="bi bi-whatsapp fs-5"></i> Beli via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="card border-0 rounded-4 shadow-sm p-5 max-w-md mx-auto bg-white">
                    <i class="bi bi-basket3 text-muted display-1 mb-3 opacity-50"></i>
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
    <div class="modal fade glass-modal" id="detailModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content overflow-hidden shadow-lg border-0">
                <div class="row g-0">
                    <div class="col-lg-5 bg-light d-flex align-items-center justify-content-center overflow-hidden" style="min-height: 300px;">
                        <img src="{{ asset('storage/' . $item->foto_produk) }}" class="w-100 h-100 object-fit-cover" alt="{{ $item->nama_produk }}" onerror="this.src='https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=600';">
                    </div>
                    <div class="col-lg-7 d-flex flex-column justify-content-between p-4 p-lg-5 bg-white text-start">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold">{{ $item->kategori }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <h3 class="fw-bold text-dark mb-1" style="font-family: 'Outfit', sans-serif;">{{ $item->nama_produk }}</h3>
                            <p class="text-success fw-bold small mb-3"><i class="bi bi-shop me-1"></i> {{ $item->nama_usaha }}</p>
                            
                            <hr class="border-light my-3">
                            
                            <h6 class="fw-bold text-secondary small text-uppercase mb-2">Deskripsi Lengkap</h6>
                            <p class="text-dark small lh-base mb-4" style="line-height: 1.7;">{{ $item->deskripsi }}</p>
                        </div>
                        
                        <div class="mt-4">
                            <div class="p-3 bg-light rounded-4 mb-4">
                                <span class="text-muted small d-block mb-1">Harga Resmi Penjual</span>
                                <span class="fs-4 fw-bold text-success">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                <span class="text-muted small">/ {{ $item->satuan }}</span>
                            </div>

                            <a href="https://wa.me/{{ $item->nomor_whatsapp }}?text=Halo%20{{ urlencode($item->nama_usaha) }},%20saya%20tertarik%20membeli%20produk%20*{{ urlencode($item->nama_produk) }}*%20yang%20dijual%20seharga%20Rp{{ number_format($item->harga, 0, ',', '.') }}%20di%20Pasar%20Digital%20Desa%20Jatiroyom." target="_blank" class="btn btn-success rounded-pill fw-bold shadow-sm w-100 py-3 d-flex align-items-center justify-content-center gap-2">
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

@section('scripts')
<script>
    const navbar = document.querySelector('.navbar');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    const header = document.querySelector('.page-header');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Handle Mobile Menu Open/Close for background color and push down effect
    if (navbarCollapse && header) {
        navbarCollapse.addEventListener('show.bs.collapse', function () {
            navbar.classList.add('expanded');
            header.classList.add('pushed');
        });

        navbarCollapse.addEventListener('hide.bs.collapse', function () {
            navbar.classList.remove('expanded');
            header.classList.remove('pushed');
        });
    }
</script>
@endsection
