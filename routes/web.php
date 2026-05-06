<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/anggaran/download', [HomeController::class, 'downloadAnggaran'])->name('anggaran.download');

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login/check-nik', [LoginController::class, 'checkNik'])->name('login.check');
Route::get('/login/pin', [LoginController::class, 'showPinForm'])->name('login.pin.form');
Route::post('/login/verify-pin', [LoginController::class, 'verifyPin'])->name('login.pin.verify');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\AnggaranController;
use App\Http\Controllers\Admin\JenisSuratController;
use App\Http\Controllers\Admin\PengajuanController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\PotretController;

use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\SuratController;
use App\Http\Controllers\User\RiwayatController;
use App\Http\Controllers\User\ProfilController;

// Dashboards
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Surat
    Route::get('/surat', [SuratController::class, 'pilih'])->name('surat.pilih');
    Route::get('/surat/buat/{jenisSurat}', [SuratController::class, 'form'])->name('surat.form');
    Route::post('/surat/kirim', [SuratController::class, 'kirim'])->name('surat.kirim');
    
    // Riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/riwayat/{pengajuan}/download', [RiwayatController::class, 'download'])->name('riwayat.download');
    
    // Profil
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Manajemen Master
    Route::resource('warga', WargaController::class)->except(['show']);
    Route::resource('acara', AcaraController::class)->except(['show']);
    Route::patch('/jenis-surat/{jenis_surat}/toggle', [JenisSuratController::class, 'toggleStatus'])->name('jenis-surat.toggle');
    Route::resource('jenis-surat', JenisSuratController::class)->except(['show']);
    
    // Potret Desa
    Route::patch('/potret/{potret}/toggle', [PotretController::class, 'toggle'])->name('potret.toggle');
    Route::resource('potret', PotretController::class)->except(['show', 'create', 'edit']);
    
    // Pengajuan & Konfirmasi
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/{pengajuan}', [PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::post('/pengajuan/{pengajuan}/konfirmasi', [PengajuanController::class, 'konfirmasi'])->name('pengajuan.konfirmasi');
    Route::post('/pengajuan/{pengajuan}/tolak', [PengajuanController::class, 'tolak'])->name('pengajuan.tolak');
    
    // Pengaturan
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    
    // Anggaran
    Route::get('/anggaran', [AnggaranController::class, 'index'])->name('anggaran.index');
    Route::post('/anggaran', [AnggaranController::class, 'store'])->name('anggaran.store');
    Route::delete('/anggaran/{anggaran}', [AnggaranController::class, 'destroy'])->name('anggaran.destroy');
});
