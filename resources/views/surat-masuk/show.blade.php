@extends('layouts.app')

@section('title', 'Detail Surat Masuk - ' . $surat->no_agenda)

@section('content')
<!-- BREADCRUMB & HEADER -->
<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <a href="{{ route('surat-masuk.index') }}" class="btn btn-light btn-sm border py-1">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="fs-4 fw-bold text-dark m-0">{{ $surat->no_agenda }}</h2>
            <span class="status-pill {{ $surat->status_badge_class }}">
                <span class="status-dot"></span>
                {{ $surat->status }}
            </span>
        </div>
        <p class="text-muted small m-0">Registrasi persuratan masuk Pusat Kebijakan Sarana Transportasi</p>
    </div>

    <div class="d-flex gap-2">
        <button type="button" class="btn btn-outline-primary btn-sm px-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#docPreviewModal">
            <i class="bi bi-file-earmark-text me-1"></i> Pratinjau Naskah
        </button>
        <a href="{{ route('surat-masuk.disposisi.cetak', $surat->id) }}" target="_blank" class="btn btn-kemenhub btn-sm px-3">
            <i class="bi bi-printer me-1"></i> Cetak Lembar Disposisi
        </a>
    </div>
</div>

<!-- MAIN RESPONSIVE GRID -->
<div class="row g-4 align-items-start">
    
    <!-- LEFT: INFORMASI DETAIL SURAT -->
    <div class="col-12 col-lg-7">
        <div class="kemenhub-card p-4 mb-4">
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
                    <div class="text-muted">Nomor Surat Asal:</div>
                    <div class="fw-bold font-monospace text-dark">{{ $surat->no_surat_asal }}</div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="text-muted">Tanggal Surat Asal:</div>
                    <div class="fw-bold text-dark">{{ $surat->tanggal_surat->format('d F Y') }}</div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="text-muted">Asal Instansi / Pengirim:</div>
                    <div class="fw-bold text-primary">{{ $surat->asal_instansi }}</div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="text-muted">Diterima pada Tanggal:</div>
                    <div class="fw-bold text-dark">{{ $surat->tanggal_diterima->format('d F Y') }}</div>
                </div>
            </div>

            <div class="p-3 bg-light rounded-3 border mb-3">
                <div class="small fw-bold text-secondary text-uppercase mb-1">Ringkasan / Isi Ringkas Naskah</div>
                <p class="small text-dark m-0" style="line-height: 1.6;">
                    {{ $surat->ringkasan_isi ?? 'Tidak ada ringkasan teks.' }}
                </p>
            </div>

            @if($surat->file_lampiran)
            <div class="p-3 border rounded-3 d-flex align-items-center justify-content-between bg-white">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-file-earmark-pdf-fill text-danger fs-2"></i>
                    <div>
                        <div class="fw-bold small text-dark">{{ $surat->file_lampiran }}</div>
                        <div class="small text-muted">Berkas Digital Resmi PKST BKT</div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#docPreviewModal">
                    <i class="bi bi-eye me-1"></i> Buka Berkas
                </button>
            </div>
            @endif
        </div>
    </div>

    <!-- RIGHT: LEMBAR DISPOSISI PIMPINAN & RIWAYAT -->
    <div class="col-12 col-lg-5">
        
        <!-- FORM DISPOSISI BARU (Khusus Pimpinan: Kapus / Kabid / Admin) -->
        @if(auth()->user()->isPimpinan() || auth()->user()->isAdmin())
        <div class="card border-warning border-opacity-75 shadow-sm mb-4">
            <div class="card-header bg-warning bg-opacity-10 text-dark fw-bold d-flex align-items-center gap-2 py-3">
                <i class="bi bi-pen-fill fs-5 text-warning"></i>
                <div>
                    <h5 class="fs-6 fw-bold m-0 text-dark">Buat Lembar Disposisi Pimpinan</h5>
                    <span class="small text-muted" style="font-size: 0.72rem;">Instruksi resmi arahan tindak lanjut untuk staf pelaksana</span>
                </div>
            </div>

            <div class="card-body p-3">
                <form action="{{ route('disposisi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="surat_masuk_id" value="{{ $surat->id }}">

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary mb-1">Diteruskan Kepada (Staf Analis)</label>
                        <select name="kepada_user_id" class="form-select form-select-sm" required>
                            <option value="">-- Pilih Staf Analis Penerima --</option>
                            @foreach($stafList as $staf)
                                <option value="{{ $staf->id }}">{{ $staf->name }} ({{ $staf->jabatan }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary mb-1">Instruksi Arahan (Pilih Satu/Lebih)</label>
                        <div class="d-flex flex-wrap gap-1 p-2 bg-light border rounded">
                            @foreach(['Tindak Lanjuti', 'Selesaikan', 'Pelajari / Kaji', 'Koordinasikan', 'Siapkan Bahan', 'Hadiri / Wakilkan', 'Simpan / Arsip'] as $instruksi)
                            <label class="instruction-chip">
                                <input type="checkbox" name="instruksi[]" value="{{ $instruksi }}" {{ $loop->first ? 'checked' : '' }}>
                                <span>{{ $instruksi }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary mb-1">Catatan Khusus Pimpinan</label>
                        <textarea name="catatan_disposisi" class="form-control form-control-sm" rows="3" placeholder="Tuliskan arahan spesifik..." required>Tolong teliti regulasi terkait dan buat telaah kebijakan dalam 3 hari kerja.</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary mb-1">Batas Waktu Penyelesaian (SLA)</label>
                        <input type="date" name="batas_waktu" class="form-control form-control-sm" value="{{ now()->addDays(3)->toDateString() }}">
                    </div>

                    <button type="submit" class="btn btn-gold btn-sm w-100 fw-bold justify-content-center">
                        <i class="bi bi-send-check me-1"></i> Terbitkan Lembar Disposisi
                    </button>
                </form>
            </div>
        </div>
        @endif

        <!-- RIWAYAT LEMBAR DISPOSISI -->
        <div class="kemenhub-card">
            <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-journal-check text-primary fs-5"></i>
                    <h5 class="fs-6 fw-bold text-dark m-0">Riwayat Disposisi Terbit</h5>
                </div>
                <span class="badge bg-light text-muted border">{{ $surat->disposisi->count() }} Lembar</span>
            </div>

            <div class="p-3">
                @forelse($surat->disposisi as $d)
                <div class="p-3 border rounded-3 mb-3 bg-white shadow-sm">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="small">
                            <span class="text-muted">Dari:</span> <strong class="text-primary">{{ $d->pemberi->name }}</strong><br>
                            <span class="text-muted">Kepada:</span> <strong class="text-dark">{{ $d->penerima->name }}</strong>
                        </div>
                        <span class="badge {{ $d->status === 'Selesai' ? 'bg-success' : ($d->status === 'Sedang Dikerjakan' ? 'bg-primary' : 'bg-warning text-dark') }}">
                            {{ $d->status }}
                        </span>
                    </div>

                    <div class="d-flex flex-wrap gap-1 mb-2">
                        @foreach($d->instruksi as $ins)
                            <span class="badge bg-light text-secondary border small">{{ $ins }}</span>
                        @endforeach
                    </div>

                    <div class="p-2 bg-light rounded small text-dark fst-italic mb-2">
                        "{{ $d->catatan_disposisi }}"
                    </div>

                    <div class="d-flex justify-content-between align-items-center small text-muted">
                        <span>Batas Waktu: <strong class="text-danger">{{ $d->batas_waktu ? $d->batas_waktu->format('d/m/Y') : '-' }}</strong></span>
                        <span>{{ $d->created_at->format('d/m/Y H:i') }}</span>
                    </div>

                    <!-- FORM RESPON STAF JIKA DITUGASKAN -->
                    @if($d->kepada_user_id === auth()->id() && $d->status !== 'Selesai')
                    <div class="mt-3 pt-3 border-top">
                        <button class="btn btn-outline-primary btn-sm w-100" type="button" data-bs-toggle="collapse" data-bs-target="#tindakLanjutForm-{{ $d->id }}">
                            <i class="bi bi-pencil-square me-1"></i> Laporkan Hasil Tindak Lanjut
                        </button>

                        <div class="collapse mt-2" id="tindakLanjutForm-{{ $d->id }}">
                            <form action="{{ route('disposisi.tindak-lanjut', $d->id) }}" method="POST" enctype="multipart/form-data" class="p-2 bg-light rounded border">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label small fw-bold text-secondary mb-1">Status Pengerjaan</label>
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="Sedang Dikerjakan">Sedang Dikerjakan (Draft Kajian)</option>
                                        <option value="Selesai">Telah Selesai Ditindaklanjuti</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small fw-bold text-secondary mb-1">Tanggapan / Laporan Kajian</label>
                                    <textarea name="tanggapan_pegawai" class="form-control form-control-sm" rows="2" placeholder="Uraikan tindak lanjut..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm w-100 fw-bold">
                                    Kirimkan Laporan Tindak Lanjut
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    @if($d->tanggapan_pegawai)
                    <div class="mt-2 pt-2 border-top small">
                        <div class="fw-bold text-success"><i class="bi bi-check-circle me-1"></i> Laporan Staf:</div>
                        <p class="text-muted m-0">{{ $d->tanggapan_pegawai }}</p>
                    </div>
                    @endif
                </div>
                @empty
                <div class="text-center text-muted py-4 small">
                    <i class="bi bi-journal-x fs-2 d-block mb-1 text-secondary opacity-50"></i>
                    Belum ada lembar disposisi yang diterbitkan.
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<!-- MODAL QUICK DOCUMENT PREVIEW -->
<div class="modal fade" id="docPreviewModal" tabindex="-1" aria-labelledby="docPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fs-6 fw-bold" id="docPreviewLabel">
                    <i class="bi bi-file-earmark-text text-primary me-2"></i> Pratinjau Naskah Digital: {{ $surat->no_agenda }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="bg-white p-4 rounded shadow-sm border" style="min-height: 380px; font-family: 'Times New Roman', serif;">
                    <div class="text-center border-bottom pb-3 mb-3">
                        <h6 class="fw-bold m-0" style="letter-spacing: 1px;">KEMENTERIAN PERHUBUNGAN REPUBLIK INDONESIA</h6>
                        <h5 class="fw-bold m-0" style="letter-spacing: 1px;">BADAN KEBIJAKAN TRANSPORTASI</h5>
                        <div class="small text-muted">Jl. Medan Merdeka Timur No. 5, Gambir, Jakarta Pusat</div>
                    </div>
                    <div class="d-flex justify-content-between small mb-3">
                        <div><strong>No:</strong> {{ $surat->no_surat_asal }}</div>
                        <div>{{ $surat->tanggal_surat->format('d F Y') }}</div>
                    </div>
                    <div class="small mb-3">
                        <strong>Perihal:</strong> {{ $surat->perihal }}<br>
                        <strong>Pengirim:</strong> {{ $surat->asal_instansi }}
                    </div>
                    <div class="small text-muted p-3 bg-light rounded border mb-3" style="line-height: 1.8;">
                        {{ $surat->ringkasan_isi ?? 'Isi naskah kedinasan digital terekam pada sistem persuratan elektronik PKST BKT Kemenhub.' }}
                    </div>
                    <div class="text-end small text-muted">
                        <em>Dokumen digital terotentikasi loket persuratan PKST</em>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection
