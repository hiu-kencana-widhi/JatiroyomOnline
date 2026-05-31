<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\Surat\PengajuanSurat::with(['user', 'jenisSurat'])->orderBy('created_at', 'desc');
        
        $status = $request->status ?? 'menunggu';
        $query->where('status', $status);

        $pengajuan = $query->paginate(15);
        return view('admin.pengajuan.index', compact('pengajuan'));
    }

    public function show(\App\Models\Surat\PengajuanSurat $pengajuan)
    {
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function konfirmasi(\App\Models\Surat\PengajuanSurat $pengajuan)
    {
        $pengajuan->update(['status' => 'disetujui']);
        
        \App\Models\System\LogAktivitas::record('Konfirmasi Permohonan', 'Menyetujui permohonan surat NIK: ' . $pengajuan->user->nik);

        return redirect()->route('admin.pengajuan.index', ['status' => 'disetujui'])->with('success', 'Permohonan berhasil dikonfirmasi.');
    }

    public function terbitkan(\App\Models\Surat\PengajuanSurat $pengajuan)
    {
        try {
            return \Illuminate\Support\Facades\DB::transaction(function () use ($pengajuan) {
                // 1. Generate Nomor Surat
                $month = date('m');
                $year = date('Y');
                $kode = $pengajuan->jenisSurat->kode_surat;
                
                $lastSurat = \App\Models\Surat\PengajuanSurat::where('nomor_surat', 'like', "$kode/%/$month$year")
                    ->lockForUpdate()
                    ->orderBy('nomor_surat', 'desc')
                    ->first();
                    
                $nextNumber = 1;
                if ($lastSurat) {
                    $parts = explode('/', $lastSurat->nomor_surat);
                    if (count($parts) >= 2) {
                        $nextNumber = (int)$parts[1] + 1;
                    }
                }
                
                $nomorSurat = sprintf("%s/%03d/%s%s", $kode, $nextNumber, $month, $year);
                
                // 2. Update Pengajuan
                $pengajuan->update([
                    'nomor_surat' => $nomorSurat,
                ]);

                \App\Models\System\LogAktivitas::record('Terbitkan Surat', 'Menerbitkan nomor surat: ' . $nomorSurat);

                return back()->with('success', "Nomor surat berhasil diterbitkan: $nomorSurat");
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menerbitkan surat: ' . $e->getMessage());
        }
    }

    public function siapDiambil(\App\Models\Surat\PengajuanSurat $pengajuan)
    {
        try {
            if (!$pengajuan->nomor_surat) {
                return back()->with('error', 'Gagal: Nomor surat belum diterbitkan.');
            }

            // 1. Generate PDF Content
            $pdfContent = $this->generatePdfContent($pengajuan);
            $fileName = 'surat-' . str_replace(['/', '\\'], '-', $pengajuan->nomor_surat) . '.pdf';
            $localPath = 'surat_terbit/' . $fileName;

            // 2. Simpan secara Lokal
            \Illuminate\Support\Facades\Storage::disk('public')->put($localPath, $pdfContent);
            $fileUrl = asset('storage/' . $localPath);

            // 3. Update status (Tanpa Google Drive)
            $pengajuan->update([
                'file_drive_url' => $fileUrl, // Kita tetap gunakan field ini untuk menyimpan URL file (lokal)
                'status' => 'siap_diambil'
            ]);
            
            \App\Models\System\LogAktivitas::record('Update Status', 'Surat nomor ' . $pengajuan->nomor_surat . ' siap diambil (Disimpan lokal)');

            return redirect()->route('admin.pengajuan.show', $pengajuan->id)->with('success', 'Status diperbarui: Siap Diambil. File telah disimpan di sistem.');
        } catch (\Exception $e) {
            \Log::error('Siap Diambil Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses surat: ' . $e->getMessage());
        }
    }

    public function tandaiSelesai(\App\Models\Surat\PengajuanSurat $pengajuan)
    {
        $pengajuan->update(['status' => 'selesai']);
        
        \App\Models\System\LogAktivitas::record('Update Status', 'Surat nomor ' . $pengajuan->nomor_surat . ' telah diambil oleh warga');

        return redirect()->route('admin.pengajuan.index', ['status' => 'selesai'])->with('success', 'Permohonan selesai: Surat telah diambil oleh warga.');
    }

    private function generatePdfContent($pengajuan)
    {
        $template = $pengajuan->jenisSurat->template_html;
        $data = $pengajuan->data_terisi;
        
        foreach ($data as $key => $val) {
            if (strpos($key, 'tanggal') !== false && !empty($val)) {
                $val = \Carbon\Carbon::parse($val)->format('d F Y');
            }
            $template = str_replace("{{$key}}", $val, $template);
        }
        
        $template = str_replace('{nomor_surat}', $pengajuan->nomor_surat, $template);
        $template = str_replace('{tanggal_surat}', $pengajuan->updated_at->format('d F Y'), $template);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($template)->setPaper('a4');
        return $pdf->output();
    }

    public function downloadPdf(\App\Models\Surat\PengajuanSurat $pengajuan)
    {
        if (!$pengajuan->nomor_surat) {
            return back()->with('error', 'Nomor surat belum di-generate.');
        }

        $pdfContent = $this->generatePdfContent($pengajuan);
        $fileName = str_replace(['/', '\\'], '-', $pengajuan->nomor_surat) . '.pdf';

        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    public function tolak(\Illuminate\Http\Request $request, \App\Models\Surat\PengajuanSurat $pengajuan)
    {
        $request->validate(['catatan_admin' => 'required|string']);
        
        $pengajuan->update([
            'status' => 'ditolak',
            'catatan_admin' => $request->catatan_admin
        ]);

        \App\Models\System\LogAktivitas::record('Tolak Permohonan', 'Menolak surat untuk NIK: ' . $pengajuan->user->nik);

        return redirect()->route('admin.pengajuan.index')->with('success', 'Permohonan berhasil ditolak.');
    }
}
