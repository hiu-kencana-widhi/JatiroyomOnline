@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark">Data Warga</h3>
        <p class="text-muted mb-0">Total {{ $warga->total() }} warga terdaftar dalam sistem.</p>
    </div>
    <a href="{{ route('admin.warga.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow">
        <i class="bi bi-person-plus-fill me-2"></i> Tambah Warga
    </a>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm rounded-4 mb-4" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 small text-uppercase text-secondary">Warga</th>
                        <th class="py-3 small text-uppercase text-secondary">Identitas</th>
                        <th class="py-3 small text-uppercase text-secondary">Alamat</th>
                        <th class="py-3 small text-uppercase text-secondary">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($warga as $item)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: 600;">
                                    {{ substr($item->nama_lengkap, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $item->nama_lengkap }}</div>
                                    <small class="text-muted">{{ $item->pekerjaan ?? '-' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="small fw-bold text-dark">NIK: {{ $item->nik }}</div>
                            <div class="small text-muted">KK: {{ $item->no_kk ?? '-' }}</div>
                        </td>
                        <td>
                            <div class="small text-dark">{{ Str::limit($item->alamat, 40) }}</div>
                            <div class="small text-muted">RT/RW {{ $item->rt_rw ?? '-' }}</div>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm rounded-circle shadow-sm" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2 rounded-3">
                                    <li><a class="dropdown-item rounded-2" href="{{ route('admin.warga.edit', $item) }}"><i class="bi bi-pencil me-2 text-primary"></i> Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('admin.warga.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus warga ini?')">
                                            @csrf @method('DELETE')
                                            <button class="dropdown-item rounded-2 text-danger"><i class="bi bi-trash me-2"></i> Hapus</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">Data warga tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3">
        {{ $warga->links() }}
    </div>
</div>
@endsection
