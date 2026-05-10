@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-dark">Transparansi Anggaran</h3>
    <p class="text-muted">Kelola dokumen Laporan Keuangan dan Anggaran Desa untuk konsumsi publik.</p>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif

<div class="row g-4">
    <!-- Form Upload Section -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-primary text-white py-3 border-0">
                <h6 class="mb-0 fw-bold"><i class="bi bi-cloud-arrow-up me-2"></i> Unggah Laporan Baru</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.anggaran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase">Judul Laporan</label>
                        <input type="text" name="judul" class="form-control border-2" placeholder="Contoh: APBDes Tahun 2026" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase">File Dokumen (PDF/Excel)</label>
                        <input type="file" name="file" class="form-control border-2" accept=".pdf,.xls,.xlsx" required>
                        <small class="text-muted mt-2 d-block">Maksimal ukuran file: 5MB</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow">
                        <i class="bi bi-upload me-2"></i> Publikasikan Laporan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- List Section -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Riwayat Laporan Anggaran</h6>
                <span class="badge bg-light text-dark border rounded-pill px-3">{{ count($anggaran) }} Dokumen</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 small text-uppercase">Judul Dokumen</th>
                                <th class="py-3 small text-uppercase">Status</th>
                                <th class="py-3 small text-uppercase">Tanggal Upload</th>
                                <th class="text-end pe-4 py-3 small text-uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($anggaran as $item)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-2 me-3">
                                            <i class="bi bi-file-earmark-pdf-fill fs-4"></i>
                                        </div>
                                        <div class="fw-bold text-dark">{{ $item->judul }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($item->is_active)
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Publik</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">Arsip</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="small text-dark fw-medium">{{ $item->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-sm btn-light rounded-circle shadow-sm" title="Lihat">
                                            <i class="bi bi-eye text-primary"></i>
                                        </a>
                                        <form action="{{ route('admin.anggaran.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light rounded-circle shadow-sm" title="Hapus">
                                                <i class="bi bi-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-5369.jpg" width="150" class="mb-3 opacity-50" loading="lazy">
                                    <p class="text-muted">Belum ada laporan anggaran yang diunggah.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
