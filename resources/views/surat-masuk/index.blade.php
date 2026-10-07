@extends('layouts.app')

@section('title', 'Daftar Surat Masuk')

@section('content')
<!-- HEADER -->
<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="fs-4 fw-bold text-dark m-0">Buku Agenda Surat Masuk</h2>
        <p class="text-muted small m-0">Registrasi dan tata kelola naskah dinas masuk Pusat Kebijakan Sarana Transportasi</p>
    </div>
    <a href="{{ route('surat-masuk.create') }}" class="btn btn-gold px-3">
        <i class="bi bi-plus-lg me-1"></i> Catat Surat Masuk Baru
    </a>
</div>

<!-- FILTER & SEARCH BAR (Bootstrap Card Grid) -->
<div class="kemenhub-card p-3 p-md-4 mb-4">
    <form method="GET" action="{{ route('surat-masuk.index') }}" class="row g-3 align-items-end">
        <div class="col-12 col-md-5">
            <label class="form-label small fw-bold text-secondary mb-1">Pencarian Naskah</label>
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                <input type="text" name="search" id="liveSearchInput" value="{{ request('search') }}" placeholder="Cari nomor agenda, instansi, perihal..." class="form-control">
            </div>
        </div>

        <div class="col-6 col-md-3">
            <label class="form-label small fw-bold text-secondary mb-1">Status Disposisi</label>
            <select name="status" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                <option value="Baru Masuk" {{ request('status') == 'Baru Masuk' ? 'selected' : '' }}>Baru Masuk</option>
                <option value="Telah Didisposisi" {{ request('status') == 'Telah Didisposisi' ? 'selected' : '' }}>Telah Didisposisi</option>
                <option value="Sedang Ditindaklanjuti" {{ request('status') == 'Sedang Ditindaklanjuti' ? 'selected' : '' }}>Sedang Ditindaklanjuti</option>
                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        <div class="col-6 col-md-2">
            <label class="form-label small fw-bold text-secondary mb-1">Sifat Naskah</label>
            <select name="sifat" class="form-select form-select-sm">
                <option value="">Semua Sifat</option>
                <option value="Sangat Segera" {{ request('sifat') == 'Sangat Segera' ? 'selected' : '' }}>Sangat Segera</option>
                <option value="Segera" {{ request('sifat') == 'Segera' ? 'selected' : '' }}>Segera</option>
                <option value="Biasa" {{ request('sifat') == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                <option value="Rahasia" {{ request('sifat') == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
            </select>
        </div>

        <div class="col-12 col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-kemenhub btn-sm w-100 justify-content-center">
                Filter
            </button>
            <a href="{{ route('surat-masuk.index') }}" class="btn btn-light btn-sm border" title="Reset">
                <i class="bi bi-arrow-counterclockwise"></i>
            </a>
        </div>
    </form>
</div>

<!-- SURAT MASUK TABLE CARD -->
<div class="kemenhub-card">
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-journal-text text-primary fs-5"></i>
            <h5 class="fs-6 fw-bold text-dark m-0">Daftar Agenda Registrasi Naskah</h5>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25" id="visibleRowCount">{{ $suratMasuk->count() }} Naskah</span>
            <span class="badge bg-light text-muted border">Total: {{ $suratMasuk->total() }} Surat</span>
        </div>
    </div>

    <!-- Quick Filter Pills Row (Zero Page Reload) -->
    <div class="px-3 pt-2 pb-1 border-bottom bg-light">
        <div class="filter-pills-row">
            <span class="small fw-bold text-secondary me-1 text-nowrap"><i class="bi bi-funnel-fill text-primary"></i> Filter Instan:</span>
            <button type="button" class="filter-pill active" onclick="applyClientFilter('', this)">
                Semua Status
            </button>
            <button type="button" class="filter-pill" onclick="applyClientFilter('Baru Masuk', this)">
                <i class="bi bi-inbox text-danger"></i> Baru Masuk
            </button>
            <button type="button" class="filter-pill" onclick="applyClientFilter('Telah Didisposisi', this)">
                <i class="bi bi-journal-arrow-down text-info"></i> Telah Didisposisi
            </button>
            <button type="button" class="filter-pill" onclick="applyClientFilter('Sedang Ditindaklanjuti', this)">
                <i class="bi bi-hourglass-split text-warning"></i> Ditindaklanjuti
            </button>
            <button type="button" class="filter-pill" onclick="applyClientFilter('Selesai', this)">
                <i class="bi bi-patch-check-fill text-success"></i> Selesai
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table-kemenhub" id="suratMasukTable">
            <thead>
                <tr>
                    <th>No. Agenda / Tgl Diterima</th>
                    <th>Asal Instansi & No. Surat Asal</th>
                    <th>Perihal Naskah</th>
                    <th>Sifat</th>
                    <th>Status Disposisi</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suratMasuk as $sm)
                <tr data-status="{{ $sm->status }}">
                    <td>
                        <div class="fw-bold text-dark">{{ $sm->no_agenda }}</div>
                        <div class="small text-muted"><i class="bi bi-calendar3 me-1"></i>{{ $sm->tanggal_diterima->format('d/m/Y') }}</div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark text-truncate" style="max-width: 200px;" title="{{ $sm->asal_instansi }}">{{ $sm->asal_instansi }}</div>
                        <div class="small text-muted font-monospace">{{ $sm->no_surat_asal }}</div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark text-truncate" style="max-width: 280px;" title="{{ $sm->perihal }}">
                            {{ $sm->perihal }}
                        </div>
                        <div class="small text-muted">Kode: <span class="badge bg-light text-secondary border">{{ $sm->klasifikasi_kode }}</span></div>
                    </td>
                    <td>
                        <span class="badge {{ $sm->sifat_surat === 'Sangat Segera' ? 'bg-danger' : ($sm->sifat_surat === 'Segera' ? 'bg-warning text-dark' : 'bg-info text-dark') }}">
                            {{ $sm->sifat_surat }}
                        </span>
                    </td>
                    <td>
                        <span class="status-pill {{ $sm->status_badge_class }}">
                            <span class="status-dot"></span>
                            {{ $sm->status }}
                        </span>
                        @if($sm->disposisi->count() > 0)
                        <div class="small text-muted mt-1" style="font-size: 0.72rem;">
                            <i class="bi bi-people me-1"></i>{{ $sm->disposisi->count() }} Arahan Disposisi
                        </div>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('surat-masuk.show', $sm->id) }}" class="btn btn-light btn-sm border" title="Buka Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('surat-masuk.disposisi.cetak', $sm->id) }}" target="_blank" class="btn btn-light btn-sm border text-secondary" title="Cetak Lembar Disposisi">
                                <i class="bi bi-printer"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                        Tidak ada arsip surat masuk ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="p-3 border-top d-flex justify-content-between align-items-center">
        <span class="small text-muted">Menampilkan {{ $suratMasuk->firstItem() ?? 0 }} - {{ $suratMasuk->lastItem() ?? 0 }} dari {{ $suratMasuk->total() }} naskah</span>
        <div>{{ $suratMasuk->links('pagination::bootstrap-5') }}</div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentStatusFilter = '';

    function applyClientFilter(status, btn) {
        currentStatusFilter = status;
        document.querySelectorAll('.filter-pill').forEach(el => el.classList.remove('active'));
        if (btn) btn.classList.add('active');

        runCombinedFilter();
    }

    // Combined live search and status filter
    function runCombinedFilter() {
        const query = (document.getElementById('liveSearchInput')?.value || '').toLowerCase();
        const rows = document.querySelectorAll('#suratMasukTable tbody tr[data-status]');
        let visibleCount = 0;

        rows.forEach(row => {
            const rowStatus = row.getAttribute('data-status') || '';
            const text = row.innerText.toLowerCase();
            const matchesStatus = !currentStatusFilter || rowStatus.toLowerCase().includes(currentStatusFilter.toLowerCase());
            const matchesSearch = !query || text.includes(query);

            if (matchesStatus && matchesSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const badge = document.getElementById('visibleRowCount');
        if (badge) {
            badge.innerText = visibleCount + ' Ditampilkan';
        }
    }

    const liveSearch = document.getElementById('liveSearchInput');
    if (liveSearch) {
        liveSearch.addEventListener('keyup', runCombinedFilter);
    }
</script>
@endsection
