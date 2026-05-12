<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Desa Jatiroyom') - Sistem Surat Online</title>
    
    <!-- Ultra-Lightweight & Fast Load Preloads -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    
    <!-- Preload Critical Assets -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" as="style">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" as="style">
    <link rel="preload" href="{{ asset('image/logo-pemalang.png') }}" as="image">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="{{ asset('image/logo-pemalang.png') }}">
    
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #3b82f6;
            --accent-color: #f59e0b;
            --dark-bg: #0f172a;
        }

        /* Global Performance Fixes */
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
            overflow-x: hidden;
            color: #1e293b;
            line-height: 1.5;
        }

        /* Super Smooth Navbar with GPU Acceleration */
        .navbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            transform: translateZ(0);
            backface-visibility: hidden;
            perspective: 1000px;
            will-change: transform, background-color;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link {
            font-weight: 500;
            color: #334155;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: var(--primary-color);
        }

        .nav-link.active {
            color: var(--primary-color) !important;
            font-weight: 700;
            position: relative;
        }

        @media (min-width: 992px) {
            .nav-link {
                position: relative;
                padding-bottom: 5px;
            }
            .nav-link.active::after {
                content: '';
                position: absolute;
                bottom: -5px;
                left: 1rem;
                right: 1rem;
                height: 3px;
                background-color: var(--primary-color);
                border-radius: 50px;
                animation: slideIn 0.3s ease-out;
            }
        }

        @keyframes slideIn {
            from { transform: scaleX(0); opacity: 0; }
            to { transform: scaleX(1); opacity: 1; }
        }

        .btn-login {
            background-color: var(--primary-color);
            color: white;
            border-radius: 50px;
            padding: 8px 25px;
            font-weight: 600;
            transform: translateZ(0);
            backface-visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-login:hover {
            background-color: #1e3a8a;
            color: white;
            transform: translateY(-2px) translateZ(0);
            box-shadow: 0 8px 20px rgba(30, 64, 175, 0.25);
        }

        /* Fast Rendering Footer */
        footer {
            background-color: var(--dark-bg);
            color: #94a3b8;
            padding: 60px 0 30px;
            transform: translateZ(0);
            contain: content;
        }

        .footer-title {
            color: white;
            font-weight: 700;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 12px;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 35px;
            height: 3px;
            background-color: var(--secondary-color);
            border-radius: 2px;
        }

        .footer-link {
            color: #94a3b8;
            text-decoration: none;
            transition: transform 0.2s ease, color 0.2s ease;
            display: block;
            margin-bottom: 12px;
        }

        .footer-link:hover {
            color: white;
            transform: translateX(5px);
        }

        .social-icon {
            width: 38px;
            height: 38px;
            background: rgba(255,255,255,0.05);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            color: white;
            text-decoration: none;
            margin-right: 8px;
            transform: translateZ(0);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .social-icon:hover {
            background: var(--secondary-color);
            transform: translateY(-3px) translateZ(0);
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 12px;
            font-size: 0.95rem;
        }

        .contact-icon {
            color: var(--secondary-color);
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .footer-bottom {
            margin-top: 40px;
            padding-top: 25px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        .map-container {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.1);
            transform: translateZ(0);
            background: #1e293b;
        }

        /* Image Optimization */
        img[loading="lazy"] {
            opacity: 0;
            transition: opacity 0.4s ease-in;
        }

        img.lazy-loaded {
            opacity: 1;
        }
        
        /* Skeleton loading feel for slow networks */
        .img-placeholder {
            background: #e2e8f0;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: .5; }
            100% { opacity: 1; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <i class="bi bi-envelope-paper-fill text-primary me-2 fs-3"></i>
                <span class="fw-bold text-dark">Jatiroyom<span class="text-primary">Online</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link px-3 {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link px-3 {{ request()->routeIs('acara') ? 'active' : '' }}" href="{{ route('acara') }}">Acara Desa</a></li>
                    <li class="nav-item"><a class="nav-link px-3 {{ request()->routeIs('anggaran') ? 'active' : '' }}" href="{{ route('anggaran') }}">Anggaran</a></li>
                    <li class="nav-item ms-lg-3">
                        @auth
                            <a class="btn btn-login" href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : (auth()->user()->role == 'perangkat_desa' ? route('perangkat.dashboard') : route('user.dashboard')) }}">Login</a>
                        @else
                            <a class="btn btn-login" href="{{ route('login') }}">Login</a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    @php
        $footerSettings = \App\Models\System\Pengaturan::getAllCached();
    @endphp

    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center mb-4">
                        <i class="bi bi-envelope-paper-fill text-primary me-2 fs-2"></i>
                        <h4 class="fw-bold text-white mb-0">Jatiroyom<span class="text-primary">Online</span></h4>
                    </div>
                    <p class="mb-4 small" style="line-height: 1.6;">
                        {{ $footerSettings['profil_desa'] ?? 'Sistem pelayanan surat online Desa Jatiroyom untuk mempermudah warga dalam mengurus administrasi desa secara modern dan transparan.' }}
                    </p>
                    <div class="d-flex">
                        <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-title">Tautan Cepat</h6>
                    <a href="{{ route('home') }}" class="footer-link small">Beranda</a>
                    <a href="{{ route('acara') }}" class="footer-link small">Acara Desa</a>
                    <a href="{{ route('home') }}#keindahan" class="footer-link small">Galeri Desa</a>
                    <a href="{{ route('anggaran') }}" class="footer-link small">Anggaran</a>
                    <a href="{{ route('login') }}" class="footer-link small">Pelayanan Surat</a>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-title">Kontak Kami</h6>
                    <div class="contact-item">
                        <i class="bi bi-geo-alt contact-icon"></i>
                        <span>Jl. Utama Jatiroyom, Kec. Bodeh, Kab. Pemalang, Jawa Tengah 52365</span>
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-telephone contact-icon"></i>
                        <span>{{ $footerSettings['kontak'] ?? '0812-3456-7890' }}</span>
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-envelope contact-icon"></i>
                        <span>{{ $footerSettings['email'] ?? 'pemdes@jatiroyom.desa.id' }}</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-title">Lokasi Balai Desa</h6>
                    <div class="map-container shadow-lg">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.9694443689373!2d109.48115467421117!3d-7.012876468692579!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fde0314e45a91%3A0x28ff274f592e5266!2sBalai%20Desa%20Jatiroyom!5e0!3m2!1sid!2sid!4v1778600355455!5m2!1sid!2sid" 
                            width="100%" 
                            height="160" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

            <div class="footer-bottom text-center">
                <p class="mb-0 x-small opacity-75">
                    &copy; {{ date('Y') }} Pemerintah Desa Jatiroyom. Dikelola oleh Tim IT Desa. <br>
                    <span class="opacity-50">Sistem Informasi Pelayanan Digital - v2.1.2</span>
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // High-Performance Image Loader
        document.addEventListener('DOMContentLoaded', function() {
            const lazyImages = [].slice.call(document.querySelectorAll('img[loading="lazy"]'));
            if ("IntersectionObserver" in window) {
                let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            let lazyImage = entry.target;
                            lazyImage.classList.add('lazy-loaded');
                            lazyImageObserver.unobserve(lazyImage);
                        }
                    });
                });
                lazyImages.forEach(function(lazyImage) {
                    lazyImageObserver.observe(lazyImage);
                });
            } else {
                // Fallback for older browsers
                lazyImages.forEach(img => img.classList.add('lazy-loaded'));
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
