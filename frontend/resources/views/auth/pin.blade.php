@extends('layouts.auth')

@section('content')
<div class="text-center mb-4">
    <p class="mb-0 fw-bold text-dark">Halo Admin,</p>
    <small class="text-muted">Silakan masukkan PIN 6 digit untuk login.</small>
</div>
<form action="{{ route('login.pin.verify') }}" method="POST">
    @csrf
    <div class="mb-4 text-start">
        <label for="pin" class="form-label small fw-bold text-secondary text-uppercase tracking-wider">PIN Admin</label>
        <input type="password" class="form-control text-center fw-bold" id="pin" name="pin" placeholder="••••••" required autofocus maxlength="6" 
               inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
               style="letter-spacing: 12px; font-size: 1.5rem;">
        @error('pin')
            <div class="error-msg">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Konfirmasi PIN</button>
    <div class="text-center mt-4">
        <a href="{{ route('login') }}" class="text-muted text-decoration-none small fw-semibold hover-primary">← Kembali ke Halaman Login</a>
    </div>
</form>
@endsection
