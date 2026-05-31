@extends('layouts.app')

@section('title', 'Anggaran Desa')

@section('styles')
<style>
    .page-header {
        position: relative;
        min-height: 75vh;
        margin-top: -76px;
        display: flex;
        align-items: center;
        background: linear-gradient(rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.6)), url('{{ asset('image/gambar-anggaran-desa-jatiroyom.png') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        color: white;
        overflow: hidden;
        transition: margin-top 0.35s ease-in-out;
        transform: translateZ(0);
        padding-top: 76px;
    }

    .page-header.pushed {
        margin-top: 0 !important;
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
        height: 80px;
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
        color: #d97706 !important;
    }

    .navbar .navbar-toggler {
        border-color: rgba(255,255,255,0.5) !important;
        background: rgba(255,255,255,0.1) !important;
    }

    .navbar.scrolled .navbar-toggler {
        border-color: rgba(0,0,0,0.1) !important;
        background: transparent !important;
    }

    .navbar .navbar-toggler-icon {
        filter: brightness(0) invert(1);
    }

    .navbar.scrolled .navbar-toggler-icon {
        filter: none;
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
            color: #d97706 !important;
        }
        .navbar.expanded .navbar-toggler-icon {
            filter: none !important;
        }
    }

    /* Budget Card Style */
    .budget-card {
        border: none;
        border-radius: 24px;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        background: white;
        overflow: hidden;
    }
    
    .hover-lift:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.12) !important;
    }

    .icon-box {
        width: 65px;
        height: 65px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
    }

    /* Curated Premium Tailored Colors for Anggaran Desa (Amber Gold Theme) */
    .text-amber-theme { color: #d97706 !important; }
    .bg-amber-theme { background-color: #d97706 !important; }
    .bg-amber-light { background-color: rgba(217, 119, 6, 0.08) !important; }
    .border-amber-theme { border-color: rgba(217, 119, 6, 0.2) !important; }
    .btn-outline-amber { color: #d97706; border-color: #d97706; background: transparent; }
    .btn-outline-amber:hover { background-color: #d97706; color: white; }
    .btn-amber { background-color: #d97706; color: white; border: none; }
    .btn-amber:hover { background-color: #b45309; color: white; }
</style>
@endsection

@section('content')
<section class="page-header text-center">
    <div class="container page-header-content">
        <div class="d-inline-block px-4 py-2 rounded-pill bg-white bg-opacity-10 text-white fw-bold mb-3 shadow-sm" style="letter-spacing: 2px; font-size: clamp(0.7rem, 1.5vw, 0.85rem); backdrop-filter: blur(5px);">
            <i class="bi bi-wallet2 me-2"></i> TRANSPARANSI DESA
        </div>
        <h1 class="fw-bold mb-3" style="font-size: clamp(2.2rem, 5vw, 3.5rem); font-family: 'Outfit', sans-serif; letter-spacing: -1px;">Anggaran & <span class="text-amber-theme">APBDes</span></h1>
        <p class="lead opacity-75 mx-auto" style="max-width: 700px; font-size: clamp(1rem, 2vw, 1.25rem);">Wujud keterbukaan informasi publik dalam pengelolaan Dana Desa Jatiroyom yang akuntabel.</p>
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
                <span class="badge bg-amber-light text-amber-theme rounded-pill px-4 py-2 mb-3 fw-bold shadow-sm" style="letter-spacing: 1px; font-size: clamp(0.7rem, 1.5vw, 0.85rem);">DOKUMEN PUBLIK</span>
                <h2 class="fw-bold text-dark mb-4" style="font-size: clamp(1.8rem, 4vw, 2.5rem); font-family: 'Outfit', sans-serif;">Komitmen Transparansi Kami</h2>
                <p class="text-muted lead px-lg-5">Kami berkomitmen mengelola dana desa secara transparan. Warga berhak mengetahui dan mengawasi setiap penggunaan anggaran desa.</p>
            </div>
        </div>

        <div class="row g-4">
            @forelse($anggaran as $ang)
            <div class="col-md-6">
                <div class="card budget-card p-4 shadow-sm hover-lift transition-all">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-amber-light text-amber-theme me-4 shadow-none">
                            <i class="bi bi-file-earmark-pdf-fill fs-2"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold text-dark mb-1" style="font-family: 'Outfit', sans-serif;">{{ $ang->judul }}</h5>
                            <p class="text-muted small mb-0">Tahun Anggaran: <span class="fw-bold text-amber-theme">{{ $ang->created_at->format('Y') }}</span></p>
                        </div>
                        <div class="ms-3">
                            <a href="{{ asset('storage/' . $ang->file_path) }}" target="_blank" class="btn btn-outline-amber btn-sm rounded-pill px-4 fw-bold">
                                <i class="bi bi-eye-fill me-1"></i> Lihat
                            </a>
                        </div>
                    </div>
                    <hr class="my-4 opacity-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small"><i class="bi bi-clock-history me-2"></i> Update: {{ $ang->created_at->format('d M Y') }}</span>
                        <a href="{{ route('anggaran.download', $ang) }}" class="btn btn-amber rounded-pill px-4 fw-bold shadow-sm">
                            <i class="bi bi-download me-2"></i> Unduh PDF
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="py-5 bg-white rounded-4 shadow-sm">
                    <i class="bi bi-folder-x text-muted display-1 mb-4 opacity-25"></i>
                    <h3 class="text-muted fw-bold">Laporan belum tersedia</h3>
                    <p class="text-muted">Pemerintah desa sedang menyiapkan laporan terbaru.</p>
                </div>
            </div>
            @endforelse
        </div>

        <div class="mt-5 p-4 p-md-5 bg-white rounded-4 shadow-sm border-0 position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-5 opacity-5">
                <i class="bi bi-info-circle-fill text-amber-theme" style="font-size: 15rem; margin-top: -50px; margin-right: -50px;"></i>
            </div>
            <div class="row align-items-center position-relative" style="z-index: 2;">
                <div class="col-lg-2 text-center mb-4 mb-lg-0">
                    <div class="bg-amber-light text-amber-theme rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 90px; height: 90px;">
                        <i class="bi bi-info-circle-fill fs-1"></i>
                    </div>
                </div>
                <div class="col-lg-10">
                    <h4 class="fw-bold mb-3" style="font-family: 'Outfit', sans-serif;">Informasi Lebih Lanjut</h4>
                    <p class="text-muted mb-0 lh-lg">Jika Anda memerlukan informasi lebih detail mengenai anggaran atau ingin memberikan saran pembangunan, silakan datang langsung ke Balai Desa Jatiroyom pada jam kerja atau hubungi kami melalui kanal pengaduan yang tersedia.</p>
                </div>
            </div>
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
