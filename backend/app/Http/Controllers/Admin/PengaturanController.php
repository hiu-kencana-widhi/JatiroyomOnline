<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $settings = \App\Models\System\Pengaturan::getAllCached();
        return view('admin.pengaturan.index', compact('settings'));
    }

    public function update(\Illuminate\Http\Request $request)
    {
        $data = $request->except('_token');
        
        foreach ($data as $key => $value) {
            \App\Models\System\Pengaturan::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        \Illuminate\Support\Facades\Cache::forget('village_settings');

        return back()->with('success', 'Pengaturan desa berhasil diperbarui.');
    }
}
