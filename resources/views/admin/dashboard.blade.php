@extends('layouts.admin')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card border-0 bg-primary text-white p-3 p-md-4 shadow-lg overflow-hidden position-relative rounded-4">
            <div class="position-absolute end-0 top-0 p-4 opacity-25 d-none d-md-block">
                <i class="bi bi-houses-fill" style="font-size: 150px;"></i>
            </div>
            <div class="position-relative z-1">
                <h2 class="fw-bold mb-1 fs-3 fs-md-2">Halo, {{ explode(' ', auth()->user()->nama_lengkap)[0] }}!</h2>
                <p class="mb-0 opacity-75 small text-balance">Selamat datang di Panel Administrasi Desa Jatiroyom.</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4 text-center">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 p-md-4 h-100 rounded-4">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-2 mb-md-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                <i class="bi bi-people-fill fs-4"></i>
            </div>
            <h4 class="fw-bold mb-1">{{ \App\Models\User::where('role', 'user')->count() }}</h4>
            <p class="text-muted small mb-0">Total Warga</p>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 p-md-4 h-100 rounded-4">
            <div class="bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-2 mb-md-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                <i class="bi bi-hourglass-split fs-4"></i>
            </div>
            <h4 class="fw-bold mb-1">{{ \App\Models\Surat\PengajuanSurat::where('status', 'menunggu')->count() }}</h4>
            <p class="text-muted small mb-0">Menunggu</p>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 p-md-4 h-100 rounded-4">
            <div class="bg-success bg-opacity-10 text-success rounded-circle mx-auto mb-2 mb-md-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                <i class="bi bi-check-circle-fill fs-4"></i>
            </div>
            <h4 class="fw-bold mb-1">{{ \App\Models\Surat\PengajuanSurat::where('status', 'selesai')->count() }}</h4>
            <p class="text-muted small mb-0">Surat Terbit</p>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 p-md-4 h-100 rounded-4">
            <div class="bg-info bg-opacity-10 text-info rounded-circle mx-auto mb-2 mb-md-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                <i class="bi bi-file-earmark-medical-fill fs-4"></i>
            </div>
            <h4 class="fw-bold mb-1">{{ \App\Models\Master\JenisSurat::count() }}</h4>
            <p class="text-muted small mb-0">Layanan</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Permohonan Terbaru</h6>
                <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-sm btn-light rounded-pill px-3">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-responsive-stack">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 small text-uppercase">Warga</th>
                                <th class="py-3 small text-uppercase">Jenis Surat</th>
                                <th class="py-3 small text-uppercase">Status</th>
                                <th class="py-3 small text-uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPermohonan as $p)
                            <tr>
                                <td class="ps-4" data-label="Warga">
                                    <div class="fw-bold mb-0">{{ $p->user->nama_lengkap }}</div>
                                    <small class="text-muted">{{ $p->user->nik }}</small>
                                </td>
                                <td data-label="Jenis Surat">{{ $p->jenisSurat->nama_surat }}</td>
                                <td data-label="Status">
                                    @if($p->status == 'menunggu')
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Menunggu</span>
                                    @elseif($p->status == 'selesai')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Selesai</span>
                                    @elseif($p->status == 'siap_diambil')
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">Siap Diambil</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Ditolak</span>
                                    @endif
                                </td>
                                <td data-label="Aksi">
                                    <a href="{{ route('admin.pengajuan.show', $p) }}" class="btn btn-sm btn-primary rounded-pill px-3">Proses</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">Belum ada permohonan masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Aktivitas Terakhir</h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @forelse(\App\Models\System\LogAktivitas::latest()->take(5)->get() as $log)
                    <div class="d-flex mb-3">
                        <div class="me-3 position-relative">
                            <div class="bg-primary rounded-circle" style="width: 12px; height: 12px; margin-top: 5px;"></div>
                            @if(!$loop->last)
                            <div class="bg-light position-absolute start-50 top-100" style="width: 2px; height: 100%; margin-left: -1px;"></div>
                            @endif
                        </div>
                        <div>
                            <p class="mb-0 small fw-bold">{{ $log->aktivitas }}</p>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ $log->created_at->diffForHumans() }} oleh {{ $log->user->nama_lengkap ?? 'Sistem' }}</small>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-muted py-4">Belum ada aktivitas.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
