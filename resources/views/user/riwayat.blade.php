@extends('layouts.user')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-dark">Riwayat Permohonan</h3>
    <p class="text-muted">Pantau status pengajuan surat Anda dan unduh dokumen jika sudah disetujui admin.</p>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3 small text-uppercase">Jenis Surat</th>
                        <th class="py-3 small text-uppercase">Tanggal Pengajuan</th>
                        <th class="py-3 small text-uppercase">Status</th>
                        <th class="py-3 small text-uppercase">No. Surat</th>
                        <th class="text-end pe-4 py-3 small text-uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $item)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $item->jenisSurat->nama_surat }}</div>
                            <small class="text-muted">Kode: {{ $item->jenisSurat->kode_surat }}</small>
                        </td>
                        <td>
                            <div class="text-dark fw-medium">{{ $item->created_at->format('d M Y') }}</div>
                            <small class="text-muted">{{ $item->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td>
                            @if($item->status == 'draft')
                                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2">
                                    <i class="bi bi-pencil-square me-1"></i> Draf
                                </span>
                            @elseif($item->status == 'menunggu')
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">
                                    <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                </span>
                            @elseif($item->status == 'dikonfirmasi' || $item->status == 'selesai')
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                </span>
                            @elseif($item->status == 'ditolak')
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2" data-bs-toggle="tooltip" title="{{ $item->catatan_admin }}">
                                    <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($item->nomor_surat)
                                <span class="badge bg-dark rounded-pill px-3">{{ $item->nomor_surat }}</span>
                            @else
                                <span class="text-muted small">Belum terbit</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            @if(($item->status == 'selesai' || $item->status == 'dikonfirmasi') && $item->file_drive_url)
                                <a href="{{ route('user.riwayat.download', $item->id) }}" target="_blank" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm">
                                    <i class="bi bi-cloud-arrow-down-fill me-1"></i> Unduh PDF
                                </a>
                            @elseif($item->status == 'draft')
                                <a href="{{ route('user.surat.form', $item->jenisSurat->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-bold">
                                    <i class="bi bi-pencil-fill me-1"></i> Lanjutkan
                                </a>
                            @else
                                <button class="btn btn-light btn-sm rounded-pill px-4 disabled" disabled>Menunggu</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-5369.jpg" width="180" class="mb-3 opacity-50">
                            <p class="text-muted">Belum ada riwayat permohonan surat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($riwayat->hasPages())
    <div class="card-footer bg-white py-3">
        {{ $riwayat->links() }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection
