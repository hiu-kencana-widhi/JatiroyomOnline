@extends('layouts.user')

@section('styles')
<!-- Leaflet CSS for Map Preview -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .camera-wrapper {
        position: relative;
        background: #1e293b;
        border-radius: 16px;
        overflow: hidden;
        min-height: 320px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: inset 0 0 40px rgba(0,0,0,0.5);
    }
    #webcamVideo {
        width: 100%;
        height: auto;
        max-height: 400px;
        object-fit: cover;
    }
    #capturedCanvas {
        display: none;
        width: 100%;
        height: auto;
        max-height: 400px;
        object-fit: cover;
        border-radius: 16px;
    }
    .map-preview {
        height: 250px;
        border-radius: 16px;
        border: 2px solid #e2e8f0;
        z-index: 5;
        position: relative;
    }
    /* Memaksa kontainer internal Leaflet agar tetap di bawah level komponen lain */
    .leaflet-container {
        z-index: 5 !important;
    }
    .status-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 10;
    }
</style>
@endsection

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.laporan.index') }}" class="text-decoration-none">Laporan Warga</a></li>
            <li class="breadcrumb-item active">Buat Laporan Insiden</li>
        </ol>
    </nav>
    <h3 class="fw-bold text-dark">Lapor Kerusakan & Insiden Lapangan</h3>
    <p class="text-muted">Ambil foto bukti fisik melalui kamera gawai Anda dan lengkapi deskripsi agar segera ditangani oleh desa.</p>
</div>

@if(session('error'))
<div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
</div>
@endif

<form action="{{ route('user.laporan.store') }}" method="POST" id="laporanForm">
    @csrf
    <input type="hidden" name="foto_base64" id="foto_base64" required>
    <input type="hidden" name="latitude" id="latitude" required>
    <input type="hidden" name="longitude" id="longitude" required>

    <div class="row g-4">
        <!-- Kolom Kiri: Kamera & Bukti -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-camera-fill text-danger me-2"></i> Foto Bukti Fisik (Wajib)</h6>
                    <span class="badge bg-danger rounded-pill" id="cameraStatusBadge"><i class="bi bi-circle-fill text-white animate-pulse me-1"></i> Live Kamera</span>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="camera-wrapper mb-3">
                            <video id="webcamVideo" autoplay playsinline></video>
                            <canvas id="capturedCanvas"></canvas>
                            <div class="text-center p-4 text-white opacity-50 position-absolute" id="cameraLoader">
                                <div class="spinner-border mb-2" role="status"></div>
                                <p class="small mb-0">Mengakses Kamera Peramban...</p>
                            </div>
                        </div>
                        <p class="text-muted small mb-4">
                            <i class="bi bi-lightbulb text-warning me-1"></i> Pastikan objek kerusakan (jalan berlubang, lampu padam, dsb.) terlihat dengan jelas.
                        </p>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-primary btn-lg w-100 py-3 rounded-pill fw-bold shadow-sm" id="btnSnap" style="position: relative; z-index: 20;">
                            <i class="bi bi-camera me-2"></i> Ambil Foto
                        </button>
                        <button type="button" class="btn btn-info btn-lg py-3 rounded-pill fw-bold text-white px-3 shadow-sm" id="btnSwitchCam" data-bs-toggle="tooltip" title="Ganti Kamera Depan/Belakang" style="position: relative; z-index: 20;">
                            <i class="bi bi-arrow-repeat fs-5"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-lg py-3 rounded-pill fw-bold d-none px-4" id="btnRetake" style="position: relative; z-index: 20;">
                            <i class="bi bi-arrow-counterclockwise"></i> Ulangi
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Detail Laporan & Peta -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-card-text me-2"></i> Rincian & Lokasi Laporan</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Kategori Insiden</label>
                            <select name="kategori" class="form-select border-2" required>
                                <option value="" disabled selected>Pilih Kategori...</option>
                                <option value="Infrastruktur" {{ old('kategori') == 'Infrastruktur' ? 'selected' : '' }}>Jalan Rusak / Infrastruktur</option>
                                <option value="Kebersihan" {{ old('kategori') == 'Kebersihan' ? 'selected' : '' }}>Penumpukan Sampah / Kebersihan</option>
                                <option value="Keamanan" {{ old('kategori') == 'Keamanan' ? 'selected' : '' }}>Lampu Padam / Keamanan</option>
                                <option value="Fasilitas Umum" {{ old('kategori') == 'Fasilitas Umum' ? 'selected' : '' }}>Fasilitas Umum</option>
                                <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Judul Singkat</label>
                            <input type="text" name="judul_laporan" class="form-control border-2" placeholder="Contoh: Jalan Longsor di RT 01" value="{{ old('judul_laporan') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Deskripsi Rinci</label>
                            <textarea name="deskripsi" class="form-control border-2" rows="3" placeholder="Jelaskan secara mendetail lokasi atau situasi kerusakan..." required>{{ old('deskripsi') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Patokan Alamat (Opsional)</label>
                            <input type="text" name="alamat_lokasi" class="form-control border-2" placeholder="Nama Jalan, Dekat Rumah Bp. X, dsb." value="{{ old('alamat_lokasi') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-secondary small text-uppercase d-flex justify-content-between">
                                <span>Titik Koordinat Geolocation</span>
                                <span class="text-success small fw-bold" id="gpsStatus"><i class="bi bi-geo-alt-fill me-1"></i> Mendeteksi Lokasi...</span>
                            </label>
                            <!-- Peta Gratis OpenStreetMap Leaflet -->
                            <div id="mapPreview" class="map-preview mb-1"></div>
                            <div class="d-flex justify-content-between align-items-center mt-1 flex-wrap gap-1">
                                <small class="text-muted" style="font-size: 0.75rem;">Geser pin penanda di atas peta jika koordinat GPS belum presisi.</small>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold py-1" id="btnRefreshGps" style="position: relative; z-index: 20;">
                                    <i class="bi bi-geo-alt me-1"></i> Deteksi Ulang GPS
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary btn-lg w-100 py-3 rounded-pill fw-bold shadow-lg" id="btnSubmit">
                            <i class="bi bi-send-fill me-2"></i> Kirim Laporan Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Inisialisasi Kamera (Webcam)
        const video = document.getElementById('webcamVideo');
        const canvas = document.getElementById('capturedCanvas');
        const btnSnap = document.getElementById('btnSnap');
        const btnRetake = document.getElementById('btnRetake');
        const cameraLoader = document.getElementById('cameraLoader');
        const fotoInput = document.getElementById('foto_base64');
        const cameraBadge = document.getElementById('cameraStatusBadge');
        const btnSwitchCam = document.getElementById('btnSwitchCam');
        let stream = null;
        let currentFacingMode = "environment";

        // Meminta akses kamera
        async function initCamera() {
            cameraLoader.style.display = 'block';
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: currentFacingMode, width: { ideal: 1280 }, height: { ideal: 720 } },
                    audio: false
                });
                video.srcObject = stream;
                video.onloadedmetadata = () => {
                    cameraLoader.style.display = 'none';
                };
                cameraBadge.className = 'badge bg-danger rounded-pill';
                cameraBadge.innerHTML = `<i class="bi bi-circle-fill text-white animate-pulse me-1"></i> Live (${currentFacingMode === 'environment' ? 'Belakang' : 'Depan'})`;
            } catch (err) {
                console.error("Gagal mengakses kamera: ", err);
                cameraLoader.innerHTML = `<i class="bi bi-camera-video-off fs-1 text-danger"></i><p class="small mt-2 mb-0 text-danger">Kamera tidak diizinkan atau tidak ditemukan.</p>`;
                cameraBadge.className = 'badge bg-secondary rounded-pill';
                cameraBadge.innerHTML = '<i class="bi bi-slash-circle me-1"></i> Offline';
            }
        }
        initCamera();

        // Tombol Ganti Kamera Depan/Belakang
        if (btnSwitchCam) {
            btnSwitchCam.addEventListener('click', function () {
                currentFacingMode = currentFacingMode === "environment" ? "user" : "environment";
                initCamera();
            });
        }

        // Mengambil foto
        btnSnap.addEventListener('click', function () {
            if (!stream) {
                alert("Kamera belum siap atau akses ditolak peramban.");
                return;
            }
            canvas.width = video.videoWidth || 640;
            canvas.height = video.videoHeight || 480;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Konversi ke Base64 (WebP agar ringan)
            const base64Data = canvas.toDataURL('image/webp', 0.85);
            fotoInput.value = base64Data;

            // Sembunyikan video, tampilkan hasil
            video.style.display = 'none';
            canvas.style.display = 'block';
            btnSnap.classList.add('d-none');
            btnRetake.classList.remove('d-none');
            cameraBadge.className = 'badge bg-success rounded-pill';
            cameraBadge.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Tersimpan';
        });

        // Mengulangi foto
        btnRetake.addEventListener('click', function () {
            fotoInput.value = '';
            canvas.style.display = 'none';
            video.style.display = 'block';
            btnRetake.classList.add('d-none');
            btnSnap.classList.remove('d-none');
            cameraBadge.className = 'badge bg-danger rounded-pill';
            cameraBadge.innerHTML = '<i class="bi bi-circle-fill text-white animate-pulse me-1"></i> Live Kamera';
        });

        // 2. Inisialisasi Peta & Sensor Geolocation
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        const gpsStatus = document.getElementById('gpsStatus');

        // Koordinat Default Balai Desa Jatiroyom jika warga gagal share loc
        let defaultLat = -7.012876;
        let defaultLng = 109.481154;

        const map = L.map('mapPreview').setView([defaultLat, defaultLng], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        // Jika marker digeser warga
        marker.on('dragend', function (event) {
            const position = marker.getLatLng();
            latInput.value = position.lat;
            lngInput.value = position.lng;
            gpsStatus.className = 'text-primary small fw-bold';
            gpsStatus.innerHTML = '<i class="bi bi-pin-map-fill me-1"></i> Pin Manual';
        });

        // Fungsi Pemutakhiran Titik GPS Presisi Tinggi
        function syncHighAccuracyGps(isManual = false) {
            if (isManual) {
                gpsStatus.className = 'text-primary small fw-bold';
                gpsStatus.innerHTML = '<i class="bi bi-arrow-repeat me-1 animate-spin"></i> Menyinkronkan GPS...';
            }
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    const accuracy = Math.round(position.coords.accuracy);
                    
                    latInput.value = userLat;
                    lngInput.value = userLng;

                    map.setView([userLat, userLng], 17);
                    marker.setLatLng([userLat, userLng]);

                    gpsStatus.className = 'text-success small fw-bold';
                    gpsStatus.innerHTML = `<i class="bi bi-check-circle-fill me-1"></i> Akurat (Radius ${accuracy}m)`;
                }, function (error) {
                    console.warn("GPS diblokir/gagal: ", error);
                    if (!latInput.value || latInput.value == defaultLat) {
                        latInput.value = defaultLat;
                        lngInput.value = defaultLng;
                    }
                    gpsStatus.className = 'text-warning small fw-bold';
                    gpsStatus.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-1"></i> Sinyal Lemah / Default';
                }, { enableHighAccuracy: true, maximumAge: 0, timeout: 15000 });
            } else {
                latInput.value = defaultLat;
                lngInput.value = defaultLng;
                gpsStatus.innerHTML = 'GPS Tidak Didukung';
            }
        }
        
        // Eksekusi awal
        syncHighAccuracyGps();

        // Pantau perbaikan akurasi satelit secara otomatis
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(function (position) {
                // Hanya perbarui otomatis jika pin belum digeser manual oleh pengguna
                if (gpsStatus.innerHTML.indexOf('Manual') === -1 && position.coords.accuracy <= 60) {
                    latInput.value = position.coords.latitude;
                    lngInput.value = position.coords.longitude;
                    marker.setLatLng([position.coords.latitude, position.coords.longitude]);
                    gpsStatus.className = 'text-success small fw-bold';
                    gpsStatus.innerHTML = `<i class="bi bi-check-circle-fill me-1"></i> Sangat Akurat (${Math.round(position.coords.accuracy)}m)`;
                }
            }, null, { enableHighAccuracy: true, maximumAge: 5000, timeout: 10000 });
        }

        // Tombol Deteksi Ulang GPS Manual
        const btnRefreshGps = document.getElementById('btnRefreshGps');
        if (btnRefreshGps) {
            btnRefreshGps.addEventListener('click', function () {
                syncHighAccuracyGps(true);
            });
        }

        // Validasi Submit
        document.getElementById('laporanForm').addEventListener('submit', function (e) {
            if (!fotoInput.value) {
                e.preventDefault();
                alert("Harap ambil foto bukti terlebih dahulu melalui kamera yang tersedia.");
            }
        });
    });
</script>
@endsection
