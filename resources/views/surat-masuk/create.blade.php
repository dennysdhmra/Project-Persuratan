@extends('layouts.app')

@section('title', 'Catat Surat Masuk Baru')

@section('content')
<!-- HEADER -->
<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="fs-4 fw-bold text-dark m-0">Registrasi Surat Masuk Baru</h2>
        <p class="text-muted small m-0">Pencatatan naskah dinas masuk pada unit kerja Pusat Kebijakan Sarana Transportasi</p>
    </div>
    <a href="{{ route('surat-masuk.index') }}" class="btn btn-outline-secondary btn-sm px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
</div>

<!-- FORM CARD -->
<div class="kemenhub-card p-4 mx-auto" style="max-width: 900px;">
    <form action="{{ route('surat-masuk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Nomor Agenda Registrasi (Otomatis)</label>
                <input type="text" name="no_agenda" class="form-control form-control-sm bg-light fw-bold font-monospace" value="{{ old('no_agenda', $suggestedAgenda) }}" required readonly>
                <div class="small text-muted" style="font-size: 0.72rem;">Format standar unit kerja: AGD/PKST/TAHUN/NOMOR</div>
            </div>

            <div class="col-12 col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Nomor Surat Asal (Dari Pengirim)</label>
                <input type="text" name="no_surat_asal" class="form-control form-control-sm" placeholder="Contoh: UM.202/1/4/DJPD-2026" value="{{ old('no_surat_asal') }}" required>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-12 col-md-8">
                <label class="form-label small fw-bold text-secondary mb-1">Asal Instansi / Pengirim</label>
                <input type="text" name="asal_instansi" class="form-control form-control-sm" placeholder="Contoh: Direktorat Jenderal Perhubungan Darat" value="{{ old('asal_instansi') }}" required>
            </div>

            <div class="col-12 col-md-4">
                <label class="form-label small fw-bold text-secondary mb-1">Sifat Naskah Dinas</label>
                <select name="sifat_surat" class="form-select form-select-sm" required>
                    <option value="Biasa" {{ old('sifat_surat') == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                    <option value="Segera" {{ old('sifat_surat') == 'Segera' ? 'selected' : '' }}>Segera</option>
                    <option value="Sangat Segera" {{ old('sifat_surat') == 'Sangat Segera' ? 'selected' : '' }}>Sangat Segera</option>
                    <option value="Rahasia" {{ old('sifat_surat') == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold text-secondary mb-1">Perihal Naskah Dinas</label>
            <input type="text" name="perihal" class="form-control form-control-sm" placeholder="Tuliskan perihal surat secara lengkap dan jelas" value="{{ old('perihal') }}" required>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-12 col-sm-6 col-md-4">
                <label class="form-label small fw-bold text-secondary mb-1">Tanggal Surat Tertera</label>
                <input type="date" name="tanggal_surat" class="form-control form-control-sm" value="{{ old('tanggal_surat', date('Y-m-d')) }}" required>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <label class="form-label small fw-bold text-secondary mb-1">Tanggal Diterima Loket</label>
                <input type="date" name="tanggal_diterima" class="form-control form-control-sm" value="{{ old('tanggal_diterima', date('Y-m-d')) }}" required>
            </div>

            <div class="col-12 col-md-4">
                <label class="form-label small fw-bold text-secondary mb-1">Kode Klasifikasi Naskah</label>
                <select name="klasifikasi_kode" class="form-select form-select-sm" required>
                    @foreach($klasifikasiList as $klas)
                        <option value="{{ $klas->kode }}" {{ old('klasifikasi_kode') == $klas->kode ? 'selected' : '' }}>
                            {{ $klas->kode }} - {{ $klas->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold text-secondary mb-1">Ringkasan / Pokok Masalah Isi Surat</label>
            <textarea name="ringkasan_isi" class="form-control form-control-sm" rows="3" placeholder="Uraian singkat pokok bahasan surat masuk...">{{ old('ringkasan_isi') }}</textarea>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Unggah Lampiran Digital (PDF / Docx)</label>
                <input type="file" name="file_lampiran" class="form-control form-control-sm" accept=".pdf,.doc,.docx">
                <div class="small text-muted" style="font-size: 0.72rem;">Maksimal 10 MB. Dokumen fisik diarsipkan di Subbagian Tata Usaha.</div>
            </div>

            <div class="col-12 col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Catatan Penerima Loket Persuratan</label>
                <input type="text" name="catatan_penerima" class="form-control form-control-sm" placeholder="Contoh: Diterima kurir loket lantai 4" value="{{ old('catatan_penerima', 'Diterima melalui loket persuratan digital PKST BKT.') }}">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 border-top pt-3">
            <a href="{{ route('surat-masuk.index') }}" class="btn btn-light btn-sm border px-3">Batal</a>
            <button type="submit" class="btn btn-kemenhub btn-sm px-4 fw-bold">
                <i class="bi bi-save me-1"></i> Simpan dan Daftarkan Surat
            </button>
        </div>
    </form>
</div>
@endsection
