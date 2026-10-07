@extends('layouts.app')

@section('title', 'Daftar Surat Keluar')

@section('content')
<!-- HEADER -->
<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="fs-4 fw-bold text-dark m-0">Tata Kelola Naskah Keluar</h2>
        <p class="text-muted small m-0">Penyusunan konsep, paraf berjenjang, dan Tanda Tangan Elektronik (TTE) PKST BKT</p>
    </div>
    <a href="{{ route('surat-keluar.create') }}" class="btn btn-gold px-3">
        <i class="bi bi-pencil-square me-1"></i> + Buat Konsep Surat Keluar
    </a>
</div>

<!-- FILTER & SEARCH BAR (Bootstrap Card Grid) -->
<div class="kemenhub-card p-3 p-md-4 mb-4">
    <form method="GET" action="{{ route('surat-keluar.index') }}" class="row g-3 align-items-end">
        <div class="col-12 col-md-6">
            <label class="form-label small fw-bold text-secondary mb-1">Pencarian Naskah Keluar</label>
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                <input type="text" name="search" id="liveSearchKeluar" value="{{ request('search') }}" placeholder="Cari nomor surat, tujuan, perihal..." class="form-control">
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label class="form-label small fw-bold text-secondary mb-1">Tahapan Workflow</label>
            <select name="status" class="form-select form-select-sm">
                <option value="">Semua Tahapan</option>
                <option value="Draft Konsep" {{ request('status') == 'Draft Konsep' ? 'selected' : '' }}>Draft Konsep</option>
                <option value="Menunggu Paraf Kabid" {{ request('status') == 'Menunggu Paraf Kabid' ? 'selected' : '' }}>Menunggu Paraf Kabid</option>
                <option value="Menunggu TTE Kapus" {{ request('status') == 'Menunggu TTE Kapus' ? 'selected' : '' }}>Menunggu TTE Kapus</option>
                <option value="Disetujui/TTE" {{ request('status') == 'Disetujui/TTE' ? 'selected' : '' }}>Disetujui / TTE Sah</option>
                <option value="Terkirim" {{ request('status') == 'Terkirim' ? 'selected' : '' }}>Terkirim</option>
            </select>
        </div>

        <div class="col-12 col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-kemenhub btn-sm w-100 justify-content-center">
                Filter
            </button>
            <a href="{{ route('surat-keluar.index') }}" class="btn btn-light btn-sm border" title="Reset">
                <i class="bi bi-arrow-counterclockwise"></i>
            </a>
        </div>
    </form>
</div>

<!-- SURAT KELUAR TABLE CARD -->
<div class="kemenhub-card">
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-send-fill text-primary fs-5"></i>
            <h5 class="fs-6 fw-bold text-dark m-0">Daftar Naskah Dinas Keluar</h5>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25" id="visibleRowCountKeluar">{{ $suratKeluar->count() }} Naskah</span>
            <span class="badge bg-light text-muted border">Total: {{ $suratKeluar->total() }} Naskah</span>
        </div>
    </div>

    <!-- Quick Filter Pills Row (Zero Page Reload) -->
    <div class="px-3 pt-2 pb-1 border-bottom bg-light">
        <div class="filter-pills-row">
            <span class="small fw-bold text-secondary me-1 text-nowrap"><i class="bi bi-funnel-fill text-primary"></i> Filter Instan:</span>
            <button type="button" class="filter-pill active" onclick="applyClientFilterKeluar('', this)">
                Semua Tahapan
            </button>
            <button type="button" class="filter-pill" onclick="applyClientFilterKeluar('Draft Konsep', this)">
                <i class="bi bi-pencil-square text-secondary"></i> Draft Konsep
            </button>
            <button type="button" class="filter-pill" onclick="applyClientFilterKeluar('Menunggu Paraf', this)">
                <i class="bi bi-pen text-info"></i> Menunggu Paraf
            </button>
            <button type="button" class="filter-pill" onclick="applyClientFilterKeluar('Menunggu TTE', this)">
                <i class="bi bi-shield-exclamation text-danger"></i> Menunggu TTE
            </button>
            <button type="button" class="filter-pill" onclick="applyClientFilterKeluar('Disetujui', this)">
                <i class="bi bi-patch-check-fill text-success"></i> TTE Sah
            </button>
            <button type="button" class="filter-pill" onclick="applyClientFilterKeluar('Terkirim', this)">
                <i class="bi bi-archive-fill text-primary"></i> Terkirim
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table-kemenhub" id="suratKeluarTable">
            <thead>
                <tr>
                    <th>Nomor Surat / Tanggal</th>
                    <th>Tujuan & Konseptor</th>
                    <th>Perihal Naskah</th>
                    <th>Sifat</th>
                    <th>Status Workflow</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suratKeluar as $sk)
                <tr data-status="{{ $sk->status }}">
                    <td>
                        <div class="fw-bold text-dark font-monospace">{{ $sk->no_surat }}</div>
                        <div class="small text-muted"><i class="bi bi-calendar3 me-1"></i>{{ $sk->tanggal_surat->format('d/m/Y') }}</div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark text-truncate" style="max-width: 200px;" title="{{ $sk->tujuan_surat }}">
                            Yth. {{ $sk->tujuan_surat }}
                        </div>
                        <div class="small text-muted">Konseptor: {{ $sk->konseptor->name }}</div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark text-truncate" style="max-width: 280px;" title="{{ $sk->perihal }}">
                            {{ $sk->perihal }}
                        </div>
                        <div class="small text-muted">Kode: <span class="badge bg-light text-secondary border">{{ $sk->klasifikasi_kode }}</span></div>
                    </td>
                    <td>
                        <span class="badge {{ $sk->sifat_surat === 'Sangat Segera' ? 'bg-danger' : ($sk->sifat_surat === 'Segera' ? 'bg-warning text-dark' : 'bg-info text-dark') }}">
                            {{ $sk->sifat_surat }}
                        </span>
                    </td>
                    <td>
                        <span class="status-pill {{ $sk->status_badge_class }}">
                            <span class="status-dot"></span>
                            @if($sk->status === 'Disetujui/TTE') <i class="bi bi-shield-check text-success me-1"></i> @endif
                            {{ $sk->status }}
                        </span>
                        @if($sk->tte_kapus_at)
                        <div class="small text-success fw-semibold mt-1" style="font-size: 0.72rem;">
                            <i class="bi bi-patch-check-fill me-1"></i>TTE Sah: {{ $sk->tte_kapus_at->format('d/m/Y H:i') }}
                        </div>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('surat-keluar.show', $sk->id) }}" class="btn btn-light btn-sm border" title="Buka Detail & Alur">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('surat-keluar.preview', $sk->id) }}" target="_blank" class="btn btn-light btn-sm border text-secondary" title="Pratinjau Dokumen Cetak">
                                <i class="bi bi-file-earmark-text"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-send fs-1 d-block mb-2 text-secondary opacity-50"></i>
                        Belum ada arsip surat keluar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="p-3 border-top d-flex justify-content-between align-items-center">
        <span class="small text-muted">Menampilkan {{ $suratKeluar->firstItem() ?? 0 }} - {{ $suratKeluar->lastItem() ?? 0 }} dari {{ $suratKeluar->total() }} naskah</span>
        <div>{{ $suratKeluar->links('pagination::bootstrap-5') }}</div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentStatusFilterKeluar = '';

    function applyClientFilterKeluar(status, btn) {
        currentStatusFilterKeluar = status;
        document.querySelectorAll('.filter-pill').forEach(el => el.classList.remove('active'));
        if (btn) btn.classList.add('active');

        runCombinedFilterKeluar();
    }

    // Combined live search and status filter for Surat Keluar
    function runCombinedFilterKeluar() {
        const query = (document.getElementById('liveSearchKeluar')?.value || '').toLowerCase();
        const rows = document.querySelectorAll('#suratKeluarTable tbody tr[data-status]');
        let visibleCount = 0;

        rows.forEach(row => {
            const rowStatus = row.getAttribute('data-status') || '';
            const text = row.innerText.toLowerCase();
            const matchesStatus = !currentStatusFilterKeluar || rowStatus.toLowerCase().includes(currentStatusFilterKeluar.toLowerCase());
            const matchesSearch = !query || text.includes(query);

            if (matchesStatus && matchesSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const badge = document.getElementById('visibleRowCountKeluar');
        if (badge) {
            badge.innerText = visibleCount + ' Ditampilkan';
        }
    }

    const liveSearchKeluar = document.getElementById('liveSearchKeluar');
    if (liveSearchKeluar) {
        liveSearchKeluar.addEventListener('keyup', runCombinedFilterKeluar);
    }
</script>
@endsection
