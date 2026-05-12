@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h3 class="fw-bold text-dark mb-1">Pusat Kendali Laporan Warga</h3>
        <p class="text-muted mb-0">Verifikasi, ubah status penanganan, dan berikan catatan instruksi atas aduan kerusakan infrastruktur dari masyarakat.</p>
    </div>
    
    <!-- Filter Status -->
    <form action="{{ route('admin.laporan.index') }}" method="GET" class="d-flex gap-2" style="position: relative; z-index: 20;">
        <select name="status" class="form-select border-2 bg-white" onchange="this.form.submit()">
            <option value="">Semua Status Laporan</option>
            <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu Tinjauan</option>
            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai Ditangani</option>
            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
        @if(request('status'))
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-light border"><i class="bi bi-x-lg"></i></a>
        @endif
    </form>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-responsive-stack">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3 small text-uppercase">Pelapor</th>
                        <th class="py-3 small text-uppercase">Insiden & Deskripsi</th>
                        <th class="py-3 small text-uppercase">Bukti & Lokasi GPS</th>
                        <th class="py-3 small text-uppercase">Status</th>
                        <th class="text-end pe-4 py-3 small text-uppercase">Tindakan Moderasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $item)
                    <tr>
                        <td class="ps-4" data-label="Pelapor">
                            <div class="fw-bold text-dark">{{ $item->user->nama_lengkap ?? 'Warga Anonim' }}</div>
                            <small class="text-muted">NIK: {{ $item->user->nik ?? '-' }}</small>
                            <div class="text-secondary small mt-1"><i class="bi bi-clock me-1"></i> {{ $item->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td data-label="Insiden & Deskripsi">
                            <div class="fw-bold text-dark">{{ $item->judul_laporan }}</div>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2 py-1 mb-1 border border-secondary border-opacity-25">
                                {{ $item->kategori }}
                            </span>
                            <p class="small text-muted mb-0 mt-1" style="max-width: 280px;">{{ $item->deskripsi }}</p>
                        </td>
                        <td data-label="Bukti & Lokasi">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset('storage/' . $item->foto_bukti) }}" class="rounded-3 object-fit-cover border shadow-sm" width="55" height="55" role="button" data-bs-toggle="modal" data-bs-target="#buktiModal{{ $item->id }}">
                                <div>
                                    <small class="text-dark d-block fw-medium text-truncate" style="max-width: 150px;">{{ $item->alamat_lokasi ?? 'Patokan GPS' }}</small>
                                    <a href="https://maps.google.com/?q={{ $item->latitude }},{{ $item->longitude }}" target="_blank" class="btn btn-sm btn-light border py-1 px-2 mt-1 fw-bold text-primary" style="position: relative; z-index: 10;">
                                        <i class="bi bi-geo-alt-fill me-1"></i> Rute Peta
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td data-label="Status">
                            @if($item->status == 'Menunggu')
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">
                                    <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                </span>
                            @elseif($item->status == 'Diproses')
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 animate-pulse">
                                    <i class="bi bi-tools me-1"></i> Diproses
                                </span>
                            @elseif($item->status == 'Selesai')
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                </span>
                            @elseif($item->status == 'Ditolak')
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">
                                    <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                </span>
                            @endif
                            
                            @if($item->catatan_tanggapan)
                                <div class="mt-2 text-end text-md-start">
                                    <small class="text-secondary d-block fw-bold" style="font-size: 0.65rem;">CATATAN TERAKHIR:</small>
                                    <span class="text-muted small text-truncate d-inline-block" style="max-width: 140px;" data-bs-toggle="tooltip" title="{{ $item->catatan_tanggapan }}">
                                        {{ \Illuminate\Support\Str::limit($item->catatan_tanggapan, 25) }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td class="text-end pe-4" data-label="Tindakan Moderasi">
                            <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#tanggapiModal{{ $item->id }}" style="position: relative; z-index: 10;">
                                <i class="bi bi-pencil-square me-1"></i> Ubah Status
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-5369.jpg" width="180" class="mb-3 opacity-50" loading="lazy">
                            <p class="text-muted mb-0">Belum ada aduan insiden warga yang masuk ke dalam sistem.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($laporan->hasPages())
    <div class="card-footer bg-white py-3">
        {{ $laporan->links() }}
    </div>
    @endif
</div>

<!-- Modal Modals diposisikan di luar struktur bersarang tabel -->
@foreach($laporan as $item)
    <!-- Modal Pratinjau Foto Penuh -->
    <div class="modal fade" id="buktiModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 bg-transparent">
                <div class="modal-header border-0 justify-content-end p-2">
                    <button type="button" class="btn-close btn-close-white bg-dark p-2 rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 text-center">
                    <img src="{{ asset('storage/' . $item->foto_bukti) }}" class="img-fluid rounded-4 shadow-lg" alt="Foto Bukti">
                    <div class="bg-dark text-white p-4 rounded-bottom-4 mt-1 text-start">
                        <div class="d-flex justify-content-between align-items-center border-bottom border-secondary pb-2 mb-2">
                            <span class="fw-bold fs-5">{{ $item->judul_laporan }}</span>
                            <span class="badge bg-primary">{{ $item->kategori }}</span>
                        </div>
                        <p class="text-white-50 small mb-2">{{ $item->deskripsi }}</p>
                        <div class="text-warning small">
                            <i class="bi bi-pin-map-fill me-1"></i> Koordinat: {{ $item->latitude }}, {{ $item->longitude }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Status & Tanggapan -->
    <div class="modal fade text-start" id="tanggapiModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white p-3">
                    <h6 class="modal-title fw-bold"><i class="bi bi-sliders me-2"></i> Tindak Lanjut Laporan Warga</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.laporan.status', $item->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Status Penanganan Saat Ini</label>
                            <select name="status" class="form-select border-2" required>
                                <option value="Menunggu" {{ $item->status == 'Menunggu' ? 'selected' : '' }}>Menunggu Tinjauan</option>
                                <option value="Diproses" {{ $item->status == 'Diproses' ? 'selected' : '' }}>Diproses Lapangan</option>
                                <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai Ditangani</option>
                                <option value="Ditolak" {{ $item->status == 'Ditolak' ? 'selected' : '' }}>Ditolak / Tidak Valid</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Catatan Tanggapan Desa / Instruksi</label>
                            <textarea name="catatan_tanggapan" class="form-control border-2" rows="4" placeholder="Tuliskan perkembangan perbaikan atau alasan penolakan untuk dibaca oleh pelapor...">{{ $item->catatan_tanggapan }}</textarea>
                            <small class="text-muted" style="font-size: 0.75rem;">Catatan ini akan langsung tersinkronisasi dan dapat dilihat pada dasbor warga terkait.</small>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>
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
