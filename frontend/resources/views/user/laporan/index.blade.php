@extends('layouts.user')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h3 class="fw-bold text-dark mb-1">Riwayat Laporan Insiden</h3>
        <p class="text-muted mb-0">Pantau status penanganan atas aduan infrastruktur dan lingkungan yang telah Anda sampaikan.</p>
    </div>
    <a href="{{ route('user.laporan.create') }}" class="btn btn-primary btn-lg rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center" style="position: relative; z-index: 20;">
        <i class="bi bi-plus-circle-fill me-2"></i> Buat Laporan Baru
    </a>
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
                        <th class="ps-4 py-3 small text-uppercase">Insiden & Kategori</th>
                        <th class="py-3 small text-uppercase">Waktu Pelaporan</th>
                        <th class="py-3 small text-uppercase">Lokasi & Bukti</th>
                        <th class="py-3 small text-uppercase">Status</th>
                        <th class="text-end pe-4 py-3 small text-uppercase">Tanggapan Desa</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $item)
                    <tr>
                        <td class="ps-4" data-label="Insiden">
                            <div class="fw-bold text-dark">{{ $item->judul_laporan }}</div>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2 py-1 mt-1 border border-secondary border-opacity-25">
                                {{ $item->kategori }}
                            </span>
                        </td>
                        <td data-label="Waktu Pelaporan">
                            <div class="text-dark fw-medium">{{ $item->created_at->format('d M Y') }}</div>
                            <small class="text-muted">{{ $item->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td data-label="Lokasi & Bukti">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset('storage/' . $item->foto_bukti) }}" class="rounded-3 object-fit-cover border" width="45" height="45" role="button" data-bs-toggle="modal" data-bs-target="#fotoModal{{ $item->id }}">
                                <div>
                                    <small class="text-dark d-block text-truncate" style="max-width: 180px;">{{ $item->alamat_lokasi ?? 'Titik GPS Terlampir' }}</small>
                                    <a href="https://maps.google.com/?q={{ $item->latitude }},{{ $item->longitude }}" target="_blank" class="text-primary small text-decoration-none" style="position: relative; z-index: 10;">
                                        <i class="bi bi-geo-alt-fill"></i> Peta
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
                                    <i class="bi bi-tools me-1"></i> Diproses Lapangan
                                </span>
                            @elseif($item->status == 'Selesai')
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> Selesai Ditangani
                                </span>
                            @elseif($item->status == 'Ditolak')
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">
                                    <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="text-end pe-4" data-label="Tanggapan Desa">
                            @if($item->catatan_tanggapan)
                                <button type="button" class="btn btn-outline-info btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#tanggapanModal{{ $item->id }}" style="position: relative; z-index: 10;">
                                    <i class="bi bi-chat-text-fill me-1"></i> Lihat Respons
                                </button>
                            @else
                                <span class="text-muted small italic">Belum ada tanggapan</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-5369.jpg" width="180" class="mb-3 opacity-50" loading="lazy">
                            <p class="text-muted mb-0">Belum ada aduan insiden yang Anda laporkan.</p>
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

<!-- Kumpulan Jendela Modal Ditempatkan Di Luar Struktur Tabel Agar Tidak Mengganggu DOM/Klik Mobile -->
@foreach($laporan as $item)
    <!-- Modal Pratinjau Foto -->
    <div class="modal fade" id="fotoModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 bg-transparent">
                <div class="modal-header border-0 justify-content-end p-2">
                    <button type="button" class="btn-close btn-close-white bg-dark p-2 rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 text-center">
                    <img src="{{ asset('storage/' . $item->foto_bukti) }}" class="img-fluid rounded-4 shadow-lg" alt="Foto Bukti">
                    <div class="bg-dark text-white p-3 rounded-bottom-4 mt-1 text-start">
                        <div class="fw-bold">{{ $item->judul_laporan }}</div>
                        <p class="small text-white-50 mb-0 mt-1">{{ $item->deskripsi }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($item->catatan_tanggapan)
        <!-- Modal Tanggapan -->
        <div class="modal fade text-start" id="tanggapanModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h6 class="modal-title fw-bold text-dark"><i class="bi bi-chat-dots-fill text-primary me-2"></i> Tanggapan Resmi Desa</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="border-start border-4 border-primary ps-3 py-1">
                            <p class="mb-0 text-dark" style="white-space: pre-wrap;">{{ $item->catatan_tanggapan }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

@endsection
