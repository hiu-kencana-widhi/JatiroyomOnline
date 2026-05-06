<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\PengajuanSurat::with(['user', 'jenisSurat'])->orderBy('created_at', 'desc');
        
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $pengajuan = $query->paginate(15);
        return view('admin.pengajuan.index', compact('pengajuan'));
    }

    public function show(\App\Models\PengajuanSurat $pengajuan)
    {
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function konfirmasi(\App\Models\PengajuanSurat $pengajuan, \App\Services\GoogleDriveService $driveService)
    {
        try {
            return \Illuminate\Support\Facades\DB::transaction(function () use ($pengajuan, $driveService) {
                // 1. Generate Nomor Surat
                $month = date('m');
                $year = date('Y');
                $kode = $pengajuan->jenisSurat->kode_surat;
                
                // Cari nomor terakhir di bulan/tahun yang sama untuk kode ini
                $lastSurat = \App\Models\PengajuanSurat::where('nomor_surat', 'like', "$kode/%/$month$year")
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
                
                // 2. Render HTML Final
                $template = $pengajuan->jenisSurat->template_html;
                $data = $pengajuan->data_terisi;
                
                foreach ($data as $key => $val) {
                    // Format khusus jika ada (misal tanggal)
                    if (strpos($key, 'tanggal') !== false && !empty($val)) {
                        $val = \Carbon\Carbon::parse($val)->format('d F Y');
                    }
                    $template = str_replace("{{$key}}", $val, $template);
                }
                
                $template = str_replace('{nomor_surat}', $nomorSurat, $template);
                $template = str_replace('{tanggal_surat}', \Carbon\Carbon::now()->format('d F Y'), $template);

                // 3. Generate PDF
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($template)->setPaper('a4');
                $pdfContent = $pdf->output();

                // 4. Upload to Drive (Pastikan file credentials ada di storage/app/google/credentials.json)
                $upload = $driveService->uploadSurat($pdfContent, $pengajuan->user->nik, $nomorSurat);

                // 5. Update Pengajuan
                $pengajuan->update([
                    'nomor_surat' => $nomorSurat,
                    'file_drive_id' => $upload['id'],
                    'file_drive_url' => $upload['url'],
                    'status' => 'dikonfirmasi'
                ]);

                \App\Models\LogAktivitas::record('Konfirmasi Surat', 'Menerbitkan surat nomor: ' . $nomorSurat);

                return redirect()->route('admin.pengajuan.index')->with('success', "Surat berhasil dikonfirmasi. Nomor: $nomorSurat");
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses surat: ' . $e->getMessage());
        }
    }

    public function tolak(\Illuminate\Http\Request $request, \App\Models\PengajuanSurat $pengajuan)
    {
        $request->validate(['catatan_admin' => 'required|string']);
        
        $pengajuan->update([
            'status' => 'ditolak',
            'catatan_admin' => $request->catatan_admin
        ]);

        \App\Models\LogAktivitas::record('Tolak Permohonan', 'Menolak surat untuk NIK: ' . $pengajuan->user->nik);

        return redirect()->route('admin.pengajuan.index')->with('success', 'Permohonan berhasil ditolak.');
    }
}
