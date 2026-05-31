@extends('layouts.user')

@section('styles')
<style>
    /* Strict A4 Document Styling */
    .document-preview-card {
        background: #f1f5f9;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: inset 0 0 100px rgba(0,0,0,0.05);
    }
    
    .preview-window {
        padding: 40px 20px;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        overflow: hidden; /* Prevent window from scrolling, we'll use scale to fit */
        min-height: 400px;
        background: #94a3b8; /* Professional dark gray desk background */
    }

    #preview-container {
        background: white;
        width: 210mm !important;
        height: 297mm !important;
        padding: 25mm 20mm !important; /* Standard official margins */
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        transform-origin: top center;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: none;
        flex-shrink: 0;
        display: block;
        box-sizing: border-box;
    }

    @media (max-width: 991.98px) {
        .preview-window {
            padding: 20px 10px;
        }
    }
</style>
@endsection

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.surat.pilih') }}" class="text-decoration-none">Pilih Surat</a></li>
            <li class="breadcrumb-item active">{{ $jenisSurat->nama_surat }}</li>
        </ol>
    </nav>
    <h3 class="fw-bold text-dark">Formulir Pengajuan Surat</h3>
    <p class="text-muted">Lengkapi data di bawah ini. Perubahan akan langsung terlihat pada pratinjau di sebelah kanan/bawah.</p>
</div>

<div class="d-flex flex-column gap-4">
    <!-- Perfect Live Preview Section (TOP) -->
    <div class="order-1">
        <div class="document-preview-card">
            <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i> Pratinjau Dokumen Real-time</h6>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-light rounded-pill px-3" id="zoomOut"><i class="bi bi-zoom-out"></i></button>
                    <button class="btn btn-sm btn-outline-light rounded-pill px-3" id="zoomIn"><i class="bi bi-zoom-in"></i></button>
                </div>
            </div>
            <div class="preview-window bg-secondary bg-opacity-25" id="previewWindow" style="height: 500px;">
                <div id="preview-container">
                    <!-- Template content will be injected here -->
                    {!! $jenisSurat->template_html !!}
                </div>
            </div>
            <div class="card-footer bg-white border-top py-2 text-center">
                <small class="text-muted"><i class="bi bi-info-circle me-1"></i> Gunakan tombol zoom jika tampilan terlalu kecil di layar Anda.</small>
            </div>
        </div>
    </div>

    <!-- Form Section (BOTTOM) -->
    <div class="order-2">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-primary text-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> Lengkapi Data Surat</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('user.surat.kirim') }}" method="POST" id="suratForm">
                    @csrf
                    <input type="hidden" name="jenis_surat_id" value="{{ $jenisSurat->id }}">
                    
                    <div class="row g-4">
                        @foreach($jenisSurat->field_diperlukan as $field)
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 0.5px;">{{ str_replace('_', ' ', $field) }}</label>
                            @php
                                $val = $user->$field ?? '';
                                if($field == 'tanggal_lahir' && $val) $val = \Carbon\Carbon::parse($val)->format('Y-m-d');
                            @endphp

                            @if($field == 'alamat')
                                <textarea name="data[{{ $field }}]" class="form-control field-input border-2" data-field="{{ $field }}" rows="2" placeholder="Masukkan alamat..." required>{{ old('data.'.$field, $val) }}</textarea>
                            @elseif($field == 'tanggal_lahir')
                                <input type="date" name="data[{{ $field }}]" class="form-control field-input border-2" data-field="{{ $field }}" value="{{ old('data.'.$field, $val) }}" required>
                            @elseif($field == 'jenis_kelamin')
                                <select name="data[{{ $field }}]" class="form-select field-input border-2" data-field="{{ $field }}" required>
                                    <option value="Laki-laki" {{ (old('data.'.$field, $val) == 'L' || old('data.'.$field, $val) == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ (old('data.'.$field, $val) == 'P' || old('data.'.$field, $val) == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            @else
                                <input type="text" name="data[{{ $field }}]" class="form-control field-input border-2" data-field="{{ $field }}" value="{{ old('data.'.$field, $val) }}" placeholder="Isi {{ str_replace('_', ' ', $field) }}..." required>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-5 border-top pt-4">
                        <div class="row g-3 justify-content-center">
                            <div class="col-md-5">
                                <button type="submit" name="action" value="draft" class="btn btn-outline-secondary btn-lg w-100 py-3 rounded-pill fw-bold shadow-sm">
                                    <i class="bi bi-journal-bookmark me-2"></i> Simpan Draf
                                </button>
                            </div>
                            <div class="col-md-7">
                                <button type="submit" name="action" value="kirim" class="btn btn-primary btn-lg w-100 py-3 rounded-pill fw-bold shadow-lg">
                                    <i class="bi bi-send-check-fill me-2"></i> Kirim Permohonan Sekarang
                                </button>
                            </div>
                        </div>
                        <p class="text-muted small mt-4 mb-0 text-center">Pastikan data di atas sudah benar sesuai pratinjau dokumen sebelum dikirim.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Raw Template -->
<script type="text/template" id="surat-template">
    {!! $jenisSurat->template_html !!}
</script>
@endsection

@section('scripts')
<script>
    let currentScale = 0.5;
    const previewContainer = document.getElementById('preview-container');
    const previewWindow = document.getElementById('previewWindow');

    function adjustScale() {
        const windowWidth = previewWindow.offsetWidth;
        const targetWidth = 210 * 3.7795; // 210mm in pixels
        
        // Calculate scale to fit width with some padding
        let scale = (windowWidth - 60) / targetWidth;
        
        // On desktop, we don't want it to be TOO small if it's already full width
        if (window.innerWidth >= 992) {
            if (scale > 0.8) scale = 0.8; // Max desktop scale for better look
        }
        
        currentScale = scale;
        applyScale();
    }

    function applyScale() {
        if (currentScale < 0.2) currentScale = 0.2;
        if (currentScale > 1.5) currentScale = 1.5;
        
        previewContainer.style.transform = `scale(${currentScale})`;
        
        // Calculate the actual visual height of the scaled A4 (297mm)
        const baseHeightInPx = 297 * 3.7795;
        const scaledHeight = baseHeightInPx * currentScale;
        
        // Set the window height to match the document height + padding
        previewWindow.style.height = (scaledHeight + 80) + 'px';
    }

    function updatePreview() {
        let template = document.getElementById('surat-template').innerHTML;
        
        document.querySelectorAll('.field-input').forEach(input => {
            const fieldName = input.getAttribute('data-field');
            let value = input.value;
            
            // Format empty values
            if (!value) {
                value = `<span style="color: #cbd5e1; border-bottom: 1px dashed #cbd5e1;">[Isi ${fieldName.replace('_', ' ')}]</span>`;
            } else {
                // Format specific types
                if (fieldName === 'tanggal_lahir') {
                    const d = new Date(value);
                    value = d.toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'});
                }
                if (fieldName === 'jenis_kelamin') {
                    value = (value === 'L' || value === 'Laki-laki') ? 'Laki-laki' : 'Perempuan';
                }
            }

            const regex = new RegExp(`{${fieldName}}`, 'g');
            template = template.replace(regex, value);
        });

        // System placeholders
        template = template.replace(/{nomor_surat}/g, '<span style="color: #94a3b8; font-style: italic;">[Nomor Akan Terbit Otomatis]</span>');
        template = template.replace(/{tanggal_surat}/g, new Date().toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}));

        previewContainer.innerHTML = template;
    }

    // Zoom Controls
    document.getElementById('zoomIn').addEventListener('click', () => { currentScale += 0.05; applyScale(); });
    document.getElementById('zoomOut').addEventListener('click', () => { currentScale -= 0.05; applyScale(); });

    // Events
    document.querySelectorAll('.field-input').forEach(input => {
        input.addEventListener('input', updatePreview);
        input.addEventListener('change', updatePreview);
    });

    window.addEventListener('resize', adjustScale);
    
    // Initial Load
    document.addEventListener('DOMContentLoaded', () => {
        updatePreview();
        setTimeout(adjustScale, 100);
    });
</script>
@endsection
