<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Desa Jatiroyom</title>
    
    <!-- Preloads for Speed -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" as="style">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="{{ asset('image/logo-pemalang.png') }}">
    
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-bg: #0f172a;
            --accent-color: #3b82f6;
        }

        /* Optimization Base */
        * {
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
            overflow-x: hidden;
            color: #1e293b;
        }

        /* GPU Accelerated Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--primary-bg);
            color: #fff;
            z-index: 1050;
            box-shadow: 4px 0 10px rgba(0,0,0,0.05);
            overflow-y: auto;
            transform: translateZ(0);
            backface-visibility: hidden;
            will-change: transform;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.1) transparent;
        }

        .sidebar.collapsed {
            transform: translateX(calc(-1 * var(--sidebar-width)));
        }

        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            will-change: margin-left;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
            background-color: var(--accent-color);
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
            -webkit-backdrop-filter: blur(4px);
            transition: opacity 0.3s ease;
        }

        @media (max-width: 991.98px) {
            .sidebar { 
                transform: translateX(calc(-1 * var(--sidebar-width))); 
            }
            .sidebar.show { 
                transform: translateX(0); 
            }
            .main-wrapper { margin-left: 0; }
            .sidebar-overlay.show { display: block; opacity: 1; }
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
                justify-content: center;
                display: flex;
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
            <div class="bg-primary rounded-3 p-2 me-2">
                <i class="bi bi-shield-lock-fill text-white fs-4"></i>
            </div>
            <span class="fw-bold fs-5 tracking-tight">Admin<span class="text-primary">Desa</span></span>
        </div>
        <nav class="nav-sidebar">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <div class="text-uppercase small fw-bold px-4 mb-2 mt-4 text-secondary opacity-50" style="font-size: 0.7rem; letter-spacing: 1px;">Manajemen Data</div>
            <a href="{{ route('admin.warga.index') }}" class="nav-link {{ request()->routeIs('admin.warga.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Warga
            </a>
            <a href="{{ route('admin.pengajuan.index') }}" class="nav-link {{ request()->routeIs('admin.pengajuan.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-check-fill"></i> Permohonan
            </a>
            <a href="{{ route('admin.jenis-surat.index') }}" class="nav-link {{ request()->routeIs('admin.jenis-surat.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-medical-fill"></i> Template Surat
            </a>
            <div class="text-uppercase small fw-bold px-4 mb-2 mt-4 text-secondary opacity-50" style="font-size: 0.7rem; letter-spacing: 1px;">Aparatur & Presensi</div>
            <a href="{{ route('admin.kelola-perangkat.index') }}" class="nav-link {{ request()->routeIs('admin.kelola-perangkat.*') ? 'active' : '' }}">
                <i class="bi bi-person-vcard-fill"></i> Kelola Aparatur
            </a>
            <a href="{{ route('admin.rekap-absensi.index') }}" class="nav-link {{ request()->routeIs('admin.rekap-absensi.*') ? 'active' : '' }}">
                <i class="bi bi-calendar2-check-fill"></i> Rekap Presensi
            </a>
            <a href="{{ route('admin.moderasi-penilaian.index') }}" class="nav-link {{ request()->routeIs('admin.moderasi-penilaian.*') ? 'active' : '' }}">
                <i class="bi bi-star-fill text-warning"></i> Moderasi Penilaian
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone-fill text-danger"></i> Laporan Warga
            </a>
            <div class="text-uppercase small fw-bold px-4 mb-2 mt-4 text-secondary opacity-50" style="font-size: 0.7rem; letter-spacing: 1px;">Publikasi</div>
            <a href="{{ route('admin.pengumuman.index') }}" class="nav-link {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone-fill text-info"></i> Siaran Pengumuman
            </a>
            <a href="{{ route('admin.umkm.index') }}" class="nav-link {{ request()->routeIs('admin.umkm.*') ? 'active' : '' }}">
                <i class="bi bi-shop text-success"></i> Moderasi UMKM
            </a>
            <a href="{{ route('admin.acara.index') }}" class="nav-link {{ request()->routeIs('admin.acara.*') ? 'active' : '' }}">
                <i class="bi bi-calendar3-event-fill"></i> Acara Desa
            </a>
            <a href="{{ route('admin.potret.index') }}" class="nav-link {{ request()->routeIs('admin.potret.*') ? 'active' : '' }}">
                <i class="bi bi-camera-fill"></i> Potret Desa
            </a>
            <a href="{{ route('admin.anggaran.index') }}" class="nav-link {{ request()->routeIs('admin.anggaran.*') ? 'active' : '' }}">
                <i class="bi bi-pie-chart-fill"></i> Anggaran
            </a>
            <a href="{{ route('admin.pengaturan.index') }}" class="nav-link {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
                <i class="bi bi-sliders"></i> Pengaturan
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
                <h6 class="mb-0 fw-bold d-none d-md-block">Administrasi Desa Jatiroyom</h6>
            </div>
            <div class="dropdown">
                <div class="d-flex align-items-center bg-light p-1 pe-3 rounded-pill" role="button" data-bs-toggle="dropdown">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="small fw-bold">{{ explode(' ', auth()->user()->nama_lengkap)[0] }}</div>
                    <i class="bi bi-chevron-down small ms-2 text-muted"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2" style="border-radius: 12px;">
                    <li><a class="dropdown-item rounded-3" href="{{ route('admin.pengaturan.index') }}"><i class="bi bi-gear me-2"></i> Pengaturan Desa</a></li>
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

        <footer class="mt-auto py-4 px-5 border-top bg-white">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="text-muted small">
                    &copy; {{ date('Y') }} <span class="fw-bold">Pemerintah Desa Jatiroyom</span>.
                </div>
                <div class="d-flex align-items-center gap-4">
                    <span class="badge bg-light text-secondary border rounded-pill px-3">v2.1.2</span>
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
</body>
</html>
