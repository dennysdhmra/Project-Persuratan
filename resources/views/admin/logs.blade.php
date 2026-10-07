@extends('layouts.app')

@section('title', 'Audit Activity Log')

@section('content')
<!-- HEADER -->
<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="fs-4 fw-bold text-dark m-0">Audit Activity Log</h2>
        <p class="text-muted small m-0">Rekam jejak aktivitas naskah dinas, disposisi, dan tanda tangan elektronik BSrE</p>
    </div>
    <span class="badge bg-secondary bg-opacity-10 text-secondary border px-3 py-2">
        <i class="bi bi-shield-check me-1"></i> Audit Trail Aktif
    </span>
</div>

<!-- LOGS TABLE CARD -->
<div class="kemenhub-card">
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-clock-history text-primary fs-5"></i>
            <h5 class="fs-6 fw-bold text-dark m-0">Log Riwayat Sistem Persuratan</h5>
        </div>
        <span class="badge bg-light text-muted border">Total: {{ $logs->total() }} Catatan</span>
    </div>

    <div class="table-responsive">
        <table class="table-kemenhub">
            <thead>
                <tr>
                    <th style="width: 180px;">Waktu Kejadian</th>
                    <th>Pegawai / Aktor</th>
                    <th>Aksi Sistem</th>
                    <th>Deskripsi Aktivitas</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>
                        <div class="small fw-bold text-dark">{{ $log->created_at->format('d/m/Y H:i:s') }}</div>
                        <div class="small text-muted" style="font-size: 0.7rem;">{{ $log->created_at->diffForHumans() }}</div>
                    </td>
                    <td>
                        @if($log->user)
                            <div class="small fw-bold text-primary">{{ $log->user->name }}</div>
                            <div class="small text-muted" style="font-size: 0.7rem;">{{ $log->user->role_label }}</div>
                        @else
                            <span class="text-muted small">Sistem Otomatis</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-dark bg-opacity-10 text-dark border font-monospace small">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td>
                        <div class="small text-dark" style="line-height: 1.5;">{{ $log->description }}</div>
                    </td>
                    <td>
                        <span class="small font-monospace text-muted">{{ $log->ip_address ?? '127.0.0.1' }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat aktivitas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="p-3 border-top d-flex justify-content-between align-items-center">
        <span class="small text-muted">Menampilkan {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} dari {{ $logs->total() }}</span>
        <div>{{ $logs->links('pagination::bootstrap-5') }}</div>
    </div>
</div>
@endsection
