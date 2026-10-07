@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- GREETING & ROLE INFO HEADER -->
<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h2 class="fs-4 fw-bold text-dark m-0">Selamat Datang, {{ $user->name }}</h2>
            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1 small">
                {{ $user->role_label }}
            </span>
        </div>
        <p class="text-muted small m-0">
            Pusat Kebijakan Sarana Transportasi &mdash; Badan Kebijakan Transportasi, Kemenhub RI
        </p>
    </div>
    
    <div class="d-flex gap-2">
        <a href="{{ route('surat-masuk.create') }}" class="btn btn-outline-primary btn-sm px-3 fw-semibold">
            <i class="bi bi-inbox me-1"></i> + Registrasi Surat
        </a>
        <a href="{{ route('surat-keluar.create') }}" class="btn btn-kemenhub btn-sm px-3">
            <i class="bi bi-pencil-square me-1"></i> + Draft Naskah
        </a>
    </div>
</div>

<!-- ROLE-SPECIFIC URGENT ACTION ALERTS -->
@if($user->isPegawai() && $pendingDisposisiCount > 0)
<div class="alert alert-warning border-warning border-opacity-50 shadow-sm d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3 p-3 mb-4 rounded-3">
    <div class="d-flex align-items-center gap-3">
        <div class="fs-2 text-warning pulse-glow rounded-circle p-1"><i class="bi bi-exclamation-triangle-fill"></i></div>
        <div>
            <h5 class="fs-6 fw-bold text-dark m-0">Tugas Disposisi: Ada {{ $pendingDisposisiCount }} Surat Menunggu Tindak Lanjut Anda!</h5>
            <p class="small text-muted m-0">Segera pelajari instruksi pimpinan dan laporkan hasil kajian atau telaah kebijakan.</p>
        </div>
    </div>
    <a href="{{ route('disposisi.index') }}" class="btn btn-warning btn-sm fw-bold px-3 text-nowrap">Buka Tugas Disposisi</a>
</div>
@endif

@if(($user->isKabid() || $user->isAdmin()) && $needParafCount > 0)
<div class="alert alert-info border-info border-opacity-50 shadow-sm d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3 p-3 mb-4 rounded-3">
    <div class="d-flex align-items-center gap-3">
        <div class="fs-2 text-primary pulse-glow rounded-circle p-1"><i class="bi bi-pen-fill"></i></div>
        <div>
            <h5 class="fs-6 fw-bold text-primary m-0">Persetujuan Paraf: {{ $needParafCount }} Konsep Surat Menunggu Paraf Kepala Bidang</h5>
            <p class="small text-muted m-0">Konsep telaah kebijakan telah diajukan staf analis dan siap diparaf koordinasi sebelum diteruskan ke Kepala Pusat.</p>
        </div>
    </div>
    <a href="{{ route('surat-keluar.index', ['status' => 'Menunggu Paraf Kabid']) }}" class="btn btn-primary btn-sm px-3 text-nowrap">Periksa & Beri Paraf</a>
</div>
@endif

@if(($user->isKapus() || $user->isAdmin()) && $needTteCount > 0)
<div class="alert alert-danger border-danger border-opacity-50 shadow-sm d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3 p-3 mb-4 rounded-3">
    <div class="d-flex align-items-center gap-3">
        <div class="fs-2 text-danger pulse-glow rounded-circle p-1"><i class="bi bi-award-fill"></i></div>
        <div>
            <h5 class="fs-6 fw-bold text-danger m-0">Pengesahan TTE: {{ $needTteCount }} Surat Dinas Menunggu Tanda Tangan Elektronik</h5>
            <p class="small text-muted m-0">Dokumen telah diparaf koordinasi Kepala Bidang dan siap disahkan secara digital dengan sertifikat BSrE.</p>
        </div>
    </div>
    <a href="{{ route('surat-keluar.index', ['status' => 'Menunggu TTE Kapus']) }}" class="btn btn-danger btn-sm px-3 text-nowrap">Tandatangani (TTE)</a>
</div>
@endif

<!-- ANIMATED KPI STAT CARDS (Bootstrap Row Grid) -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="kpi-card kpi-blue">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="kpi-label">Surat Masuk Terdaftar</div>
                    <div class="kpi-value counter-value" data-target="{{ $totalSuratMasuk }}">0</div>
                    <div class="small text-muted mt-1"><i class="bi bi-arrow-up-short text-success"></i> Dokumen kedinasan masuk</div>
                </div>
                <div class="kpi-icon-wrap">
                    <i class="bi bi-inbox-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="kpi-card kpi-navy">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="kpi-label">Surat Keluar / Naskah</div>
                    <div class="kpi-value counter-value" data-target="{{ $totalSuratKeluar }}">0</div>
                    <div class="small text-muted mt-1"><i class="bi bi-shield-check text-info"></i> TTE & Naskah Dinas</div>
                </div>
                <div class="kpi-icon-wrap">
                    <i class="bi bi-send-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="kpi-card kpi-gold">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="kpi-label">Disposisi Berjalan</div>
                    <div class="kpi-value counter-value" data-target="{{ $totalDisposisiAktif }}">0</div>
                    <div class="small text-muted mt-1"><i class="bi bi-clock-history text-warning"></i> Instruksi aktif pimpinan</div>
                </div>
                <div class="kpi-icon-wrap">
                    <i class="bi bi-journal-text"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="kpi-card kpi-emerald">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="kpi-label">Naskah Telah Selesai</div>
                    <div class="kpi-value counter-value" data-target="{{ $totalSelesai }}">0</div>
                    <div class="small text-muted mt-1"><i class="bi bi-check2-all text-success"></i> Diarsipkan permanen</div>
                </div>
                <div class="kpi-icon-wrap">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DYNAMIC VISUALIZATION CHARTS (Chart.js) -->
<div class="row g-4 mb-4">
    <div class="col-12 col-lg-8">
        <div class="kemenhub-card p-3 p-md-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="fs-6 fw-bold text-dark m-0 d-flex align-items-center gap-2">
                        <i class="bi bi-bar-chart-fill text-primary"></i> Tren Alur Persuratan & Disposisi Bulanan
                    </h5>
                    <span class="small text-muted">Statistik dinamika naskah dinas Pusat Kebijakan Sarana Transportasi</span>
                </div>
                <span class="badge bg-light text-secondary border">Tahun 2026</span>
            </div>
            <div style="position: relative; height: 260px; width: 100%;">
                <canvas id="persuratanChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="kemenhub-card p-3 p-md-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="fs-6 fw-bold text-dark m-0 d-flex align-items-center gap-2">
                        <i class="bi bi-pie-chart-fill text-warning"></i> Rasio Status Disposisi
                    </h5>
                    <span class="small text-muted">Status penyelesaian arahan</span>
                </div>
                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">SLA</span>
            </div>
            <div style="position: relative; height: 210px; width: 100%; display: flex; align-items: center; justify-content: center;">
                <canvas id="disposisiStatusChart"></canvas>
            </div>
            <div class="d-flex justify-content-around text-center small text-muted mt-2 border-top pt-2">
                <div><span class="badge bg-warning p-1 me-1"></span>Menunggu</div>
                <div><span class="badge bg-primary p-1 me-1"></span>Dikerjakan</div>
                <div><span class="badge bg-success p-1 me-1"></span>Selesai</div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN TABLES & FEEDS (Responsive Grid) -->
<div class="row g-4">
    <!-- LEFT COLUMN: TABLES -->
    <div class="col-12 col-lg-8">
        
        <!-- SURAT MASUK TERBARU TABLE -->
        <div class="kemenhub-card mb-4">
            <div class="p-3 border-bottom d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-inbox-fill text-primary fs-5"></i>
                    <h5 class="fs-6 fw-bold text-dark m-0">Surat Masuk Terbaru</h5>
                </div>
                <div class="d-flex align-items-center gap-2 w-100 w-sm-auto">
                    <input type="text" id="filterSuratMasukInput" class="form-control form-control-sm" placeholder="Saring cepat..." style="max-width: 180px;">
                    <a href="{{ route('surat-masuk.index') }}" class="btn btn-outline-secondary btn-sm text-nowrap">Lihat Semua &rarr;</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table-kemenhub" id="tableSuratMasuk">
                    <thead>
                        <tr>
                            <th>No. Agenda / Asal</th>
                            <th>Perihal & Klasifikasi</th>
                            <th>Sifat</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSuratMasuk as $sm)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $sm->no_agenda }}</div>
                                <div class="small text-muted text-truncate" style="max-width: 160px;" title="{{ $sm->asal_instansi }}">{{ $sm->asal_instansi }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark text-truncate" style="max-width: 240px;" title="{{ $sm->perihal }}">
                                    {{ $sm->perihal }}
                                </div>
                                <div class="small text-muted">{{ $sm->klasifikasi_kode }} &bull; {{ $sm->tanggal_surat->format('d/m/Y') }}</div>
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
                            </td>
                            <td class="text-center">
                                <a href="{{ route('surat-masuk.show', $sm->id) }}" class="btn btn-light btn-sm border" title="Buka Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data surat masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SURAT KELUAR & WORKFLOW PROGRES TABLE -->
        <div class="kemenhub-card">
            <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-send-fill text-primary fs-5"></i>
                    <h5 class="fs-6 fw-bold text-dark m-0">Surat Keluar & Progres TTE</h5>
                </div>
                <a href="{{ route('surat-keluar.index') }}" class="btn btn-outline-secondary btn-sm">Lihat Semua &rarr;</a>
            </div>

            <div class="table-responsive">
                <table class="table-kemenhub">
                    <thead>
                        <tr>
                            <th>Nomor Surat / Tujuan</th>
                            <th>Perihal & Konseptor</th>
                            <th>Status Workflow</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSuratKeluar as $sk)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $sk->no_surat }}</div>
                                <div class="small text-muted text-truncate" style="max-width: 170px;">Yth. {{ $sk->tujuan_surat }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark text-truncate" style="max-width: 250px;" title="{{ $sk->perihal }}">
                                    {{ $sk->perihal }}
                                </div>
                                <div class="small text-muted">Konseptor: {{ $sk->konseptor->name }}</div>
                            </td>
                            <td>
                                <span class="status-pill {{ $sk->status_badge_class }}">
                                    <span class="status-dot"></span>
                                    @if($sk->status === 'Disetujui/TTE') <i class="bi bi-shield-check text-success me-1"></i> @endif
                                    {{ $sk->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('surat-keluar.show', $sk->id) }}" class="btn btn-light btn-sm border" title="Detail & Alur">
                                    <i class="bi bi-arrow-right-short fs-6"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Belum ada surat keluar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- RIGHT COLUMN: SLA ALERTS & AUDIT TRAIL -->
    <div class="col-12 col-lg-4">
        
        <!-- SLA OVERDUE WARNING -->
        @if($overdueDisposisi->count() > 0)
        <div class="card border-danger border-opacity-50 shadow-sm mb-4">
            <div class="card-header bg-danger bg-opacity-10 text-danger fw-bold d-flex align-items-center gap-2 py-2">
                <i class="bi bi-exclamation-octagon-fill"></i> Peringatan Batas Waktu (SLA)
            </div>
            <div class="card-body p-3">
                <p class="small text-muted mb-2">Disposisi berikut telah melewati batas waktu target pengerjaan:</p>
                <div class="list-group list-group-flush">
                    @foreach($overdueDisposisi as $od)
                    <div class="list-group-item px-0 py-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <strong class="small text-dark text-truncate" style="max-width: 180px;">{{ $od->suratMasuk->no_agenda }}</strong>
                            <span class="badge bg-danger small">Lewat SLA</span>
                        </div>
                        <div class="small text-muted text-truncate">{{ $od->suratMasuk->perihal }}</div>
                        <div class="d-flex justify-content-between small mt-1 text-muted">
                            <span>PJ: {{ $od->penerima->name }}</span>
                            <span class="text-danger fw-semibold">{{ $od->batas_waktu->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- AUDIT ACTIVITY STREAM -->
        <div class="kemenhub-card">
            <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-activity text-primary fs-5"></i>
                    <h5 class="fs-6 fw-bold text-dark m-0">Aktivitas Sistem Terkini</h5>
                </div>
                <span class="badge bg-light text-muted border">Realtime</span>
            </div>

            <div class="p-3">
                <div class="timeline-stream">
                    @forelse($recentLogs as $log)
                    <div class="d-flex gap-3 mb-3 pb-2 border-bottom border-light">
                        <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.8rem; flex-shrink: 0;">
                            {{ substr($log->user->name ?? 'S', 0, 1) }}
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="small fw-semibold text-dark">{{ $log->user->name ?? 'Sistem' }}</div>
                            <div class="small text-muted text-break" style="font-size: 0.78rem;">{{ $log->keterangan }}</div>
                            <div class="small text-muted" style="font-size: 0.7rem;">{{ $log->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3 small">Belum ada aktivitas tercatat.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    // 1. KPI Animated Count-Up Function
    document.addEventListener('DOMContentLoaded', function () {
        const counters = document.querySelectorAll('.counter-value');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            let current = 0;
            const increment = target / 25;
            const updateCount = () => {
                current += increment;
                if (current < target) {
                    counter.innerText = Math.ceil(current);
                    setTimeout(updateCount, 25);
                } else {
                    counter.innerText = target;
                }
            };
            if (target > 0) {
                updateCount();
            } else {
                counter.innerText = '0';
            }
        });

        // 2. Client-side Live Search on Surat Masuk Table
        const searchInput = document.getElementById('filterSuratMasukInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                const query = this.value.toLowerCase();
                const rows = document.querySelectorAll('#tableSuratMasuk tbody tr');
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
            });
        }

        // 3. Render Chart.js - Tren Persuratan Bulanan
        const ctxPersuratan = document.getElementById('persuratanChart');
        if (ctxPersuratan) {
            new Chart(ctxPersuratan, {
                type: 'bar',
                data: {
                    labels: ['Mei', 'Jun', 'Jul', 'Ags', 'Sep (Bulan Ini)'],
                    datasets: [
                        {
                            label: 'Surat Masuk',
                            data: [12, 19, 15, 22, {{ $totalSuratMasuk }}],
                            backgroundColor: 'rgba(2, 132, 199, 0.8)',
                            borderColor: '#0284C7',
                            borderWidth: 1,
                            borderRadius: 6
                        },
                        {
                            label: 'Surat Keluar / TTE',
                            data: [8, 14, 11, 18, {{ $totalSuratKeluar }}],
                            backgroundColor: 'rgba(10, 37, 64, 0.85)',
                            borderColor: '#0A2540',
                            borderWidth: 1,
                            borderRadius: 6
                        },
                        {
                            label: 'Disposisi Selesai',
                            data: [10, 16, 12, 20, {{ $totalSelesai }}],
                            backgroundColor: 'rgba(245, 166, 35, 0.85)',
                            borderColor: '#F5A623',
                            borderWidth: 1,
                            borderRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(226, 232, 240, 0.6)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // 4. Render Chart.js - Rasio Status Disposisi
        const ctxStatus = document.getElementById('disposisiStatusChart');
        if (ctxStatus) {
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: ['Menunggu', 'Sedang Dikerjakan', 'Selesai'],
                    datasets: [{
                        data: [
                            {{ \App\Models\Disposisi::where('status', 'Menunggu')->count() ?: 1 }},
                            {{ \App\Models\Disposisi::where('status', 'Sedang Dikerjakan')->count() ?: 2 }},
                            {{ \App\Models\Disposisi::where('status', 'Selesai')->count() ?: 3 }}
                        ],
                        backgroundColor: ['#F5A623', '#0284C7', '#059669'],
                        borderWidth: 2,
                        borderColor: '#FFFFFF'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    cutout: '70%'
                }
            });
        }
    });
</script>
@endsection
