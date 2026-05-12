@extends('layouts.admin')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="bi bi-person-vcard-fill text-primary me-2"></i> Kelola Aparatur Desa</h4>
            <p class="text-muted small mb-0">Manajemen akun, jabatan, dan hak akses presensi mandiri perangkat desa.</p>
        </div>
        <button type="button" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-2"></i> Tambah Aparatur
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
            <ul class="mb-0 ps-3 small">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card bg-white shadow-sm p-4 border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle text-nowrap table-responsive-stack">
                <thead class="table-light text-uppercase fs-7 text-muted">
                    <tr>
                        <th class="py-3 ps-3 rounded-start">NIK / Identitas</th>
                        <th class="py-3">Nama Lengkap</th>
                        <th class="py-3">Jabatan</th>
                        <th class="py-3 text-center">Status Akun</th>
                        <th class="py-3 text-center rounded-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($perangkat as $item)
                        <tr>
                            <td class="ps-3 fw-bold text-dark" data-label="NIK"><i class="bi bi-person-badge text-muted me-2"></i>{{ $item->nik }}</td>
                            <td class="fw-medium" data-label="Nama Lengkap">{{ $item->nama_lengkap }}</td>
                            <td data-label="Jabatan"><span class="badge bg-light text-secondary border px-2 py-1">{{ $item->jabatan }}</span></td>
                            <td class="text-center" data-label="Status Akun">
                                <span class="badge {{ $item->status_aktif ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }} px-3 py-1 rounded-pill">
                                    <i class="bi bi-{{ $item->status_aktif ? 'check' : 'x' }}-circle-fill me-1"></i> {{ $item->status_aktif ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-center" data-label="Aksi">
                                <button type="button" class="btn btn-sm btn-light border rounded-circle p-2 mx-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}" title="Edit Aparatur">
                                    <i class="bi bi-pencil-fill text-primary"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-light border rounded-circle p-2 mx-1" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $item->id }}" title="Hapus Aparatur">
                                    <i class="bi bi-trash-fill text-danger"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0 shadow-lg">
                                    <form action="{{ route('admin.kelola-perangkat.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header border-0 pb-0">
                                            <h6 class="modal-title fw-bold">Edit Data Aparatur</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">NIK (Nomor Induk Kependudukan)</label>
                                                <input type="text" class="form-control rounded-3 bg-light" value="{{ $item->nik }}" readonly>
                                                <span class="fs-8 text-muted">NIK bersifat unik dan tidak dapat diubah.</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                                                <input type="text" name="nama_lengkap" class="form-control rounded-3" value="{{ $item->nama_lengkap }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">Jabatan / Posisi</label>
                                                <input type="text" name="jabatan" class="form-control rounded-3" value="{{ $item->jabatan }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">Status Akses Akun</label>
                                                <select name="status_aktif" class="form-select rounded-3">
                                                    <option value="1" {{ $item->status_aktif ? 'selected' : '' }}>Aktif (Diizinkan Presensi)</option>
                                                    <option value="0" {{ !$item->status_aktif ? 'selected' : '' }}>Nonaktifkan Akun</option>
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold text-muted">Reset PIN Rahasia 6-Digit (Opsional)</label>
                                                <input type="password" name="pin" class="form-control rounded-3" placeholder="Biarkan kosong jika tidak ingin mereset PIN" maxlength="6">
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pt-0 pe-4 pb-4">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="modalHapus{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0 shadow-lg text-center">
                                    <div class="modal-body p-4">
                                        <div class="py-3">
                                            <i class="bi bi-exclamation-circle-fill text-danger fs-1"></i>
                                            <h6 class="fw-bold mt-3">Hapus Akun Aparatur?</h6>
                                            <p class="text-muted small mb-4">Seluruh data presensi dan ulasan yang tertaut dengan <b>{{ $item->nama_lengkap }}</b> akan terhapus secara permanen.</p>
                                            <form action="{{ route('admin.kelola-perangkat.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Ya, Hapus Permanen</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted small">Belum ada data aparatur desa terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Aparatur Baru -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form action="{{ route('admin.kelola-perangkat.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold"><i class="bi bi-person-plus-fill text-primary me-2"></i> Pendaftaran Aparatur Baru</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">NIK (Sesuai KTP)</label>
                        <input type="text" name="nik" class="form-control rounded-3" placeholder="Contoh: 33271100..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_lengkap" class="form-control rounded-3" placeholder="Contoh: Ahmad Fauzi, S.Kom." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Jabatan Resmi</label>
                        <input type="text" name="jabatan" class="form-control rounded-3" placeholder="Contoh: Sekretaris Desa, Kepala Dusun, dll" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-muted">PIN Rahasia Awal (6-Digit Angka)</label>
                        <input type="password" name="pin" class="form-control rounded-3" placeholder="123456" minlength="6" maxlength="6" required>
                        <span class="fs-8 text-muted">PIN ini akan digunakan oleh aparatur saat login mandiri.</span>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pe-4 pb-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Daftarkan Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
