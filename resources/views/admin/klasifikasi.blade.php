@extends('layouts.app')

@section('title', 'Master Klasifikasi Surat')

@section('content')
<!-- HEADER -->
<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="fs-4 fw-bold text-dark m-0">Kode Klasifikasi Naskah Dinas</h2>
        <p class="text-muted small m-0">Referensi pengkodean naskah dinas lingkup Pusat Kebijakan Sarana Transportasi</p>
    </div>
    <span class="badge bg-info bg-opacity-10 text-primary border px-3 py-2">
        <i class="bi bi-tag-fill me-1"></i> Standar Tata Naskah Kemenhub
    </span>
</div>

<!-- TABLE CARD -->
<div class="kemenhub-card">
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-tags-fill text-primary fs-5"></i>
            <h5 class="fs-6 fw-bold text-dark m-0">Tabel Kode Klasifikasi Kementerian Perhubungan</h5>
        </div>
        <span class="badge bg-light text-muted border">{{ $klasifikasi->count() }} Kategori</span>
    </div>

    <div class="table-responsive">
        <table class="table-kemenhub">
            <thead>
                <tr>
                    <th style="width: 160px;">Kode Klasifikasi</th>
                    <th>Nama Urusan / Naskah Dinas</th>
                    <th style="width: 220px;">Kategori Urusan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($klasifikasi as $k)
                <tr>
                    <td>
                        <span class="badge bg-light text-dark border font-monospace fs-6 px-3 py-2">
                            {{ $k->kode }}
                        </span>
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ $k->nama }}</div>
                    </td>
                    <td>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1">
                            {{ $k->kategori }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
