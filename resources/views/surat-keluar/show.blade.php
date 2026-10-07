@extends('layouts.app')

@section('title', 'Alur Surat Keluar - ' . $surat->no_surat)

@section('content')
<!-- HEADER -->
<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
            <a href="{{ route('surat-keluar.index') }}" class="btn btn-light btn-sm border py-1">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="fs-4 fw-bold text-dark m-0 font-monospace">{{ $surat->no_surat }}</h2>
            <button type="button" class="copy-btn" onclick="copyToClipboard('{{ $surat->no_surat }}', this)" title="Salin Nomor Surat">
                <i class="bi bi-clipboard"></i> Salin
            </button>
            <span class="status-pill {{ $surat->status_badge_class }}">
                <span class="status-dot"></span>
                {{ $surat->status }}
            </span>
        </div>
        <p class="text-muted small m-0">Konseptor: <strong>{{ $surat->konseptor->name }}</strong> &bull; Klasifikasi: {{ $surat->klasifikasi_kode }}</p>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('surat-keluar.preview', $surat->id) }}" target="_blank" class="btn btn-kemenhub btn-sm px-3">
            <i class="bi bi-file-earmark-text me-1"></i> Pratinjau Naskah Dinas Resmi
        </a>
    </div>
</div>

<!-- 1. WORKFLOW STEPPER COMPONENT -->
<div class="kemenhub-card p-3 p-md-4 mb-4">
    <div class="small fw-bold text-secondary text-uppercase mb-3">
        <i class="bi bi-diagram-3-fill text-primary me-1"></i> Tahapan Validasi & Penandatanganan Elektronik
    </div>

    @php
        $step = $surat->step_index;
    @endphp

    <div class="workflow-stepper">
        <!-- Step 1 -->
        <div class="step-item {{ $step >= 1 ? ($step > 1 ? 'completed' : 'active') : '' }}">
            <div class="step-circle">{!! $step > 1 ? '<i class="bi bi-check-lg"></i>' : '1' !!}</div>
            <div class="step-title">Draft Konsep</div>
            <div class="step-subtitle">Staf Analis</div>
        </div>

        <!-- Step 2 -->
        <div class="step-item {{ $step >= 3 ? ($step > 3 ? 'completed' : 'active') : '' }}">
            <div class="step-circle">{!! $step > 3 ? '<i class="bi bi-check-lg"></i>' : '2' !!}</div>
            <div class="step-title">Paraf Kabid</div>
            <div class="step-subtitle">Kepala Bidang</div>
        </div>

        <!-- Step 3 -->
        <div class="step-item {{ $step >= 4 ? ($step > 4 ? 'completed' : 'active') : '' }}">
            <div class="step-circle">{!! $step > 4 ? '<i class="bi bi-check-lg"></i>' : '3' !!}</div>
            <div class="step-title">TTE Kapus</div>
            <div class="step-subtitle">Kepala Pusat</div>
        </div>

        <!-- Step 4 -->
        <div class="step-item {{ $step >= 5 ? ($step > 5 ? 'completed' : 'active') : '' }}">
            <div class="step-circle">{!! $step > 5 ? '<i class="bi bi-check-lg"></i>' : '4' !!}</div>
            <div class="step-title">TTE Sah & QR</div>
            <div class="step-subtitle">BSrE Valid</div>
        </div>

        <!-- Step 5 -->
        <div class="step-item {{ $step >= 6 ? 'completed' : '' }}">
            <div class="step-circle">5</div>
            <div class="step-title">Terkirim</div>
            <div class="step-subtitle">Arsip Selesai</div>
        </div>
    </div>
</div>

<!-- 2. MAIN RESPONSIVE CONTENT GRID -->
<div class="row g-4 align-items-start">
    
    <!-- LEFT COLUMN: DETAIL SURAT KELUAR -->
    <div class="col-12 col-lg-7">
        <div class="kemenhub-card p-4">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1">
                    Klasifikasi: {{ $surat->klasifikasi_kode }}
                </span>
                <span class="badge {{ $surat->sifat_surat === 'Sangat Segera' ? 'bg-danger' : ($surat->sifat_surat === 'Segera' ? 'bg-warning text-dark' : 'bg-info text-dark') }}">
                    Sifat: {{ $surat->sifat_surat }}
                </span>
            </div>

            <h3 class="fs-5 fw-bold text-dark mb-3">{{ $surat->perihal }}</h3>

            <div class="row g-3 small mb-4">
                <div class="col-12 col-sm-6">
                    <div class="text-muted">Tujuan Naskah Dinas:</div>
                    <div class="fw-bold text-primary">Yth. {{ $surat->tujuan_surat }}</div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="text-muted">Tanggal Naskah:</div>
                    <div class="fw-bold text-dark">{{ $surat->tanggal_surat->format('d F Y') }}</div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="text-muted">Konseptor Pengusul:</div>
                    <div class="fw-bold text-dark">{{ $surat->konseptor->name }}</div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="text-muted">Unit Kerja:</div>
                    <div class="fw-bold text-secondary">{{ $surat->konseptor->unit_kerja }}</div>
                </div>
            </div>

            <div class="p-3 bg-light rounded-3 border mb-3">
                <div class="small fw-bold text-secondary text-uppercase mb-1">Batang Tubuh / Isi Naskah</div>
                <div class="small text-dark" style="line-height: 1.8; white-space: pre-line;">{{ $surat->isi_surat }}</div>
            </div>

            @if($surat->file_lampiran)
            <div class="p-3 border rounded-3 d-flex align-items-center justify-content-between bg-white">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-file-earmark-pdf-fill text-danger fs-2"></i>
                    <div>
                        <div class="fw-bold small text-dark">{{ $surat->file_lampiran }}</div>
                        <div class="small text-muted">Lampiran Kajian / Telaah Teknis</div>
                    </div>
                </div>
                <a href="{{ route('surat-keluar.preview', $surat->id) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-eye me-1"></i> Pratinjau
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- RIGHT COLUMN: ACTION FORMS & DIGITAL SIGNATURE PROOF -->
    <div class="col-12 col-lg-5">
        
        <!-- AKSI WORKFLOW INTERAKTIF -->
        <div class="kemenhub-card p-4 mb-4">
            <h5 class="fs-6 fw-bold text-dark mb-3">
                <i class="bi bi-gear-wide-connected text-primary me-2"></i> Tindakan Tahapan Naskah
            </h5>

            <!-- A. Jika Draft Konsep -->
            @if($surat->status === 'Draft Konsep')
                <div class="alert alert-light border rounded-3 p-3 mb-0">
                    <p class="small text-muted mb-3">
                        Konsep surat telah disusun. Ajukan naskah dinas ini ke <strong>Kepala Bidang</strong> untuk proses penelaahan teknis dan paraf elektronik.
                    </p>
                    <form id="formAjukan" action="{{ route('surat-keluar.ajukan', $surat->id) }}" method="POST" onsubmit="confirmAjukan(event)">
                        @csrf
                        <button type="submit" class="btn btn-kemenhub w-100 justify-content-center">
                            <i class="bi bi-send-fill me-2"></i> Ajukan Paraf ke Kepala Bidang
                        </button>
                    </form>
                </div>
            @endif

            <!-- B. Jika Menunggu Paraf Kabid -->
            @if($surat->status === 'Menunggu Paraf Kabid')
                <div class="alert alert-info border-info border-opacity-50 p-3 mb-0 rounded-3">
                    <div class="fw-bold text-primary mb-1 d-flex align-items-center gap-1">
                        <i class="bi bi-pen-fill"></i> Wewenang: Kepala Bidang (Kabid)
                    </div>
                    <p class="small text-muted mb-3">
                        Naskah dinas ini menunggu persetujuan dan paraf koordinasi Kepala Bidang sebelum diteruskan kepada Kepala Pusat Kebijakan Sarana Transportasi.
                    </p>

                    @if(auth()->user()->isKabid() || auth()->user()->isAdmin())
                    <form id="formParaf" action="{{ route('surat-keluar.paraf-kabid', $surat->id) }}" method="POST" onsubmit="confirmParaf(event)">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary mb-1">Catatan Pemeriksaan Paraf</label>
                            <input type="text" name="catatan" class="form-control form-control-sm" value="Telah diteliti secara teknis dan materi kebijakan telah siap disahkan Kepala Pusat." required>
                        </div>
                        <button type="submit" class="btn btn-gold w-100 justify-content-center fw-bold">
                            <i class="bi bi-check2-circle me-1"></i> Sematkan Paraf Elektronik Kabid
                        </button>
                    </form>
                    @else
                    <div class="p-2 bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded small text-dark">
                        <i class="bi bi-info-circle-fill text-primary me-1"></i> Hanya akun <strong>Kepala Bidang</strong> yang berhak membubuhkan paraf koordinasi. Beralih peran ke <strong>Kabid</strong> di menu bar atas untuk mencoba.
                    </div>
                    @endif
                </div>
            @endif

            <!-- C. Jika Menunggu TTE Kapus -->
            @if($surat->status === 'Menunggu TTE Kapus')
                <div class="alert alert-danger border-danger border-opacity-50 p-3 mb-0 rounded-3">
                    <div class="fw-bold text-danger mb-1 d-flex align-items-center gap-1">
                        <i class="bi bi-award-fill text-danger"></i> Wewenang: Kepala Pusat Kebijakan Sarana (Kapus)
                    </div>
                    <p class="small text-muted mb-3">
                        Naskah dinas telah diparaf koordinasi oleh Kepala Bidang. Pengesahan akhir dilakukan dengan Tanda Tangan Elektronik (TTE) resmi Kepala Pusat berstandar BSrE Kemenhub.
                    </p>

                    @if(auth()->user()->isKapus() || auth()->user()->isAdmin())
                    <form id="formTTE" action="{{ route('surat-keluar.tte-kapus', $surat->id) }}" method="POST" onsubmit="confirmTTE(event)">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary mb-1">Catatan Pengesahan TTE</label>
                            <input type="text" name="catatan" class="form-control form-control-sm" value="Disahkan dengan Tanda Tangan Elektronik (TTE) tersertifikasi Kepala Pusat Kebijakan Sarana Transportasi." required>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 justify-content-center fw-bold">
                            <i class="bi bi-shield-lock-fill me-1"></i> Sahkan TTE Digital & Aktifkan QR Code
                        </button>
                    </form>
                    @else
                    <div class="p-2 bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded small text-dark">
                        <i class="bi bi-info-circle-fill text-primary me-1"></i> Hanya akun <strong>Kepala Pusat</strong> yang berhak melakukan TTE akhir. Beralih peran ke <strong>Kapus</strong> di menu bar atas untuk mencoba.
                    </div>
                    @endif
                </div>
            @endif

            <!-- D. Jika Disetujui/TTE (Siap Dikirim) -->
            @if($surat->status === 'Disetujui/TTE')
                <div class="alert alert-success border-success border-opacity-50 p-3 mb-0 rounded-3">
                    <div class="fw-bold text-success mb-1 d-flex align-items-center gap-1">
                        <i class="bi bi-patch-check-fill"></i> Naskah Dinas Sah & Terverifikasi BSrE
                    </div>
                    <p class="small text-muted mb-3">
                        Naskah telah resmi ditandatangani secara elektronik oleh Kepala Pusat. QR Code validasi keaslian telah diterbitkan.
                    </p>
                    <form id="formKirim" action="{{ route('surat-keluar.kirim', $surat->id) }}" method="POST" onsubmit="confirmKirim(event)">
                        @csrf
                        <button type="submit" class="btn btn-kemenhub w-100 justify-content-center">
                            <i class="bi bi-envelope-check-fill me-1"></i> Kirimkan ke Instansi Tujuan & Arsipkan
                        </button>
                    </form>
                </div>
            @endif

            <!-- E. Jika Terkirim -->
            @if($surat->status === 'Terkirim')
                <div class="alert alert-secondary text-center p-3 mb-0 rounded-3">
                    <i class="bi bi-archive-fill text-secondary fs-3 d-block mb-1"></i>
                    <strong class="text-dark">Naskah Dinas Telah Terkirim & Tersimpan di Arsip PKST BKT.</strong>
                </div>
            @endif
        </div>

        <!-- BUKTI DIGITAL TTE & PARAF -->
        <div class="kemenhub-card p-4">
            <h5 class="fs-6 fw-bold text-dark mb-3">
                <i class="bi bi-patch-check-fill text-primary me-2"></i> Bukti Pengesahan Naskah Elektronik
            </h5>

            <!-- Box Paraf Kabid -->
            <div class="p-3 border rounded-3 mb-3 bg-light">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <strong class="small text-dark">Paraf Kepala Bidang</strong>
                    @if($surat->paraf_kabid_at)
                        <span class="badge bg-success small"><i class="bi bi-check-circle-fill me-1"></i> Sah Diparaf</span>
                    @else
                        <span class="badge bg-secondary small">Belum Diparaf</span>
                    @endif
                </div>
                @if($surat->paraf_kabid_at)
                    <div class="small fw-semibold text-primary">{{ $surat->parafKabid->name }}</div>
                    <div class="small text-muted" style="font-size: 0.72rem;">Waktu: {{ $surat->paraf_kabid_at->format('d M Y H:i:s') }} WIB</div>
                    <div class="small text-muted fst-italic mt-1">"{{ $surat->paraf_kabid_catatan }}"</div>
                @endif
            </div>

            <!-- Box TTE Kapus & QR Code -->
            <div class="p-3 border rounded-3 bg-light">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <strong class="small text-dark">Tanda Tangan Elektronik (TTE)</strong>
                    @if($surat->tte_kapus_at)
                        <span class="badge bg-success small"><i class="bi bi-shield-check me-1"></i> Sah Bersertifikasi BSrE</span>
                    @else
                        <span class="badge bg-secondary small">Menunggu TTE</span>
                    @endif
                </div>

                @if($surat->tte_kapus_at)
                    <div class="small fw-semibold text-primary">{{ $surat->tteKapus->name }}</div>
                    <div class="small text-muted" style="font-size: 0.72rem;">Waktu: {{ $surat->tte_kapus_at->format('d M Y H:i:s') }} WIB</div>

                    <!-- QR Code Validation Box -->
                    <div class="d-flex align-items-center gap-3 bg-white p-3 rounded border border-warning border-opacity-50 mt-3">
                        <div class="logo-badge" style="width: 48px; height: 48px; font-size: 1.4rem;">
                            QR
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="small fw-bold text-dark">Token Sertifikat BSrE:</div>
                            <div class="d-flex align-items-center gap-2 flex-wrap my-1">
                                <span class="small font-monospace text-primary text-truncate">{{ $surat->qr_code_token }}</span>
                                <button type="button" class="copy-btn" onclick="copyToClipboard('{{ $surat->qr_code_token }}', this)" title="Salin Token Sertifikat">
                                    <i class="bi bi-clipboard"></i> Salin Token
                                </button>
                            </div>
                            <a href="{{ route('verifikasi.tte', $surat->qr_code_token) }}" target="_blank" class="small fw-bold text-warning text-decoration-none">
                                <i class="bi bi-search me-1"></i> Cek Sertifikat Publik &rarr;
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmAjukan(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Ajukan Paraf Koordinasi?',
            text: 'Naskah dinas akan diteruskan ke antrean telaahan Kepala Bidang.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0A2540',
            cancelButtonColor: '#64748B',
            confirmButtonText: '<i class="bi bi-send-fill me-1"></i> Ya, Ajukan Sekarang',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formAjukan').submit();
            }
        });
    }

    function confirmParaf(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Sematkan Paraf Koordinasi?',
            text: 'Pastikan telaahan dan materi kebijakan telah sesuai dengan kaidah tata naskah dinas PKST.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#F5A623',
            cancelButtonColor: '#64748B',
            confirmButtonText: '<i class="bi bi-check2-circle me-1"></i> Ya, Sematkan Paraf',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formParaf').submit();
            }
        });
    }

    function confirmTTE(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Sahkan Tanda Tangan Elektronik?',
            html: '<p class="small text-muted mb-0">Naskah dinas akan disahkan secara digital dengan sertifikasi <strong>BSrE BSSN RI</strong> dan QR Code resmi akan diaktifkan secara publik.</p>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#64748B',
            confirmButtonText: '<i class="bi bi-shield-lock-fill me-1"></i> Sahkan TTE Sekarang',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formTTE').submit();
            }
        });
    }

    function confirmKirim(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Kirim & Arsipkan Naskah?',
            text: 'Naskah dinas akan berstatus Terkirim dan tercatat permanen di Buku Agenda Surat Keluar PKST BKT.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0A2540',
            cancelButtonColor: '#64748B',
            confirmButtonText: '<i class="bi bi-envelope-check-fill me-1"></i> Ya, Kirim Sekarang',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formKirim').submit();
            }
        });
    }
</script>
@endsection
