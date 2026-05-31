@extends('layouts.admin')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1"><i class="bi bi-calendar2-check-fill text-primary me-2"></i> Verifikasi & Rekap Presensi</h4>
            <p class="text-muted small mb-0">Pemantauan riwayat masuk/pulang, verifikasi swafoto riil, serta pencatatan izin dinas aparatur.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalManual">
                <i class="bi bi-pencil-square me-2"></i> Catat Kehadiran / Izin Manual
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Baris Penyaring Data -->
    <div class="card bg-white shadow-sm p-4 border-0 mb-4">
        <form action="{{ route('admin.rekap-absensi.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-sm-4 col-md-3">
                    <label class="form-label small fw-bold text-muted">Bulan</label>
                    <select name="bulan" class="form-select rounded-3">
                        <option value="">Semua Bulan</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 col-md-3">
                    <label class="form-label small fw-bold text-muted">Tahun</label>
                    <select name="tahun" class="form-select rounded-3">
                        <option value="">Semua Tahun</option>
                        @foreach(range(date('Y')-1, date('Y')+1) as $y)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dark rounded-3 px-4 fw-bold flex-grow-1"><i class="bi bi-funnel-fill me-2"></i> Terapkan Filter</button>
                        @if(request()->has('bulan') || request()->has('tahun'))
                            <a href="{{ route('admin.rekap-absensi.index') }}" class="btn btn-outline-secondary rounded-3 px-3" title="Reset Filter"><i class="bi bi-arrow-counterclockwise"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Rekap Absensi -->
    <div class="card bg-white shadow-sm p-4 border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle text-nowrap table-responsive-stack">
                <thead class="table-light text-uppercase fs-7 text-muted">
                    <tr>
                        <th class="py-3 ps-3 rounded-start">Aparatur</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3 text-center">Masuk</th>
                        <th class="py-3 text-center">Pulang</th>
                        <th class="py-3 text-center">Kehadiran</th>
                        <th class="py-3 text-center">Foto Bukti</th>
                        <th class="py-3 text-center">Status Validasi</th>
                        <th class="py-3 text-center rounded-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $item)
                        <tr>
                            <td class="ps-3" data-label="Aparatur">
                                <div class="fw-bold text-dark">{{ $item->user?->nama_lengkap ?? 'Aparatur Terhapus' }}</div>
                                <div class="small text-muted">{{ $item->user?->jabatan ?? '-' }}</div>
                            </td>
                            <td class="fw-medium text-secondary" data-label="Tanggal">{{ $item->tanggal->translatedFormat('d M Y') }}</td>
                            <td class="text-center fw-bold text-success" data-label="Masuk">{{ $item->waktu_masuk ? \Carbon\Carbon::parse($item->waktu_masuk)->format('H:i') : '-' }}</td>
                            <td class="text-center fw-bold text-secondary" data-label="Pulang">{{ $item->waktu_keluar ? \Carbon\Carbon::parse($item->waktu_keluar)->format('H:i') : '-' }}</td>
                            <td class="text-center" data-label="Kehadiran">
                                <div class="d-flex flex-column gap-1 align-items-center">
                                    <span class="badge {{ $item->status === 'Hadir' ? 'bg-success bg-opacity-10 text-success' : 'bg-warning bg-opacity-10 text-warning' }} px-2 py-1 rounded-3">
                                        {{ $item->status }}
                                    </span>
                                    @if($item->catatan === 'Telat')
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-0 rounded-pill" style="font-size: 0.65rem;">Telat</span>
                                    @elseif($item->catatan === 'On Time')
                                        <span class="badge bg-info bg-opacity-10 text-info px-2 py-0 rounded-pill" style="font-size: 0.65rem;">On Time</span>
                                    @elseif($item->catatan === 'Tidak Hadir')
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-0 rounded-pill" style="font-size: 0.65rem;">Tidak Hadir</span>
                                    @elseif($item->catatan)
                                        <i class="bi bi-info-circle text-muted" style="font-size: 0.7rem;" data-bs-toggle="tooltip" title="{{ $item->catatan }}"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center" data-label="Foto Bukti">
                                @if($item->foto_masuk || $item->foto_keluar)
                                    <button type="button" class="btn btn-sm btn-light border rounded-circle p-1 mx-1" onclick="previewFotoAdmin('{{ $item->foto_masuk ? asset('storage/'.$item->foto_masuk) : '' }}', '{{ $item->foto_keluar ? asset('storage/'.$item->foto_keluar) : '' }}', '{{ $item->user?->nama_lengkap }}', '{{ $item->tanggal->translatedFormat('d F Y') }}')" title="Lihat Foto Bukti">
                                        <i class="bi bi-image text-primary"></i>
                                    </button>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <!-- Status Validasi Terpadu -->
                            <td class="text-center" data-label="Status Validasi">
                                <div class="d-flex flex-column gap-1 align-items-center">
                                    <span class="badge {{ $item->status_konfirmasi_masuk === 'Terkonfirmasi' ? 'bg-primary bg-opacity-10 text-primary' : ($item->status_konfirmasi_masuk === 'Ditolak' ? 'bg-danger bg-opacity-10 text-danger' : 'bg-secondary bg-opacity-10 text-secondary') }} px-2 py-1 rounded-pill small" style="font-size: 0.68rem;" title="Status Pagi">
                                        Pagi: {{ $item->status_konfirmasi_masuk }}
                                    </span>
                                    @if($item->waktu_keluar)
                                        <span class="badge {{ $item->status_konfirmasi_keluar === 'Terkonfirmasi' ? 'bg-primary bg-opacity-10 text-primary' : ($item->status_konfirmasi_keluar === 'Ditolak' ? 'bg-danger bg-opacity-10 text-danger' : 'bg-secondary bg-opacity-10 text-secondary') }} px-2 py-1 rounded-pill small" style="font-size: 0.68rem;" title="Status Sore">
                                            Sore: {{ $item->status_konfirmasi_keluar }}
                                        </span>
                                    @else
                                        <span class="text-muted" style="font-size: 0.65rem;">Sore: Belum rekam</span>
                                    @endif
                                </div>
                            </td>
                            <!-- Tombol Pemicu Modal Konfirmasi -->
                            <td class="text-center" data-label="Aksi">
                                @php
                                    $isConfirmed = $item->status_konfirmasi_masuk === 'Terkonfirmasi' || $item->status_konfirmasi_keluar === 'Terkonfirmasi';
                                @endphp
                                <button type="button" class="btn btn-sm {{ $isConfirmed ? 'btn-outline-primary' : 'btn-success' }} rounded-pill px-3 py-1 fw-bold" data-bs-toggle="modal" data-bs-target="#modalKonfirmasi{{ $item->id }}">
                                    @if($isConfirmed)
                                        <i class="bi bi-pencil-fill me-1"></i> Edit
                                    @else
                                        <i class="bi bi-check2-circle me-1"></i> Konfirmasi
                                    @endif
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted small">Belum ada catatan presensi aparatur pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginasi -->
        <div class="mt-4">
            {{ $absensi->links() }}
        </div>
    </div>
</div>

<!-- Kumpulan Modal Konfirmasi Spesifik per Item -->
@foreach($absensi as $item)
    <div class="modal fade" id="modalKonfirmasi{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <form action="{{ route('admin.rekap-absensi.konfirmasi', $item->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header border-0 pb-0">
                        <h6 class="modal-title fw-bold text-dark"><i class="bi bi-shield-check text-primary me-2"></i> Konfirmasi & Status Presensi</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-start">
                        <div class="d-flex align-items-center mb-3 p-3 bg-light rounded-3">
                            <div>
                                <h6 class="fw-bold text-dark mb-0">{{ $item->user?->nama_lengkap }}</h6>
                                <span class="small text-muted">{{ $item->tanggal->translatedFormat('d F Y') }} &bull; Jabatan: {{ $item->user?->jabatan }}</span>
                            </div>
                        </div>

                        <!-- Status Kehadiran Dasar -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Status Kehadiran Dasar</label>
                            <select name="status" class="form-select rounded-3">
                                <option value="Hadir" {{ $item->status === 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="Izin" {{ $item->status === 'Izin' ? 'selected' : '' }}>Izin</option>
                                <option value="Sakit" {{ $item->status === 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="Alpa" {{ $item->status === 'Alpa' ? 'selected' : '' }}>Alpa</option>
                            </select>
                        </div>

                        <!-- Status Verifikasi Pagi & Sore -->
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">Verifikasi Pagi (Masuk)</label>
                                <select name="status_konfirmasi_masuk" class="form-select rounded-3">
                                    <option value="Terkonfirmasi" {{ $item->status_konfirmasi_masuk === 'Terkonfirmasi' ? 'selected' : '' }}>Terkonfirmasi</option>
                                    <option value="Menunggu" {{ $item->status_konfirmasi_masuk === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Ditolak" {{ $item->status_konfirmasi_masuk === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">Verifikasi Sore (Pulang)</label>
                                <select name="status_konfirmasi_keluar" class="form-select rounded-3">
                                    <option value="Terkonfirmasi" {{ $item->status_konfirmasi_keluar === 'Terkonfirmasi' ? 'selected' : '' }}>Terkonfirmasi</option>
                                    <option value="Menunggu" {{ $item->status_konfirmasi_keluar === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Ditolak" {{ $item->status_konfirmasi_keluar === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                @if(!$item->waktu_keluar)
                                    <span class="text-muted d-block mt-1" style="font-size:0.65rem;">Belum rekam foto sore</span>
                                @endif
                            </div>
                        </div>

                        <!-- Catatan Kustom -->
                        <div class="mb-2">
                            <label class="form-label small fw-bold text-muted">Keterangan / Catatan Admin</label>
                            <select name="catatan" class="form-select rounded-3">
                                <option value="On Time" {{ $item->catatan === 'On Time' || empty($item->catatan) ? 'selected' : '' }}>On Time</option>
                                <option value="Telat" {{ $item->catatan === 'Telat' ? 'selected' : '' }}>Telat</option>
                                <option value="Tidak Hadir" {{ $item->catatan === 'Tidak Hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 pe-4 pb-4">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<!-- Modal Input Manual -->
<div class="modal fade" id="modalManual" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form action="{{ route('admin.rekap-absensi.manual') }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold"><i class="bi bi-pencil-square text-primary me-2"></i> Sisipkan Kehadiran / Izin Aparatur</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Pilih Aparatur Desa</label>
                        <select name="user_id" class="form-select rounded-3" required>
                            <option value="">-- Pilih Aparatur --</option>
                            @foreach($aparaturList as $ap)
                                <option value="{{ $ap->id }}">{{ $ap->nama_lengkap }} ({{ $ap->jabatan }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Tanggal Presensi</label>
                        <input type="date" name="tanggal" class="form-control rounded-3" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Status Presensi</label>
                        <select name="status" class="form-select rounded-3" required>
                            <option value="Hadir">Hadir (Dinas Luar Tanpa Gawai)</option>
                            <option value="Izin">Izin / Keperluan Mendesak</option>
                            <option value="Sakit">Sakit (Dengan Surat Dokter)</option>
                            <option value="Alpa">Alpa / Tanpa Keterangan</option>
                        </select>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">Jam Masuk (Opsional)</label>
                            <input type="time" name="waktu_masuk" class="form-control rounded-3">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">Jam Pulang (Opsional)</label>
                            <input type="time" name="waktu_keluar" class="form-control rounded-3">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-muted">Keterangan / Alasan Verifikasi</label>
                        <textarea name="catatan" class="form-control rounded-3" rows="2" placeholder="Contoh: Mengikuti rapat dinas di kecamatan, lampiran izin tercetak, dll"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pe-4 pb-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Simpan & Verifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Preview Foto untuk Admin -->
<div class="modal fade" id="modalPreviewFotoAdmin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold text-dark">Verifikasi Foto &bull; <span id="namaAparaturPreview" class="text-primary"></span></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <p class="small text-muted mb-3">Tanggal: <span id="tglAparaturPreview" class="fw-bold text-dark"></span></p>
                <div class="row g-3">
                    <div class="col-6">
                        <p class="small text-muted fw-bold mb-1">Bukti Masuk (Pagi)</p>
                        <img id="imgMasukAdmin" src="" class="img-fluid rounded-3 shadow-sm object-fit-cover w-100" style="aspect-ratio: 3/4; display:none;" alt="Foto Masuk">
                        <div id="noImgMasukAdmin" class="py-5 bg-light rounded-3 text-muted small border">Tidak Ada Foto</div>
                    </div>
                    <div class="col-6">
                        <p class="small text-muted fw-bold mb-1">Bukti Pulang (Sore)</p>
                        <img id="imgPulangAdmin" src="" class="img-fluid rounded-3 shadow-sm object-fit-cover w-100" style="aspect-ratio: 3/4; display:none;" alt="Foto Pulang">
                        <div id="noImgPulangAdmin" class="py-5 bg-light rounded-3 text-muted small border">Tidak Ada Foto</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewFotoAdmin(urlMasuk, urlPulang, nama, tgl) {
        document.getElementById('namaAparaturPreview').innerText = nama;
        document.getElementById('tglAparaturPreview').innerText = tgl;
        
        const imgMasuk = document.getElementById('imgMasukAdmin');
        const noImgMasuk = document.getElementById('noImgMasukAdmin');
        if (urlMasuk) {
            imgMasuk.src = urlMasuk;
            imgMasuk.style.display = 'block';
            noImgMasuk.style.display = 'none';
        } else {
            imgMasuk.style.display = 'none';
            noImgMasuk.style.display = 'block';
        }

        const imgPulang = document.getElementById('imgPulangAdmin');
        const noImgPulang = document.getElementById('noImgPulangAdmin');
        if (urlPulang) {
            imgPulang.src = urlPulang;
            imgPulang.style.display = 'block';
            noImgPulang.style.display = 'none';
        } else {
            imgPulang.style.display = 'none';
            noImgPulang.style.display = 'block';
        }

        new bootstrap.Modal(document.getElementById('modalPreviewFotoAdmin')).show();
    }
</script>
@endsection
