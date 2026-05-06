@extends('layouts.auth')

@section('content')
<div class="text-center mb-4">
    <p class="mb-0">Halo Admin,</p>
    <small class="text-white-50">Silakan masukkan PIN 6 digit untuk login.</small>
</div>
<form action="{{ route('login.pin.verify') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="pin" class="form-label">PIN Admin</label>
        <input type="password" class="form-control text-center" id="pin" name="pin" placeholder="••••••" required autofocus maxlength="6" style="letter-spacing: 5px; font-size: 1.5rem;">
        @error('pin')
            <div class="error-msg">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Konfirmasi PIN</button>
    <div class="text-center mt-3">
        <a href="{{ route('login') }}" class="text-white-50 text-decoration-none small">← Kembali</a>
    </div>
</form>
@endsection
