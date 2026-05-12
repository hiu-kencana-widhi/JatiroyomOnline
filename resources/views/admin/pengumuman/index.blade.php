@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-dark mb-1">Siaran Pengumuman & Spanduk Darurat</h3>
    <p class="text-muted mb-0">Kelola informasi krusial, pemadaman, atau jadwal kegiatan yang langsung ditayangkan sebagai pita spanduk di Beranda Publik dan Dasbor Warga.</p>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row g-4">
    <!-- Kolom Pembuatan Pengumuman Baru -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100" style="position: relative; z-index: 10;">
            <div class="card-header bg-primary text-white py-3 rounded-top-4">
                <h6 class="mb-0 fw-bold"><i class="bi bi-megaphone-fill me-2"></i> Terbitkan Spanduk Baru</h6>
            </div>
            <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small text-uppercase">Judul Pengumuman</label>
                        <input type="text" name="judul" class="form-control border-2" placeholder="Contoh: Pemadaman Listrik PLN / Bansos" value="{{ old('judul') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small text-uppercase">Tipe / Urgensi Pita</label>
                        <select name="tipe_spanduk" class="form-select border-2" required>
                            <option value="info" {{ old('tipe_spanduk') == 'info' ? 'selected' : '' }}>Info Biasa (Biru)</option>
                            <option value="peringatan" {{ old('tipe_spanduk') == 'peringatan' ? 'selected' : '' }}>Peringatan (Kuning)</option>
                            <option value="darurat" {{ old('tipe_spanduk') == 'darurat' ? 'selected' : '' }}>Darurat / Krusial (Merah)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small text-uppercase">Batas Akhir Penayangan</label>
                        <input type="datetime-local" name="tanggal_selesai" class="form-control border-2 position-relative" value="{{ old('tanggal_selesai', now()->addDays(3)->format('Y-m-d\TH:i')) }}" required style="z-index: 20;">
                        <small class="text-muted" style="font-size: 0.7rem;">Spanduk otomatis turun layar setelah batas waktu ini.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small text-uppercase">Dokumen Lampiran Bukti (Opsional)</label>
                        <input type="file" name="file_lampiran" class="form-control border-2" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted" style="font-size: 0.7rem;">Format: PDF/Gambar max 5MB (Surat Edaran, Undangan, dsb.)</small>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold text-secondary small text-uppercase">Isi / Instruksi Rinci</label>
                        <textarea name="isi_pengumuman" class="form-control border-2" rows="4" placeholder="Tuliskan rincian jadwal, wilayah terdampak, atau instruksi lengkap untuk dibaca warga..." required>{{ old('isi_pengumuman') }}</textarea>
                    </div>
                </div>
                <div class="card-footer bg-light border-0 py-3 text-end rounded-bottom-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm w-100">
                        <i class="bi bi-send-fill me-2"></i> Terbitkan Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Kolom Tabel Daftar Riwayat Pengumuman -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-card-list text-primary me-2"></i> Daftar Riwayat Pengumuman</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-responsive-stack">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th class="ps-4 py-3 small text-uppercase">Spanduk & Tipe</th>
                                <th class="py-3 small text-uppercase">Masa Penayangan</th>
                                <th class="py-3 small text-uppercase">Lampiran</th>
                                <th class="py-3 small text-uppercase">Status Tayang</th>
                                <th class="text-end pe-4 py-3 small text-uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengumuman as $item)
                            <tr>
                                <td class="ps-4" data-label="Spanduk & Tipe">
                                    <div class="fw-bold text-dark">{{ $item->judul }}</div>
                                    <span class="badge bg-{{ $item->tipe_spanduk === 'darurat' ? 'danger' : ($item->tipe_spanduk === 'peringatan' ? 'warning' : 'info') }} rounded-pill text-uppercase" style="font-size: 0.65rem;">
                                        {{ $item->tipe_spanduk }}
                                    </span>
                                    <p class="small text-muted mb-0 mt-1 text-truncate" style="max-width: 200px;">{{ $item->isi_pengumuman }}</p>
                                </td>
                                <td data-label="Masa Penayangan">
                                    <small class="text-dark d-block fw-medium"><i class="bi bi-calendar-event me-1"></i> S/d: {{ $item->tanggal_selesai->format('d M Y') }}</small>
                                    <small class="text-muted">{{ $item->tanggal_selesai->format('H:i') }} WIB</small>
                                    @if($item->tanggal_selesai < now())
                                        <span class="d-block badge bg-secondary bg-opacity-10 text-secondary mt-1">Kedaluwarsa</span>
                                    @endif
                                </td>
                                <td data-label="Lampiran Bukti">
                                    @if($item->file_lampiran)
                                        <a href="{{ asset('storage/' . $item->file_lampiran) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fw-bold" style="position: relative; z-index: 10;">
                                            <i class="bi bi-file-earmark-check me-1"></i> Buka File
                                        </a>
                                    @else
                                        <span class="text-muted small italic">-</span>
                                    @endif
                                </td>
                                <td data-label="Status Tayang">
                                    <form action="{{ route('admin.pengumuman.toggle', $item->id) }}" method="POST" style="position: relative; z-index: 10;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm border-0 p-0" data-bs-toggle="tooltip" title="Klik untuk {{ $item->status_aktif ? 'matikan' : 'aktifkan' }} tayang">
                                            @if($item->status_aktif)
                                                <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm"><i class="bi bi-eye-fill me-1"></i> Sedang Tayang</span>
                                            @else
                                                <span class="badge bg-secondary rounded-pill px-3 py-2 opacity-75"><i class="bi bi-eye-slash-fill me-1"></i> Disembunyikan</span>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td class="text-end pe-4" data-label="Aksi Pengelolaan">
                                    <div class="d-flex justify-content-end gap-1" style="position: relative; z-index: 10;">
                                        <button type="button" class="btn btn-sm btn-light border rounded-pill px-2 py-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                            <i class="bi bi-pencil text-primary"></i>
                                        </button>
                                        <form action="{{ route('admin.pengumuman.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permanen pengumuman ini beserta berkas lampirannya?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border rounded-pill px-2 py-1">
                                                <i class="bi bi-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-5369.jpg" width="160" class="mb-3 opacity-50" loading="lazy">
                                    <p class="text-muted mb-0">Belum ada siaran spanduk pengumuman yang diterbitkan.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($pengumuman->hasPages())
            <div class="card-footer bg-white py-3 border-0">
                {{ $pengumuman->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Modals Ditempatkan Di Bagian Bawah Dokumen Di Luar Struktur Tabel Agar Mobile Normal -->
@foreach($pengumuman as $item)
    <div class="modal fade text-start" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header bg-primary text-white p-3 rounded-top-4">
                    <h6 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i> Perbarui Rincian Pengumuman</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.pengumuman.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Judul Pengumuman</label>
                            <input type="text" name="judul" class="form-control border-2" value="{{ $item->judul }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Tipe / Urgensi Pita</label>
                            <select name="tipe_spanduk" class="form-select border-2" required>
                                <option value="info" {{ $item->tipe_spanduk == 'info' ? 'selected' : '' }}>Info Biasa (Biru)</option>
                                <option value="peringatan" {{ $item->tipe_spanduk == 'peringatan' ? 'selected' : '' }}>Peringatan (Kuning)</option>
                                <option value="darurat" {{ $item->tipe_spanduk == 'darurat' ? 'selected' : '' }}>Darurat (Merah)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Batas Akhir Penayangan</label>
                            <input type="datetime-local" name="tanggal_selesai" class="form-control border-2 position-relative" value="{{ $item->tanggal_selesai->format('Y-m-d\TH:i') }}" required style="z-index: 20;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Ganti Berkas Lampiran (Opsional)</label>
                            <input type="file" name="file_lampiran" class="form-control border-2" accept=".pdf,.jpg,.jpeg,.png">
                            @if($item->file_lampiran)
                                <small class="text-success d-block mt-1"><i class="bi bi-check-circle-fill me-1"></i> File saat ini terlampir.</small>
                            @endif
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold text-secondary small">Isi / Instruksi Rinci</label>
                            <textarea name="isi_pengumuman" class="form-control border-2" rows="4" required>{{ $item->isi_pengumuman }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0 rounded-bottom-4">
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
