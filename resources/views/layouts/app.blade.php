<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Surat PKST') - Pusat Kebijakan Sarana Transportasi BKT Kemenhub</title>
    
    <!-- Google Fonts: Atkinson Hyperlegible (Official Accessible Standard) + Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3.3 CSS & Bootstrap Icons -->
    <!-- Bootstrap 5.3.3 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Chart.js & SweetAlert2 for Dynamic Visualizations & Dialogs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Theme State Initializer (Zero Flash) -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('esurat_theme');
            if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>

    <!-- Custom Kemenhub Design System Theme -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-baketrans.png') }}">
    <link rel="stylesheet" href="{{ asset('css/kemenhub.css') }}">
</head>
<body>
    <!-- Accessibility: Skip Link -->
    <a href="#main-content" class="skip-to-content">Lewati ke Konten Utama</a>

    <!-- 1. LIVE ROLE SWITCHER BAR (Simulasi RBAC Cepat & Fleksibel) -->
    @auth
    <div class="role-switcher-bar">
        <div class="role-switcher-left">
            <span class="d-flex align-items-center gap-1">
                <i class="bi bi-bank2 text-warning me-1"></i>
                <strong>Kemenhub BKT</strong> | Profil Aktif:
            </span>
            <span class="role-badge-current">{{ auth()->user()->role_label }}</span>
            <span class="role-user-name d-none d-sm-inline">({{ auth()->user()->name }})</span>
        </div>
        <div class="role-switcher-buttons d-flex align-items-center">
            <span class="role-switch-label d-none d-md-inline">Uji Peran:</span>
            <a href="{{ route('switch.role', 'admin') }}" class="btn-switch {{ auth()->user()->isAdmin() ? 'active' : '' }}" title="Ganti ke Profil Administrator">
                <i class="bi bi-shield-lock-fill text-danger"></i> Admin
            </a>
            <a href="{{ route('switch.role', 'pegawai') }}" class="btn-switch {{ auth()->user()->isPegawai() ? 'active' : '' }}" title="Ganti ke Profil Staf Analis">
                <i class="bi bi-person-workspace text-info"></i> Pegawai
            </a>
            <a href="{{ route('switch.role', 'kepala_bidang') }}" class="btn-switch {{ auth()->user()->isKabid() ? 'active' : '' }}" title="Ganti ke Profil Kepala Bidang (Kabid)">
                <i class="bi bi-diagram-3-fill text-primary"></i> Kabid
            </a>
            <a href="{{ route('switch.role', 'kepala_pusat') }}" class="btn-switch {{ auth()->user()->isKapus() ? 'active' : '' }}" title="Ganti ke Profil Kepala Pusat Sarana (Kapus)">
                <i class="bi bi-award-fill text-warning"></i> Kapus
            </a>
            
            <!-- Quick Theme Switch in Bar -->
            <button type="button" class="btn-theme-toggle ms-2" onclick="toggleTheme()" title="Beralih Mode Gelap/Terang" id="themeToggleBtnRole">
                <i class="bi bi-moon-stars-fill text-warning" id="themeIconRole"></i>
                <span id="themeTextRole" class="d-none d-sm-inline">Mode Gelap</span>
            </button>
        </div>
    </div>
    @endauth

    @php
        $notifInbox = \App\Models\SuratMasuk::where('status', 'Baru Masuk')->latest()->take(3)->get();
        $notifKeluar = \App\Models\SuratKeluar::whereIn('status', ['Menunggu Paraf Kabid', 'Menunggu TTE Kapus'])->latest()->take(3)->get();
        $totalNotif = $notifInbox->count() + $notifKeluar->count();
    @endphp

    <!-- 2. MOBILE TOP NAVBAR (Muncul di layar tablet & smartphone < 992px) -->
    <div class="mobile-top-bar d-lg-none">
        <a href="{{ route('dashboard') }}" class="mobile-brand">
            <img src="{{ asset('images/logo-baketrans.png') }}" alt="Logo Baketrans" class="mobile-brand-img">
            <div>
                <strong style="font-size: 0.95rem; font-weight: 800; color: var(--kemenhub-navy);">E-SURAT PKST</strong>
                <div style="font-size: 0.68rem; color: var(--text-muted);">BKT Kemenhub RI</div>
            </div>
        </a>

        <div class="d-flex align-items-center gap-2">
            <!-- Mobile Theme Toggle -->
            <button type="button" class="btn-theme-toggle-topbar" onclick="toggleTheme()" title="Beralih Tema">
                <i class="bi bi-moon-stars-fill" id="themeIconMobile"></i>
            </button>

            <!-- Mobile Notification Bell Dropdown -->
            <div class="dropdown">
                <button class="btn-notification-bell" type="button" id="mobileNotifDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Pemberitahuan">
                    <i class="bi bi-bell-fill"></i>
                    @if($totalNotif > 0)
                        <span class="notification-badge-pulse">{{ $totalNotif }}</span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-end notif-dropdown-menu" aria-labelledby="mobileNotifDropdown">
                    <div class="notif-header">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-bell-fill text-warning"></i>
                            <strong>Pemberitahuan Sistem</strong>
                        </div>
                        <span class="badge bg-warning text-dark">{{ $totalNotif }} Antrean</span>
                    </div>
                    <div style="max-height: 280px; overflow-y: auto;">
                        @forelse($notifInbox as $ni)
                        <a href="{{ route('surat-masuk.show', $ni->id) }}" class="notif-item unread">
                            <div class="notif-icon-box bg-info bg-opacity-10 text-info">
                                <i class="bi bi-inbox-fill"></i>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-bold small text-truncate">{{ $ni->perihal }}</div>
                                <div class="text-muted small" style="font-size: 0.72rem;">Agenda: {{ $ni->no_agenda }} &bull; Masuk Baru</div>
                            </div>
                        </a>
                        @empty
                        @endforelse

                        @forelse($notifKeluar as $nk)
                        <a href="{{ route('surat-keluar.show', $nk->id) }}" class="notif-item unread">
                            <div class="notif-icon-box bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-pen-fill"></i>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-bold small text-truncate">{{ $nk->perihal }}</div>
                                <div class="text-muted small" style="font-size: 0.72rem;">{{ $nk->status }}</div>
                            </div>
                        </a>
                        @empty
                        @endforelse

                        @if($totalNotif == 0)
                        <div class="p-4 text-center text-muted small">
                            <i class="bi bi-check-circle fs-3 text-success d-block mb-1"></i>
                            Tidak ada naskah yang menunggu tindakan Anda.
                        </div>
                        @endif
                    </div>
                    <div class="p-2 bg-light border-top text-center">
                        <a href="{{ route('dashboard') }}" class="small text-decoration-none fw-bold text-primary">Lihat Seluruh Aktivitas &rarr;</a>
                    </div>
                </div>
            </div>

            <button class="btn btn-light btn-sm border" onclick="openCmdPalette()" title="Cari (Ctrl+K)">
                <i class="bi bi-search"></i>
            </button>
            <button class="btn btn-kemenhub btn-sm px-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebarOffcanvas" aria-controls="mobileSidebarOffcanvas">
                <i class="bi bi-list fs-5"></i>
            </button>
        </div>
    </div>

    <!-- 3. MOBILE OFFCANVAS DRAWER (Sidebar di smartphone & tablet) -->
    <div class="offcanvas offcanvas-start d-lg-none text-bg-dark" tabindex="-1" id="mobileSidebarOffcanvas" style="background: #0A2540 !important; width: 280px;">
        <div class="offcanvas-header border-bottom border-secondary border-opacity-25 py-3">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('images/logo-baketrans.png') }}" alt="Logo Baketrans" style="width: 36px; height: auto; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));">
                <div>
                    <h5 class="offcanvas-title text-white fw-bold fs-6 m-0">E-SURAT PKST</h5>
                    <span class="text-secondary small">Badan Kebijakan Transportasi</span>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0 d-flex flex-column justify-content-between">
            <nav class="sidebar-nav">
                <div class="nav-section-title">Menu Utama</div>
                
                <a href="{{ route('dashboard') }}" class="nav-item-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <div class="nav-item-left">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard</span>
                    </div>
                </a>

                <a href="{{ route('surat-masuk.index') }}" class="nav-item-link {{ request()->routeIs('surat-masuk.*') ? 'active' : '' }}">
                    <div class="nav-item-left">
                        <i class="bi bi-inbox-fill"></i>
                        <span>Surat Masuk</span>
                    </div>
                    @php $newInbox = \App\Models\SuratMasuk::where('status', 'Baru Masuk')->count(); @endphp
                    @if($newInbox > 0)
                        <span class="nav-badge danger">{{ $newInbox }} Baru</span>
                    @endif
                </a>

                <a href="{{ route('disposisi.index') }}" class="nav-item-link {{ request()->routeIs('disposisi.*') ? 'active' : '' }}">
                    <div class="nav-item-left">
                        <i class="bi bi-journal-check"></i>
                        <span>Alur Disposisi</span>
                    </div>
                    @php $activeDisp = \App\Models\Disposisi::where('status', 'Menunggu')->count(); @endphp
                    @if($activeDisp > 0)
                        <span class="nav-badge gold">{{ $activeDisp }}</span>
                    @endif
                </a>

                <a href="{{ route('surat-keluar.index') }}" class="nav-item-link {{ request()->routeIs('surat-keluar.*') ? 'active' : '' }}">
                    <div class="nav-item-left">
                        <i class="bi bi-send-fill"></i>
                        <span>Surat Keluar</span>
                    </div>
                    @php $needApproval = \App\Models\SuratKeluar::whereIn('status', ['Menunggu Paraf Kabid', 'Menunggu TTE Kapus'])->count(); @endphp
                    @if($needApproval > 0)
                        <span class="nav-badge danger">{{ $needApproval }}</span>
                    @endif
                </a>

                <a href="{{ route('verifikasi.tte', 'demo-scan') }}" class="nav-item-link">
                    <div class="nav-item-left">
                        <i class="bi bi-qr-code-scan"></i>
                        <span>Verifikasi TTE (QR)</span>
                    </div>
                </a>

                @if(auth()->user()->isAdmin())
                <div class="nav-section-title">Administrasi Sistem</div>
                
                <a href="{{ route('admin.users') }}" class="nav-item-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <div class="nav-item-left">
                        <i class="bi bi-people-fill"></i>
                        <span>Kelola Pegawai</span>
                    </div>
                </a>

                <a href="{{ route('admin.klasifikasi') }}" class="nav-item-link {{ request()->routeIs('admin.klasifikasi') ? 'active' : '' }}">
                    <div class="nav-item-left">
                        <i class="bi bi-tags-fill"></i>
                        <span>Kode Klasifikasi</span>
                    </div>
                </a>

                <a href="{{ route('admin.logs') }}" class="nav-item-link {{ request()->routeIs('admin.logs') ? 'active' : '' }}">
                    <div class="nav-item-left">
                        <i class="bi bi-shield-check"></i>
                        <span>Audit Activity Log</span>
                    </div>
                </a>
                @endif
            </nav>

            @auth
            <div class="sidebar-user">
                <div class="user-info">
                    <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <div class="user-text">
                        <h4>{{ auth()->user()->name }}</h4>
                        <p>{{ auth()->user()->jabatan }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout" title="Keluar">
                        <i class="bi bi-box-arrow-right fs-5"></i>
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </div>

    <!-- 4. APP MAIN WRAPPER -->
    <div class="app-wrapper">
        
        <!-- SIDEBAR NAVIGATION (Desktop Persistent >= 992px) -->
        <aside class="sidebar d-none d-lg-flex">
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}" class="logo-container">
                    <img src="{{ asset('images/logo-baketrans.png') }}" alt="Logo Baketrans" class="sidebar-logo-img">
                    <div class="logo-text">
                        <h1>E-SURAT PKST</h1>
                        <span>BKT Kemenhub RI</span>
                    </div>
                </a>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section-title">Menu Utama</div>
                
                <a href="{{ route('dashboard') }}" class="nav-item-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <div class="nav-item-left">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard</span>
                    </div>
                </a>

                <a href="{{ route('surat-masuk.index') }}" class="nav-item-link {{ request()->routeIs('surat-masuk.*') ? 'active' : '' }}">
                    <div class="nav-item-left">
                        <i class="bi bi-inbox-fill"></i>
                        <span>Surat Masuk</span>
                    </div>
                    @php $newInbox = \App\Models\SuratMasuk::where('status', 'Baru Masuk')->count(); @endphp
                    @if($newInbox > 0)
                        <span class="nav-badge danger">{{ $newInbox }} Baru</span>
                    @endif
                </a>

                <a href="{{ route('disposisi.index') }}" class="nav-item-link {{ request()->routeIs('disposisi.*') ? 'active' : '' }}">
                    <div class="nav-item-left">
                        <i class="bi bi-journal-check"></i>
                        <span>Alur Disposisi</span>
                    </div>
                    @php $activeDisp = \App\Models\Disposisi::where('status', 'Menunggu')->count(); @endphp
                    @if($activeDisp > 0)
                        <span class="nav-badge gold">{{ $activeDisp }}</span>
                    @endif
                </a>

                <a href="{{ route('surat-keluar.index') }}" class="nav-item-link {{ request()->routeIs('surat-keluar.*') ? 'active' : '' }}">
                    <div class="nav-item-left">
                        <i class="bi bi-send-fill"></i>
                        <span>Surat Keluar</span>
                    </div>
                    @php $needApproval = \App\Models\SuratKeluar::whereIn('status', ['Menunggu Paraf Kabid', 'Menunggu TTE Kapus'])->count(); @endphp
                    @if($needApproval > 0)
                        <span class="nav-badge danger">{{ $needApproval }}</span>
                    @endif
                </a>

                <a href="{{ route('verifikasi.tte', 'demo-scan') }}" class="nav-item-link">
                    <div class="nav-item-left">
                        <i class="bi bi-qr-code-scan"></i>
                        <span>Verifikasi TTE (QR)</span>
                    </div>
                </a>

                @if(auth()->user()->isAdmin())
                <div class="nav-section-title">Administrasi Sistem</div>
                
                <a href="{{ route('admin.users') }}" class="nav-item-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <div class="nav-item-left">
                        <i class="bi bi-people-fill"></i>
                        <span>Kelola Pegawai</span>
                    </div>
                </a>

                <a href="{{ route('admin.klasifikasi') }}" class="nav-item-link {{ request()->routeIs('admin.klasifikasi') ? 'active' : '' }}">
                    <div class="nav-item-left">
                        <i class="bi bi-tags-fill"></i>
                        <span>Kode Klasifikasi</span>
                    </div>
                </a>

                <a href="{{ route('admin.logs') }}" class="nav-item-link {{ request()->routeIs('admin.logs') ? 'active' : '' }}">
                    <div class="nav-item-left">
                        <i class="bi bi-shield-check"></i>
                        <span>Audit Activity Log</span>
                    </div>
                </a>
                @endif
            </nav>

            @auth
            <div class="sidebar-user">
                <div class="user-info">
                    <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <div class="user-text">
                        <h4>{{ auth()->user()->name }}</h4>
                        <p>{{ auth()->user()->jabatan }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout" title="Keluar">
                        <i class="bi bi-box-arrow-right fs-5"></i>
                    </button>
                </form>
            </div>
            @endauth
        </aside>

        <!-- MAIN VIEW AREA -->
        <main class="main-content" id="main-content">
            <!-- Topbar (Desktop >= 992px) -->
            <header class="topbar d-none d-lg-flex">
                <div class="topbar-left">
                    <button type="button" class="search-command-btn" onclick="openCmdPalette()">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-search"></i>
                            <span>Cari naskah dinas, nomor agenda, atau perihal...</span>
                        </div>
                        <span class="kbd-shortcut">Ctrl + K</span>
                    </button>
                </div>
                <div class="topbar-right">
                    <div class="d-flex align-items-center gap-2">
                        <!-- Desktop Theme Toggle -->
                        <button type="button" class="btn-theme-toggle-topbar" onclick="toggleTheme()" title="Beralih Tema Gelap/Terang" id="themeToggleBtnTopbar">
                            <i class="bi bi-moon-stars-fill" id="themeIconTopbar"></i>
                        </button>

                        <!-- Desktop Notification Bell Dropdown -->
                        <div class="dropdown">
                            <button class="btn-notification-bell" type="button" id="desktopNotifDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Pemberitahuan Sistem">
                                <i class="bi bi-bell-fill"></i>
                                @if($totalNotif > 0)
                                    <span class="notification-badge-pulse">{{ $totalNotif }}</span>
                                @endif
                            </button>
                            <div class="dropdown-menu dropdown-menu-end notif-dropdown-menu" aria-labelledby="desktopNotifDropdown">
                                <div class="notif-header">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-bell-fill text-warning"></i>
                                        <strong>Pemberitahuan Sistem</strong>
                                    </div>
                                    <span class="badge bg-warning text-dark">{{ $totalNotif }} Menunggu</span>
                                </div>
                                <div style="max-height: 300px; overflow-y: auto;">
                                    @forelse($notifInbox as $ni)
                                    <a href="{{ route('surat-masuk.show', $ni->id) }}" class="notif-item unread">
                                        <div class="notif-icon-box bg-info bg-opacity-10 text-info">
                                            <i class="bi bi-inbox-fill"></i>
                                        </div>
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="fw-bold small text-truncate">{{ $ni->perihal }}</div>
                                            <div class="text-muted small" style="font-size: 0.72rem;">Agenda: {{ $ni->no_agenda }} &bull; Masuk Baru</div>
                                        </div>
                                    </a>
                                    @empty
                                    @endforelse

                                    @forelse($notifKeluar as $nk)
                                    <a href="{{ route('surat-keluar.show', $nk->id) }}" class="notif-item unread">
                                        <div class="notif-icon-box bg-warning bg-opacity-10 text-warning">
                                            <i class="bi bi-pen-fill"></i>
                                        </div>
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="fw-bold small text-truncate">{{ $nk->perihal }}</div>
                                            <div class="text-muted small" style="font-size: 0.72rem;">{{ $nk->status }}</div>
                                        </div>
                                    </a>
                                    @empty
                                    @endforelse

                                    @if($totalNotif == 0)
                                    <div class="p-4 text-center text-muted small">
                                        <i class="bi bi-check-circle fs-3 text-success d-block mb-1"></i>
                                        Tidak ada naskah yang menunggu tindakan Anda saat ini.
                                    </div>
                                    @endif
                                </div>
                                <div class="p-2 bg-light border-top text-center">
                                    <a href="{{ route('dashboard') }}" class="small text-decoration-none fw-bold text-primary">Lihat Seluruh Aktivitas &rarr;</a>
                                </div>
                            </div>
                        </div>

                        <div class="vr mx-1 d-none d-xl-block" style="height: 24px; opacity: 0.2;"></div>

                        <a href="{{ route('surat-masuk.create') }}" class="btn btn-outline-secondary btn-sm px-3 fw-semibold">
                            <i class="bi bi-plus-lg me-1"></i> Registrasi Surat
                        </a>
                        <a href="{{ route('surat-keluar.create') }}" class="btn btn-kemenhub btn-sm px-3">
                            <i class="bi bi-pencil-square me-1"></i> Buat Konsep
                        </a>
                    </div>
                </div>
            </header>

            <!-- Content Body -->
            <div class="content-body">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- 5. FLOATING TOAST NOTIFICATIONS CONTAINER -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 2000;">
        @if(session('success'))
        <div class="toast align-items-center text-bg-success border-0 show shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2 fs-6">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="toast align-items-center text-bg-danger border-0 show shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2 fs-6">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif
    </div>

    <!-- 6. ENHANCED COMMAND PALETTE MODAL (Ctrl + K) -->
    <div class="modal fade cmd-modal" id="cmdPaletteModal" tabindex="-1" aria-labelledby="cmdPaletteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="p-2 border-bottom bg-light d-flex align-items-center gap-2 px-3">
                    <i class="bi bi-search text-muted fs-5"></i>
                    <input type="text" id="cmdInput" class="cmd-search-input bg-light" placeholder="Ketik perintah, nomor surat, atau navigasi cepat..." onkeyup="filterCmdItems()" autofocus>
                    <span class="badge bg-secondary">ESC</span>
                </div>
                <div class="modal-body p-2" style="max-height: 380px; overflow-y: auto;" id="cmdItemsList">
                    <div class="px-3 py-2 text-muted small fw-bold text-uppercase">Pintasan Navigasi</div>
                    <a href="{{ route('dashboard') }}" class="cmd-item-link">
                        <span><i class="bi bi-grid-1x2-fill me-2 text-primary"></i> Menuju ke Dashboard</span>
                        <span class="kbd-shortcut">Beranda</span>
                    </a>
                    <a href="{{ route('surat-masuk.index') }}" class="cmd-item-link">
                        <span><i class="bi bi-inbox-fill me-2 text-info"></i> Buka Daftar Surat Masuk</span>
                        <span class="kbd-shortcut">Inbox</span>
                    </a>
                    <a href="{{ route('surat-masuk.create') }}" class="cmd-item-link">
                        <span><i class="bi bi-plus-circle-fill me-2 text-success"></i> Registrasi Surat Masuk Baru</span>
                        <span class="kbd-shortcut">+ Masuk</span>
                    </a>
                    <a href="{{ route('surat-keluar.index') }}" class="cmd-item-link">
                        <span><i class="bi bi-send-fill me-2 text-primary"></i> Buka Daftar Surat Keluar</span>
                        <span class="kbd-shortcut">Outbox</span>
                    </a>
                    <a href="{{ route('surat-keluar.create') }}" class="cmd-item-link">
                        <span><i class="bi bi-pencil-fill me-2 text-warning"></i> Buat Draft Konsep Surat Keluar</span>
                        <span class="kbd-shortcut">+ Keluar</span>
                    </a>
                    <a href="{{ route('disposisi.index') }}" class="cmd-item-link">
                        <span><i class="bi bi-journal-check me-2 text-primary"></i> Buka Kotak Masuk Disposisi</span>
                        <span class="kbd-shortcut">Disposisi</span>
                    </a>

                    <div class="px-3 py-2 text-muted small fw-bold text-uppercase mt-2">Simulasi Ganti Peran (RBAC)</div>
                    <a href="{{ route('switch.role', 'kepala_bidang') }}" class="cmd-item-link">
                        <span class="d-flex align-items-center"><i class="bi bi-diagram-3-fill text-primary me-2"></i> Beralih Profil: <strong>Kepala Bidang (Kabid)</strong></span>
                        <span class="badge bg-primary">Kabid</span>
                    </a>
                    <a href="{{ route('switch.role', 'kepala_pusat') }}" class="cmd-item-link">
                        <span class="d-flex align-items-center"><i class="bi bi-award-fill text-warning me-2"></i> Beralih Profil: <strong>Kepala Pusat (Kapus)</strong></span>
                        <span class="badge bg-warning text-dark">Kapus</span>
                    </a>
                    <a href="{{ route('switch.role', 'pegawai') }}" class="cmd-item-link">
                        <span class="d-flex align-items-center"><i class="bi bi-person-workspace text-info me-2"></i> Beralih Profil: <strong>Staf Analis (Pegawai)</strong></span>
                        <span class="badge bg-info">Pegawai</span>
                    </a>
                    <a href="{{ route('switch.role', 'admin') }}" class="cmd-item-link">
                        <span class="d-flex align-items-center"><i class="bi bi-shield-lock-fill text-danger me-2"></i> Beralih Profil: <strong>Administrator Persuratan</strong></span>
                        <span class="badge bg-danger">Admin</span>
                    </a>
                </div>
                <div class="modal-footer bg-light py-2 px-3 justify-content-between text-muted small">
                    <span>Gunakan <strong>↑</strong> <strong>↓</strong> untuk memilih, <strong>Enter</strong> untuk buka</span>
                    <span>Pusat Kebijakan Sarana Transportasi</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Global Interactive Script -->
    <script>
        // Theme Toggle System with LocalStorage Persistence
        function updateThemeUI(theme) {
            const isDark = theme === 'dark';
            
            // Update role bar button
            const iconRole = document.getElementById('themeIconRole');
            const textRole = document.getElementById('themeTextRole');
            if (iconRole) {
                iconRole.className = isDark ? 'bi bi-sun-fill text-warning' : 'bi bi-moon-stars-fill text-warning';
            }
            if (textRole) {
                textRole.innerText = isDark ? 'Mode Terang' : 'Mode Gelap';
            }

            // Update topbar icons
            const iconTopbar = document.getElementById('themeIconTopbar');
            if (iconTopbar) {
                iconTopbar.className = isDark ? 'bi bi-sun-fill text-warning' : 'bi bi-moon-stars-fill';
            }
            const iconMobile = document.getElementById('themeIconMobile');
            if (iconMobile) {
                iconMobile.className = isDark ? 'bi bi-sun-fill text-warning' : 'bi bi-moon-stars-fill';
            }
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('esurat_theme', newTheme);
            updateThemeUI(newTheme);

            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: false
            });
            Toast.fire({
                icon: 'info',
                title: newTheme === 'dark' ? 'Mode Gelap diaktifkan' : 'Mode Terang diaktifkan'
            });
        }

        // Initialize UI state based on current document theme
        document.addEventListener('DOMContentLoaded', function() {
            const activeTheme = document.documentElement.getAttribute('data-theme') || 'light';
            updateThemeUI(activeTheme);

            // Init Bootstrap Toasts automatically if present
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            var toastList = toastElList.map(function(toastEl) {
                var toast = new bootstrap.Toast(toastEl, { delay: 4500 });
                toast.show();
                return toast;
            });
        });

        // 1-Click Copy to Clipboard Helper
        function copyToClipboard(text, btnElement) {
            navigator.clipboard.writeText(text).then(function() {
                if (btnElement) {
                    const originalHtml = btnElement.innerHTML;
                    btnElement.classList.add('copied');
                    btnElement.innerHTML = '<i class="bi bi-check-lg text-white me-1"></i> Tersalin!';
                    setTimeout(function() {
                        btnElement.classList.remove('copied');
                        btnElement.innerHTML = originalHtml;
                    }, 2000);
                }
            }).catch(function(err) {
                console.error('Gagal menyalin:', err);
            });
        }

        // Command Palette Keyboard shortcut
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                openCmdPalette();
            }
        });

        let cmdModalInstance = null;
        function openCmdPalette() {
            var modalEl = document.getElementById('cmdPaletteModal');
            if (!cmdModalInstance) {
                cmdModalInstance = new bootstrap.Modal(modalEl);
            }
            cmdModalInstance.show();
            setTimeout(function() {
                var input = document.getElementById('cmdInput');
                if (input) {
                    input.value = '';
                    input.focus();
                    filterCmdItems();
                }
            }, 250);
        }

        function filterCmdItems() {
            const query = document.getElementById('cmdInput').value.toLowerCase();
            const items = document.querySelectorAll('.cmd-item-link');
            items.forEach(item => {
                const text = item.innerText.toLowerCase();
                if (text.includes(query)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>

    @yield('scripts')
</body>
</html>
