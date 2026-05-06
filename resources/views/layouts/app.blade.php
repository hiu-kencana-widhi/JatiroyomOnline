<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Desa Jatiroyom') - Sistem Surat Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="{{ asset('image/logo-pemalang.png') }}">
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #3b82f6;
            --accent-color: #f59e0b;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }
        .nav-link {
            font-weight: 500;
            color: #334155;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: var(--primary-color);
        }
        .btn-login {
            background-color: var(--primary-color);
            color: white;
            border-radius: 50px;
            padding: 8px 25px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background-color: #1e3a8a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 64, 175, 0.3);
        }
        footer {
            background-color: #0f172a;
            color: #94a3b8;
            padding: 40px 0;
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
                    <li class="nav-item"><a class="nav-link px-3" href="/">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#acara">Acara Desa</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#anggaran">Anggaran</a></li>
                    <li class="nav-item ms-lg-3">
                        @auth
                            <a class="btn btn-login" href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}">Dashboard</a>
                        @else
                            <a class="btn btn-login" href="{{ route('login') }}">Masuk NIK</a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="mt-5">
        <div class="container text-center">
            <p class="mb-2">&copy; {{ date('Y') }} Pemerintah Desa Jatiroyom. All Rights Reserved.</p>
            <small>Kecamatan Bodeh, Kabupaten Pemalang, Jawa Tengah</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
