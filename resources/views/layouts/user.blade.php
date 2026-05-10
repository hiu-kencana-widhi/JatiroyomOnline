<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Warga - Desa Jatiroyom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-blue: #2563eb;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
            overflow-x: hidden;
        }
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #fff;
            border-right: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            z-index: 1050;
        }
        .sidebar.collapsed {
            left: calc(-1 * var(--sidebar-width));
        }
        .main-wrapper {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            min-height: 100vh;
        }
        .main-wrapper.expanded {
            margin-left: 0;
        }
        .top-bar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 25px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .nav-sidebar .nav-link {
            color: #64748b;
            padding: 12px 20px;
            border-radius: 12px;
            margin: 4px 15px;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: all 0.2s;
        }
        .nav-sidebar .nav-link i {
            font-size: 1.25rem;
            margin-right: 12px;
        }
        .nav-sidebar .nav-link.active {
            background-color: #eff6ff;
            color: var(--primary-blue);
        }
        .nav-sidebar .nav-link:hover:not(.active) {
            background-color: #f1f5f9;
            color: #1e293b;
        }
        .content-area {
            padding: 25px;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.4);
            z-index: 1040;
            backdrop-filter: blur(2px);
        }
        @media (max-width: 991.98px) {
            .sidebar { left: calc(-1 * var(--sidebar-width)); }
            .sidebar.show { left: 0; }
            .main-wrapper { margin-left: 0; }
            .sidebar-overlay.show { display: block; }
            .content-area { padding: 15px; }
        }

        /* Responsive Table Stack */
        @media (max-width: 767.98px) {
            .table-responsive-stack thead {
                display: none;
            }
            .table-responsive-stack tr {
                display: block;
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                margin-bottom: 15px;
                padding: 10px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            }
            .table-responsive-stack td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border: none !important;
                padding: 10px 15px !important;
                text-align: right;
                font-size: 0.9rem;
            }
            .table-responsive-stack td::before {
                content: attr(data-label);
                font-weight: 700;
                text-transform: uppercase;
                font-size: 0.65rem;
                color: #94a3b8;
                text-align: left;
                flex: 1;
            }
            .table-responsive-stack td > * {
                flex: 2;
                display: flex;
                justify-content: flex-end;
            }
            .table-responsive-stack .ps-4 {
                padding-left: 15px !important;
            }
            .table-responsive-stack .text-center {
                text-align: right !important;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="sidebar" id="sidebar">
        <div class="p-4 mb-3 d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 rounded-3 p-2 me-2">
                <i class="bi bi-person-badge text-primary fs-4"></i>
            </div>
            <span class="fw-bold fs-5 tracking-tight text-dark">Panel<span class="text-primary">Warga</span></span>
        </div>
        <nav class="nav-sidebar">
            <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door-fill"></i> Dashboard
            </a>
            <a href="{{ route('user.surat.pilih') }}" class="nav-link {{ request()->routeIs('user.surat.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-plus-fill"></i> Buat Surat
            </a>
            <a href="{{ route('user.riwayat') }}" class="nav-link {{ request()->routeIs('user.riwayat') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat
            </a>
            <a href="{{ route('user.profil') }}" class="nav-link {{ request()->routeIs('user.profil') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> Profil Saya
            </a>
            <div class="mt-5 px-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 rounded-pill fw-bold">
                        <i class="bi bi-box-arrow-left me-2"></i> Keluar
                    </button>
                </form>
            </div>
        </nav>
    </div>

    <div class="main-wrapper" id="mainWrapper">
        <div class="top-bar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-light rounded-circle me-3" id="toggleBtn">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <h6 class="mb-0 fw-bold d-none d-md-block text-dark">Layanan Mandiri Desa Jatiroyom</h6>
            </div>
            <div class="dropdown">
                <div class="d-flex align-items-center bg-light p-1 pe-3 rounded-pill" role="button" data-bs-toggle="dropdown">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                        {{ substr(auth()->user()->nama_lengkap, 0, 1) }}
                    </div>
                    <div class="small fw-bold d-none d-sm-block">{{ explode(' ', auth()->user()->nama_lengkap)[0] }}</div>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2" style="border-radius: 12px;">
                    <li><a class="dropdown-item rounded-3" href="{{ route('user.profil') }}"><i class="bi bi-person me-2"></i> Profil Saya</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item rounded-3 text-danger"><i class="bi bi-box-arrow-left me-2"></i> Keluar</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="content-area">
            @yield('content')
        </div>

        <footer class="mt-auto py-4 px-4 border-top bg-white">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="text-muted small">
                    &copy; {{ date('Y') }} <span class="fw-bold text-primary">E-Surat Jatiroyom</span>. Layanan Mandiri Warga.
                </div>
                <div class="d-flex gap-3">
                    <a href="https://wa.me/628123456789" class="text-decoration-none text-muted small"><i class="bi bi-whatsapp me-1"></i> Bantuan</a>
                    <a href="#" class="text-decoration-none text-muted small">Panduan</a>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('toggleBtn');
        const mainWrapper = document.getElementById('mainWrapper');

        function toggleSidebar() {
            if (window.innerWidth >= 992) {
                // Desktop Toggle
                sidebar.classList.toggle('collapsed');
                mainWrapper.classList.toggle('expanded');
            } else {
                // Mobile Toggle
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }
        }

        toggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            toggleSidebar();
        });

        overlay.addEventListener('click', toggleSidebar);
    </script>
    @yield('scripts')
</body>
</html>
