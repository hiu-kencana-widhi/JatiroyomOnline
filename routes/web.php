<?php

use Illuminate\Support\Facades\Route;

// Auth & Home Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\AnggaranController;
use App\Http\Controllers\Admin\JenisSuratController;
use App\Http\Controllers\Admin\PengajuanController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\PotretController;

// User Controllers
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\SuratController;
use App\Http\Controllers\User\RiwayatController;
use App\Http\Controllers\User\ProfilController;

// Perangkat Controllers
use App\Http\Controllers\Perangkat\PerangkatDashboardController;
use App\Http\Controllers\Perangkat\AbsensiController;

// Admin Perangkat Controllers
use App\Http\Controllers\Admin\KelolaPerangkatController;
use App\Http\Controllers\Admin\RekapAbsensiController;
use App\Http\Controllers\Admin\ModerasiPenilaianController;

// Public Penilaian Controller
use App\Http\Controllers\Public\PenilaianController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/acara', [HomeController::class, 'acara'])->name('acara');
Route::get('/anggaran', [HomeController::class, 'anggaran'])->name('anggaran');
Route::get('/anggaran/download/{anggaran}', [HomeController::class, 'downloadAnggaran'])->name('anggaran.download');
Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login/check-nik', [LoginController::class, 'checkNik'])->name('login.check');
Route::get('/login/pin', [LoginController::class, 'showPinForm'])->name('login.pin.form');
Route::post('/login/verify-pin', [LoginController::class, 'verifyPin'])->name('login.pin.verify');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| User / Warga Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Pengajuan Surat
    Route::get('/surat', [SuratController::class, 'pilih'])->name('surat.pilih');
    Route::get('/surat/buat/{jenisSurat}', [SuratController::class, 'form'])->name('surat.form');
    Route::post('/surat/kirim', [SuratController::class, 'kirim'])->name('surat.kirim');
    
    // Riwayat & Download
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/riwayat/{pengajuan}/download', [RiwayatController::class, 'download'])->name('riwayat.download');
    
    // Profil Mandiri
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');

    // Pelaporan Insiden Warga
    Route::get('/laporan', [\App\Http\Controllers\User\LaporanWargaController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/buat', [\App\Http\Controllers\User\LaporanWargaController::class, 'create'])->name('laporan.create');
    Route::post('/laporan', [\App\Http\Controllers\User\LaporanWargaController::class, 'store'])->name('laporan.store');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Master Data
    Route::resource('warga', WargaController::class)->except(['show']);
    Route::resource('acara', AcaraController::class)->except(['show']);
    Route::patch('/jenis-surat/{jenis_surat}/toggle', [JenisSuratController::class, 'toggleStatus'])->name('jenis-surat.toggle');
    Route::resource('jenis-surat', JenisSuratController::class)->except(['show']);
    
    // Potret Desa
    Route::patch('/potret/{potret}/toggle', [PotretController::class, 'toggle'])->name('potret.toggle');
    Route::resource('potret', PotretController::class)->except(['show', 'create', 'edit']);
    
    // Alur Kerja Pengajuan Surat
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/{pengajuan}', [PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::post('/pengajuan/{pengajuan}/konfirmasi', [PengajuanController::class, 'konfirmasi'])->name('pengajuan.konfirmasi');
    Route::post('/pengajuan/{pengajuan}/terbitkan', [PengajuanController::class, 'terbitkan'])->name('pengajuan.terbitkan');
    Route::post('/pengajuan/{pengajuan}/siap-diambil', [PengajuanController::class, 'siapDiambil'])->name('pengajuan.siap-diambil');
    Route::post('/pengajuan/{pengajuan}/selesai', [PengajuanController::class, 'tandaiSelesai'])->name('pengajuan.selesai');
    Route::get('/pengajuan/{pengajuan}/download-pdf', [PengajuanController::class, 'downloadPdf'])->name('pengajuan.download-pdf');
    Route::post('/pengajuan/{pengajuan}/tolak', [PengajuanController::class, 'tolak'])->name('pengajuan.tolak');
    
    // Pengaturan Sistem & Anggaran
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    Route::resource('anggaran', AnggaranController::class)->only(['index', 'store', 'destroy']);
    
    // Manajemen Perangkat Desa & Absensi
    Route::get('/kelola-perangkat', [KelolaPerangkatController::class, 'index'])->name('kelola-perangkat.index');
    Route::post('/kelola-perangkat', [KelolaPerangkatController::class, 'store'])->name('kelola-perangkat.store');
    Route::put('/kelola-perangkat/{user}', [KelolaPerangkatController::class, 'update'])->name('kelola-perangkat.update');
    Route::delete('/kelola-perangkat/{user}', [KelolaPerangkatController::class, 'destroy'])->name('kelola-perangkat.destroy');

    // Rekap & Konfirmasi Absensi
    Route::get('/rekap-absensi', [RekapAbsensiController::class, 'index'])->name('rekap-absensi.index');
    Route::patch('/rekap-absensi/{absensi}/konfirmasi', [RekapAbsensiController::class, 'konfirmasi'])->name('rekap-absensi.konfirmasi');
    Route::post('/rekap-absensi/manual', [RekapAbsensiController::class, 'storeManual'])->name('rekap-absensi.manual');

    // Moderasi Penilaian Warga
    Route::get('/moderasi-penilaian', [ModerasiPenilaianController::class, 'index'])->name('moderasi-penilaian.index');
    Route::patch('/moderasi-penilaian/{penilaian}/toggle', [ModerasiPenilaianController::class, 'toggle'])->name('moderasi-penilaian.toggle');
    Route::delete('/moderasi-penilaian/{penilaian}', [ModerasiPenilaianController::class, 'destroy'])->name('moderasi-penilaian.destroy');

    // Pengelolaan Laporan Insiden Warga
    Route::get('/laporan', [\App\Http\Controllers\Admin\KelolaLaporanController::class, 'index'])->name('laporan.index');
    Route::patch('/laporan/{id}/status', [\App\Http\Controllers\Admin\KelolaLaporanController::class, 'updateStatus'])->name('laporan.status');

    // Manajemen Spanduk Pengumuman Desa Global
    Route::patch('/pengumuman/{pengumuman}/toggle', [\App\Http\Controllers\Admin\PengumumanController::class, 'toggle'])->name('pengumuman.toggle');
    Route::resource('pengumuman', \App\Http\Controllers\Admin\PengumumanController::class)->except(['show', 'create', 'edit']);
});

/*
|--------------------------------------------------------------------------
| Perangkat Desa Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:perangkat_desa'])->prefix('perangkat')->name('perangkat.')->group(function () {
    Route::get('/dashboard', [PerangkatDashboardController::class, 'index'])->name('dashboard');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');

    // Pantauan Laporan Insiden Lapangan
    Route::get('/laporan', [\App\Http\Controllers\Perangkat\LaporanWargaController::class, 'index'])->name('laporan.index');
    Route::patch('/laporan/{id}/tanggapan', [\App\Http\Controllers\Perangkat\LaporanWargaController::class, 'tanggapi'])->name('laporan.tanggapi');
});
