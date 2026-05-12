@extends('layouts.perangkat')

@section('styles')
<style>
    .stat-card {
        border-radius: 20px;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
        border: none;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .icon-wrapper {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .video-container {
        position: relative;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
        border-radius: 20px;
        overflow: hidden;
        background-color: #0f172a;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        aspect-ratio: 4/3;
    }
    #webcam {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .camera-overlay {
        position: absolute;
        bottom: 15px;
        left: 0;
        right: 0;
        text-align: center;
        z-index: 10;
    }
    .badge-status {
        padding: 8px 16px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    .review-bubble {
        background: #fff;
        border-radius: 16px;
        padding: 16px;
        border: 1px solid #f1f5f9;
        margin-bottom: 12px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">
    <!-- Header Welcome -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Selamat Datang, {{ auth()->user()->nama_lengkap }}</h4>
            <p class="text-muted small mb-0"><i class="bi bi-briefcase me-1"></i> {{ auth()->user()->jabatan ?? 'Aparatur Desa' }} &bull; <i class="bi bi-calendar3 ms-2 me-1"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div>
            <span class="badge bg-white text-dark shadow-sm px-3 py-2 border rounded-pill">
                <i class="bi bi-clock-fill text-teal me-1" style="color: var(--primary-teal);"></i> <span id="realtimeClock" class="fw-bold">00:00:00</span> WIB
            </span>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm pe-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm pe-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Baris Statistik -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card bg-white shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small fw-bold mb-1 tracking-wider text-uppercase">Total Kehadiran</p>
                        <h3 class="fw-bold mb-0 text-dark">{{ $statistik['hadir'] }} <span class="fs-6 fw-normal text-muted">hari</span></h3>
                    </div>
                    <div class="icon-wrapper" style="background-color: var(--primary-teal-light); color: var(--primary-teal);">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card bg-white shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small fw-bold mb-1 tracking-wider text-uppercase">Izin / Dinas Luar</p>
                        <h3 class="fw-bold mb-0 text-dark">{{ $statistik['izin'] }} <span class="fs-6 fw-normal text-muted">kali</span></h3>
                    </div>
                    <div class="icon-wrapper bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-envelope-paper"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card bg-white shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small fw-bold mb-1 tracking-wider text-uppercase">Sakit</p>
                        <h3 class="fw-bold mb-0 text-dark">{{ $statistik['sakit'] }} <span class="fs-6 fw-normal text-muted">hari</span></h3>
                    </div>
                    <div class="icon-wrapper bg-info bg-opacity-10 text-info">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card bg-white shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small fw-bold mb-1 tracking-wider text-uppercase">Rating Kinerja</p>
                        <h3 class="fw-bold mb-0 text-dark">{{ number_format($rataRataBintang, 1) }} <span class="fs-6 fw-normal text-warning"><i class="bi bi-star-fill"></i></span></h3>
                    </div>
                    <div class="icon-wrapper bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-award"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Utama: Presensi Kamera & Riwayat -->
    <div class="row g-4">
        <!-- Kolom Kiri: Perekaman Presensi -->
        <div class="col-lg-5">
            <div class="card bg-white shadow-sm p-4 border-0">
                <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-camera-video me-2" style="color: var(--primary-teal);"></i> Presensi Swafoto Langsung</h5>
                
                @if($absensiHariIni && $absensiHariIni->status !== 'Hadir')
                    <!-- Tampilan Khusus Status Manual Admin (Sakit/Izin/Alpa) -->
                    <div class="text-center py-4 px-3 rounded-4 bg-light border my-3">
                        <div class="d-inline-block p-3 rounded-circle mb-2 {{ $absensiHariIni->status === 'Sakit' ? 'bg-info bg-opacity-10 text-info' : 'bg-warning bg-opacity-10 text-warning' }}">
                            <i class="bi {{ $absensiHariIni->status === 'Sakit' ? 'bi-heart-pulse' : 'bi-envelope-paper' }} fs-1"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Status Hari Ini: {{ strtoupper($absensiHariIni->status) }}</h5>
                        <p class="text-muted small mb-0">Kehadiran Anda hari ini telah dicatat secara administratif oleh Admin.</p>
                        @if($absensiHariIni->catatan)
                            <div class="mt-2 small text-secondary fst-italic">"{{ $absensiHariIni->catatan }}"</div>
                        @endif
                    </div>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-secondary py-3 fw-bold rounded-pill shadow-sm" disabled>
                            <i class="bi bi-info-circle me-2 fs-5"></i> Kehadiran Diisi Admin ({{ $absensiHariIni->status }})
                        </button>
                    </div>
                @else
                    <!-- Status Kehadiran Hari Ini -->
                    <div class="p-3 mb-4 rounded-4" style="background-color: #f8fafc; border: 1px dashed #cbd5e1;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted fw-bold">Jam Masuk:</span>
                            <span class="fw-bold {{ $absensiHariIni?->waktu_masuk ? 'text-success' : 'text-danger' }}">
                                {{ $absensiHariIni?->waktu_masuk ?? 'Belum Tercatat' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted fw-bold">Jam Pulang:</span>
                            <span class="fw-bold {{ $absensiHariIni?->waktu_keluar ? 'text-success' : 'text-muted' }}">
                                {{ $absensiHariIni?->waktu_keluar ?? 'Belum Tercatat' }}
                            </span>
                        </div>
                    </div>

                    <!-- Kontainer Video Kamera -->
                    <div class="video-container mb-3">
                        <video id="webcam" autoplay playsinline></video>
                        <canvas id="canvas" class="d-none"></canvas>
                        <img id="snapshotPreview" class="d-none w-100 h-100 object-fit-cover position-absolute top-0 start-0" alt="Preview Snapshot">
                        
                        <div class="camera-overlay" id="cameraControls">
                            <button type="button" class="btn btn-light rounded-circle shadow p-3 mx-1" id="btnSwitchCamera" title="Ganti Kamera">
                                <i class="bi bi-arrow-repeat fs-5 text-dark"></i>
                            </button>
                            <button type="button" class="btn btn-danger rounded-circle shadow p-3 mx-1" id="btnCaptureSnap" title="Jepret Swafoto">
                                <i class="bi bi-camera-fill fs-4 text-white"></i>
                            </button>
                        </div>

                        <div class="camera-overlay d-none" id="previewControls">
                            <button type="button" class="btn btn-warning rounded-pill shadow px-4 py-2 mx-1 fw-bold small text-dark" id="btnRetakeSnap">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Foto Ulang
                            </button>
                        </div>
                    </div>

                    <!-- Formulir Aksi Presensi -->
                    <form action="{{ route('perangkat.absensi.store') }}" method="POST" id="formPresensi">
                        @csrf
                        <input type="hidden" name="image" id="base64Image">
                        <input type="hidden" name="tipe" id="tipePresensi">

                        <div class="d-grid gap-2">
                            @if(!$absensiHariIni?->waktu_masuk)
                                <button type="button" class="btn py-3 fw-bold rounded-pill shadow-sm text-white" style="background-color: var(--primary-teal);" onclick="submitPresensi('masuk')">
                                    <i class="bi bi-box-arrow-in-right me-2 fs-5"></i> Simpan Presensi Masuk Pagi
                                </button>
                            @elseif(!$absensiHariIni?->waktu_keluar)
                                <button type="button" class="btn btn-dark py-3 fw-bold rounded-pill shadow-sm" onclick="submitPresensi('keluar')">
                                    <i class="bi bi-box-arrow-right me-2 fs-5"></i> Simpan Presensi Pulang Sore
                                </button>
                            @else
                                <button type="button" class="btn btn-success py-3 fw-bold rounded-pill shadow-sm" disabled>
                                    <i class="bi bi-check2-all me-2 fs-5"></i> Presensi Hari Ini Selesai
                                </button>
                            @endif
                        </div>
                    </form>

                    <p class="text-muted small text-center mt-3 mb-0"><i class="bi bi-shield-check text-success me-1"></i> Foto wajah diambil langsung demi transparansi publik.</p>
                @endif
            </div>
        </div>

        <!-- Kolom Kanan: Riwayat & Ulasan -->
        <div class="col-lg-7">
            <!-- Tabel Riwayat Kehadiran -->
            <div class="card bg-white shadow-sm p-4 border-0 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-clock-history me-2 text-muted"></i> Riwayat Kehadiran Bulan Ini</h5>
                    <span class="badge bg-light text-dark border">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle text-nowrap table-responsive-stack">
                        <thead class="table-light text-uppercase fs-7 text-muted">
                            <tr>
                                <th class="py-3 ps-3 rounded-start">Tanggal</th>
                                <th class="py-3 text-center">Masuk</th>
                                <th class="py-3 text-center">Pulang</th>
                                <th class="py-3 text-center">Status</th>
                                <th class="py-3 text-center rounded-end">Foto Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatAbsensi as $item)
                                <tr>
                                    <td class="ps-3 fw-medium text-dark" data-label="Tanggal">{{ $item->tanggal->translatedFormat('d M Y') }}</td>
                                    <td class="text-center fw-bold text-success" data-label="Masuk">{{ $item->waktu_masuk ? \Carbon\Carbon::parse($item->waktu_masuk)->format('H:i') : '-' }}</td>
                                    <td class="text-center fw-bold text-secondary" data-label="Pulang">{{ $item->waktu_keluar ? \Carbon\Carbon::parse($item->waktu_keluar)->format('H:i') : '-' }}</td>
                                    <td class="text-center" data-label="Status">
                                        <div class="d-flex flex-column gap-1 align-items-center">
                                            <span class="badge {{ $item->status === 'Hadir' ? 'bg-success bg-opacity-10 text-success' : 'bg-warning bg-opacity-10 text-warning' }} px-2 py-1 rounded-3">
                                                {{ $item->status }}
                                            </span>
                                            @if($item->catatan === 'Telat')
                                                <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-0 rounded-pill" style="font-size: 0.62rem;">Telat</span>
                                            @elseif($item->catatan === 'On Time')
                                                <span class="badge bg-info bg-opacity-10 text-info px-2 py-0 rounded-pill" style="font-size: 0.62rem;">On Time</span>
                                            @elseif($item->catatan === 'Tidak Hadir')
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-0 rounded-pill" style="font-size: 0.62rem;">Tidak Hadir</span>
                                            @endif
                                            @if($item->status_konfirmasi_masuk === 'Terkonfirmasi')
                                                <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-0 rounded-3 mt-1" style="font-size: 0.65rem;"><i class="bi bi-check-circle-fill me-1"></i> Terkonfirmasi</span>
                                            @elseif($item->status_konfirmasi_masuk === 'Ditolak')
                                                <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-0 rounded-3 mt-1" style="font-size: 0.65rem;"><i class="bi bi-x-circle-fill me-1"></i> Ditolak</span>
                                            @else
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-0 rounded-3 mt-1" style="font-size: 0.65rem;"><i class="bi bi-hourglass-split me-1"></i> Menunggu Admin</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center" data-label="Foto Bukti">
                                        @if($item->foto_masuk || $item->foto_keluar)
                                            <button type="button" class="btn btn-sm btn-light border rounded-circle p-1 mx-1" onclick="previewFoto('{{ $item->foto_masuk ? asset('storage/'.$item->foto_masuk) : '' }}', '{{ $item->foto_keluar ? asset('storage/'.$item->foto_keluar) : '' }}', '{{ $item->tanggal->translatedFormat('d F Y') }}')" title="Lihat Foto">
                                                <i class="bi bi-image text-primary"></i>
                                            </button>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted small">Belum ada catatan presensi pada bulan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Ulasan Kinerja dari Warga -->
            <div class="card bg-white shadow-sm p-4 border-0">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-chat-heart me-2 text-danger"></i> Ulasan & Penilaian Masyarakat</h5>
                
                @forelse($penilaian as $ulasan)
                    <div class="review-bubble">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-dark small">
                                <i class="bi bi-person-circle text-muted me-1"></i> {{ $ulasan->warga?->nama_lengkap ?? 'Warga (Anonim)' }}
                            </span>
                            <span class="text-warning small">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $ulasan->rating ? '-fill' : '' }}"></i>
                                @endfor
                            </span>
                        </div>
                        <p class="text-muted small mb-1">{{ $ulasan->ulasan }}</p>
                        <span class="fs-8 text-secondary" style="font-size: 0.75rem;">{{ $ulasan->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted small border rounded-4 bg-light">
                        Belum ada ulasan yang disetujui untuk ditampilkan saat ini.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Foto Bukti -->
<div class="modal fade" id="modalPreviewFoto" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold text-dark" id="modalLabel">Bukti Swafoto - <span id="tglPreview"></span></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <div class="row g-3">
                    <div class="col-6">
                        <p class="small text-muted fw-bold mb-1">Pagi (Masuk)</p>
                        <img id="imgMasuk" src="" class="img-fluid rounded-3 shadow-sm object-fit-cover w-100" style="aspect-ratio: 3/4; display:none;" alt="Foto Masuk">
                        <div id="noImgMasuk" class="py-5 bg-light rounded-3 text-muted small border">Tidak Ada Foto</div>
                    </div>
                    <div class="col-6">
                        <p class="small text-muted fw-bold mb-1">Sore (Pulang)</p>
                        <img id="imgPulang" src="" class="img-fluid rounded-3 shadow-sm object-fit-cover w-100" style="aspect-ratio: 3/4; display:none;" alt="Foto Pulang">
                        <div id="noImgPulang" class="py-5 bg-light rounded-3 text-muted small border">Tidak Ada Foto</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Real-Time Clock Terintegrasi Waktu Internet (Anti-Manipulasi Jam Klien)
    let currentAbsoluteTime = new Date("{{ now()->toIso8601String() }}").getTime();
    
    // Kalibrasi ekstra ke Internet Time API untuk menjamin akurasi mutlak
    fetch('https://worldtimeapi.org/api/timezone/Asia/Jakarta')
        .then(response => response.json())
        .then(data => {
            if (data && data.datetime) {
                currentAbsoluteTime = new Date(data.datetime).getTime();
            }
        })
        .catch(err => console.log("NTP Sync fallback menggunakan waktu aman server"));

    function updateClock() {
        currentAbsoluteTime += 1000;
        const now = new Date(currentAbsoluteTime);
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const clockEl = document.getElementById('realtimeClock');
        if (clockEl) {
            clockEl.innerText = `${hours}:${minutes}:${seconds}`;
        }
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Webcam Logic (HTML5 WebRTC)
    const video = document.getElementById('webcam');
    const canvas = document.getElementById('canvas');
    const snapshotPreview = document.getElementById('snapshotPreview');
    const base64Input = document.getElementById('base64Image');
    const tipeInput = document.getElementById('tipePresensi');
    
    const cameraControls = document.getElementById('cameraControls');
    const previewControls = document.getElementById('previewControls');
    const btnCaptureSnap = document.getElementById('btnCaptureSnap');
    const btnRetakeSnap = document.getElementById('btnRetakeSnap');
    const btnSwitchCamera = document.getElementById('btnSwitchCamera');

    let currentStream = null;
    let useFrontCamera = true;

    async function startCamera() {
        stopCamera();
        const constraints = {
            video: {
                facingMode: useFrontCamera ? 'user' : 'environment',
                width: { ideal: 640 },
                height: { ideal: 480 }
            }
        };

        try {
            currentStream = await navigator.mediaDevices.getUserMedia(constraints);
            video.srcObject = currentStream;
            video.classList.remove('d-none');
            snapshotPreview.classList.add('d-none');
            cameraControls.classList.remove('d-none');
            previewControls.classList.add('d-none');
            base64Input.value = '';
        } catch (err) {
            console.error("Akses kamera ditolak atau tidak tersedia:", err);
            // Fallback UI
            video.parentElement.innerHTML = `<div class="p-5 text-center text-white"><i class="bi bi-camera-video-off fs-1 text-muted"></i><p class="small mt-2">Kamera tidak terdeteksi atau akses ditolak.</p></div>`;
        }
    }

    function stopCamera() {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
        }
    }

    btnSwitchCamera?.addEventListener('click', () => {
        useFrontCamera = !useFrontCamera;
        startCamera();
    });

    btnCaptureSnap?.addEventListener('click', () => {
        if (!currentStream) return;
        
        // Atur dimensi canvas sesuai video
        canvas.width = video.videoWidth || 640;
        canvas.height = video.videoHeight || 480;
        
        const context = canvas.getContext('2d');
        // Jika kamera depan, balik gambar secara horizontal agar seperti cermin
        if (useFrontCamera) {
            context.translate(canvas.width, 0);
            context.scale(-1, 1);
        }
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Ekspor ke format Base64 JPEG
        const dataUrl = canvas.toDataURL('image/jpeg', 0.8);
        base64Input.value = dataUrl;
        
        // Tampilkan Preview
        snapshotPreview.src = dataUrl;
        snapshotPreview.classList.remove('d-none');
        video.classList.add('d-none');
        cameraControls.classList.add('d-none');
        previewControls.classList.remove('d-none');
    });

    btnRetakeSnap?.addEventListener('click', () => {
        startCamera();
    });

    function submitPresensi(tipe) {
        if (!base64Input.value) {
            alert('Silakan jepret foto swafoto Anda terlebih dahulu sebelum menyimpan presensi!');
            return;
        }
        tipeInput.value = tipe;
        document.getElementById('formPresensi').submit();
    }

    function previewFoto(urlMasuk, urlPulang, tgl) {
        document.getElementById('tglPreview').innerText = tgl;
        
        const imgMasuk = document.getElementById('imgMasuk');
        const noImgMasuk = document.getElementById('noImgMasuk');
        if (urlMasuk) {
            imgMasuk.src = urlMasuk;
            imgMasuk.style.display = 'block';
            noImgMasuk.style.display = 'none';
        } else {
            imgMasuk.style.display = 'none';
            noImgMasuk.style.display = 'block';
        }

        const imgPulang = document.getElementById('imgPulang');
        const noImgPulang = document.getElementById('noImgPulang');
        if (urlPulang) {
            imgPulang.src = urlPulang;
            imgPulang.style.display = 'block';
            noImgPulang.style.display = 'none';
        } else {
            imgPulang.style.display = 'none';
            noImgPulang.style.display = 'block';
        }

        new bootstrap.Modal(document.getElementById('modalPreviewFoto')).show();
    }

    // Jalankan kamera saat halaman dimuat
    window.addEventListener('DOMContentLoaded', startCamera);
    // Hentikan kamera saat berpindah halaman
    window.addEventListener('beforeunload', stopCamera);
</script>
@endsection
