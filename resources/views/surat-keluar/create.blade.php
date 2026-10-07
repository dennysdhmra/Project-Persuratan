@extends('layouts.app')

@section('title', 'Buat Konsep Surat Keluar')

@section('content')
<!-- HEADER -->
<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="fs-4 fw-bold text-dark m-0">Penyusunan Konsep Surat Keluar</h2>
        <p class="text-muted small m-0">Pembuatan naskah dinas atau telaah kebijakan baru oleh konseptor analis</p>
    </div>
    <a href="{{ route('surat-keluar.index') }}" class="btn btn-outline-secondary btn-sm px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
</div>

<!-- FORM CARD -->
<div class="kemenhub-card p-4 mx-auto" style="max-width: 900px;">
    <form action="{{ route('surat-keluar.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Nomor Surat Resmi (Saran Sistem)</label>
                <input type="text" name="no_surat" class="form-control form-control-sm bg-light fw-bold font-monospace text-primary" value="{{ old('no_surat', $suggestedNo) }}" required>
                <div class="small text-muted" style="font-size: 0.72rem;">Format standar unit kerja: KODE/NOMOR/UNIT/TAHUN</div>
            </div>

            <div class="col-12 col-md-6">
                <label class="form-label small fw-bold text-secondary mb-1">Sifat Naskah Dinas</label>
                <select name="sifat_surat" class="form-select form-select-sm" required>
                    <option value="Biasa">Biasa</option>
                    <option value="Segera">Segera</option>
                    <option value="Sangat Segera">Sangat Segera</option>
                    <option value="Rahasia">Rahasia</option>
                </select>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-12 col-md-8">
                <label class="form-label small fw-bold text-secondary mb-1">Tujuan Naskah (Kepada Yth.)</label>
                <input type="text" name="tujuan_surat" class="form-control form-control-sm" placeholder="Contoh: Direktur Jenderal Perhubungan Darat" value="{{ old('tujuan_surat') }}" required>
            </div>

            <div class="col-12 col-md-4">
                <label class="form-label small fw-bold text-secondary mb-1">Tanggal Naskah</label>
                <input type="date" name="tanggal_surat" class="form-control form-control-sm" value="{{ old('tanggal_surat', date('Y-m-d')) }}" required>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-12 col-md-8">
                <label class="form-label small fw-bold text-secondary mb-1">Perihal Naskah Dinas</label>
                <input type="text" name="perihal" class="form-control form-control-sm" placeholder="Contoh: Rekomendasi Kebijakan Standardisasi Sarana Kereta Cepat" value="{{ old('perihal') }}" required>
            </div>

            <div class="col-12 col-md-4">
                <label class="form-label small fw-bold text-secondary mb-1">Klasifikasi Urusan</label>
                <select name="klasifikasi_kode" class="form-select form-select-sm" required>
                    @foreach($klasifikasiList as $klas)
                        <option value="{{ $klas->kode }}">{{ $klas->kode }} - {{ $klas->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold text-secondary mb-1">Ringkasan Eksekutif (Opsional)</label>
            <textarea name="ringkasan_isi" rows="2" class="form-control form-control-sm" placeholder="Ringkasan poin strategis rekomendasi...">{{ old('ringkasan_isi') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold text-secondary mb-1">Batang Tubuh Isi Naskah Dinas</label>
            <textarea name="isi_surat" rows="8" class="form-control form-control-sm" placeholder="Tuliskan draf isi surat secara lengkap..." required style="line-height: 1.7;">{{ old('isi_surat', "Sehubungan dengan permohonan rekomendasi teknis sarana transportasi, bersama ini Pusat Kebijakan Sarana Transportasi Badan Kebijakan Transportasi menyampaikan telaah strategis sebagai berikut:\n\n1. Kajian kelayakan teknis dan operasional sarana...\n2. Rekomendasi regulasi standardisasi keselamatan...\n3. Langkah mitigasi risiko dan pengawasan kelaikan berkala.\n\nDemikian kami sampaikan, atas perhatian dan kerja sama yang baik diucapkan terima kasih.") }}</textarea>
        </div>

        <div class="mb-4">
            <label class="form-label small fw-bold text-secondary mb-1">Unggah Berkas Lampiran Penunjang (PDF / Docx)</label>
            <input type="file" name="file_lampiran" class="form-control form-control-sm" accept=".pdf,.doc,.docx">
        </div>

        <div class="d-flex justify-content-end gap-2 border-top pt-3">
            <a href="{{ route('surat-keluar.index') }}" class="btn btn-light btn-sm border px-3">Batal</a>
            <button type="submit" class="btn btn-kemenhub btn-sm px-4 fw-bold">
                <i class="bi bi-save me-1"></i> Simpan Konsep Naskah
            </button>
        </div>
    </form>
</div>
@endsection
