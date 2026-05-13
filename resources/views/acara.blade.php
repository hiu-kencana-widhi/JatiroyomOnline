@extends('layouts.app')

@section('title', 'Acara Desa')

@section('styles')
<style>
    .page-header {
        position: relative;
        min-height: 75vh;
        margin-top: -76px;
        display: flex;
        align-items: center;
        background: linear-gradient(rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.6)), url('{{ asset('image/gambar-acara-desa-jatiroyom.png') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
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

    .hero-wave {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
        transform: rotate(180deg);
        z-index: 5;
    }

    .hero-wave svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 60px;
    }

    .hero-wave .shape-fill {
        fill: #f8fafc;
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
        color: #8b5cf6 !important;
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
        .navbar.expanded .navbar-brand span {
            color: #334155 !important;
        }
        .navbar.expanded .navbar-brand i {
            color: #8b5cf6 !important;
        }
        .navbar.expanded .navbar-toggler-icon {
            filter: none !important;
        }
    }

    .event-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }
    .event-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .event-img {
        height: 220px;
        object-fit: cover;
    }
    .glass-modal .modal-content {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 30px;
        border: none;
    }

    /* Curated Premium Tailored Colors for Acara Desa (Amethyst Purple Theme) */
    .text-purple-theme { color: #8b5cf6 !important; }
    .bg-purple-theme { background-color: #8b5cf6 !important; }
    .bg-purple-light { background-color: rgba(139, 92, 246, 0.08) !important; }
    .border-purple-theme { border-color: rgba(139, 92, 246, 0.2) !important; }
</style>
@endsection

@section('content')
<section class="page-header text-center">
    <div class="container page-header-content">
        <div class="d-inline-block px-4 py-2 rounded-pill bg-white bg-opacity-10 text-white fw-bold mb-3 shadow-sm" style="letter-spacing: 2px; font-size: clamp(0.7rem, 1.5vw, 0.85rem); backdrop-filter: blur(5px);">
            <i class="bi bi-calendar-check me-2"></i> AGENDA DESA
        </div>
        <h1 class="fw-bold mb-3" style="font-size: clamp(2.2rem, 5vw, 3.5rem); font-family: 'Outfit', sans-serif; letter-spacing: -1px;">Acara & Agenda <span class="text-purple-theme">Jatiroyom</span></h1>
        <p class="lead opacity-75 mx-auto" style="max-width: 700px; font-size: clamp(1rem, 2vw, 1.25rem);">Informasi lengkap mengenai kegiatan masyarakat dan agenda pemerintahan mendatang di Desa Jatiroyom.</p>
    </div>

    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="line-height: 0; z-index: 5;">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="position: relative; display: block; width: calc(100% + 1.3px); height: 80px; transform: rotate(180deg);">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="#f8fafc"></path>
        </svg>
    </div>
</section>

<section class="py-5" style="background-color: #f8fafc;">
    <div class="container py-4">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center page-header-content">
                <span class="badge bg-purple-light text-purple-theme rounded-pill px-4 py-2 mb-3 fw-bold shadow-sm" style="letter-spacing: 1px; font-size: clamp(0.7rem, 1.5vw, 0.85rem);">AGENDA TERPADU</span>
                <h2 class="fw-bold text-dark mb-4" style="font-size: clamp(1.8rem, 4vw, 2.5rem); font-family: 'Outfit', sans-serif;">Kebersamaan Membangun Desa</h2>
                <p class="text-muted lead px-lg-5">Kami berkomitmen untuk selalu menginformasikan setiap agenda dan kegiatan desa secara terbuka guna meningkatkan partisipasi aktif dan mempererat silaturahmi seluruh warga.</p>
            </div>
        </div>

        <div class="row g-4">
            @forelse($acara as $ac)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 rounded-4 shadow-sm h-100 hover-lift transition-all cursor-pointer overflow-hidden bg-white" data-bs-toggle="modal" data-bs-target="#acaraModal{{ $ac->id }}">
                    <div class="position-relative">
                        @if($ac->gambar)
                            <img src="{{ asset('storage/' . $ac->gambar) }}" class="event-img w-100" style="height: 250px; object-fit: cover;" alt="{{ $ac->judul }}">
                        @else
                            <div class="event-img bg-purple-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                <i class="bi bi-calendar-event text-purple-theme display-4"></i>
                            </div>
                        @endif
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-white text-purple-theme rounded-pill px-3 py-2 fw-bold shadow-sm">
                                <i class="bi bi-tag-fill me-1"></i> Kegiatan
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-4 text-center text-md-start">
                        <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-3">
                            <div class="bg-purple-light text-purple-theme rounded-pill px-3 py-1 small fw-bold">
                                <i class="bi bi-calendar3 me-2"></i>{{ \Carbon\Carbon::parse($ac->tanggal)->format('d M Y') }}
                            </div>
                        </div>
                        <h5 class="fw-bold text-dark mb-3" style="font-family: 'Outfit', sans-serif;">{{ $ac->judul }}</h5>
                        <p class="text-muted small mb-4 lh-lg">{{ Str::limit($ac->deskripsi, 100) }}</p>
                        <div class="d-flex align-items-center justify-content-center justify-content-md-start text-purple-theme fw-bold small">
                            Lihat Detail Acara <i class="bi bi-arrow-right ms-2"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Acara -->
            <div class="modal fade glass-modal" id="acaraModal{{ $ac->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content overflow-hidden">
                        <div class="row g-0">
                            @if($ac->gambar)
                            <div class="col-lg-5">
                                <img src="{{ asset('storage/' . $ac->gambar) }}" class="w-100 h-100" style="object-fit: cover; min-height: 300px;" alt="{{ $ac->judul }}">
                            </div>
                            @endif
                            <div class="{{ $ac->gambar ? 'col-lg-7' : 'col-12' }} p-4 p-lg-5">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="badge bg-purple-theme text-white rounded-pill px-3 py-2">
                                        {{ \Carbon\Carbon::parse($ac->tanggal)->format('d F Y') }}
                                    </span>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <h3 class="fw-bold mb-3">{{ $ac->judul }}</h3>
                                <div class="d-flex align-items-center text-muted mb-4">
                                    <i class="bi bi-geo-alt-fill text-danger me-2"></i> {{ $ac->lokasi ?? 'Desa Jatiroyom' }}
                                </div>
                                <div class="text-secondary" style="line-height: 1.8;">
                                    {!! nl2br(e($ac->deskripsi)) !!}
                                </div>
                                <div class="mt-5">
                                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold w-100" data-bs-dismiss="modal">Tutup Detail</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="py-5">
                    <i class="bi bi-calendar-x text-muted display-1 mb-4"></i>
                    <h3 class="text-muted">Belum ada acara yang terdaftar</h3>
                    <p class="text-muted">Silakan kembali lagi nanti untuk informasi kegiatan terbaru.</p>
                </div>
            </div>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $acara->links() }}
        </div>
    </div>
</section>
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
    navbarCollapse.addEventListener('show.bs.collapse', function () {
        navbar.classList.add('expanded');
        header.classList.add('pushed');
    });

    navbarCollapse.addEventListener('hide.bs.collapse', function () {
        navbar.classList.remove('expanded');
        header.classList.remove('pushed');
    });
</script>
@endsection
