@extends('layouts.app')

@section('styles')
<style>
    /* Premium Landing Page Styling */
    /* Full Screen Hero with Transparent Navbar */
    .hero-section {
        position: relative;
        min-height: 100vh;
        margin-top: -76px; /* Offset for navbar height to make it truly full */
        display: flex;
        align-items: center;
        background: linear-gradient(rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.6)), 
                    url('{{ asset('image/gambar-jatiroyom1.png') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        color: white;
        overflow: hidden;
        transform: translateZ(0); /* Hardware Acceleration */
    }

    /* Navbar adjustment for home page */
    .navbar {
        background-color: transparent !important;
        backdrop-filter: none !important;
        box-shadow: none !important;
        transition: background-color 0.35s ease-in-out, box-shadow 0.35s ease-in-out, backdrop-filter 0.35s ease-in-out;
        transform: translateZ(0);
    }

    .navbar.scrolled {
        background: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(10px) !important;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1) !important;
    }

    .navbar .nav-link, .navbar .navbar-brand span {
        color: white !important;
        transition: color 0.3s;
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

    /* Mobile Navbar Toggler Fix */
    .navbar .navbar-toggler {
        border-color: rgba(255,255,255,0.5) !important;
        background: rgba(255,255,255,0.1) !important;
    }

    .navbar.scrolled .navbar-toggler {
        border-color: rgba(0,0,0,0.1) !important;
        background: transparent !important;
    }

    .navbar .navbar-toggler-icon {
        filter: brightness(0) invert(1); /* Make hamburger white */
    }

    .navbar.scrolled .navbar-toggler-icon {
        filter: none; /* Make hamburger default (dark) */
    }

    /* Mobile Menu - Push Down Style */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            background: transparent;
            padding: 0;
            margin-top: 0;
            transition: all 0.35s ease-in-out;
        }
        
        /* Smoothly show background on the WHOLE navbar when expanded */
        .navbar.expanded {
            background-color: white !important;
            backdrop-filter: blur(10px) !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
        }

        .navbar.expanded .navbar-collapse {
            padding: 10px 0 20px;
        }

        .navbar:not(.scrolled):not(.expanded) .nav-link {
            color: white !important;
        }
        
        .navbar.expanded .nav-link, 
        .navbar.scrolled .nav-link {
            color: #334155 !important;
        }

        .navbar.expanded .navbar-brand span, 
        .navbar.expanded .navbar-brand i,
        .navbar.expanded .navbar-toggler-icon {
            color: var(--primary-color) !important;
            filter: none !important;
        }
        
        /* Smooth push down effect */
        .hero-section {
            transition: margin-top 0.35s ease-in-out;
        }

        .hero-section.pushed {
            margin-top: 0 !important;
        }
    }

    .hero-content {
        z-index: 10;
        animation: fadeInUp 1s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateZ(0);
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateZ(0);
    }

    .glass-card:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-5px) translateZ(0);
    }

    .btn-premium {
        padding: 14px 35px;
        border-radius: 50px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateZ(0);
    }

    .gallery-img {
        height: 300px;
        object-fit: cover;
        border-radius: 20px;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateZ(0);
    }

    .gallery-img:hover {
        transform: scale(1.03) translateZ(0);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px) translateZ(0); }
        to { opacity: 1; transform: translateY(0) translateZ(0); }
    }

    .stat-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--bs-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
        transform: translateZ(0);
    }

    /* Responsive Modal Styling - Side-by-Side on Desktop */
    .modal-content {
        border-radius: 28px !important;
        border: none !important;
        transform: translateZ(0);
    }
    
    .modal-flex-container {
        display: flex;
        flex-direction: column;
    }

    @media (min-width: 992px) {
        .modal-flex-container {
            flex-direction: row;
            min-height: 500px;
        }
        .modal-img-side {
            width: 45%;
            min-height: 100%;
        }
        .modal-content-side {
            width: 55%;
            padding: 40px !important;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .modal-img-side img {
            height: 100% !important;
            width: 100%;
            object-fit: cover;
        }
        .modal-lg {
            max-width: 1000px;
        }
    }

    @media (max-width: 991px) {
        .modal-img-side img {
            height: 220px;
            width: 100%;
            object-fit: cover;
        }
        .modal-content-side {
            padding: 25px !important;
        }
    }

    /* Hover Lift Effect for Cards */
    .hover-lift {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        transform: translateZ(0);
        will-change: transform, box-shadow;
    }
    .hover-lift:hover {
        transform: translateY(-12px) translateZ(0);
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.15) !important;
    }
    .hover-lift:hover .bg-opacity-10 {
        background-opacity: 0.2 !important;
        transform: scale(1.1);
    }
    .shadow-soft {
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05), 0 5px 15px -8px rgba(0, 0, 0, 0.05) !important;
    }
    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08) !important;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--bs-primary) 0%, transparent 100%);
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section text-center px-3">
    <div class="container hero-content">
        <span class="badge bg-primary rounded-pill px-4 py-2 mb-3 fw-bold text-uppercase" style="letter-spacing: 2px;">Selamat Datang</span>
        <h1 class="display-2 fw-bold mb-3">Pesona Desa <span class="text-primary">Jatiroyom</span></h1>
        <p class="lead mb-5 mx-auto opacity-75" style="max-width: 700px;">
            Mewujudkan tata kelola desa yang modern, transparan, dan mandiri melalui inovasi pelayanan digital terbaik untuk seluruh warga.
        </p>
        <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
            @auth
                <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}" class="btn btn-primary btn-premium shadow-lg">
                    <i class="bi bi-speedometer2 me-2"></i> Masuk ke Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-premium shadow-lg">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Ajukan Surat Sekarang
                </a>
                <a href="#keindahan" class="btn btn-outline-light btn-premium">
                    <i class="bi bi-camera-fill me-2"></i> Jelajahi Desa
                </a>
            @endauth
        </div>
    </div>
    
    <!-- Decorative Wave -->
    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="line-height: 0;">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="position: relative; display: block; width: calc(100% + 1.3px); height: 80px; transform: rotate(180deg);">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<!-- Visi & Misi Section -->
<section id="visimisi" class="py-5 bg-white overflow-hidden position-relative">
    <!-- Premium Background Glow -->
    <div class="position-absolute top-0 start-50 translate-middle-x w-100 h-100 pointer-events-none opacity-50">
        <div class="position-absolute top-0 start-0 translate-middle bg-primary rounded-circle" style="width: 500px; height: 500px; filter: blur(150px); opacity: 0.1;"></div>
        <div class="position-absolute bottom-0 end-0 translate-middle bg-success rounded-circle" style="width: 400px; height: 400px; filter: blur(120px); opacity: 0.1;"></div>
    </div>

    <div class="container py-lg-5 position-relative">
        <!-- Visi: Centered Top Layout -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10 text-center">
                <div class="d-inline-block px-4 py-2 rounded-pill bg-primary bg-opacity-10 text-primary fw-bold mb-4 shadow-sm" style="letter-spacing: 2px; font-size: 0.85rem;">
                    <i class="bi bi-shield-check me-2"></i> KOMITMEN DESA
                </div>
                <h2 class="display-5 fw-bold mb-4 text-dark" style="letter-spacing: -1px;">Arah Masa Depan Jatiroyom</h2>
                
                <div class="mx-auto" style="max-width: 950px;">
                    <div class="card border-0 rounded-4 bg-white shadow-sm hover-lift transition-all position-relative overflow-hidden" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#visiModal">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4 d-none d-md-block">
                                <div class="h-100 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center p-5">
                                    <i class="bi bi-patch-check-fill text-primary" style="font-size: 8rem; opacity: 0.2;"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4 p-md-5 text-center text-md-start">
                                    <h4 class="fw-bold text-primary mb-3"><i class="bi bi-eye-fill me-2"></i> Visi Desa</h4>
                                    <p class="mb-0 fs-4 text-dark lh-base" style="font-family: 'Outfit', sans-serif; font-weight: 600; letter-spacing: -0.5px;">
                                        "Mewujudkan Desa Jatiroyom yang Mandiri, Sejahtera, dan Berbudaya melalui Tata Kelola Pemerintahan yang Transparan dan Inovatif."
                                    </p>
                                    <div class="mt-4 text-muted small fw-bold"><i class="bi bi-arrows-angle-expand me-1"></i> Klik untuk memperbesar informasi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visi Modal -->
        <div class="modal fade" id="visiModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 30px;">
                    <div class="modal-body p-5 text-center">
                        <div class="stat-circle mb-4 bg-primary bg-opacity-10 text-primary mx-auto" style="width: 80px; height: 80px;">
                            <i class="bi bi-stars fs-1"></i>
                        </div>
                        <h4 class="fw-bold mb-4">Visi Desa Jatiroyom</h4>
                        <p class="fs-4 text-dark italic lh-base">
                            "Mewujudkan Desa Jatiroyom yang Mandiri, Sejahtera, dan Berbudaya melalui Tata Kelola Pemerintahan yang Transparan dan Inovatif."
                        </p>
                        <button type="button" class="btn btn-primary rounded-pill px-5 mt-4 fw-bold" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Misi: Grid Bottom Layout -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-12">
                <div class="text-center mb-5">
                    <div class="d-inline-block px-4 py-2 rounded-pill bg-success bg-opacity-10 text-success fw-bold mb-3 shadow-sm" style="letter-spacing: 2px; font-size: 0.85rem;">
                        <i class="bi bi-rocket-takeoff me-2"></i> MISI STRATEGIS
                    </div>
                    <h3 class="display-6 fw-bold text-dark">Langkah Nyata Membangun Desa</h3>
                </div>
                
                <div class="row g-4 px-2">
                    @php
                        $misi = [
                            ['id' => 'digital', 'icon' => 'bi-display', 'color' => 'primary', 'title' => 'Digitalisasi', 'desc' => 'Transformasi pelayanan publik berbasis teknologi untuk efisiensi dan transparansi maksimal bagi warga.'],
                            ['id' => 'mandiri', 'icon' => 'bi-cash-stack', 'color' => 'success', 'title' => 'Kemandirian', 'desc' => 'Pemberdayaan ekonomi melalui UMKM lokal dan optimalisasi potensi sumber daya alam berkelanjutan.'],
                            ['id' => 'infra', 'icon' => 'bi-truck', 'color' => 'warning', 'title' => 'Infrastruktur', 'desc' => 'Pemerataan pembangunan sarana fisik yang berkualitas dan berdaya guna di setiap dusun secara merata.'],
                            ['id' => 'sosial', 'icon' => 'bi-people', 'color' => 'danger', 'title' => 'Sosial Budaya', 'desc' => 'Memperkuat semangat gotong royong dan melestarikan warisan budaya luhur serta kearifan lokal.']
                        ];
                    @endphp

                    @foreach($misi as $m)
                    <div class="col-6 col-lg-3">
                        <div class="card border-0 rounded-4 p-3 p-md-4 h-100 bg-white shadow-soft hover-lift transition-all text-center cursor-pointer" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#misiModal{{ $m['id'] }}">
                            <!-- Icon with Gradient Background -->
                            <div class="d-flex align-items-center justify-content-center mb-3 mb-md-4 mx-auto rounded-4 bg-{{ $m['color'] }} bg-opacity-10 text-{{ $m['color'] }}" style="width: 50px; height: 50px; transition: 0.3s;">
                                <i class="bi {{ $m['icon'] }} fs-4 fs-md-2"></i>
                            </div>
                            <h6 class="fw-bold mb-2 mb-md-3 text-dark">{{ $m['title'] }}</h6>
                            <p class="text-muted x-small small-md mb-0 lh-base lh-md-lg">{{ $m['desc'] }}</p>
                            
                            <!-- Bottom Line Accent -->
                            <div class="mt-4 mx-auto bg-{{ $m['color'] }} opacity-25" style="width: 40px; height: 3px; border-radius: 10px;"></div>
                        </div>
                    </div>

                    <!-- Misi Modal -->
                    <div class="modal fade" id="misiModal{{ $m['id'] }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 30px;">
                                <div class="modal-body p-5 text-center">
                                    <div class="stat-circle mb-4 bg-{{ $m['color'] }} bg-opacity-10 text-{{ $m['color'] }} mx-auto" style="width: 80px; height: 80px;">
                                        <i class="bi {{ $m['icon'] }} fs-1"></i>
                                    </div>
                                    <h4 class="fw-bold mb-3">{{ $m['title'] }}</h4>
                                    <p class="text-muted lh-lg">
                                        {{ $m['desc'] }}
                                    </p>
                                    <button type="button" class="btn btn-{{ $m['color'] }} rounded-pill px-5 mt-4 fw-bold text-white" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</section>

<!-- Potret Desa Kita Section -->
<section id="keindahan" class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Potret Desa Kita</h2>
            <div class="bg-primary mx-auto mb-3" style="width: 60px; height: 4px; border-radius: 2px;"></div>
            <p class="text-muted">Panorama alam Desa Jatiroyom yang asri dan menyejukkan.</p>
        </div>
        <div class="row g-4">
            @forelse($potret as $p)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 cursor-pointer shadow-hover hover-lift" data-bs-toggle="modal" data-bs-target="#wisataModal{{ $p->id }}" style="cursor: pointer;">
                    <img src="{{ asset('storage/' . $p->gambar) }}" class="w-100" style="height: 250px; object-fit: cover;" alt="{{ $p->judul }}" loading="lazy">
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bold text-dark mb-2">{{ $p->judul }}</h5>
                        <p class="text-muted small mb-0">{{ Str::limit($p->deskripsi, 60) }}</p>
                        <div class="mt-3 text-primary small fw-bold">Lihat Detail <i class="bi bi-zoom-in"></i></div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">Belum ada potret desa yang diunggah.</div>
            @endforelse
        </div>
    </div>

    <!-- Modals Wisata -->
    @foreach($potret as $p)
    <div class="modal fade" id="wisataModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content overflow-hidden shadow-lg">
                <div class="modal-flex-container">
                    <div class="modal-img-side">
                        <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->judul }}" loading="lazy">
                    </div>
                    <div class="modal-content-side">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 fw-bold small text-uppercase">Wisata</span>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <h3 class="fw-bold text-dark mb-4">{{ $p->judul }}</h3>
                        <div class="text-secondary" style="font-size: 0.95rem; line-height: 1.6;">
                            {{ $p->deskripsi }}
                        </div>
                        <div class="mt-4 pt-3 border-top">
                            <button type="button" class="btn btn-light rounded-pill px-4 fw-bold w-100" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</section>

<!-- Stats & Info -->
<section class="py-5 bg-white">
    <div class="container py-4 text-center">
        <div class="row g-5">
            <div class="col-6 col-md-3">
                <div class="stat-circle text-white mb-3"><i class="bi bi-people-fill fs-3"></i></div>
                <h2 class="fw-bold mb-0">2.450</h2>
                <small class="text-muted fw-bold text-uppercase">Penduduk</small>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-circle text-white mb-3"><i class="bi bi-check-circle-fill fs-3"></i></div>
                <h2 class="fw-bold mb-0">100%</h2>
                <small class="text-muted fw-bold text-uppercase">Pelayanan Digital</small>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-circle text-white mb-3"><i class="bi bi-award-fill fs-3"></i></div>
                <h2 class="fw-bold mb-0">3</h2>
                <small class="text-muted fw-bold text-uppercase">Penghargaan Desa</small>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-circle text-white mb-3"><i class="bi bi-geo-alt-fill fs-3"></i></div>
                <h2 class="fw-bold mb-0">45</h2>
                <small class="text-muted fw-bold text-uppercase">Hektar Wisata</small>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container py-4">
        <h2 class="fw-bold mb-4">Butuh Pelayanan Surat Sekarang?</h2>
        <p class="mb-5 opacity-75">Hemat waktu Anda dengan mengurus surat secara mandiri tanpa harus mengantre di Balai Desa.</p>
        <a href="{{ route('login') }}" class="btn btn-light btn-lg px-5 rounded-pill fw-bold shadow">
            Mulai Pengajuan <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </div>
</section>
@endsection

@section('scripts')
<script>
    const navbar = document.querySelector('.navbar');
    const hero = document.querySelector('.hero-section');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    // Throttled Scroll Handling for Ultra Smooth Performance
    let ticking = false;
    window.addEventListener('scroll', function() {
        if (!ticking) {
            window.requestAnimationFrame(function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
                ticking = false;
            });
            ticking = true;
        }
    });

    // Handle Mobile Menu Open/Close for "Push Down" effect
    navbarCollapse.addEventListener('show.bs.collapse', function () {
        navbar.classList.add('expanded');
        hero.classList.add('pushed');
    });

    navbarCollapse.addEventListener('hide.bs.collapse', function () {
        navbar.classList.remove('expanded');
        hero.classList.remove('pushed');
    });
</script>
@endsection
