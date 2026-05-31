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
            <table class="table table-hover align-middle mb-0 table-responsive-stack">
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
                        <td class="ps-4" data-label="Jenis Surat">
                            <div class="fw-bold text-dark">{{ $item->jenisSurat->nama_surat }}</div>
                            <small class="text-muted">Kode: {{ $item->jenisSurat->kode_surat }}</small>
                        </td>
                        <td data-label="Tanggal">
                            <div class="text-dark fw-medium">{{ $item->created_at->format('d M Y') }}</div>
                            <small class="text-muted">{{ $item->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td data-label="Status">
                            @if($item->status == 'draft')
                                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2">
                                    <i class="bi bi-pencil-square me-1"></i> Draf
                                </span>
                            @elseif($item->status == 'menunggu')
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">
                                    <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                </span>
                            @elseif($item->status == 'disetujui')
                                <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2">
                                     <i class="bi bi-file-earmark-check me-1"></i> Disetujui
                                 </span>
                            @elseif($item->status == 'siap_diambil')
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                                     <i class="bi bi-mailbox me-1"></i> Siap Diambil
                                 </span>
                            @elseif($item->status == 'selesai')
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                     <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                 </span>
                            @elseif($item->status == 'ditolak')
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2" data-bs-toggle="tooltip" title="{{ $item->catatan_admin }}">
                                    <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                </span>
                            @endif
                        </td>
                        <td data-label="No. Surat">
                            @if($item->nomor_surat)
                                <span class="badge bg-dark rounded-pill px-3">{{ $item->nomor_surat }}</span>
                            @else
                                <span class="text-muted small">Belum terbit</span>
                            @endif
                        </td>
                        <td class="text-end pe-4" data-label="Aksi">
                            @if($item->status == 'siap_diambil')
                                <button type="button" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#detailLokasiModal"
                                    data-wa="{{ \App\Models\System\Pengaturan::where('key', 'kontak')->first()->value ?? '081234567890' }}"
                                    data-nomor="{{ $item->nomor_surat }}">
                                    <i class="bi bi-geo-alt-fill me-1"></i> Detail Lokasi
                                </button>
                            @elseif(($item->status == 'selesai' || $item->status == 'disetujui') && $item->file_drive_url)
                                <a href="{{ route('user.riwayat.download', $item->id) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-bold shadow-sm">
                                    <i class="bi bi-cloud-arrow-down-fill me-1"></i> Unduh PDF
                                </a>
                            @elseif($item->status == 'draft')
                                <a href="{{ route('user.surat.form', $item->jenisSurat->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-bold">
                                    <i class="bi bi-pencil-fill me-1"></i> Lanjutkan
                                </a>
                            @else
                                <button class="btn btn-light btn-sm rounded-pill px-4 disabled" disabled>Proses Admin</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-5369.jpg" width="180" class="mb-3 opacity-50" loading="lazy">
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

<!-- Modal Detail Lokasi -->
<div class="modal fade" id="detailLokasiModal" tabindex="-1" aria-labelledby="detailLokasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white p-4">
                <h5 class="modal-title fw-bold" id="detailLokasiModalLabel">
                    <i class="bi bi-geo-alt-fill me-2"></i> Pengambilan Surat Selesai
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-6">
                        <div class="p-4">
                            <div class="alert alert-info border-0 rounded-4 small mb-4">
                                <i class="bi bi-info-circle-fill me-2"></i> Surat Anda dengan nomor <strong id="modal-nomor-surat">...</strong> sudah siap diambil secara fisik di Balai Desa.
                            </div>
                            
                            <h6 class="fw-bold text-dark mb-3">Informasi Pengambilan:</h6>
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                                    <i class="bi bi-building text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Tempat</small>
                                    <span class="fw-bold">Balai Desa Jatiroyom</span>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3">
                                    <i class="bi bi-person-badge text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Menemui</small>
                                    <span class="fw-bold">Admin Pelayanan (Bp. Ahmad)</span>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-start mb-4">
                                <div class="bg-info bg-opacity-10 p-2 rounded-3 me-3">
                                    <i class="bi bi-clock text-info"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Jam Operasional</small>
                                    <span class="fw-bold">Senin - Jumat (08:00 - 15:00)</span>
                                </div>
                            </div>
                            
                            <a href="#" id="modal-wa-link" target="_blank" class="btn btn-success w-100 fw-bold rounded-pill py-2 mb-2">
                                <i class="bi bi-whatsapp me-2"></i> Hubungi via WhatsApp
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="h-100 min-vh-25">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.9694443689373!2d109.48115467421117!3d-7.012876468692579!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fde0314e45a91%3A0x28ff274f592e5266!2sBalai%20Desa%20Jatiroyom!5e0!3m2!1sid!2sid!4v1778600355455!5m2!1sid!2sid" 
                                width="100%" 
                                height="100%" 
                                style="border:0; min-height: 400px;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tooltip initialization
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Modal Dynamic Content
        var detailModal = document.getElementById('detailLokasiModal');
        detailModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var nomor = button.getAttribute('data-nomor');
            var wa = button.getAttribute('data-wa').replace(/[^0-9]/g, '');
            
            // Format WA to international format if starts with 0
            if(wa.startsWith('0')) wa = '62' + wa.substring(1);

            document.getElementById('modal-nomor-surat').textContent = nomor;
            document.getElementById('modal-wa-link').href = 'https://wa.me/' + wa + '?text=Halo%20Admin%2C%20saya%20ingin%20mengambil%20surat%20dengan%20nomor%20' + encodeURIComponent(nomor);
        });
    });
</script>
@endsection
