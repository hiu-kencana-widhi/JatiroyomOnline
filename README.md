<div align="center">

# 🏛️ SMART VILLAGE: DESA JATIROYOM
**Sistem Informasi Manajemen Surat & Pelayanan Publik Terpadu**

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)
[![Tailwind / CSS](https://img.shields.io/badge/Styling-Modern_CSS-38B2AC?style=for-the-badge)](/)
[![Status](https://img.shields.io/badge/Status-Production_Ready-success?style=for-the-badge)](#)

*Solusi Digitalisasi Administrasi Desa yang Transparan, Cepat, dan Akuntabel demi Mewujudkan Pelayanan Prima bagi Seluruh Warga.*

</div>

---

## 📖 Tentang Proyek

**Sistem Manajemen Surat Desa Jatiroyom** adalah aplikasi web modern yang dirancang khusus untuk mempermudah, mempercepat, dan mendigitalisasi proses pelayanan administrasi serta pengajuan surat menyurat di tingkat desa. 

Mengusung konsep **Smart Village**, platform ini menjembatani komunikasi dan layanan antara aparatur desa dengan masyarakat melalui antarmuka yang sangat responsif, ramah pengguna (user-friendly), dan mengutamakan estetika visual yang premium.

---

## ✨ Fitur Unggulan

### 🌐 1. Portal Publik & Transparansi
- **Beranda Interaktif**: Menampilkan profil singkat, visual/potret desa, dan navigasi cepat.
- **Publikasi Acara Desa**: Informasi kegiatan dan agenda desa terkini agar warga selalu up-to-date.
- **Transparansi Anggaran**: Modul khusus untuk menampilkan alokasi dana serta laporan anggaran desa yang dapat diunduh langsung oleh publik.

### 👥 2. Layanan Mandiri Warga (User Dashboard)
- **Akses Praktis (Tanpa Kata Sandi Rumit)**: Warga cukup masuk menggunakan **NIK** yang terdaftar di sistem.
- **Pengajuan Surat Mandiri**: Pilihan berbagai jenis surat pengantar/keterangan dengan formulir isian yang dinamis.
- **Pelacakan Status Real-Time**: Warga dapat melihat progres pengajuan secara transparan (Menunggu Konfirmasi, Diterbitkan, Siap Diambil, atau Selesai).
- **Unduh Arsip Digital**: Kemudahan mengunduh salinan surat yang telah disetujui.

### 🛡️ 3. Sistem Tata Kelola Admin (Admin Dashboard)
- **Keamanan Berlapis**: Login khusus admin menggunakan kombinasi **NIK** dan **PIN Rahasia 6-Digit**.
- **Manajemen Alur Kerja Surat**: Verifikasi, penolakan dengan catatan, penerbitan dokumen PDF otomatis, hingga pelabelan status pengambilan.
- **Kelola Master Data**: CRUD lengkap untuk data Warga, Acara Desa, Jenis Surat (dilengkapi fitur *Toggle Status* aktif/nonaktif instan), dan Anggaran.
- **Galeri Potret Desa**: Manajemen aset visual/foto desa yang ditampilkan secara langsung pada halaman publik.

---

## 🔐 Informasi Akses Akun Demo

Untuk keperluan peninjauan atau pengujian lokal, basis data telah dilengkapi dengan data *seeder* default:

| Peran | NIK | PIN / Password | Keterangan |
| :--- | :---: | :---: | :--- |
| **Administrator** | `001` | `123456` | Memiliki akses penuh ke seluruh dasbor tata kelola |
| **Warga (Contoh 1)** | `3374101234560001` | *(Tanpa PIN)* | Cukup masukkan NIK untuk login langsung |
| **Warga (Contoh 2)** | `3374101234560002` | *(Tanpa PIN)* | Atas nama Siti Aminah |

> **💡 Catatan Login:** Sistem menggunakan metode login yang sangat ramah warga. Ketika NIK dimasukkan, sistem otomatis mendeteksi apakah pengguna tersebut adalah **Warga** (langsung masuk dasbor) atau **Admin** (diarahkan ke halaman verifikasi PIN).

---

## 🚀 Panduan Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di mesin lokal Anda:

### 1. Kloning Repositori
```bash
git clone https://github.com/username-anda/management-surat-desa-jatiroyom.git
cd management-surat-desa-jatiroyom
```

### 2. Instalasi Dependensi
Pastikan Anda telah menginstal PHP (minimal v8.1+) dan Composer.
```bash
composer install
```

### 3. Konfigurasi Environment
Salin file `.env.example` menjadi `.env` lalu sesuaikan kredensial koneksi database Anda.
```bash
cp .env.example .env
```
Generate *Application Key*:
```bash
php artisan key:generate
```

### 4. Migrasi & Seeding Basis Data
Jalankan perintah berikut untuk membuat tabel sekaligus mengisi data master awal (akun admin, data warga, dan pengaturan dasar):
```bash
php artisan migrate:fresh --seed
```

### 5. Jalankan Server Lokal
```bash
php artisan serve
```
Aplikasi kini dapat diakses melalui browser pada tautan: `http://localhost:8000`

---

## 🔄 Alur Kerja Pengajuan Surat

```
[ Warga: Pilih Jenis & Isi Form ] 
               │
               ▼
   [ Status: Menunggu Konfirmasi ] ──(Ditolak Admin?)──► [ Selesai: Status Ditolak ]
               │
          (Diverifikasi)
               │
               ▼
     [ Status: Diterbitkan ] ──► (Sistem Generate PDF Dokumen Resmi)
               │
               ▼
    [ Status: Siap Diambil ] ──► (Notifikasi Mandiri di Dasbor Warga)
               │
               ▼
     [ Status Akhir: Selesai ]
```

---
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

**Dibuat dengan ❤️ untuk kemajuan pelayanan publik digital tingkat desa.**  
© Hak Cipta Sistem Manajemen Surat Desa Jatiroyom.

</div>
