<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use App\Models\Master\JenisSurat;

class JenisSuratSeeder extends Seeder
{
    public function run(): void
    {
        $kopSurat = '
        <div style="border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 80px; text-align: center; vertical-align: middle;">
                        <img src="/image/logo-pemalang.png" style="width: 65px; height: auto;">
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        <h4 style="margin: 0; text-transform: uppercase; font-size: 16px;">PEMERINTAH KABUPATEN PEMALANG</h4>
                        <h4 style="margin: 0; text-transform: uppercase; font-size: 16px;">KECAMATAN BODEH</h4>
                        <h3 style="margin: 0; text-transform: uppercase; font-weight: bold; font-size: 20px;">KANTOR KEPALA DESA JATIROYOM</h3>
                        <p style="margin: 0; font-size: 11px;">Alamat: Jl. Raya Jatiroyom No. 01, Kode Pos 52365</p>
                    </td>
                    <td style="width: 80px;"></td>
                </tr>
            </table>
        </div>';

        $tandaTangan = '
        <div style="margin-top: 50px; float: right; width: 250px; text-align: center;">
            <p style="margin-bottom: 80px;">Jatiroyom, {tanggal_surat}<br>Kepala Desa Jatiroyom</p>
            <p><strong>( ..................................... )</strong></p>
        </div>';

        $templates = [
            [
                'kode_surat' => 'SKU',
                'nama_surat' => 'Surat Keterangan Usaha',
                'deskripsi' => 'Surat untuk menerangkan kepemilikan usaha bagi warga.',
                'field_diperlukan' => ['nama_lengkap', 'nik', 'alamat', 'pekerjaan'],
                'template_html' => $kopSurat . '<div style="text-align: center; margin-bottom: 20px;"><h4 style="margin: 0; text-decoration: underline; font-size: 18px;">SURAT KETERANGAN USAHA</h4><p style="margin: 0;">Nomor: {nomor_surat}</p></div><p>Kepala Desa Jatiroyom menerangkan bahwa:</p><table style="width: 100%; margin-left: 30px; margin-bottom: 20px;"><tr><td style="width: 180px;">Nama Lengkap</td><td>: {nama_lengkap}</td></tr><tr><td>NIK</td><td>: {nik}</td></tr><tr><td>Alamat</td><td>: {alamat}</td></tr></table><p>Berdasarkan pengamatan kami, nama tersebut di atas benar memiliki usaha di wilayah Desa Jatiroyom.</p>' . $tandaTangan,
            ],
            [
                'kode_surat' => 'SKTM',
                'nama_surat' => 'Surat Keterangan Tidak Mampu',
                'deskripsi' => 'Surat untuk pengajuan bantuan atau keringanan biaya.',
                'field_diperlukan' => ['nama_lengkap', 'nik', 'no_kk', 'alamat'],
                'template_html' => $kopSurat . '<div style="text-align: center; margin-bottom: 20px;"><h4 style="margin: 0; text-decoration: underline; font-size: 18px;">SURAT KETERANGAN TIDAK MAMPU</h4><p style="margin: 0;">Nomor: {nomor_surat}</p></div><p>Menerangkan bahwa:</p><table style="width: 100%; margin-left: 30px; margin-bottom: 20px;"><tr><td style="width: 180px;">Nama Lengkap</td><td>: {nama_lengkap}</td></tr><tr><td>NIK / KK</td><td>: {nik} / {no_kk}</td></tr><tr><td>Alamat</td><td>: {alamat}</td></tr></table><p>Adalah benar warga Desa Jatiroyom yang tergolong dalam keluarga kurang mampu.</p>' . $tandaTangan,
            ],
            [
                'kode_surat' => 'SKD',
                'nama_surat' => 'Surat Keterangan Domisili',
                'deskripsi' => 'Surat keterangan tempat tinggal warga.',
                'field_diperlukan' => ['nama_lengkap', 'nik', 'alamat', 'rt_rw'],
                'template_html' => $kopSurat . '<div style="text-align: center; margin-bottom: 20px;"><h4 style="margin: 0; text-decoration: underline; font-size: 18px;">SURAT KETERANGAN DOMISILI</h4><p style="margin: 0;">Nomor: {nomor_surat}</p></div><p>Menerangkan bahwa:</p><table style="width: 100%; margin-left: 30px; margin-bottom: 20px;"><tr><td style="width: 180px;">Nama Lengkap</td><td>: {nama_lengkap}</td></tr><tr><td>NIK</td><td>: {nik}</td></tr><tr><td>Domisili</td><td>: {alamat} RT/RW {rt_rw}</td></tr></table><p>Adalah benar saat ini berdomisili di wilayah Desa Jatiroyom.</p>' . $tandaTangan,
            ],
            [
                'kode_surat' => 'SKK',
                'nama_surat' => 'Surat Keterangan Kematian',
                'deskripsi' => 'Surat untuk melaporkan kematian warga desa.',
                'field_diperlukan' => ['nama_lengkap', 'nik', 'alamat'],
                'template_html' => $kopSurat . '<div style="text-align: center; margin-bottom: 20px;"><h4 style="margin: 0; text-decoration: underline; font-size: 18px;">SURAT KETERANGAN KEMATIAN</h4><p style="margin: 0;">Nomor: {nomor_surat}</p></div><p>Kepala Desa Jatiroyom menerangkan bahwa:</p><table style="width: 100%; margin-left: 30px; margin-bottom: 20px;"><tr><td style="width: 180px;">Nama Almarhum</td><td>: {nama_lengkap}</td></tr><tr><td>NIK</td><td>: {nik}</td></tr><tr><td>Alamat</td><td>: {alamat}</td></tr></table><p>Telah meninggal dunia di wilayah Desa Jatiroyom.</p>' . $tandaTangan,
            ],
            [
                'kode_surat' => 'SKBN',
                'nama_surat' => 'Surat Keterangan Beda Nama',
                'deskripsi' => 'Surat untuk menjelaskan perbedaan penulisan nama.',
                'field_diperlukan' => ['nama_lengkap', 'nik', 'alamat'],
                'template_html' => $kopSurat . '<div style="text-align: center; margin-bottom: 20px;"><h4 style="margin: 0; text-decoration: underline; font-size: 18px;">SURAT KETERANGAN BEDA NAMA</h4><p style="margin: 0;">Nomor: {nomor_surat}</p></div><p>Menerangkan bahwa nama di KTP dan KK adalah orang yang sama:</p><table style="width: 100%; margin-left: 30px; margin-bottom: 20px;"><tr><td style="width: 180px;">Nama</td><td>: {nama_lengkap}</td></tr><tr><td>NIK</td><td>: {nik}</td></tr></table>' . $tandaTangan,
            ],
            [
                'kode_surat' => 'SKP',
                'nama_surat' => 'Surat Keterangan Penghasilan',
                'deskripsi' => 'Surat untuk menerangkan penghasilan bulanan warga.',
                'field_diperlukan' => ['nama_lengkap', 'nik', 'pekerjaan', 'alamat'],
                'template_html' => $kopSurat . '<div style="text-align: center; margin-bottom: 20px;"><h4 style="margin: 0; text-decoration: underline; font-size: 18px;">SURAT KETERANGAN PENGHASILAN</h4><p style="margin: 0;">Nomor: {nomor_surat}</p></div><p>Menerangkan bahwa:</p><table style="width: 100%; margin-left: 30px; margin-bottom: 20px;"><tr><td style="width: 180px;">Nama</td><td>: {nama_lengkap}</td></tr><tr><td>Pekerjaan</td><td>: {pekerjaan}</td></tr></table><p>Memiliki penghasilan rata-rata yang cukup untuk kebutuhan sehari-hari.</p>' . $tandaTangan,
            ],
            [
                'kode_surat' => 'SIK',
                'nama_surat' => 'Surat Pengantar Izin Keramaian',
                'deskripsi' => 'Surat pengantar untuk mengadakan acara.',
                'field_diperlukan' => ['nama_lengkap', 'nik', 'alamat'],
                'template_html' => $kopSurat . '<div style="text-align: center; margin-bottom: 20px;"><h4 style="margin: 0; text-decoration: underline; font-size: 18px;">PENGANTAR IZIN KERAMAIAN</h4><p style="margin: 0;">Nomor: {nomor_surat}</p></div><p>Memberikan pengantar izin kepada {nama_lengkap} untuk mengadakan acara di wilayah Desa Jatiroyom.</p>' . $tandaTangan,
            ],
            [
                'kode_surat' => 'SPP',
                'nama_surat' => 'Surat Pengantar Pindah',
                'deskripsi' => 'Surat pengantar bagi warga yang akan pindah domisili.',
                'field_diperlukan' => ['nama_lengkap', 'nik', 'alamat', 'rt_rw'],
                'template_html' => $kopSurat . '<div style="text-align: center; margin-bottom: 20px;"><h4 style="margin: 0; text-decoration: underline; font-size: 18px;">SURAT PENGANTAR PINDAH</h4><p style="margin: 0;">Nomor: {nomor_surat}</p></div><p>Memberikan pengantar pindah kepada {nama_lengkap} (NIK: {nik}) dari alamat {alamat}.</p>' . $tandaTangan,
            ],
        ];

        foreach ($templates as $t) {
            $html = '<div style="font-family: \'Times New Roman\', Times, serif; line-height: 1.5; color: #000; font-size: 14px;">' . $t['template_html'] . '</div>';
            JenisSurat::updateOrCreate(['kode_surat' => $t['kode_surat']], [
                'nama_surat' => $t['nama_surat'],
                'deskripsi' => $t['deskripsi'],
                'field_diperlukan' => $t['field_diperlukan'],
                'template_html' => $html,
                'is_aktif' => true,
            ]);
        }
    }
}
