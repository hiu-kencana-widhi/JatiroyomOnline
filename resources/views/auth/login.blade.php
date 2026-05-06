@extends('layouts.auth')

@section('content')
<form action="{{ route('login.check') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="nik" class="form-label">Masukkan NIK</label>
        <input type="text" class="form-control" id="nik" name="nik" 
               placeholder="NIK / ID Anda" required autofocus maxlength="16"
               inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
        @error('nik')
            <div class="error-msg">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Lanjutkan</button>
</form>
@endsection
