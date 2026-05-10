@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-dark">Daftar Permohonan Surat</h3>
    <p class="text-muted">Kelola dan verifikasi pengajuan surat dari warga Desa Jatiroyom.</p>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <ul class="nav nav-pills card-header-pills">
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'menunggu' || !request('status') ? 'active' : '' }}" href="{{ route('admin.pengajuan.index', ['status' => 'menunggu']) }}">Menunggu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'disetujui' ? 'active' : '' }}" href="{{ route('admin.pengajuan.index', ['status' => 'disetujui']) }}">Disetujui</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'siap_diambil' ? 'active' : '' }}" href="{{ route('admin.pengajuan.index', ['status' => 'siap_diambil']) }}">Siap Diambil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'selesai' ? 'active' : '' }}" href="{{ route('admin.pengajuan.index', ['status' => 'selesai']) }}">Selesai</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'ditolak' ? 'active' : '' }}" href="{{ route('admin.pengajuan.index', ['status' => 'ditolak']) }}">Ditolak</a>
            </li>
        </ul>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-responsive-stack">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 small text-uppercase text-secondary">Tanggal</th>
                        <th class="py-3 small text-uppercase text-secondary">Warga</th>
                        <th class="py-3 small text-uppercase text-secondary">Jenis Surat</th>
                        <th class="py-3 small text-uppercase text-secondary">Status</th>
                        <th class="py-3 small text-uppercase text-secondary text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuan as $item)
                    <tr>
                        <td class="ps-4" data-label="Tanggal">
                            <div class="fw-bold text-dark">{{ $item->created_at->format('d M Y') }}</div>
                            <small class="text-muted">{{ $item->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td data-label="Warga">
                            <div class="fw-bold text-dark">{{ $item->user->nama_lengkap }}</div>
                            <small class="text-muted">NIK: {{ $item->user->nik }}</small>
                        </td>
                        <td data-label="Jenis Surat">
                            <div class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 fw-bold">
                                {{ $item->jenisSurat->nama_surat }}
                            </div>
                        </td>
                        <td data-label="Status">
                            @if($item->status == 'menunggu')
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Menunggu</span>
                            @elseif($item->status == 'disetujui')
                                <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">Disetujui</span>
                            @elseif($item->status == 'siap_diambil')
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">Siap Diambil</span>
                            @elseif($item->status == 'selesai')
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Selesai</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Ditolak</span>
                            @endif
                        </td>
                        <td class="text-center" data-label="Aksi">
                            <a href="{{ route('admin.pengajuan.show', $item) }}" class="btn btn-sm btn-outline-primary rounded-pill px-4 fw-bold">
                                Detail & Proses
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Tidak ada permohonan ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3">
        {{ $pengajuan->links() }}
    </div>
</div>
@endsection
