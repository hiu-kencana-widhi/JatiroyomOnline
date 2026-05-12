@extends('layouts.user')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-dark mb-1">Toko & Usaha Saya (UMKM Desa)</h3>
    <p class="text-muted mb-0">Daftarkan produk unggulan, kerajinan, atau kuliner Anda untuk dipromosikan ke seluruh penjuru daerah melalui etalase digital resmi desa.</p>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row g-4">
    <!-- Kolom Form Pendaftaran Produk -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100" style="position: relative; z-index: 10;">
            <div class="card-header bg-primary text-white py-3 rounded-top-4">
                <h6 class="mb-0 fw-bold"><i class="bi bi-plus-circle-fill me-2"></i> Daftarkan Produk Baru</h6>
            </div>
            <form action="{{ route('user.umkm.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small text-uppercase">Nama Usaha / Toko</label>
                        <input type="text" name="nama_usaha" class="form-control border-2" placeholder="Contoh: Keripik Bu Ani / Bengkel Las" value="{{ old('nama_usaha') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small text-uppercase">Nama Spesifik Produk</label>
                        <input type="text" name="nama_produk" class="form-control border-2" placeholder="Contoh: Keripik Pisang Aneka Rasa" value="{{ old('nama_produk') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small text-uppercase">Kategori Usaha</label>
                        <select name="kategori" class="form-select border-2" required>
                            <option value="Kuliner" {{ old('kategori') == 'Kuliner' ? 'selected' : '' }}>Kuliner & Makanan</option>
                            <option value="Kerajinan" {{ old('kategori') == 'Kerajinan' ? 'selected' : '' }}>Kerajinan Tangan</option>
                            <option value="Hasil Tani" {{ old('kategori') == 'Hasil Tani' ? 'selected' : '' }}>Hasil Pertanian / Ternak</option>
                            <option value="Jasa" {{ old('kategori') == 'Jasa' ? 'selected' : '' }}>Jasa & Layanan</option>
                            <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-7">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control border-2" placeholder="15000" min="0" value="{{ old('harga') }}" required>
                        </div>
                        <div class="col-5">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Satuan</label>
                            <input type="text" name="satuan" class="form-control border-2" placeholder="Pcs / Bungkus" value="{{ old('satuan', 'Pcs') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small text-uppercase">Nomor WhatsApp Aktif</label>
                        <div class="input-group">
                            <span class="input-group-text border-2 bg-light fw-bold">+62</span>
                            <input type="text" name="nomor_whatsapp" class="form-control border-2" placeholder="8123456789" value="{{ old('nomor_whatsapp') }}" required>
                        </div>
                        <small class="text-muted" style="font-size: 0.7rem;">Pembeli akan langsung diarahkan ke nomor obrolan ini.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small text-uppercase">Foto Produk Unggulan</label>
                        <input type="file" name="foto_produk" class="form-control border-2" accept=".jpg,.jpeg,.png" required>
                        <small class="text-muted" style="font-size: 0.7rem;">Format JPG/PNG maksimal 5MB. Pastikan foto terang & menarik.</small>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold text-secondary small text-uppercase">Deskripsi & Keunggulan</label>
                        <textarea name="deskripsi" class="form-control border-2" rows="3" placeholder="Tuliskan rasa, komposisi, atau lokasi pengambilan barang jika ingin COD..." required>{{ old('deskripsi') }}</textarea>
                    </div>
                </div>
                <div class="card-footer bg-light border-0 py-3 text-end rounded-bottom-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm w-100">
                        <i class="bi bi-cloud-arrow-up-fill me-2"></i> Kirim untuk Peninjauan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Kolom Tabel Daftar Produk Milik Warga -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-shop-window text-primary me-2"></i> Daftar Etalase Produk Anda</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-responsive-stack">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th class="ps-4 py-3 small text-uppercase">Produk & Usaha</th>
                                <th class="py-3 small text-uppercase">Harga / Satuan</th>
                                <th class="py-3 small text-uppercase">Status Tayang</th>
                                <th class="text-end pe-4 py-3 small text-uppercase">Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($umkm as $item)
                            <tr>
                                <td class="ps-4" data-label="Produk & Usaha">
                                    <!-- SELURUH KONTEN DI DALAM TD DIBUNGKUS DIV TUNGGAL AGAR AMAN DI MOBILE STACK -->
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset('storage/' . $item->foto_produk) }}" class="rounded-3 object-fit-cover border shadow-sm flex-shrink-0" width="60" height="60" alt="Foto">
                                        <div>
                                            <div class="fw-bold text-dark">{{ $item->nama_produk }}</div>
                                            <small class="text-muted d-block">{{ $item->nama_usaha }}</small>
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1 mt-1 border border-primary border-opacity-20" style="font-size: 0.65rem;">
                                                {{ $item->kategori }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Harga Jual">
                                    <div>
                                        <span class="fw-bold text-success">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                        <small class="text-muted">/ {{ $item->satuan }}</small>
                                    </div>
                                </td>
                                <td data-label="Status Peninjauan">
                                    <div>
                                        @if($item->status_verifikasi === 'Disetujui')
                                            <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm">
                                                <i class="bi bi-check-circle-fill me-1"></i> Disetujui (Tayang)
                                            </span>
                                        @elseif($item->status_verifikasi === 'Menunggu')
                                            <span class="badge bg-warning rounded-pill px-3 py-2 text-dark shadow-sm">
                                                <i class="bi bi-hourglass-split me-1"></i> Menunggu Verifikasi
                                            </span>
                                        @else
                                            <span class="badge bg-danger rounded-pill px-3 py-2 shadow-sm" data-bs-toggle="tooltip" title="Produk tidak memenuhi syarat penayangan">
                                                <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-end pe-4" data-label="Aksi">
                                    <div class="d-flex justify-content-end gap-1" style="position: relative; z-index: 10;">
                                        <button type="button" class="btn btn-sm btn-light border rounded-pill px-2 py-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                            <i class="bi bi-pencil text-primary"></i>
                                        </button>
                                        <form action="{{ route('user.umkm.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus permanen produk ini dari etalase Anda?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border rounded-pill px-2 py-1">
                                                <i class="bi bi-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-5369.jpg" width="160" class="mb-3 opacity-50" loading="lazy">
                                    <p class="text-muted mb-0">Belum ada produk usaha yang didaftarkan pada etalase Anda.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($umkm->hasPages())
            <div class="card-footer bg-white py-3 border-0">
                {{ $umkm->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modals Diletakkan di Luar Struktur Tabel agar Aman pada Tampilan Mobile -->
@foreach($umkm as $item)
    <div class="modal fade text-start" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header bg-primary text-white p-3 rounded-top-4">
                    <h6 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i> Perbarui Rincian Produk</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.umkm.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Nama Usaha / Toko</label>
                            <input type="text" name="nama_usaha" class="form-control border-2" value="{{ $item->nama_usaha }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Nama Spesifik Produk</label>
                            <input type="text" name="nama_produk" class="form-control border-2" value="{{ $item->nama_produk }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Kategori Usaha</label>
                            <select name="kategori" class="form-select border-2" required>
                                <option value="Kuliner" {{ $item->kategori == 'Kuliner' ? 'selected' : '' }}>Kuliner & Makanan</option>
                                <option value="Kerajinan" {{ $item->kategori == 'Kerajinan' ? 'selected' : '' }}>Kerajinan Tangan</option>
                                <option value="Hasil Tani" {{ $item->kategori == 'Hasil Tani' ? 'selected' : '' }}>Hasil Pertanian / Ternak</option>
                                <option value="Jasa" {{ $item->kategori == 'Jasa' ? 'selected' : '' }}>Jasa & Layanan</option>
                                <option value="Lainnya" {{ $item->kategori == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-7">
                                <label class="form-label fw-bold text-secondary small">Harga (Rp)</label>
                                <input type="number" name="harga" class="form-control border-2" min="0" value="{{ $item->harga }}" required>
                            </div>
                            <div class="col-5">
                                <label class="form-label fw-bold text-secondary small">Satuan</label>
                                <input type="text" name="satuan" class="form-control border-2" value="{{ $item->satuan }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Nomor WhatsApp Aktif</label>
                            <input type="text" name="nomor_whatsapp" class="form-control border-2" value="{{ $item->nomor_whatsapp }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Ganti Foto Produk (Opsional)</label>
                            <input type="file" name="foto_produk" class="form-control border-2" accept=".jpg,.jpeg,.png">
                            <small class="text-muted d-block mt-1">Biarkan kosong jika tidak ingin mengganti foto saat ini.</small>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold text-secondary small">Deskripsi & Keunggulan</label>
                            <textarea name="deskripsi" class="form-control border-2" rows="3" required>{{ $item->deskripsi }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0 rounded-bottom-4">
                        <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection
