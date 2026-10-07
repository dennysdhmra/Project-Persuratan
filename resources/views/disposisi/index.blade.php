@extends('layouts.app')

@section('title', 'Alur & Lembar Disposisi')

@section('content')
<!-- HEADER -->
<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="fs-4 fw-bold text-dark m-0">Monitoring Disposisi Digital Berjenjang</h2>
        <p class="text-muted small m-0">Pengawasan instruksi pimpinan dan pelaksanaan tindak lanjut telaah kebijakan sarana</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <span class="role-badge-current">{{ auth()->user()->role_label }}</span>
    </div>
</div>

<!-- INTERACTIVE STATUS TABS -->
<div class="kemenhub-card p-3 mb-4">
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
        <div class="nav nav-pills gap-2" role="tablist">
            <a href="{{ route('disposisi.index') }}" class="nav-link py-1 px-3 small fw-bold {{ !request('status') ? 'active bg-primary' : 'bg-light text-secondary border' }}">
                Semua Disposisi
            </a>
            <a href="{{ route('disposisi.index', ['status' => 'Menunggu']) }}" class="nav-link py-1 px-3 small fw-bold {{ request('status') === 'Menunggu' ? 'active bg-warning text-dark' : 'bg-light text-secondary border' }}">
                Menunggu Pengerjaan
            </a>
            <a href="{{ route('disposisi.index', ['status' => 'Sedang Dikerjakan']) }}" class="nav-link py-1 px-3 small fw-bold {{ request('status') === 'Sedang Dikerjakan' ? 'active bg-info text-white' : 'bg-light text-secondary border' }}">
                Sedang Dikerjakan
            </a>
            <a href="{{ route('disposisi.index', ['status' => 'Selesai']) }}" class="nav-link py-1 px-3 small fw-bold {{ request('status') === 'Selesai' ? 'active bg-success text-white' : 'bg-light text-secondary border' }}">
                Selesai
            </a>
        </div>

        <div class="d-flex align-items-center gap-2 w-100 w-md-auto">
            <input type="text" id="liveSearchDisp" class="form-control form-control-sm" placeholder="Saring cepat tugas..." style="max-width: 220px;">
        </div>
    </div>
</div>

<!-- DISPOSISI TABLE CARD -->
<div class="kemenhub-card">
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-journal-check text-primary fs-5"></i>
            <h5 class="fs-6 fw-bold text-dark m-0">Daftar Tugas & Disposisi Naskah Dinas</h5>
        </div>
        <span class="badge bg-light text-muted border">Total: {{ $disposisiList->total() }} Tugas</span>
    </div>

    <div class="table-responsive">
        <table class="table-kemenhub" id="disposisiTable">
            <thead>
                <tr>
                    <th>Surat Masuk Terkait</th>
                    <th>Pemberi Disposisi</th>
                    <th>Diteruskan Kepada</th>
                    <th>Instruksi Arahan</th>
                    <th>Target SLA</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($disposisiList as $disp)
                <tr>
                    <td>
                        <div class="fw-bold text-dark">{{ $disp->suratMasuk->no_agenda }}</div>
                        <div class="small text-muted text-truncate" style="max-width: 220px;" title="{{ $disp->suratMasuk->perihal }}">
                            {{ $disp->suratMasuk->perihal }}
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold small text-dark">{{ $disp->pemberi->name }}</div>
                        <div class="small text-muted">{{ $disp->pemberi->jabatan }}</div>
                    </td>
                    <td>
                        <div class="fw-bold small text-primary">{{ $disp->penerima->name }}</div>
                        <div class="small text-muted">{{ $disp->penerima->jabatan }}</div>
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1" style="max-width: 200px;">
                            @foreach($disp->instruksi as $ins)
                                <span class="badge bg-light text-secondary border small">{{ $ins }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        @if($disp->batas_waktu)
                            <div class="small fw-bold {{ $disp->isOverdue() ? 'text-danger' : 'text-dark' }}">
                                {{ $disp->batas_waktu->format('d M Y') }}
                            </div>
                            @if($disp->isOverdue())
                                <span class="badge bg-danger small" style="font-size: 0.65rem;">Terlewat SLA</span>
                            @endif
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $disp->status === 'Selesai' ? 'bg-success' : ($disp->status === 'Sedang Dikerjakan' ? 'bg-primary' : 'bg-warning text-dark') }}">
                            {{ $disp->status }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('surat-masuk.show', $disp->surat_masuk_id) }}" class="btn btn-light btn-sm border" title="Buka Detail">
                            <i class="bi bi-arrow-right-short fs-6"></i> Buka
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-journal-x fs-1 d-block mb-2 text-secondary opacity-50"></i>
                        Belum ada tugas disposisi yang tercatat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="p-3 border-top d-flex justify-content-between align-items-center">
        <span class="small text-muted">Menampilkan {{ $disposisiList->firstItem() ?? 0 }} - {{ $disposisiList->lastItem() ?? 0 }} dari {{ $disposisiList->total() }}</span>
        <div>{{ $disposisiList->links('pagination::bootstrap-5') }}</div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const liveSearchDisp = document.getElementById('liveSearchDisp');
    if (liveSearchDisp) {
        liveSearchDisp.addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('#disposisiTable tbody tr');
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }
</script>
@endsection
