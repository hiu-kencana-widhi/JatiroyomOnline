@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-dark mb-1">Pintu Moderasi Pasar Digital & UMKM</h3>
    <p class="text-muted mb-0">Tinjau kelayakan, keaslian foto, serta deskripsi produk usaha yang didaftarkan warga sebelum ditayangkan secara resmi pada etalase digital publik.</p>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif

<!-- Baris Filter dan Pencarian -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <form action="{{ route('admin.umkm.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-0 bg-light" placeholder="Cari nama toko, produk, atau kategori..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select border-0 bg-light">
                    <option value="">Semua Status Peninjauan</option>
                    <option value="Menunggu" {{ request('status') === 'Menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="Disetujui" {{ request('status') === 'Disetujui' ? 'selected' : '' }}>Telah Disetujui (Tayang)</option>
                    <option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-3 text-md-end">
                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold w-100">
                    <i class="bi bi-funnel-fill me-1"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Daftar Moderasi Produk -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-shop text-primary me-2"></i> Daftar Pengajuan Produk Warga</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-responsive-stack">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3 small text-uppercase">Produk & Usaha</th>
                        <th class="py-3 small text-uppercase">Pemilik Akun</th>
                        <th class="py-3 small text-uppercase">Harga Jual</th>
                        <th class="py-3 small text-uppercase">Rincian & Kontak</th>
                        <th class="py-3 small text-uppercase">Status Tayang</th>
                        <th class="text-end pe-4 py-3 small text-uppercase">Keputusan Moderasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($umkm as $item)
                    <tr>
                        <td class="ps-4" data-label="Produk & Usaha">
                            <!-- BUNGKUSAN DIV TUNGGAL AGAR AMAN DI MOBILE STACK -->
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset('storage/' . $item->foto_produk) }}" class="rounded-3 object-fit-cover border shadow-sm flex-shrink-0" width="65" height="65" role="button" data-bs-toggle="modal" data-bs-target="#fotoModal{{ $item->id }}" alt="Foto">
                                <div>
                                    <div class="fw-bold text-dark">{{ $item->nama_produk }}</div>
                                    <small class="text-muted d-block"><i class="bi bi-shop-window me-1"></i> {{ $item->nama_usaha }}</small>
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1 mt-1 border border-primary border-opacity-20" style="font-size: 0.65rem;">
                                        {{ $item->kategori }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td data-label="Pemilik Akun Warga">
                            <div>
                                <div class="fw-bold text-dark">{{ $item->user->nama_lengkap ?? 'Warga Terhapus' }}</div>
                                <small class="text-muted d-block">NIK: {{ $item->user->nik ?? '-' }}</small>
                                <small class="text-secondary" style="font-size: 0.7rem;"><i class="bi bi-calendar-check me-1"></i> {{ $item->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </td>
                        <td data-label="Harga Jual">
                            <div>
                                <span class="fw-bold text-success">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                <small class="text-muted d-block">/ {{ $item->satuan }}</small>
                            </div>
                        </td>
                        <td data-label="Deskripsi & Tautan">
                            <div>
                                <p class="small text-muted mb-1 text-truncate" style="max-width: 220px;" data-bs-toggle="tooltip" title="{{ $item->deskripsi }}">
                                    {{ $item->deskripsi }}
                                </p>
                                <a href="https://wa.me/{{ $item->nomor_whatsapp }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-2 py-0" style="font-size: 0.7rem; position: relative; z-index: 10;">
                                    <i class="bi bi-whatsapp me-1"></i> +{{ $item->nomor_whatsapp }}
                                </a>
                            </div>
                        </td>
                        <td data-label="Status Saat Ini">
                            <div>
                                @if($item->status_verifikasi === 'Disetujui')
                                    <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm">
                                        <i class="bi bi-check-circle-fill me-1"></i> Sedang Tayang
                                    </span>
                                @elseif($item->status_verifikasi === 'Menunggu')
                                    <span class="badge bg-warning rounded-pill px-3 py-2 text-dark shadow-sm animate-pulse">
                                        <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                    </span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3 py-2 shadow-sm">
                                        <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="text-end pe-4" data-label="Aksi Keputusan">
                            <!-- BUNGKUSAN DIV TUNGGAL AGAR AMAN DI MOBILE STACK -->
                            <div class="d-flex justify-content-end gap-1 flex-wrap" style="position: relative; z-index: 10;">
                                @if($item->status_verifikasi !== 'Disetujui')
                                    <form action="{{ route('admin.umkm.verifikasi', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status_verifikasi" value="Disetujui">
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-2 py-1 shadow-sm" data-bs-toggle="tooltip" title="Setujui dan Tayangkan">
                                            <i class="bi bi-check-lg"></i> Setujui
                                        </button>
                                    </form>
                                @endif

                                @if($item->status_verifikasi !== 'Ditolak')
                                    <form action="{{ route('admin.umkm.verifikasi', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status_verifikasi" value="Ditolak">
                                        <button type="submit" class="btn btn-sm btn-warning rounded-pill px-2 py-1 shadow-sm text-dark" data-bs-toggle="tooltip" title="Tolak Penayangan">
                                            <i class="bi bi-x-lg"></i> Tolak
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.umkm.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permanen catatan produk ini beserta fotonya dari pangkalan data?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" data-bs-toggle="tooltip" title="Hapus Paksa Permanen">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-5369.jpg" width="160" class="mb-3 opacity-50" loading="lazy">
                            <p class="text-muted mb-0">Belum ada pengajuan produk usaha UMKM yang memerlukan moderasi.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($umkm->hasPages())
    <div class="card-footer bg-white py-3 border-0">
        {{ $umkm->links() }}
    </div>
    @endif
</div>

<!-- Modal Pratinjau Foto Penuh di Luar Struktur Tabel agar Bebas Distorsi Mobile -->
@foreach($umkm as $item)
    <div class="modal fade" id="fotoModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 bg-transparent shadow-none">
                <div class="modal-header border-0 justify-content-end p-2">
                    <button type="button" class="btn-close btn-close-white bg-dark p-2 rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 text-center">
                    <img src="{{ asset('storage/' . $item->foto_produk) }}" class="img-fluid rounded-4 shadow-lg object-fit-contain" style="max-height: 80vh;" alt="Foto Detail Produk">
                    <div class="bg-dark text-white p-3 rounded-bottom-4 mt-1 text-start">
                        <div class="fw-bold fs-5">{{ $item->nama_produk }}</div>
                        <div class="text-warning small"><i class="bi bi-shop me-1"></i> {{ $item->nama_usaha }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection
