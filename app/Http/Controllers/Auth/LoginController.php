<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function checkNik(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|min:1|max:16',
        ]);

        $user = \App\Models\User::where('nik', $request->nik)->first();

        if (!$user) {
            return back()->withErrors(['nik' => 'NIK tidak ditemukan atau belum terdaftar.']);
        }

        if ($user->role === 'admin') {
            session(['pending_admin_nik' => $request->nik]);
            return redirect()->route('login.pin.form');
        }

        // Login as citizen
        \Illuminate\Support\Facades\Auth::login($user);
        \App\Models\System\LogAktivitas::record('Login', 'Warga login menggunakan NIK');
        return redirect()->route('user.dashboard');
    }

    public function showPinForm()
    {
        if (!session()->has('pending_admin_nik')) {
            return redirect()->route('login');
        }
        return view('auth.pin');
    }

    public function verifyPin(Request $request)
    {
        $request->validate([
            'pin' => 'required|digits:6',
        ]);

        $nik = session('pending_admin_nik');
        $user = \App\Models\User::where('nik', $nik)->where('role', 'admin')->first();

        if (!$user || !\Illuminate\Support\Facades\Hash::check($request->pin, $user->password)) {
            return back()->withErrors(['pin' => 'PIN salah!']);
        }

        session()->forget('pending_admin_nik');
        \Illuminate\Support\Facades\Auth::login($user);
        \App\Models\System\LogAktivitas::record('Login Admin', 'Administrator login');
        
        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        \App\Models\System\LogAktivitas::record('Logout', 'User keluar dari sistem');
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
