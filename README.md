<div align="center">

# 🏛️ SMART VILLAGE: DESA JATIROYOM
**Sistem Informasi Manajemen Surat, Presensi Aparatur & Pelayanan Publik Terpadu**

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)
[![Styling](https://img.shields.io/badge/Styling-Premium_CSS_Stack-38B2AC?style=for-the-badge)](/)
[![Status](https://img.shields.io/badge/Status-Production_Ready-success?style=for-the-badge)](#)

*Solusi Digitalisasi Administrasi Desa Terintegrasi Pengajuan Surat Mandiri, Rekam Jejak Kehadiran Aparatur Real-Time, dan Transparansi Ulasan Kinerja Warga.*

</div>

---

## 📖 Tentang Proyek

**Sistem Smart Village Desa Jatiroyom** merupakan evolusi aplikasi web tata kelola desa dari platform surat-menyurat menjadi portal administrasi terpadu. Proyek ini mendigitalisasi tiga pilar utama pelayanan publik:
1. **Pelayanan Administrasi Surat Warga** secara mandiri dan cepat.
2. **Integritas Waktu & Presensi Aparatur Desa** menggunakan deteksi kamera mandiri yang tervalidasi dengan zona waktu riil Indonesia (WIB).
3. **Akuntabilitas & Evaluasi Kinerja** melalui wadah pemberian *rating* serta ulasan langsung dari masyarakat.

Dikembangkan dengan estetika premium, antarmuka sistem menjamin pengalaman pengguna yang luar biasa di perangkat desktop maupun seluler melalui arsitektur **Card Stacked Layout** tanpa pengguliran mendatar yang kaku.

---

## ✨ Fitur & Modul Utama

### 🌐 1. Portal Publik & Transparansi Informasi
- **Beranda Interaktif**: Etalase visual keindahan desa, struktur kepemimpinan, dan sorotan ulasan pelayanan dari masyarakat.
- **Agenda & Acara Desa**: Publikasi acara dan jadwal kegiatan desa untuk memastikan masyarakat luas terus mengetahui informasi terkini.
- **Transparansi Anggaran**: Publikasi grafik dan laporan alokasi anggaran desa yang transparan serta dapat diunduh langsung oleh publik.
- **Peta Lokasi Akurat**: Sematan peta Google Maps Balai Desa Jatiroyom dengan perlindungan privasi berskala tinggi.

### 👥 2. Dasbor Warga (Layanan Surat & Evaluasi)
- **Akses Cepat NIK**: Masuk tanpa kata sandi yang rumit, cukup menggunakan NIK.
- **Pengajuan Surat Dinamis**: Memilih ragam surat pengantar, mengisi formulir spesifik, dan melacak status persetujuan secara seketika (*real-time*).
- **Unduh Arsip Resmi**: Akses unduh berkas digital (PDF) bertanda tangan elektronik langsung setelah disetujui.
- **Penilaian Kinerja Aparatur**: Warga dapat memilih aparatur desa, memberikan *rating* bintang (1-5), serta menulis ulasan kepuasan layanan yang nantinya akan dimoderasi oleh sistem sebelum tampil publik.

### 💼 3. Dasbor Aparatur Desa (Presensi Mandiri)
- **Otentikasi Aman**: Perlindungan ganda berbasis NIK dan PIN rahasia 6-digit.
- **Presensi Pagi & Sore**: Fitur rekam kehadiran dengan pratinjau foto kamera mandiri (*webcam snapshot*) atau unggahan bukti.
- **Integritas Waktu Internet**: Sinkronisasi waktu menggunakan konfigurasi basis server (`Asia/Jakarta`) guna menghindari manipulasi jam lokal pada gawai pengguna.
- **Riwayat Status Kehadiran**: Perekaman pelabelan otomatis (*On Time*, *Telat*, *Tidak Hadir*) dan pemantauan status persetujuan admin.

### 🛡️ 4. Dasbor Administrator (Tata Kelola Menyeluruh)
- **Verifikasi Alur Surat**: Konfirmasi, penolakan dengan catatan, dan notifikasi pengambilan dokumen fisik di Balai Desa.
- **Moderasi Presensi Aparatur**: Validasi ganda atas foto bukti masuk/pulang, serta kemampuan mencatat absensi/izin aparatur secara manual yang otomatis terintegrasi ke dasbor aparatur terkait.
- **Moderasi Penilaian Publik**: Hak penuh untuk menyetujui, menyembunyikan (*toggle visibility*), atau menghapus ulasan yang mengandung unsur tidak pantas sebelum tayang di beranda.
- **Manajemen Basis Data Lengkap**: Kelola akun warga, kelola akun aparatur dengan pengaturan status aktif/nonaktif, serta pengelolaan anggaran dan jenis surat.

---

## 🔐 Informasi Kredensial Demo

Sistem menggunakan alur gerbang *login* cerdas. Cukup ketikkan NIK, maka sistem akan otomatis memilah rute dasbor yang dituju atau menampilkan form input PIN rahasia.

Gunakan akun terdaftar berikut untuk menguji sistem di lingkungan lokal:

| Peran Dasbor | NIK | PIN / Sandi | Akses Menu |
| :--- | :---: | :---: | :--- |
| **Administrator Utama** | `001` | `123456` | Kontrol penuh atas seluruh modul dan moderasi sistem |
| **Aparatur (Sekretaris Desa)**| `002` | `123456` | Dasbor rekam presensi mandiri dan pantau ulasan warga |
| **Aparatur (Kaur Keuangan)** | `003` | `123456` | Dasbor rekam presensi mandiri dan pantau ulasan warga |
| **Warga Desa (Siti Aminah)** | `3374101234560001` | *(Tanpa PIN)* | Akses pengajuan surat dan kirim ulasan kinerja aparatur |

---

## 📱 Keunggulan UX: Responsivitas Mobile Tanpa Geser

Untuk mengatasi kendala umum pada aplikasi web berbasis tabel yang menyulitkan pengguna ponsel, proyek ini mengimplementasikan inovasi CSS `.table-responsive-stack`:
- **Desktop View**: Ditampilkan dalam bentuk tabel mendatar yang padat, rapi, dan informatif.
- **Mobile View (`< 768px`)**: Seluruh tabel otomatis menyembunyikan *header* atas dan menyusun ulang setiap baris data menjadi **kartu informasi vertikal** dengan pemisah baris halus. Nama kolom disisipkan otomatis sebagai label di sisi kiri, memberikan kenyamanan navigasi tanpa perlu menggeser layar (*horizontal scroll*).

---

## 🚀 Panduan Instalasi Lokal

Ikuti petunjuk di bawah untuk mempersiapkan dan menjalankan aplikasi pada peladen pengembangan Anda:

### 1. Kloning Repositori
```bash
git clone https://github.com/username-anda/management-surat-desa-jatiroyom.git
cd management-surat-desa-jatiroyom
```

### 2. Instalasi Dependensi
Pastikan PHP versi 8.1 atau lebih baru dan Composer telah terpasang.
```bash
composer install
```

### 3. Persiapan Variabel Lingkungan
```bash
cp .env.example .env
php artisan key:generate
```
Sesuaikan parameter `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di dalam berkas `.env` sesuai pengaturan MySQL lokal Anda.

### 4. Migrasi dan Pengisian Seeder Master
Perintah ini akan menyusun seluruh relasi skema basis data dan menanamkan akun demo beserta data awalan sistem:
```bash
php artisan migrate:fresh --seed
```

### 5. Optimalisasi Tampilan dan Cache
Guna memastikan sinkronisasi waktu WIB serta antarmuka tabel bertumpuk termuat sempurna:
```bash
php artisan optimize:clear
php artisan view:clear
```

### 6. Menjalankan Server
```bash
php artisan serve
```
Buka tautan `http://localhost:8000` di peramban favorit Anda.

---

## 🔄 Alur Kerja Sistem (Workflow)

### A. Alur Permohonan & Pengambilan Surat
```
[ Warga: Pilih Surat & Isi Form ] ──► [ Status: Menunggu ]
                                            │
               ┌──────────◄───(Ditolak?)────┴────(Diterima?)───►──────────┐
               ▼                                                          ▼
    [ Status: Ditolak ]                                          [ Status: Diterbitkan ]
    (Disertai alasan)                                            (Sistem buat file PDF)
                                                                          │
                                                                          ▼
                                                                  [ Siap Diambil ]
                                                                  (Klaim di Balai Desa)
```

### B. Alur Presensi & Evaluasi Aparatur
```
[ Aparatur: Snap Foto Pagi/Sore ] ──► [ Sinkron Waktu Internet ] ──► [ Status: Terkonfirmasi ]
                                                                             │
[ Warga: Beri Rating & Ulasan ]   ──► [ Moderasi Admin ]         ──► [ Tampil di Beranda Desa ]
```

---

<br>

<div align="center">

## 📸 GALERI ANTARMUKA & CUPLIKAN LAYAR
Berikut adalah dokumentasi visual dari antarmuka sistem yang dikembangkan.

</div>

<br>

### 🖥️ Cuplikan Antarmuka Halaman Publik
*Antarmuka beranda, transparansi informasi anggaran, dan agenda kegiatan desa yang dapat diakses oleh masyarakat umum.*

#### 1. Beranda Utama (Hero & Navigasi)
![Beranda Utama](public/image/readme/public/beranda.png)

#### 2. Transparansi Anggaran Desa
![Anggaran Desa](public/image/readme/public/anggaran.png)

#### 3. Halaman Informasi Acara & Kegiatan
![Acara Desa](public/image/readme/public/acara.png)

---

<div align="center">
<br>

**Didedikasikan untuk memajukan kualitas transparansi dan tata kelola desa berbasis teknologi digital.**  
© Hak Cipta Sistem Informasi Smart Village Desa Jatiroyom.

</div>
