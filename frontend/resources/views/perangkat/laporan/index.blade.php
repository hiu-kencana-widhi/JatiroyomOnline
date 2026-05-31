@extends('layouts.perangkat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h3 class="fw-bold text-dark mb-1">Pantauan Aduan Fisik Lapangan</h3>
        <p class="text-muted mb-0">Tinjau lokasi kerusakan fisik desa melalui Google Maps dan sampaikan progres perbaikan langsung dari lokasi.</p>
    </div>
    
    <!-- Filter Status -->
    <form action="{{ route('perangkat.laporan.index') }}" method="GET" class="d-flex gap-2" style="position: relative; z-index: 20;">
        <select name="status" class="form-select border-2 bg-white" style="border-color: var(--primary-teal-light);" onchange="this.form.submit()">
            <option value="">Semua Aduan</option>
            <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu Peninjauan</option>
            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
        @if(request('status'))
            <a href="{{ route('perangkat.laporan.index') }}" class="btn btn-light border"><i class="bi bi-x-lg"></i></a>
        @endif
    </form>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm rounded-4 mb-4" style="background-color: #f0fdf4; color: #166534;">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-responsive-stack">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3 small text-uppercase">Informasi Insiden</th>
                        <th class="py-3 small text-uppercase">Foto Bukti & Peta</th>
                        <th class="py-3 small text-uppercase">Status Penanganan</th>
                        <th class="text-end pe-4 py-3 small text-uppercase">Kontribusi Progres</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $item)
                    <tr>
                        <td class="ps-4" data-label="Informasi Insiden">
                            <div class="fw-bold text-dark">{{ $item->judul_laporan }}</div>
                            <span class="badge rounded-pill px-2 py-1 mb-1 border" style="background-color: #f0fdf4; color: var(--primary-teal); border-color: var(--primary-teal-light) !important;">
                                {{ $item->kategori }}
                            </span>
                            <p class="small text-muted mb-1 mt-1" style="max-width: 250px;">{{ $item->deskripsi }}</p>
                            <small class="text-secondary opacity-75"><i class="bi bi-calendar-event me-1"></i> Dilaporkan: {{ $item->created_at->format('d M Y') }}</small>
                        </td>
                        <td data-label="Foto Bukti & Peta">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset('storage/' . $item->foto_bukti) }}" class="rounded-3 object-fit-cover border shadow-sm" width="60" height="60" role="button" data-bs-toggle="modal" data-bs-target="#fotoLapanganModal{{ $item->id }}">
                                <div>
                                    <small class="text-dark d-block fw-medium text-truncate" style="max-width: 140px;">{{ $item->alamat_lokasi ?? 'Koordinat Terlampir' }}</small>
                                    <a href="https://maps.google.com/?q={{ $item->latitude }},{{ $item->longitude }}" target="_blank" class="btn btn-sm text-white rounded-pill py-1 px-3 mt-1 fw-bold shadow-sm" style="background-color: var(--primary-teal); font-size: 0.75rem; position: relative; z-index: 10;">
                                        <i class="bi bi-geo-alt-fill me-1"></i> Buka Google Maps
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td data-label="Status">
                            @if($item->status == 'Menunggu')
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">
                                    <i class="bi bi-hourglass-split me-1"></i> Menunggu Tinjauan
                                </span>
                            @elseif($item->status == 'Diproses')
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 animate-pulse">
                                    <i class="bi bi-tools me-1"></i> Sedang Dikerjakan
                                </span>
                            @elseif($item->status == 'Selesai')
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> Selesai Perbaikan
                                </span>
                            @elseif($item->status == 'Ditolak')
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">
                                    <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                </span>
                            @endif

                            @if($item->catatan_tanggapan)
                                <div class="mt-2 text-end text-md-start">
                                    <span class="text-muted small text-truncate d-inline-block" style="max-width: 140px;" data-bs-toggle="tooltip" title="{{ $item->catatan_tanggapan }}">
                                        <i class="bi bi-chat-left-text text-secondary me-1"></i> {{ \Illuminate\Support\Str::limit($item->catatan_tanggapan, 20) }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td class="text-end pe-4" data-label="Kontribusi Progres">
                            <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold" style="border-color: var(--primary-teal); color: var(--primary-teal); position: relative; z-index: 10;" data-bs-toggle="modal" data-bs-target="#updateProgresModal{{ $item->id }}">
                                <i class="bi bi-reply-fill me-1"></i> Beri Progres
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-5369.jpg" width="180" class="mb-3 opacity-50" loading="lazy">
                            <p class="text-muted mb-0">Belum ada aduan insiden warga yang memerlukan peninjauan.</p>
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

<!-- Semua Modal Modals ditaruh di luar tag bersarang tabel -->
@foreach($laporan as $item)
    <!-- Modal Resolusi Penuh -->
    <div class="modal fade" id="fotoLapanganModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 bg-transparent">
                <div class="modal-header border-0 justify-content-end p-2">
                    <button type="button" class="btn-close btn-close-white bg-dark p-2 rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 text-center">
                    <img src="{{ asset('storage/' . $item->foto_bukti) }}" class="img-fluid rounded-4 shadow-lg" alt="Bukti Insiden">
                    <div class="bg-dark text-white p-3 rounded-bottom-4 mt-1 text-start">
                        <div class="fw-bold">{{ $item->judul_laporan }}</div>
                        <p class="small text-white-50 mb-0 mt-1">{{ $item->deskripsi }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Beri Progres Lapangan -->
    <div class="modal fade text-start" id="updateProgresModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header text-white p-3" style="background-color: var(--primary-teal);">
                    <h6 class="modal-title fw-bold"><i class="bi bi-journal-check me-2"></i> Laporkan Progres Lapangan</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('perangkat.laporan.tanggapi', $item->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body p-4">
                        <div class="alert alert-info border-0 rounded-3 small mb-3 bg-light text-secondary">
                            <i class="bi bi-info-circle-fill me-1"></i> Menambahkan respons di bawah ini akan otomatis mengubah status insiden menjadi <strong>Diproses</strong> jika sebelumnya masih menunggu.
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Catatan Perkembangan / Investigasi Anda</label>
                            <textarea name="catatan_tanggapan" class="form-control border-2" rows="3" placeholder="Contoh: Tim sedang melakukan penimbunan jalan berlubang menggunakan kerikil padat..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn text-white rounded-pill px-4 fw-bold shadow-sm" style="background-color: var(--primary-teal);">Kirim Catatan</button>
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
