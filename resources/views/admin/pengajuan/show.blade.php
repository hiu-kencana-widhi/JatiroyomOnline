@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.pengajuan.index') }}" class="text-decoration-none small text-muted">← Kembali ke Daftar</a>
    <h4 class="fw-bold mt-2">Detail Permohonan: {{ $pengajuan->jenisSurat->nama_surat }}</h4>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <!-- Informasi Pemohon -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Informasi Pemohon</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">Nama Lengkap</small>
                    <span class="fw-bold">{{ $pengajuan->user->nama_lengkap }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">NIK</small>
                    <span class="fw-bold">{{ $pengajuan->user->nik }}</span>
                </div>
                <div class="mb-0">
                    <small class="text-muted d-block">Status Permohonan</small>
                    @if($pengajuan->status == 'menunggu')
                        <span class="badge bg-warning text-dark px-3 py-2">Menunggu Konfirmasi</span>
                    @elseif($pengajuan->status == 'dikonfirmasi')
                        <span class="badge bg-success px-3 py-2">Selesai / Dikonfirmasi</span>
                    @else
                        <span class="badge bg-danger px-3 py-2">Ditolak</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Aksi Admin -->
        @if($pengajuan->status == 'menunggu')
        <div class="card border-0 shadow-sm border-primary" style="border-top: 4px solid #0d6efd !important;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Tindakan Admin</h6>
                <form action="{{ route('admin.pengajuan.konfirmasi', $pengajuan->id) }}" method="POST" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-success w-100 fw-bold py-2" onclick="return confirm('Konfirmasi permohonan ini? Sistem akan generate PDF dan upload ke Drive.')">
                        <i class="bi bi-check-circle-fill me-2"></i> Konfirmasi & Terbitkan
                    </button>
                </form>
                
                <button type="button" class="btn btn-outline-danger w-100 fw-bold py-2" data-bs-toggle="modal" data-bs-target="#modalTolak">
                    <i class="bi bi-x-circle-fill me-2"></i> Tolak Permohonan
                </button>
            </div>
        </div>
        @elseif($pengajuan->status == 'dikonfirmasi')
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 text-center">
                <i class="bi bi-cloud-check-fill text-success display-4 mb-3 d-block"></i>
                <h6 class="fw-bold">Surat Sudah Terbit</h6>
                <p class="small text-muted">Nomor: {{ $pengajuan->nomor_surat }}</p>
                <a href="{{ $pengajuan->file_drive_url }}" target="_blank" class="btn btn-outline-primary w-100 fw-bold">
                    <i class="bi bi-eye me-2"></i> Lihat di Google Drive
                </a>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-8">
        <!-- Preview Surat -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-dark text-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-eye-fill me-2"></i> Preview Final Surat</h6>
            </div>
            <div class="card-body bg-secondary bg-opacity-10 p-0 overflow-hidden d-flex justify-content-center align-items-start" style="height: 80vh;">
                <div id="preview-wrapper" style="width: 100%; height: 100%; overflow: hidden; position: relative; display: flex; justify-content: center;">
                    <div id="preview-container" class="bg-white shadow-lg" style="width: 210mm; min-height: 297mm; padding: 20mm; font-family: 'Times New Roman', serif; color: #000; position: absolute; top: 20px; transform: scale(0.48); transform-origin: top center; pointer-events: none;">
                        @php
                            $html = $pengajuan->jenisSurat->template_html;
                            foreach($pengajuan->data_terisi as $k => $v) {
                                if (strpos($k, 'tanggal') !== false && !empty($v)) {
                                    $v = \Carbon\Carbon::parse($v)->format('d F Y');
                                }
                                $html = str_replace("{{$k}}", $v, $html);
                            }
                            $html = str_replace('{nomor_surat}', $pengajuan->nomor_surat ?? '[NOMOR SURAT]', $html);
                            $html = str_replace('{tanggal_surat}', \Carbon\Carbon::now()->format('d F Y'), $html);
                        @endphp
                        {!! $html !!}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Data Table (Moved below preview) -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3 border-bottom pb-2">Data yang Diisi Warga:</h6>
                <div class="row g-3">
                    @foreach($pengajuan->data_terisi as $key => $val)
                    <div class="col-sm-4">
                        <small class="text-muted d-block">{{ str_replace('_', ' ', ucfirst($key)) }}</small>
                        <span class="fw-semibold">{{ $val }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div class="modal fade" id="modalTolak" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tolak Permohonan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.pengajuan.tolak', $pengajuan->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alasan Penolakan</label>
                        <textarea name="catatan_admin" class="form-control" rows="4" placeholder="Contoh: Data tidak sesuai dengan KTP asli." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger fw-bold">Kirim Penolakan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
