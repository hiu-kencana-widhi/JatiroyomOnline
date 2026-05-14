@extends('layouts.auth')

@section('content')
<form action="{{ route('login.check') }}" method="POST">
    @csrf
    <div class="mb-4 text-start">
        <label for="nik" class="form-label small fw-bold text-secondary text-uppercase tracking-wider">Nomor Induk Kependudukan (NIK)</label>
        <input type="text" class="form-control fw-medium" id="nik" name="nik" 
               placeholder="Contoh: 3327xxxxxxxxxxxx" required autofocus maxlength="16"
               inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
        @error('nik')
            <div class="error-msg">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Login</button>
    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="text-muted text-decoration-none small fw-semibold hover-primary">← Kembali ke Halaman Utama</a>
    </div>
</form>
@endsection
