<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Perangkat Desa - Jatiroyom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="{{ asset('image/logo-jatiroyomonline.png') }}">
    <link rel="preload" href="{{ asset('image/logo-jatiroyomonline.png') }}" as="image">
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-bg: #0f172a;
            --primary-teal: #0d9488;
            --primary-teal-light: #ccfbf1;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
            overflow-x: hidden;
            color: #1e293b;
        }
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--primary-bg);
            color: #fff;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1050;
            box-shadow: 4px 0 10px rgba(0,0,0,0.05);
            overflow-y: auto;
        }
        .sidebar.collapsed {
            left: calc(-1 * var(--sidebar-width));
        }
        .main-wrapper {
            margin-left: var(--sidebar-width);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
            z-index: 1045;
        }
        .nav-sidebar .nav-link {
            color: #94a3b8;
            padding: 12px 18px;
            border-radius: 12px;
            margin: 6px 16px;
            display: flex;
            align-items: center;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-sidebar .nav-link i {
            font-size: 1.2rem;
            width: 28px;
            text-align: left;
            margin-right: 10px;
            transition: transform 0.2s ease;
        }
        .nav-sidebar .nav-link.active {
            background-color: var(--primary-teal);
            color: #fff;
            font-weight: 600;
        }
        .nav-sidebar .nav-link:hover:not(.active) {
            background-color: rgba(255, 255, 255, 0.06);
            color: #f8fafc;
            transform: translateX(6px);
        }
        .content-area {
            padding: 30px;
            flex: 1;
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
            backdrop-filter: blur(4px);
        }
        @media (max-width: 991.98px) {
            .sidebar { left: calc(-1 * var(--sidebar-width)); }
            .sidebar.show { left: 0; }
            .main-wrapper { margin-left: 0; }
            .sidebar-overlay.show { display: block; }
            .content-area { padding: 20px; }
        }

        /* Responsive Table Stack */
        @media (max-width: 767.98px) {
            .table-responsive-stack thead {
                display: none !important;
            }
            .table-responsive-stack tbody, 
            .table-responsive-stack tr, 
            .table-responsive-stack td {
                display: block !important;
                width: 100% !important;
            }
            .table-responsive-stack tr {
                background: #fff;
                border: 1px solid #e2e8f0 !important;
                border-radius: 16px;
                margin-bottom: 16px;
                padding: 4px 0;
                box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            }
            .table-responsive-stack td {
                text-align: right !important;
                padding: 12px 16px !important;
                border-bottom: 1px solid #f1f5f9 !important;
                font-size: 0.95rem;
                display: flex !important;
                justify-content: space-between !important;
                align-items: flex-start !important;
                gap: 12px;
                white-space: normal !important;
                word-break: break-word;
            }
            .table-responsive-stack td:last-child {
                border-bottom: none !important;
                justify-content: center !important;
                padding-top: 14px !important;
                padding-bottom: 14px !important;
                background-color: #f8fafc;
                border-bottom-left-radius: 16px;
                border-bottom-right-radius: 16px;
            }
            .table-responsive-stack td::before {
                content: attr(data-label);
                font-weight: 700;
                text-transform: uppercase;
                font-size: 0.7rem;
                color: #64748b;
                text-align: left;
                display: block;
                flex-shrink: 0;
                margin-top: 2px;
            }
            .table-responsive-stack td > div,
            .table-responsive-stack td > span,
            .table-responsive-stack td > form {
                display: inline-flex;
                flex-direction: column;
                align-items: flex-end;
                text-align: right;
            }
            .table-responsive-stack td:last-child::before {
                display: none !important;
            }
            .table-responsive-stack td:last-child > * {
                width: 100%;
                flex-direction: row !important;
                justify-content: center !important;
                align-items: center !important;
                display: flex !important;
                flex-wrap: wrap;
                gap: 8px;
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
        <div class="p-4 mb-3 d-flex align-items-center border-bottom border-secondary border-opacity-25">
            <img src="{{ asset('image/logo-jatiroyomonline.png') }}" alt="Logo Jatiroyom" class="me-2" style="height: 35px; width: auto; object-fit: contain;">
            <span class="fw-bold fs-5 tracking-tight text-white">Aparatur<span style="color: var(--primary-teal-light);">Desa</span></span>
        </div>
        <nav class="nav-sidebar">
            <a href="{{ route('perangkat.dashboard') }}" class="nav-link {{ request()->routeIs('perangkat.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i> Dashboard
            </a>
            <a href="{{ route('perangkat.laporan.index') }}" class="nav-link {{ request()->routeIs('perangkat.laporan.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone-fill" style="color: var(--primary-teal-light);"></i> Laporan Warga
            </a>
            <div class="mt-5 px-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 rounded-pill d-flex align-items-center justify-content-center fw-bold">
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
                <h6 class="mb-0 fw-bold d-none d-md-block text-dark">Sistem Presensi & Kinerja Aparatur</h6>
            </div>
            <div class="dropdown">
                <div class="d-flex align-items-center bg-light p-1 pe-3 rounded-pill" role="button" data-bs-toggle="dropdown">
                    <div class="text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="background-color: var(--primary-teal); width: 32px; height: 32px;">
                        {{ substr(auth()->user()->nama_lengkap, 0, 1) }}
                    </div>
                    <div class="small fw-bold d-none d-sm-block">{{ explode(' ', auth()->user()->nama_lengkap)[0] }}</div>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2" style="border-radius: 12px;">
                    <li><span class="dropdown-item-text small text-muted">{{ auth()->user()->jabatan ?? 'Perangkat Desa' }}</span></li>
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
                    &copy; {{ date('Y') }} <span class="fw-bold" style="color: var(--primary-teal);">Desa Jatiroyom</span>. Sistem Informasi Aparatur. <span class="watermark-hiu fw-bold text-primary ms-1" style="letter-spacing: 0.5px;">ByHiu</span>
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
                sidebar.classList.toggle('collapsed');
                mainWrapper.classList.toggle('expanded');
            } else {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
            }
        }

        toggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            toggleSidebar();
        });

        overlay.addEventListener('click', toggleSidebar);
    </script>
    @yield('scripts')
    @include('components.app-sound')
</body>
</html>
