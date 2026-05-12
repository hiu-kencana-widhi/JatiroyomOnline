@extends('layouts.user')

@section('content')

<!-- Spanduk Siaran Pengumuman Global -->
@php
    $pengumumanAktif = \App\Models\PengumumanDesa::where('status_aktif', true)
        ->where('tanggal_selesai', '>=', now())
        ->latest()
        ->first();
@endphp
@if($pengumumanAktif)
<div class="alert alert-{{ $pengumumanAktif->tipe_spanduk === 'darurat' ? 'danger' : ($pengumumanAktif->tipe_spanduk === 'peringatan' ? 'warning' : 'info') }} alert-dismissible fade show border-0 shadow-sm rounded-4 text-start p-4 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: {{ $pengumumanAktif->tipe_spanduk === 'darurat' ? '#fef2f2' : ($pengumumanAktif->tipe_spanduk === 'peringatan' ? '#fefce8' : '#eff6ff') }}; border-left: 5px solid {{ $pengumumanAktif->tipe_spanduk === 'darurat' ? '#ef4444' : ($pengumumanAktif->tipe_spanduk === 'peringatan' ? '#eab308' : '#3b82f6') }} !important;">
    <div class="d-flex align-items-start gap-3">
        <div class="p-2 rounded-circle bg-{{ $pengumumanAktif->tipe_spanduk === 'darurat' ? 'danger' : ($pengumumanAktif->tipe_spanduk === 'peringatan' ? 'warning' : 'info') }} bg-opacity-10 text-{{ $pengumumanAktif->tipe_spanduk === 'darurat' ? 'danger' : ($pengumumanAktif->tipe_spanduk === 'peringatan' ? 'warning' : 'info') }}">
            <i class="bi bi-{{ $pengumumanAktif->tipe_spanduk === 'darurat' ? 'exclamation-octagon-fill' : ($pengumumanAktif->tipe_spanduk === 'peringatan' ? 'exclamation-triangle-fill' : 'info-circle-fill') }} fs-4"></i>
        </div>
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-{{ $pengumumanAktif->tipe_spanduk === 'darurat' ? 'danger' : ($pengumumanAktif->tipe_spanduk === 'peringatan' ? 'warning' : 'info') }} rounded-pill text-uppercase" style="font-size: 0.65rem;">Pengumuman Desa</span>
                <small class="text-muted fw-bold">{{ $pengumumanAktif->created_at->format('d M Y') }}</small>
            </div>
            <h6 class="fw-bold mb-1 text-dark" style="font-size: 1.05rem;">{{ $pengumumanAktif->judul }}</h6>
            <p class="small text-muted mb-0" style="max-width: 650px; line-height: 1.4;">{{ $pengumumanAktif->isi_pengumuman }}</p>
        </div>
    </div>
    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
        @if($pengumumanAktif->file_lampiran)
            <a href="{{ asset('storage/' . $pengumumanAktif->file_lampiran) }}" target="_blank" class="btn btn-sm btn-primary rounded-pill fw-bold px-3 py-2 shadow-sm" style="position: relative; z-index: 20;">
                <i class="bi bi-file-earmark-arrow-down-fill me-1"></i> Unduh Lampiran
            </a>
        @endif
        <button type="button" class="btn-close position-static p-2 m-0" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

<div class="row g-3 g-md-4 mb-4">
    <div class="col-12">
        <div class="card border-0 bg-white p-3 p-md-4 shadow-sm position-relative overflow-hidden rounded-4">
            <div class="position-absolute end-0 top-0 p-4 opacity-10 d-none d-lg-block">
                <i class="bi bi-person-check-fill" style="font-size: 120px;"></i>
            </div>
            <div class="row align-items-center position-relative z-1 text-center text-md-start">
                <div class="col-12 col-md-auto mb-3 mb-md-0">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        {{ substr(auth()->user()->nama_lengkap, 0, 1) }}
                    </div>
                </div>
                <div class="col-12 col-md">
                    <h4 class="fw-bold text-dark mb-1">Halo, {{ explode(' ', auth()->user()->nama_lengkap)[0] }}!</h4>
                    <p class="text-muted small mb-0">NIK: {{ auth()->user()->nik }}</p>
                </div>
                <div class="col-12 col-md-auto mt-3 mt-md-0">
                    <a href="{{ route('user.surat.pilih') }}" class="btn btn-primary w-100 w-md-auto rounded-pill px-4 fw-bold shadow-sm">
                        <i class="bi bi-file-earmark-plus me-1"></i> Buat Surat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Stat Cards: 2 columns on mobile, 3 columns on tablet+ -->
    <div class="col-6 col-md-4">
        <div class="card border-0 shadow-sm p-3 h-100 bg-white rounded-4">
            <div class="text-warning mb-2">
                <i class="bi bi-clock-history fs-4"></i>
            </div>
            <h4 class="fw-bold mb-0 text-dark">{{ \App\Models\Surat\PengajuanSurat::where('user_id', auth()->id())->where('status', 'menunggu')->count() }}</h4>
            <p class="text-muted small mb-0" style="font-size: 0.7rem;">Sedang Proses</p>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card border-0 shadow-sm p-3 h-100 bg-white rounded-4">
            <div class="text-success mb-2">
                <i class="bi bi-check-circle-fill fs-4"></i>
            </div>
            <h4 class="fw-bold mb-0 text-dark">{{ \App\Models\Surat\PengajuanSurat::where('user_id', auth()->id())->where('status', 'selesai')->count() }}</h4>
            <p class="text-muted small mb-0" style="font-size: 0.7rem;">Selesai</p>
        </div>
    </div>
    <div class="col-12 col-md-4 d-none d-md-block">
        <!-- Visible on desktop/tablet only to keep 3 columns, or 2 columns on mobile -->
        <div class="card border-0 shadow-sm p-3 h-100 bg-white rounded-4">
            <div class="text-primary mb-2">
                <i class="bi bi-shield-check fs-4"></i>
            </div>
            <h4 class="fw-bold mb-0 text-dark">Aktif</h4>
            <p class="text-muted small mb-0" style="font-size: 0.7rem;">Status Akun</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Riwayat Permohonan Terakhir</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 small text-uppercase text-secondary">Tanggal</th>
                                <th class="py-3 small text-uppercase text-secondary">Jenis Surat</th>
                                <th class="py-3 small text-uppercase text-secondary">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Surat\PengajuanSurat::where('user_id', auth()->id())->latest()->take(5)->get() as $riwayat)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">{{ $riwayat->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $riwayat->created_at->format('H:i') }} WIB</small>
                                </td>
                                <td>{{ $riwayat->jenisSurat->nama_surat }}</td>
                                <td>
                                    @if($riwayat->status == 'menunggu')
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Menunggu</span>
                                    @elseif($riwayat->status == 'selesai')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Selesai</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-5369.jpg" width="150" class="mb-3" loading="lazy">
                                    <p class="text-muted">Anda belum pernah mengajukan surat.</p>
                                    <a href="{{ route('user.surat.pilih') }}" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">Buat Sekarang</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white text-center py-3">
                <a href="{{ route('user.riwayat') }}" class="text-decoration-none small fw-bold">Lihat Semua Riwayat <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Bantuan Layanan</h6>
            </div>
            <div class="card-body">
                <div class="d-flex mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3 h-100">
                        <i class="bi bi-chat-dots-fill fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Hubungi Admin</h6>
                        <p class="text-muted small mb-0">Tanya seputar persyaratan atau masalah teknis.</p>
                        <a href="https://wa.me/628123456789" class="btn btn-link btn-sm text-primary p-0 fw-bold mt-2">Chat WhatsApp <i class="bi bi-chevron-right small"></i></a>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="bg-info bg-opacity-10 text-info rounded-3 p-3 me-3 h-100">
                        <i class="bi bi-question-circle-fill fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Pusat Bantuan</h6>
                        <p class="text-muted small mb-0">Pelajari cara penggunaan aplikasi secara mandiri.</p>
                        <a href="#" class="btn btn-link btn-sm text-info p-0 fw-bold mt-2">Baca Panduan <i class="bi bi-chevron-right small"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
