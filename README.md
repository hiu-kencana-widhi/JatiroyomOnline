<img src="https://capsule-render.vercel.app/api?type=waving&color=0D6EFD&height=150&section=header" width="100%"/>

<div align="center">
 
# 🏛️ JATIROYOM ONLINE
**Sistem Informasi Manajemen Surat, Laporan Warga, Presensi Aparatur, Pelayanan Publik & Pasar Digital Terpadu**

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)
[![Styling](https://img.shields.io/badge/Styling-Premium_CSS_Stack-38B2AC?style=for-the-badge)](/)
[![Status](https://img.shields.io/badge/Status-Production_Ready-success?style=for-the-badge)](#)

*Portal Administrasi Cerdas Desa Jatiroyom: Melayani Pengajuan Surat Mandiri, Pelaporan Kerusakan Infrastruktur Real-Time via Geolocation & Kamera Gawai, Rekam Jejak Kehadiran Aparatur, Transparansi Akuntabilitas Publik, serta Katalisator Ekonomi melalui Pasar Digital UMKM Terintegrasi WhatsApp.*

</div>

---

## 📖 Tentang Proyek

**JatiroyomOnline** merupakan platform transformasi digital berskala penuh untuk tata kelola administrasi dan pelayanan publik tingkat desa. Mengusung konsep *Smart Village*, sistem ini mendigitalisasi lima pilar utama interaksi antara pemerintah desa dan masyarakat:
1. **Layanan Administrasi Surat Warga** secara mandiri dan cepat, menghilangkan birokrasi antrean fisik yang panjang.
2. **Sistem Pelaporan Insiden Warga (*Citizen Incident Reporting*)** berbasis penjelajah peramban (*browser-native*) yang memanfaatkan sensor GPS gawai dan jepretan langsung kamera depan/belakang untuk melaporkan kerusakan jalan, lingkungan, maupun fasilitas umum.
3. **Integritas Waktu & Presensi Aparatur Desa** menggunakan deteksi foto kamera mandiri (*webcam snapshot*) yang divalidasi mutlak dengan zona waktu peladen riil Indonesia (WIB).
4. **Akuntabilitas & Evaluasi Kinerja** melalui ruang pemberian *rating* bintang serta ulasan kepuasan dari masyarakat yang termoderasi secara transparan.
5. **Pemberdayaan Ekonomi Digital UMKM (*Digital Commerce Gateway*)** yang menyediakan etalase terbuka untuk produk usaha warga dengan antarmuka kelas atas bergaya *Bento Grid* dan otomatisasi pembuatan tautan pemesanan langsung menuju obrolan WhatsApp penjual.

Dikembangkan dengan sentuhan estetika antarmuka premium, sistem menjamin kenyamanan visual yang luar biasa di perangkat desktop maupun gawai seluler terkecil melalui arsitektur **Card Stacked Layout** yang responsif tanpa pengguliran mendatar yang mengganggu.

---

## ✨ Fitur & Modul Utama

### 🌐 1. Portal Publik & Transparansi Informasi
- **Beranda Interaktif**: Etalase visual keindahan profil desa, struktur kepemimpinan aparatur, dan sorotan ulasan pelayanan riil dari masyarakat.
- **Pasar Digital UMKM (*Baru*)**: Katalog produk olahan tani, kuliner khas, dan kerajinan tangan warga yang disajikan dengan tata letak *Bento Grid* modern, lencana status terverifikasi, saringan kategori dinamis, serta generator tautan pesanan instan via WhatsApp tanpa potongan biaya sistem.
- **Siaran Spanduk Darurat**: Pengunjung langsung disambut oleh pita pengumuman global bergaya *Glassmorphism* di bawah menu utama yang menyajikan peringatan mendesak, jadwal pemadaman, atau pembagian bansos secara *real-time*, lengkap dengan tombol pengunduhan surat edaran/dokumen pendukung.
- **Agenda & Acara Desa**: Publikasi acara, pengumuman, dan jadwal kegiatan desa untuk memastikan masyarakat luas terus mendapatkan informasi terkini.
- **Transparansi Anggaran**: Rilis publikasi grafik dan rincian laporan alokasi anggaran belanja desa yang dapat dipantau dan diunduh langsung oleh publik.
- **Peta Lokasi Terintegrasi**: Sematan peta interaktif menuju titik koordinat pusat layanan desa dengan perlindungan privasi berskala tinggi.

### 👥 2. Dasbor Warga (Surat, Laporan Insiden, UMKM & Evaluasi)
- **Akses Instan NIK**: Otentikasi mandiri yang ringkas tanpa perlu mengingat kata sandi rumit, cukup menggunakan Nomor Induk Kependudukan (NIK).
- **Manajemen Toko & Usaha Saya (*Baru*)**: Akses pendaftaran mandiri produk UMKM dengan unggahan foto teroptimasi, normalisasi otomatis nomor kontak berawalan `62`, dan proteksi pengamanan ulang status ke *Menunggu* setiap kali warga memperbarui rincian atau foto produk demi kenyamanan pengawasan.
- **Pengajuan Surat Dinamis**: Memilih ragam surat pengantar, mengisi rincian formulir spesifik, dan melacak tahapan verifikasi secara seketika.
- **Lapor Insiden Lapangan**: Warga dapat mengadukan fasilitas rusak dengan menyalakan **kamera gawai langsung dari peramban** (mendukung penukaran instan lensa depan/belakang), menyedot titik koordinat presisi tinggi tanpa singgahan *cache* via **Geolocation API**, serta mengoreksi patokan lokasi menggunakan pin peta interaktif gratis (Leaflet.js).
- **Pita Peringatan Dasbor**: Memastikan warga yang masuk langsung membaca siaran darurat desa di urutan teratas layar mereka.
- **Unduh Arsip Resmi**: Akses unduhan mandiri dokumen digital (PDF) bertanda tangan elektronik langsung setelah disetujui aparat.
- **Penilaian Kinerja Aparatur**: Memberikan ulasan dan penilaian kepuasan layanan spesifik kepada masing-masing personel aparatur desa.

### 💼 3. Dasbor Perangkat Desa (Presensi & Tindak Lanjut Aduan)
- **Otentikasi Berlapis**: Perlindungan masuk berbasis NIK dan PIN otentikasi rahasia 6-digit.
- **Presensi Pagi & Sore**: Fitur rekam kehadiran harian dengan tangkapan foto langsung dari kamera.
- **Integritas Waktu Server**: Menolak manipulasi jam lokal pada gawai pengguna dengan menyinkronkan cap waktu langsung ke acuan zona peladen (`Asia/Jakarta`).
- **Respon Aduan Warga**: Perangkat lapangan dapat meninjau titik pelaporan kerusakan via pintasan rute **Google Maps** serta menyumbangkan progres investigasi/perbaikan langsung dari ponsel mereka di lokasi fisik, yang akan memicu transisi status otomatis.

### 🛡️ 4. Dasbor Administrator (Pusat Kendali Menyeluruh)
- **Pintu Moderasi UMKM (*Baru*)**: Pusat kurasi produk usaha warga sebelum tayang publik. Dilengkapi dengan pratinjau gambar produk utuh (*full-resolution snapshot*) dalam wadah modal terisolasi, penyaringan berdasarkan status peninjauan, serta tombol satu klik untuk menyetujui, menolak, atau menghapus paksa produk yang menyalahi ketentuan desa.
- **Verifikasi Alur Surat**: Konfirmasi penerbitan, penolakan dengan catatan koreksi, dan pengiriman notifikasi pengambilan dokumen fisik di Balai Desa.
- **Moderasi Spanduk Pengumuman**: Menerbitkan, memperbarui lampiran dokumen, mengatur kedaluwarsa waktu otomatis, atau mematikan tayang siaran spanduk global secara instan melalui dasbor *Card Stacked* responsif.
- **Moderasi Laporan Insiden**: Pusat tinjauan aduan masyarakat yang dilengkapi jendela pratinjau foto bukti beresolusi penuh, filter kategori/status dinamis, serta kendali mutlak untuk mengubah status (*Menunggu* ➔ *Diproses* ➔ *Selesai*) dan memberikan instruksi penanganan.
- **Moderasi Presensi & Penilaian Publik**: Validasi foto bukti presisi, kemampuan menginput izin/sakit secara manual, serta hak tayang ulasan publik.
- **Manajemen Basis Data Terpadu**: Pengelolaan basis data penduduk, hak akses aparatur, pengaturan anggaran, dan penyesuaian jenis surat.

---

## 🔐 Informasi Kredensial Demo

Sistem menerapkan alur gerbang masuk yang efisien. Cukup masukkan NIK terdaftar, maka sistem akan mengarahkan rute dasbor secara otomatis atau meminta verifikasi PIN tambahan.

Gunakan akun terdaftar berikut untuk menguji coba fungsionalitas sistem di lingkungan pengembangan lokal:

| Peran Dasbor | NIK | PIN / Sandi | Akses Menu & Kapabilitas |
| :--- | :---: | :---: | :--- |
| **Administrator Utama** | `001` | `123456` | Kontrol penuh atas seluruh modul, persetujuan surat, moderasi UMKM, dan kendali aduan warga |
| **Aparatur (Sekretaris Desa)**| `002` | `123456` | Dasbor rekam presensi mandiri dan pelaporan kemajuan aduan lapangan |
| **Aparatur (Kaur Keuangan)** | `003` | `123456` | Dasbor rekam presensi mandiri dan pelaporan kemajuan aduan lapangan |
| **Warga Desa (Siti Aminah)** | `3374101234560001` | *(Tanpa PIN)* | Akses permohonan surat, pendaftaran produk UMKM, lapor insiden fisik, dan ulasan aparatur |

---

## 📱 Keunggulan UX: Responsivitas Mobile Tanpa Geser

Untuk menuntaskan kendala umum pada aplikasi web tradisional yang menampilkan tabel kaku hingga terpotong di layar ponsel, JatiroyomOnline mengimplementasikan inovasi CSS `.table-responsive-stack`:
- **Desktop View**: Komponen tabel dirender dalam format baris mendatar yang padat, terstruktur, dan informatif.
- **Mobile View (`< 768px`)**: Seluruh tabel secara mulus menyembunyikan tajuk kolom (*header*) atas dan menyusun ulang setiap baris sel menjadi **kartu susun vertikal independen**. Nama kolom disisipkan secara cerdas sebagai label di sisi kiri, memberikan navigasi sentuh yang alami tanpa mengharuskan pengguna menggeser layar secara horizontal.
- **Isolasi Z-Index**: Penataan tumpukan komponen interaktif (seperti peta dan *dropdown*) telah dikalibrasi ketat agar tidak pernah memblokir penangkap sentuhan pada tombol navigasi utama.

---

## 🚀 Panduan Instalasi Lokal

Ikuti langkah-langkah di bawah untuk memasang dan menjalankan portal JatiroyomOnline pada peladen lokal Anda:

### 1. Kloning Repositori
```bash
git clone https://github.com/hiu-kencana-widhi/JatiroyomOnline.git
cd JatiroyomOnline
```

### 2. Instalasi Dependensi
Pastikan peladen Anda menjalankan PHP versi 8.1 atau yang lebih baru dan Composer telah terpasang.
```bash
composer install
```

### 3. Persiapan Konfigurasi Lingkungan
```bash
cp .env.example .env
php artisan key:generate
```
Buka berkas `.env` dan sesuaikan parameter koneksi basis data (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) dengan kredensial MySQL lokal Anda.

### 4. Migrasi Skema & Penanaman Seeder Master
Perintah di bawah ini akan membangun fisik tabel dari awal dan menanamkan akun demo beserta data referensi awal:
```bash
php artisan migrate:fresh --seed
```

### 5. Optimalisasi Tampilan dan Pembersihan Cache
Guna memastikan sinkronisasi acuan waktu WIB serta penyegaran tembolok tampilan (*view cache*) termuat dengan sempurna:
```bash
php artisan optimize:clear
```

### 6. Menjalankan Peladen Lokal
```bash
php artisan serve
```
Akses portal melalui tautan `http://localhost:8000` di peramban gawai atau komputer meja Anda.

---

## 🔄 Alur Kerja Sistem (System Workflows)

Berikut adalah pemetaan diagram alur kerja terperinci yang mencakup seluruh antarmuka dan modul fungsional di portal **JatiroyomOnline**:

### A. Alur Navigasi & Transparansi Publik (*Public Gateway*)
```
[ Pengunjung Web / Warga Umum ]
               │
               ├─► [ Beranda Portal ] ──────► Akses Profil Desa, Visi-Misi, & Etalase Ulasan Pilihan
               ├─► [ Siaran Darurat ] ──────► Spanduk Melayang Otomatis Tampil jika Ada Info/Pemadaman/Bansos
               ├─► [ Pasar Digital UMKM ] ──► Tinjau Katalog Bento, Saringan Kategori, & Pesan Langsung via WA
               ├─► [ Transparansi Dana ] ───► Unduh & Pantau Alokasi Anggaran Belanja Desa Riil
               └─► [ Agenda Acara Desa ] ───► Tinjau Informasi Kegiatan, Tanggal Pelaksanaan, & Pengumuman
```

### B. Alur Pendaftaran & Transaksi Pasar Digital UMKM (*Digital Commerce Workflow*)
```
[ Warga: Dasbor Toko Saya ] ──► [ Input Usaha, Produk, Harga, Kategori, Foto, & No. WA ]
                                                      │
                                          [ Status Awal: Menunggu ]
                                                      │
                       ┌──────────────◄───(Ditolak?)──┴──(Disetujui?)──►──────────────┐
                       ▼                                                              ▼
             [ Status: Ditolak ]                                           [ Status: Disetujui ]
             (Tidak tampil di etalase)                                     (Otomatis Tayang di Etalase Publik)
                                                                                      │
                                                                                      ▼
                                                                           [ Pembeli Umum / Publik ]
                                                                           (Klik CTA Beli via WhatsApp)
                                                                                      │
                                                                                      ▼
                                                                           [ Tautan Pesanan Instan ]
                                                                           (Langsung membuka chat penjual)
```

### C. Alur Permohonan & Pengambilan Surat Resmi (*Citizen Services*)
```
[ Warga: Otentikasi NIK ] ──► [ Dasbor Warga: Pilih Jenis Surat & Lengkapi Rincian ]
                                                      │
                                          [ Status Awal: Menunggu ]
                                                      │
                       ┌──────────────◄───(Ditolak?)──┴──(Diterima?)───►──────────────┐
                       ▼                                                              ▼
             [ Status: Ditolak ]                                           [ Status: Diterbitkan ]
             (Alasan terlampir di akun)                                    (Sistem menerbitkan file PDF)
                                                                                      │
                                                                                      ▼
                                                                             [ Pengambilan Surat ]
                                                                             (Klaim fisik / Cetak Mandiri)
```

### D. Alur Pelaporan Insiden & Kerusakan Lapangan (*Citizen Incident Reporting*)
```
[ Warga: Aktifkan Kamera Peramban & Sensor GPS ] ──► [ Pengiriman Form Aduan Bukti Fisik ]
                                                                   │
                                                      [ Status Awal: Menunggu ]
                                                                   │
               ┌───────────────────────◄───(Tidak Valid?)──────────┴──────────(Diterima?)───►────────────────────────┐
               ▼                                                                                                     ▼
     [ Status: Ditolak ]                                                                                [ Status: Diproses ]
     (Tanggapan koreksi dari Admin)                                                                     (Tindakan Perbaikan Lapangan)
                                                                                                                     │
                                                                                                     [ Perangkat Memberi Log Progres ]
                                                                                                                     │
                                                                                                                     ▼
                                                                                                          [ Status Akhir: Selesai ]
                                                                                                          (Kerusakan tuntas diatasi)
```

### E. Alur Siaran Spanduk Darurat & Pengumuman (*Broadcast Banner Control*)
```
[ Admin Utama: Terbitkan Spanduk Baru ] ──► [ Lengkapi Judul, Pesan, Tipe Urgensi, & Lampiran PDF ]
                                                                   │
                                                      [ Masa Tayang Dijadwalkan ]
                                                                   │
               ┌───────────────────────────────────────────────────┴───────────────────────────────────────────────────┐
               ▼                                                                                                       ▼
   [ Dirender Seketika Secara Global ]                                                                     [ Kedaluwarsa Otomatis ]
   (Tampil melayang di Beranda Publik & Dasbor Warga)                                                      (Melewati Batas Waktu Akhir)
                                                                                                                       │
                                                                                                                       ▼
                                                                                                           [ Spanduk Turun Layar ]
                                                                                                           (Tersimpan di Riwayat Arsip)
```

### F. Alur Presensi Mandiri Harian Aparatur (*Aparatur Integrity*)
```
[ Aparatur: Input NIK & PIN Rahasia ] ──► [ Rekam Kehadiran: Ambil Foto Pagi/Sore ]
                                                          │
                                         [ Sinkronisasi Waktu Server WIB ]
                                                          │
                                                          ▼
                                            [ Label Otomatis via Sistem ]
                                            (Tepat Waktu / Terlambat / Izin)
                                                          │
                                                          ▼
                                            [ Validasi / Pemantauan Admin ]
```

### G. Alur Pemberian & Moderasi Ulasan Kepuasan (*Public Accountability*)
```
[ Warga: Pilih Nama Aparatur ] ──► [ Input Rating Bintang (1-5) & Teks Ulasan ]
                                                          │
                                          [ Status Awal: Tertunda / Disembunyikan ]
                                                          │
                                                          ▼
                                            [ Dasbor Moderasi Administrator ]
                                                          │
                                  ┌───────────────────────┴───────────────────────┐
                                  ▼                                               ▼
                        [ Ulasan Disetujui ]                             [ Ulasan Ditolak / Dihapus ]
                        (Tampil publik di Beranda)                       (Mengandung bahasa tidak pantas)
```

---

<br>

<div align="center">

## 📸 GALERI ANTARMUKA & CUPLIKAN LAYAR
Berikut adalah dokumentasi visual dari antarmuka portal desa yang telah dikembangkan secara premium dan responsif.

</div>

<br>

### 🖥️ Cuplikan Antarmuka Halaman Publik
*Antarmuka beranda, informasi acara, etalase pasar digital, dan transparansi anggaran desa yang dapat diakses oleh masyarakat umum tanpa batas.*

#### 1. Beranda Utama (Hero & Navigasi Terpadu)
![Beranda Utama](public/image/readme/public/beranda.png)

#### 2. Halaman Informasi Acara & Agenda Kegiatan
![Acara Desa](public/image/readme/public/acara.png)

#### 3. Etalase Pasar Digital & UMKM Desa (*Bento Grid*)
![Pasar UMKM Desa](public/image/readme/public/umkm.png)

#### 4. Transparansi Anggaran & APBDes
![Anggaran Desa](public/image/readme/public/anggaran.png)

---

<div align="center">
<br>

**Didedikasikan untuk memajukan kualitas transparansi, perekonomian mandiri, dan tata kelola desa berbasis teknologi digital.**  
© Hak Cipta Portal Administrasi Cerdas **JatiroyomOnline**.

</div>


<img src="https://capsule-render.vercel.app/api?type=waving&color=0D6EFD&height=200&section=footer" width="100%"/>