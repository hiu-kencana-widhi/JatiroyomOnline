@extends('layouts.app')

@section('styles')
<style>
    /* Premium Landing Page Styling */
    .hero-section {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), 
                    url('{{ asset('image/gambar-jatiroyom1.jpg') }}'); /* Actual Village Image */
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        color: white;
        overflow: hidden;
    }

    .hero-content {
        z-index: 10;
        animation: fadeInUp 1s ease-out;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        transition: all 0.3s ease;
    }

    .glass-card:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-5px);
    }

    .btn-premium {
        padding: 14px 35px;
        border-radius: 50px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.4s ease;
    }

    .gallery-img {
        height: 300px;
        object-fit: cover;
        border-radius: 20px;
        transition: all 0.5s ease;
    }

    .gallery-img:hover {
        transform: scale(1.03);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
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
    }

    /* Responsive Modal Styling - Side-by-Side on Desktop */
    .modal-content {
        border-radius: 28px !important;
        border: none !important;
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
        transition: all 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
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
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="#F8FAFC"></path>
        </svg>
    </div>
</section>

<!-- Acara Desa Section -->
<section id="acara" class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Acara & Agenda Desa</h2>
            <div class="bg-primary mx-auto mb-3" style="width: 60px; height: 4px; border-radius: 2px;"></div>
            <p class="text-muted">Ikuti terus kegiatan dan berita terbaru dari Pemerintah Desa Jatiroyom.</p>
        </div>
        
        <div class="row g-4">
            @php $acaras = \App\Models\AcaraDesa::where('is_aktif', true)->latest()->take(3)->get(); @endphp
            @forelse($acaras as $ac)
            <div class="col-md-6 col-lg-4">
                <div class="glass-card p-2 h-100 cursor-pointer shadow-hover hover-lift" data-bs-toggle="modal" data-bs-target="#acaraModal{{ $ac->id }}" style="cursor: pointer;">
                    @if($ac->gambar)
                        <img src="{{ asset('storage/' . $ac->gambar) }}" class="gallery-img w-100 shadow-sm" alt="{{ $ac->judul }}">
                    @else
                        <div class="bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center gallery-img w-100">
                            <i class="bi bi-calendar-event text-secondary fs-1"></i>
                        </div>
                    @endif
                    <div class="p-3">
                        <div class="text-primary small fw-bold mb-2"><i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($ac->tanggal)->format('d M Y') }}</div>
                        <h6 class="fw-bold mb-2 text-dark">{{ $ac->judul }}</h6>
                        <p class="text-muted small mb-0">{{ Str::limit($ac->deskripsi, 100) }}</p>
                        <div class="mt-3 text-primary small fw-bold">Baca Selengkapnya <i class="bi bi-arrow-right"></i></div>
                    </div>
                </div>
            </div>

            <!-- Modal Acara -->
            <div class="modal fade" id="acaraModal{{ $ac->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                    <div class="modal-content overflow-hidden shadow-lg">
                        <div class="modal-flex-container">
                            @if($ac->gambar)
                                <div class="modal-img-side">
                                    <img src="{{ asset('storage/' . $ac->gambar) }}" alt="{{ $ac->judul }}">
                                </div>
                            @endif
                            <div class="modal-content-side">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-bold small">
                                        <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($ac->tanggal)->format('d F Y') }}
                                    </span>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <h3 class="fw-bold text-dark mb-2">{{ $ac->judul }}</h3>
                                <div class="d-flex align-items-center text-muted mb-4 small">
                                    <i class="bi bi-geo-alt-fill text-danger me-2"></i> 
                                    <span>{{ $ac->lokasi ?? 'Desa Jatiroyom' }}</span>
                                </div>
                                <div class="text-secondary" style="font-size: 0.95rem; line-height: 1.6;">
                                    {!! nl2br(e($ac->deskripsi)) !!}
                                </div>
                                <div class="mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold w-100" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-5">Belum ada agenda acara saat ini.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- Anggaran Section -->
<section id="anggaran" class="py-5 bg-white border-top">
    <div class="container py-5 text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="badge bg-success bg-opacity-10 text-success rounded-pill px-4 py-2 mb-3 fw-bold">TRANSPARANSI PUBLIK</div>
                <h2 class="fw-bold mb-4">Laporan Anggaran & APBDes</h2>
                <p class="text-muted mb-5 lead">
                    Sebagai bentuk keterbukaan informasi publik, Pemerintah Desa Jatiroyom menyediakan akses bagi seluruh warga untuk melihat dan mengunduh laporan realisasi anggaran.
                </p>
                
                @php $anggaranAktif = \App\Models\AnggaranDesa::where('is_active', true)->latest()->first(); @endphp
                @if($anggaranAktif)
                <div class="glass-card p-4 d-flex align-items-center justify-content-between border-2 border-primary border-opacity-25 shadow-lg">
                    <div class="text-start d-flex align-items-center">
                        <div class="bg-danger text-white rounded-circle p-3 me-3">
                            <i class="bi bi-file-earmark-pdf fs-3"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-dark">{{ $anggaranAktif->judul }}</h5>
                            <small class="text-muted">Diperbarui pada: {{ $anggaranAktif->created_at->format('d M Y') }}</small>
                        </div>
                    </div>
                    <a href="{{ asset('storage/' . $anggaranAktif->file_path) }}" target="_blank" class="btn btn-primary rounded-pill px-4 fw-bold">
                        <i class="bi bi-download me-2"></i> Unduh Laporan
                    </a>
                </div>
                @else
                <div class="p-5 border-2 border-dashed rounded-4 bg-light text-muted">
                    <i class="bi bi-folder-x fs-1 d-block mb-3"></i>
                    Belum ada laporan anggaran yang dipublikasikan untuk periode ini.
                </div>
                @endif
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
                    <img src="{{ asset('storage/' . $p->gambar) }}" class="w-100" style="height: 250px; object-fit: cover;" alt="{{ $p->judul }}">
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
                        <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->judul }}">
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
