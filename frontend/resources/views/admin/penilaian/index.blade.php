@extends('layouts.admin')

@section('content')
<div class="container-fluid px-0">
    <div class="mb-4">
        <h4 class="fw-bold mb-1"><i class="bi bi-star-fill text-warning me-2"></i> Moderasi Ulasan & Penilaian Aparatur</h4>
        <p class="text-muted small mb-0">Saring dan setujui ulasan atau masukan dari masyarakat sebelum dipublikasikan di halaman depan desa.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card bg-white shadow-sm p-4 border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle text-nowrap table-responsive-stack">
                <thead class="table-light text-uppercase fs-7 text-muted">
                    <tr>
                        <th class="py-3 ps-3 rounded-start" style="width: 20%;">Aparatur Tertuju</th>
                        <th class="py-3" style="width: 18%;">Pengirim (Warga)</th>
                        <th class="py-3 text-center" style="width: 12%;">Rating</th>
                        <th class="py-3" style="width: 30%;">Isi Ulasan</th>
                        <th class="py-3 text-center" style="width: 10%;">Status Tayang</th>
                        <th class="py-3 text-center rounded-end" style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penilaian as $item)
                        <tr>
                            <td class="ps-3" data-label="Aparatur Tertuju">
                                <div class="fw-bold text-dark">{{ $item->perangkat?->nama_lengkap ?? 'Aparatur Terhapus' }}</div>
                                <div class="small text-muted">{{ $item->perangkat?->jabatan ?? '-' }}</div>
                            </td>
                            <td data-label="Pengirim (Warga)">
                                <div class="fw-medium text-secondary">{{ $item->warga?->nama_lengkap ?? 'Warga (Anonim)' }}</div>
                                <div class="fs-8 text-muted">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</div>
                            </td>
                            <td class="text-center text-warning text-nowrap" data-label="Rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $item->rating ? '-fill' : '' }}"></i>
                                @endfor
                            </td>
                            <td data-label="Isi Ulasan">
                                <p class="mb-0 small text-dark" style="max-width: 350px; white-space: normal;">{{ $item->ulasan }}</p>
                            </td>
                            <td class="text-center" data-label="Status Tayang">
                                <span class="badge {{ $item->status_tampil ? 'bg-success bg-opacity-10 text-success' : 'bg-secondary bg-opacity-10 text-secondary' }} px-3 py-1 rounded-pill">
                                    <i class="bi bi-{{ $item->status_tampil ? 'eye-fill' : 'eye-slash-fill' }} me-1"></i> {{ $item->status_tampil ? 'Publik' : 'Disembunyikan' }}
                                </span>
                            </td>
                            <td class="text-center text-nowrap" data-label="Aksi">
                                <form action="{{ route('admin.moderasi-penilaian.toggle', $item->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $item->status_tampil ? 'btn-outline-secondary' : 'btn-success' }} rounded-circle p-2 mx-1" title="{{ $item->status_tampil ? 'Sembunyikan dari Publik' : 'Tampilkan ke Publik' }}">
                                        <i class="bi bi-{{ $item->status_tampil ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.moderasi-penilaian.destroy', $item->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle p-2 mx-1" title="Hapus Ulasan">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted small">Belum ada data ulasan dari masyarakat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $penilaian->links() }}
        </div>
    </div>
</div>
@endsection
