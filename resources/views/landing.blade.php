<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Surat PKST - Pusat Kebijakan Sarana Transportasi | Badan Kebijakan Transportasi Kemenhub</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-baketrans.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- SweetAlert2 for Live Modal Alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Theme Initializer (Zero Flash) -->
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

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/kemenhub.css') }}">

    <style>
        :root {
            --brand-navy: #0A2540;
            --brand-navy-dark: #07192C;
            --brand-gold: #F5A623;
            --brand-gold-hover: #E09216;
            --brand-cyan: #0284C7;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #1E293B;
            background-color: #FFFFFF;
            overflow-x: hidden;
        }

        /* 1. PUBLIC NAVBAR */
        .landing-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid #E2E8F0;
            position: sticky;
            top: 0;
            z-index: 1040;
            transition: all 0.3s ease;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        .navbar-brand-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #0A2540;
        }

        .navbar-brand-custom img {
            width: 44px;
            height: auto;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.15));
        }

        .brand-titles h1 {
            font-size: 1.15rem;
            font-weight: 800;
            margin: 0;
            line-height: 1.1;
            letter-spacing: -0.3px;
            color: #0A2540;
        }

        .brand-titles span {
            font-size: 0.7rem;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            display: block;
        }

        .nav-link-custom {
            color: #334155 !important;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 8px 16px !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link-custom:hover {
            color: var(--brand-cyan) !important;
            background: #F1F5F9;
        }

        .landing-toggler {
            color: #0A2540;
        }

        .btn-portal-login {
            background: linear-gradient(135deg, var(--brand-gold) 0%, #D97706 100%);
            color: #0A2540;
            font-weight: 700;
            font-size: 0.88rem;
            padding: 8px 20px;
            border-radius: 9999px;
            border: none;
            box-shadow: 0 4px 14px rgba(245, 166, 35, 0.35);
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-portal-login:hover {
            background: linear-gradient(135deg, #FFB84D 0%, #F5A623 100%);
            color: #0A2540;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 166, 35, 0.45);
        }

        /* 2. HERO SECTION */
        .hero-section {
            background: radial-gradient(circle at 85% 20%, rgba(2, 132, 199, 0.12) 0%, transparent 45%),
                        radial-gradient(circle at 15% 85%, rgba(245, 166, 35, 0.10) 0%, transparent 40%),
                        linear-gradient(145deg, #F8FAFC 0%, #EFF6FF 50%, #E0F2FE 100%);
            color: #0A2540;
            padding: 90px 0 110px;
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid #E2E8F0;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(rgba(10, 37, 64, 0.05) 1px, transparent 1px);
            background-size: 28px 28px;
            opacity: 0.7;
            pointer-events: none;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            background: #EFF6FF;
            border: 1px solid #BAE6FD;
            border-radius: 9999px;
            color: #0284C7;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 24px;
        }

        .hero-title {
            font-size: 2.85rem;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.8px;
            margin-bottom: 20px;
            color: #0A2540;
        }

        .hero-title span {
            color: #D97706;
            text-shadow: none;
        }

        .hero-desc {
            font-size: 1.05rem;
            line-height: 1.7;
            color: #475569;
            margin-bottom: 36px;
        }

        .hero-btn-outline {
            border: 2px solid #0A2540;
            color: #0A2540;
            background: transparent;
            transition: all 0.2s ease;
        }

        .hero-btn-outline:hover {
            background: #0A2540;
            color: #FFFFFF;
        }

        .hero-motto-bar {
            border-top: 1px solid #CBD5E1;
            color: #64748B;
        }

        .hero-motto-bar strong {
            color: #0A2540;
        }

        .hero-card-preview {
            background: linear-gradient(145deg, #0A2540 0%, #07192C 100%);
            border: 1px solid #1E3A5F;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 25px 50px -12px rgba(10, 37, 64, 0.25);
        }

        /* 3. VERIFICATION WIDGET */
        .verify-widget-card {
            background: #FFFFFF;
            border: 1px solid rgba(10, 37, 64, 0.1);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(10, 37, 64, 0.08);
            margin-top: -50px;
            position: relative;
            z-index: 10;
        }

        .stat-highlight-card {
            background: linear-gradient(135deg, #0A2540 0%, #153A60 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 24px 20px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(10, 37, 64, 0.15);
            transition: all 0.3s ease;
        }

        .stat-highlight-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 28px rgba(10, 37, 64, 0.25);
            border-color: var(--brand-gold);
        }

        .stat-number {
            font-size: 2.3rem;
            font-weight: 800;
            color: var(--brand-gold);
            line-height: 1.1;
            margin-bottom: 4px;
        }

        /* 4. FEATURES SECTION */
        .feature-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 28px;
            height: 100%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(10, 37, 64, 0.04);
        }

        .feature-card:hover {
            transform: translateY(-4px);
            border-color: var(--brand-cyan);
            box-shadow: 0 12px 24px rgba(2, 132, 199, 0.12);
        }

        .feature-icon-wrapper {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .icon-blue { background: #E0F2FE; color: #0284C7; }
        .icon-gold { background: #FEF3C7; color: #D97706; }
        .icon-purple { background: #F3E8FF; color: #7E22CE; }
        .icon-green { background: #DCFCE7; color: #16A34A; }

        /* 5. FLOW STEPPER SECTION */
        .flow-step-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 26px 20px;
            text-align: center;
            position: relative;
            height: 100%;
            box-shadow: 0 2px 8px rgba(10, 37, 64, 0.04);
            transition: all 0.3s ease;
        }

        .flow-step-card:hover {
            border-color: var(--brand-gold);
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(245, 166, 35, 0.15);
        }

        .flow-badge {
            width: 44px;
            height: 44px;
            background: var(--brand-navy);
            color: var(--brand-gold);
            font-weight: 800;
            font-size: 1.15rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            border: 3px solid rgba(245, 166, 35, 0.3);
        }

        /* 6. FOOTER - HIGH CONTRAST WCAG AAA COMPLIANT */
        .landing-footer {
            background: #051424;
            color: #FFFFFF;
            padding: 60px 0 25px;
            border-top: 3px solid var(--brand-gold);
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
        }

        .footer-brand img {
            width: 48px;
            height: auto;
            filter: drop-shadow(0 2px 6px rgba(0, 0, 0, 0.5));
        }

        .footer-brand h4 {
            font-size: 1.25rem;
            font-weight: 800;
            margin: 0;
            color: #FFFFFF;
            letter-spacing: -0.3px;
        }

        .footer-subtitle {
            font-size: 0.76rem;
            color: #CBD5E1;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-weight: 600;
        }

        .footer-text {
            color: #CBD5E1;
            font-size: 0.92rem;
            line-height: 1.7;
        }

        .footer-heading {
            color: #FFFFFF;
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: -0.2px;
            margin-bottom: 18px;
            position: relative;
            padding-bottom: 8px;
        }

        .footer-heading::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 32px;
            height: 2px;
            background: var(--brand-gold);
            border-radius: 2px;
        }

        .footer-links a {
            color: #E2E8F0;
            font-size: 0.92rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .footer-links a:hover {
            color: var(--brand-gold);
            transform: translateX(4px);
        }

        .footer-contact-item {
            color: #E2E8F0;
            font-size: 0.92rem;
            line-height: 1.6;
            margin-bottom: 12px;
            display: flex;
            align-items: flex-start;
        }

        .footer-contact-item i {
            font-size: 1.1rem;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .footer-copyright {
            color: #CBD5E1;
            font-size: 0.88rem;
            padding-top: 28px;
            margin-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }

        @media (max-width: 991px) {
            .hero-title {
                font-size: 2.2rem;
            }
            .verify-widget-card {
                margin-top: 20px;
            }
        }

        /* Dynamic Dark Theme Adjustments for Landing Page */
        [data-theme="dark"] body {
            background-color: #07192C;
            color: #F8FAFC;
        }

        [data-theme="dark"] .landing-navbar {
            background: rgba(7, 25, 44, 0.95) !important;
            border-bottom-color: var(--border-color) !important;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.3) !important;
        }

        [data-theme="dark"] .navbar-brand-custom {
            color: #FFFFFF !important;
        }

        [data-theme="dark"] .brand-titles h1 {
            color: #FFFFFF !important;
        }

        [data-theme="dark"] .brand-titles span {
            color: #CBD5E1 !important;
        }

        [data-theme="dark"] .nav-link-custom {
            color: #E2E8F0 !important;
        }

        [data-theme="dark"] .nav-link-custom:hover {
            color: var(--brand-gold) !important;
            background: rgba(255, 255, 255, 0.06) !important;
        }

        [data-theme="dark"] .landing-toggler {
            color: #FFFFFF !important;
        }

        [data-theme="dark"] .hero-section {
            background: radial-gradient(circle at 80% 20%, rgba(2, 132, 199, 0.25) 0%, transparent 50%),
                        radial-gradient(circle at 10% 80%, rgba(245, 166, 35, 0.15) 0%, transparent 40%),
                        linear-gradient(145deg, #07192C 0%, #0A2540 60%, #0F3863 100%) !important;
            color: #FFFFFF !important;
            border-bottom-color: #1E3A5F !important;
        }

        [data-theme="dark"] .hero-section::before {
            background: radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px) !important;
        }

        [data-theme="dark"] .hero-badge {
            background: rgba(245, 166, 35, 0.15) !important;
            border-color: rgba(245, 166, 35, 0.4) !important;
            color: var(--brand-gold) !important;
        }

        [data-theme="dark"] .hero-title {
            color: #FFFFFF !important;
        }

        [data-theme="dark"] .hero-title span {
            color: var(--brand-gold) !important;
            text-shadow: 0 0 25px rgba(245, 166, 35, 0.4) !important;
        }

        [data-theme="dark"] .hero-desc {
            color: #CBD5E1 !important;
        }

        [data-theme="dark"] .hero-btn-outline {
            border-color: rgba(255, 255, 255, 0.4) !important;
            color: #FFFFFF !important;
        }

        [data-theme="dark"] .hero-btn-outline:hover {
            background: rgba(255, 255, 255, 0.15) !important;
            border-color: #FFFFFF !important;
        }

        [data-theme="dark"] .hero-motto-bar {
            border-top-color: rgba(255, 255, 255, 0.1) !important;
            color: #94A3B8 !important;
        }

        [data-theme="dark"] .hero-motto-bar strong {
            color: #FFFFFF !important;
        }

        [data-theme="dark"] .hero-card-preview {
            background: rgba(255, 255, 255, 0.07) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
        }

        [data-theme="dark"] .feature-card,
        [data-theme="dark"] .flow-step-card {
            background: #0D2847;
            border-color: #1E3A5F;
            color: #F8FAFC;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4);
        }

        [data-theme="dark"] .feature-card h3,
        [data-theme="dark"] .flow-step-card h3,
        [data-theme="dark"] .feature-card h4,
        [data-theme="dark"] .flow-step-card h4 {
            color: #FFFFFF !important;
        }

        [data-theme="dark"] .feature-card p,
        [data-theme="dark"] .flow-step-card p {
            color: #94A3B8 !important;
        }

        [data-theme="dark"] .icon-blue { background: rgba(2, 132, 199, 0.2); color: #38BDF8; }
        [data-theme="dark"] .icon-gold { background: rgba(245, 166, 35, 0.2); color: #FBBF24; }
        [data-theme="dark"] .icon-purple { background: rgba(168, 85, 247, 0.2); color: #C084FC; }
        [data-theme="dark"] .icon-green { background: rgba(16, 185, 129, 0.2); color: #34D399; }

        [data-theme="dark"] .verify-widget-card {
            background: #0D2847;
            border-color: #1E3A5F;
        }

        [data-theme="dark"] #layanan,
        [data-theme="dark"] #tentang {
            background-color: #07192C !important;
        }

        [data-theme="dark"] .lead.text-muted {
            color: #94A3B8 !important;
        }
    </style>
</head>
<body>
    <!-- Accessibility: Skip Link -->
    <a href="#beranda" class="skip-to-content">Lewati ke Konten Utama</a>

    <!-- 1. PUBLIC TOP NAVIGATION -->
    <nav class="navbar navbar-expand-lg landing-navbar py-3">
        <div class="container">
            <a class="navbar-brand-custom" href="{{ route('landing') }}">
                <img src="{{ asset('images/logo-baketrans.png') }}" alt="Logo Badan Kebijakan Transportasi">
                <div class="brand-titles">
                    <h1>E-SURAT PKST</h1>
                    <span>Badan Kebijakan Transportasi &bull; Kemenhub RI</span>
                </div>
            </a>

            <button class="navbar-toggler border-0 landing-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-2"></i>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <ul class="navbar-nav align-items-lg-center gap-1 my-3 my-lg-0">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#layanan">Layanan Persuratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#alur">Alur Birokrasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#verifikasi">Cek Dokumen & TTE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#tentang">Tentang PKST</a>
                    </li>
                </ul>

                <div class="ms-lg-3 mt-3 mt-lg-0 d-flex align-items-center gap-2">
                    <!-- Dark Mode Toggle Button -->
                    <button type="button" class="btn-theme-toggle" onclick="toggleLandingTheme()" id="landingThemeBtn" title="Beralih Mode Gelap/Terang">
                        <i class="bi bi-moon-stars-fill text-warning" id="landingThemeIcon"></i>
                        <span id="landingThemeText" class="d-none d-sm-inline">Mode Gelap</span>
                    </button>

                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-portal-login">
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard ({{ auth()->user()->role_label }})</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-portal-login">
                            <i class="bi bi-box-arrow-in-right"></i>
                            <span>Masuk Sistem Pegawai</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. HERO SECTION -->
    <header class="hero-section" id="beranda">
        <div class="container position-relative">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <div class="hero-badge">
                        <i class="bi bi-patch-check-fill"></i>
                        <span>Sistem Persuratan & Disposisi Elektronik</span>
                    </div>

                    <h1 class="hero-title">
                        Tata Kelola Naskah Dinas yang <span>Cepat, Akurat, & Bermanfaat</span>
                    </h1>

                    <p class="hero-desc">
                        Aplikasi persuratan digital terintegrasi untuk internal pegawai <strong>Pusat Kebijakan Sarana Transportasi</strong>, Badan Kebijakan Transportasi, Kementerian Perhubungan Republik Indonesia. Mendukung alur disposisi berjenjang, paraf koordinasi, dan Tanda Tangan Elektronik (TTE) tersertifikasi BSrE.
                    </p>

                    <div class="d-flex flex-wrap gap-3 align-items-center">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-warning btn-lg px-4 py-3 fw-bold rounded-pill text-dark shadow-lg">
                                <i class="bi bi-speedometer2 me-2"></i> Ke Dashboard Saya &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-warning btn-lg px-4 py-3 fw-bold rounded-pill text-dark shadow-lg">
                                <i class="bi bi-shield-lock-fill me-2"></i> Masuk Sistem Persuratan
                            </a>
                        @endauth

                        <a href="#verifikasi" class="btn hero-btn-outline btn-lg px-4 py-3 rounded-pill fw-semibold">
                            <i class="bi bi-qr-code-scan me-2"></i> Verifikasi TTE Naskah
                        </a>
                    </div>

                    <!-- Motto Baketrans Info -->
                    <div class="d-flex align-items-center gap-3 mt-4 pt-3 hero-motto-bar small">
                        <div><strong>Motto Pelayanan:</strong> Cepat &bull; Akurat &bull; Bermanfaat</div>
                        <div>&bull;</div>
                        <div>Unit Kerja PKST BKT</div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <!-- Glassmorphism Live Letter Flow Preview -->
                    <div class="hero-card-preview">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom border-white border-opacity-15">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset('images/logo-baketrans.png') }}" alt="Logo" style="width: 28px; height: auto;">
                                <span class="fw-bold small text-white">Naskah Dinas Terverifikasi</span>
                            </div>
                            <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25 px-2 py-1 small">
                                <i class="bi bi-shield-check"></i> BSrE Valid
                            </span>
                        </div>

                        <div class="bg-black bg-opacity-25 p-3 rounded-3 mb-3 border border-white border-opacity-10">
                            <div class="text-white-50" style="font-size: 0.72rem; text-transform: uppercase;">Nomor Naskah Resmi:</div>
                            <div class="fw-bold text-warning font-monospace fs-6">PR.102/001/PKST-BKT/2026</div>
                            <div class="text-light small mt-1">Usulan Kebijakan Modernisasi Sarana Kereta Cepat Jakarta-Surabaya</div>
                        </div>

                        <!-- Stepper Mockup inside Card -->
                        <div class="small text-white-50 mb-2" style="font-size: 0.72rem;">STATUS ALUR PERSETUJUAN:</div>
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex align-items-center gap-2 bg-white bg-opacity-10 p-2 rounded">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <div class="small flex-grow-1 text-white">Konseptor (Staf Analis)</div>
                                <span class="badge bg-light text-dark small" style="font-size: 0.65rem;">Konsep Diajukan</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 bg-white bg-opacity-10 p-2 rounded">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <div class="small flex-grow-1 text-white">Paraf Koordinasi (Kepala Bidang)</div>
                                <span class="badge bg-info text-white small" style="font-size: 0.65rem;">Diparaf</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 bg-warning bg-opacity-20 p-2 rounded border border-warning border-opacity-30">
                                <i class="bi bi-patch-check-fill text-warning"></i>
                                <div class="small flex-grow-1 text-white fw-bold">Pengesahan TTE (Kepala Pusat)</div>
                                <span class="badge bg-warning text-dark small" style="font-size: 0.65rem;">TTE Sah</span>
                            </div>
                        </div>

                        <div class="mt-3 pt-3 border-top border-white border-opacity-15 d-flex align-items-center justify-content-between">
                            <div class="text-white-50" style="font-size: 0.72rem;">
                                Token: <span class="font-monospace text-warning">{{ $sampleToken }}</span>
                            </div>
                            <a href="{{ route('verifikasi.tte', $sampleToken) }}" class="small text-decoration-none text-info fw-bold">
                                Uji Pratinjau TTE &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- 3. QUICK VERIFICATION WIDGET -->
    <section class="container" id="verifikasi">
        <div class="verify-widget-card">
            <div class="row align-items-center g-3">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="feature-icon-wrapper icon-blue m-0 flex-shrink-0">
                            <i class="bi bi-qr-code-scan"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1" style="color: var(--brand-navy);">Lacak & Validasi Naskah Dinas</h5>
                            <p class="text-muted small m-0">Verifikasi instan keaslian tanda tangan digital BSrE naskah dinas resmi PKST.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <form id="verifyForm" onsubmit="handleVerifySubmit(event)">
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-shield-lock text-muted"></i>
                                </span>
                                <input type="text" id="tokenInput" class="form-control form-control-lg border-start-0 font-monospace" placeholder="Masukkan Token Sertifikat (contoh: {{ $sampleToken }})" value="{{ $sampleToken }}" required>
                            </div>
                            <button type="submit" id="verifyBtn" class="btn btn-primary px-4 fw-bold text-nowrap d-flex align-items-center justify-content-center gap-2" style="background: var(--brand-navy); border-color: var(--brand-navy);">
                                <span class="spinner-border spinner-border-sm d-none" id="verifySpinner" role="status" aria-hidden="true"></span>
                                <i class="bi bi-search" id="verifyIcon"></i>
                                <span id="verifyBtnText">Cek Sertifikat</span>
                            </button>
                        </div>
                        <div class="mt-2 d-flex align-items-center gap-2 flex-wrap">
                            <span class="small text-muted" style="font-size: 0.78rem;">Uji Cepat:</span>
                            <button type="button" class="btn btn-sm btn-outline-warning py-0 px-2 rounded-pill font-monospace" style="font-size: 0.75rem;" onclick="useDemoToken('{{ $sampleToken }}')" title="Gunakan Token Demo Valid">
                                <i class="bi bi-lightning-charge-fill me-1"></i> Token Aktif: {{ $sampleToken }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. LIVE METRICS COUNTER -->
    <section class="py-5 my-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-lg-3">
                    <div class="stat-highlight-card">
                        <div class="stat-number">{{ $totalSuratMasuk }}</div>
                        <div class="fw-bold text-white small">Surat Masuk Tercatat</div>
                        <div class="text-white-50" style="font-size: 0.72rem;">Agenda Naskah Masuk Unit Kerja</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-highlight-card">
                        <div class="stat-number">{{ $totalSuratKeluar }}</div>
                        <div class="fw-bold text-white small">Surat Keluar Diterbitkan</div>
                        <div class="text-white-50" style="font-size: 0.72rem;">Dengan Format Penomoran Baku</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-highlight-card">
                        <div class="stat-number">{{ $totalDisposisi }}</div>
                        <div class="fw-bold text-white small">Alur Disposisi Aktif</div>
                        <div class="text-white-50" style="font-size: 0.72rem;">Pemantauan SLA Berjenjang</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-highlight-card">
                        <div class="stat-number">100%</div>
                        <div class="fw-bold text-white small">TTE Sah BSrE</div>
                        <div class="text-white-50" style="font-size: 0.72rem;">Sertifikasi Resmi Digital</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. FITUR UNGGULAN SISTEM -->
    <section class="py-5 bg-light" id="layanan">
        <div class="container py-4">
            <div class="text-center max-w-700 mx-auto mb-5">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">
                    Layanan & Modul Utama
                </span>
                <h2 class="fw-bold" style="color: var(--brand-navy);">Standar Persuratan Digital Modern PKST</h2>
                <p class="text-muted">
                    Dirancang sesuai tata kelola naskah dinas Kementerian Perhubungan RI dengan kemudahan penggunaan bagi seluruh jajaran pegawai.
                </p>
            </div>

            <div class="row g-4">
                <!-- Fitur 1 -->
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper icon-blue">
                            <i class="bi bi-inbox-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Registrasi Surat Masuk</h5>
                        <p class="text-muted small mb-0">
                            Pencatatan surat masuk otomatis dengan sistem nomor agenda, klasifikasi sifat surat (Biasa, Penting, Rahasia), dan pengunggahan berkas digital.
                        </p>
                    </div>
                </div>

                <!-- Fitur 2 -->
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper icon-gold">
                            <i class="bi bi-journal-arrow-down"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Disposisi Pimpinan & SLA</h5>
                        <p class="text-muted small mb-0">
                            Instruksi langsung dari Kepala Pusat dan Kepala Bidang kepada Staf Analis dengan target waktu penyelesaian (SLA) dan lembar disposisi siap cetak.
                        </p>
                    </div>
                </div>

                <!-- Fitur 3 -->
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper icon-purple">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Paraf Koordinasi Kabid</h5>
                        <p class="text-muted small mb-0">
                            Pemeriksaan naskah dinas sebelum penandatanganan melalui paraf koordinasi elektronik Kepala Bidang untuk akuntabilitas isi telaahan.
                        </p>
                    </div>
                </div>

                <!-- Fitur 4 -->
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper icon-green">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-2">TTE Kepala Pusat & QR Code</h5>
                        <p class="text-muted small mb-0">
                            Pengesahan dokumen resmi oleh Kepala Pusat Kebijakan Sarana Transportasi dengan TTE digital dan QR Code sertifikasi Balai Sertifikasi Elektronik (BSrE).
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. ALUR BIROKRASI PERSURATAN (INTERACTIVE STEPPER SIMULATOR) -->
    <section class="py-5" id="alur">
        <div class="container py-4">
            <div class="text-center max-w-700 mx-auto mb-4">
                <span class="badge bg-warning bg-opacity-25 text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">
                    <i class="bi bi-diagram-3-fill me-1"></i> Simulator Alur Interaktif
                </span>
                <h2 class="fw-bold" style="color: var(--brand-navy);">Mekanisme Persuratan Berjenjang & Digital TTE</h2>
                <p class="text-muted">
                    Klik setiap tahapan di bawah ini untuk melihat simulasi proses verifikasi, wewenang aparatur, dan pengesahan dokumen.
                </p>
            </div>

            <!-- Stepper Interactive Container -->
            <div class="sim-stepper-container">
                <!-- Nav Step Buttons -->
                <div class="d-flex flex-column flex-md-row gap-2 gap-md-3 mb-4" id="simNavGroup">
                    <button type="button" class="sim-nav-btn active" id="simNavBtn1" onclick="selectSimStep(1)">
                        <div class="sim-step-badge">1</div>
                        <div class="fw-bold" style="font-size: 0.95rem;">1. Konsep & Telaah</div>
                        <div class="text-muted small" style="font-size: 0.76rem;">Staf Analis Kebijakan</div>
                    </button>
                    <button type="button" class="sim-nav-btn" id="simNavBtn2" onclick="selectSimStep(2)">
                        <div class="sim-step-badge">2</div>
                        <div class="fw-bold" style="font-size: 0.95rem;">2. Paraf Koordinasi</div>
                        <div class="text-muted small" style="font-size: 0.76rem;">Kepala Bidang (Kabid)</div>
                    </button>
                    <button type="button" class="sim-nav-btn" id="simNavBtn3" onclick="selectSimStep(3)">
                        <div class="sim-step-badge">3</div>
                        <div class="fw-bold" style="font-size: 0.95rem;">3. Pengesahan TTE</div>
                        <div class="text-muted small" style="font-size: 0.76rem;">Kepala Pusat (Kapus)</div>
                    </button>
                    <button type="button" class="sim-nav-btn" id="simNavBtn4" onclick="selectSimStep(4)">
                        <div class="sim-step-badge">4</div>
                        <div class="fw-bold" style="font-size: 0.95rem;">4. Terbit & Validasi QR</div>
                        <div class="text-muted small" style="font-size: 0.76rem;">Distribusi & BSrE Valid</div>
                    </button>
                </div>

                <!-- Active Step Dynamic Content Box -->
                <div class="sim-preview-box" id="simContentBox">
                    <!-- Dynamic Content Injected via selectSimStep(n) -->
                </div>

                <!-- Simulation Footer Controls -->
                <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary btn-sm px-3" id="simPrevBtn" onclick="stepPrev()" disabled>
                        <i class="bi bi-chevron-left me-1"></i> Tahap Sebelumnya
                    </button>
                    <div class="small text-muted fw-bold" id="simStepCounter">
                        Tahap <span id="currentStepNum">1</span> dari 4
                    </div>
                    <button type="button" class="btn btn-primary btn-sm px-3" id="simNextBtn" onclick="stepNext()" style="background: var(--brand-navy); border-color: var(--brand-navy);">
                        Tahap Selanjutnya <i class="bi bi-chevron-right ms-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. TENTANG PUSAT KEBIJAKAN SARANA TRANSPORTASI -->
    <section class="py-5 bg-light" id="tentang">
        <div class="container py-4">
            <div class="row align-items-center g-5">
                <div class="col-lg-5 text-center">
                    <img src="{{ asset('images/logo-baketrans.png') }}" alt="Logo Baketrans" style="max-width: 240px; height: auto; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.15));">
                </div>
                <div class="col-lg-7">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">
                        Profil Satuan Kerja
                    </span>
                    <h2 class="fw-bold mb-3" style="color: var(--brand-navy);">Pusat Kebijakan Sarana Transportasi (PKST)</h2>
                    <p class="text-muted" style="line-height: 1.7;">
                        Pusat Kebijakan Sarana Transportasi merupakan salah satu unit kerja eselon II di bawah <strong>Badan Kebijakan Transportasi (BKT)</strong>, Kementerian Perhubungan Republik Indonesia. Bertugas merumuskan rekomendasi kebijakan teknis, analitis, dan strategis di bidang sarana transportasi darat, perkeretaapian, laut, dan udara secara menyeluruh.
                    </p>
                    <p class="text-muted" style="line-height: 1.7;">
                        Implementasi <strong>E-Surat PKST</strong> merupakan wujud transformasi digital birokrasi pemerintahan (SPBE) untuk menghadirkan layanan persuratan yang akuntabel, efisien, nir-kertas (*paperless*), dan berkepastian hukum.
                    </p>
                    <div class="d-flex gap-3 mt-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 py-2 fw-bold" style="background: var(--brand-navy); border-color: var(--brand-navy);">
                                Buka Dashboard Persuratan &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2 fw-bold" style="background: var(--brand-navy); border-color: var(--brand-navy);">
                                Masuk ke Portal Pegawai &rarr;
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. FOOTER -->
    <footer class="landing-footer">
        <div class="container">
            <div class="row g-4 mb-2">
                <div class="col-lg-5">
                    <div class="footer-brand">
                        <img src="{{ asset('images/logo-baketrans.png') }}" alt="Logo Badan Kebijakan Transportasi">
                        <div>
                            <h4>E-SURAT PKST</h4>
                            <span class="footer-subtitle">Badan Kebijakan Transportasi &bull; Kemenhub RI</span>
                        </div>
                    </div>
                    <p class="pe-lg-4 footer-text">
                        Sistem Informasi Tata Persuratan, Naskah Dinas Keluar, dan Alur Disposisi Elektronik Internal Pusat Kebijakan Sarana Transportasi, Kementerian Perhubungan Republik Indonesia.
                    </p>
                </div>

                <div class="col-6 col-lg-3 footer-links">
                    <h6 class="footer-heading">Tautan Terkait</h6>
                    <div><a href="https://dephub.go.id" target="_blank"><i class="bi bi-box-arrow-up-right me-2 text-warning"></i> Kementerian Perhubungan</a></div>
                    <div><a href="https://baketrans.dephub.go.id" target="_blank"><i class="bi bi-box-arrow-up-right me-2 text-warning"></i> Badan Kebijakan Transportasi</a></div>
                    <div><a href="https://bsre.bssn.go.id" target="_blank"><i class="bi bi-shield-check me-2 text-warning"></i> Balai Sertifikasi Elektronik (BSrE)</a></div>
                </div>

                <div class="col-6 col-lg-4">
                    <h6 class="footer-heading">Alamat & Kontak Satker</h6>
                    <div class="footer-contact-item">
                        <i class="bi bi-geo-alt-fill text-warning me-2"></i>
                        <span>Jl. Medan Merdeka Timur No. 5, Gambir, Jakarta Pusat, DKI Jakarta 10110</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-telephone-fill text-warning me-2"></i>
                        <span>(021) 3847519 / 3811308</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-envelope-fill text-warning me-2"></i>
                        <span>bkt@dephub.go.id | pkst@dephub.go.id</span>
                    </div>
                </div>
            </div>

            <div class="footer-copyright text-center">
                &copy; {{ date('Y') }} <strong>Pusat Kebijakan Sarana Transportasi</strong> &mdash; Badan Kebijakan Transportasi, Kementerian Perhubungan Republik Indonesia. Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

    <!-- LIVE VERIFICATION RESULT MODAL -->
    <div class="modal fade" id="liveVerifyModal" tabindex="-1" aria-labelledby="liveVerifyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #07192C 0%, #0A2540 100%); border-bottom: 2px solid var(--brand-gold);">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('images/logo-baketrans.png') }}" alt="Logo" style="width: 32px; height: auto;">
                        <div>
                            <h5 class="modal-title fs-6 fw-bold m-0" id="liveVerifyModalLabel">Hasil Verifikasi Keaslian Naskah Dinas</h5>
                            <span style="font-size: 0.7rem; color: #CBD5E1;">Balai Sertifikasi Elektronik (BSrE) &bull; BKT Kemenhub</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Status Banner -->
                    <div class="p-3 rounded-3 mb-4 d-flex align-items-center gap-3" style="background: #ECFDF5; border: 1px solid #A7F3D0;">
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: #10B981; color: #FFFFFF; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-success" style="font-size: 1.05rem;">TANDA TANGAN ELEKTRONIK SAH & RESMI</div>
                            <div class="small text-muted">Dokumen terdaftar resmi dalam pangkalan data Badan Kebijakan Transportasi Kemenhub RI dan tersertifikasi BSrE.</div>
                        </div>
                    </div>

                    <!-- Details Table Grid -->
                    <div class="row g-3 small">
                        <div class="col-sm-6">
                            <div class="text-muted" style="font-size: 0.75rem;">NOMOR NASKAH DINAS</div>
                            <div class="fw-bold font-monospace fs-6 text-dark" id="modalNoSurat">-</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted" style="font-size: 0.75rem;">TANGGAL PENGESAHAN TTE</div>
                            <div class="fw-bold text-dark" id="modalTanggalTTE">-</div>
                        </div>
                        <div class="col-12">
                            <div class="text-muted" style="font-size: 0.75rem;">PERIHAL NASKAH</div>
                            <div class="fw-semibold text-dark fs-6" id="modalPerihal">-</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted" style="font-size: 0.75rem;">TUJUAN SURAT</div>
                            <div class="fw-bold text-primary" id="modalTujuan">-</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted" style="font-size: 0.75rem;">SIFAT / KLASIFIKASI</div>
                            <div>
                                <span class="badge bg-secondary" id="modalSifat">-</span>
                                <span class="badge bg-light text-dark border font-monospace" id="modalKlasifikasi">-</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr class="my-2">
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted" style="font-size: 0.75rem;">PEJABAT PENANDATANGAN</div>
                            <div class="fw-bold text-dark" id="modalPenandatangan">-</div>
                            <div class="text-muted small" id="modalJabatan">-</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted" style="font-size: 0.75rem;">INTEGRITAS PARAF KOORDINASI</div>
                            <div class="text-success small fw-semibold" id="modalParafInfo">
                                <i class="bi bi-check-circle-fill me-1"></i> Telah Diparaf Kepala Bidang
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-2 bg-light rounded border font-monospace text-break" style="font-size: 0.72rem;">
                                <div class="text-muted mb-1">DIGEST HASH SHA-256 BSrE:</div>
                                <span class="text-secondary" id="modalHash">-</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3 justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
                    <div class="d-flex gap-2">
                        <a href="#" id="modalPdfBtn" target="_blank" class="btn btn-outline-danger btn-sm px-3">
                            <i class="bi bi-file-earmark-pdf me-1"></i> Pratinjau Naskah PDF
                        </a>
                        <a href="#" id="modalPublicLink" target="_blank" class="btn btn-primary btn-sm px-3 fw-bold" style="background: var(--brand-navy); border-color: var(--brand-navy);">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Halaman Publik &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Theme Management for Landing
        function updateLandingThemeUI(theme) {
            const isDark = theme === 'dark';
            const icon = document.getElementById('landingThemeIcon');
            const text = document.getElementById('landingThemeText');
            if (icon) {
                icon.className = isDark ? 'bi bi-sun-fill text-warning' : 'bi bi-moon-stars-fill text-warning';
            }
            if (text) {
                text.innerText = isDark ? 'Mode Terang' : 'Mode Gelap';
            }
        }

        function toggleLandingTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('esurat_theme', newTheme);
            updateLandingThemeUI(newTheme);
        }

        // Live AJAX Token Verification
        let verifyModalInstance = null;

        function handleVerifySubmit(e) {
            e.preventDefault();
            const token = document.getElementById('tokenInput').value.trim();
            if (token) {
                checkLiveToken(token);
            }
        }

        function useDemoToken(token) {
            document.getElementById('tokenInput').value = token;
            checkLiveToken(token);
        }

        function checkLiveToken(token) {
            const btn = document.getElementById('verifyBtn');
            const spinner = document.getElementById('verifySpinner');
            const icon = document.getElementById('verifyIcon');
            const text = document.getElementById('verifyBtnText');

            // UI Loading state
            if (btn) btn.disabled = true;
            if (spinner) spinner.classList.remove('d-none');
            if (icon) icon.classList.add('d-none');
            if (text) text.innerText = 'Memeriksa...';

            fetch('{{ url("/api/verifikasi") }}/' + encodeURIComponent(token))
                .then(response => response.json())
                .then(data => {
                    // Reset button state
                    if (btn) btn.disabled = false;
                    if (spinner) spinner.classList.add('d-none');
                    if (icon) icon.classList.remove('d-none');
                    if (text) text.innerText = 'Cek Sertifikat';

                    if (data.valid || data.success) {
                        const s = data.surat || data;
                        document.getElementById('modalNoSurat').innerText = s.no_surat || '-';
                        document.getElementById('modalTanggalTTE').innerText = (s.penandatangan && s.penandatangan.timestamp) ? s.penandatangan.timestamp : (s.tanggal_tte || '-');
                        document.getElementById('modalPerihal').innerText = s.perihal || '-';
                        document.getElementById('modalTujuan').innerText = s.tujuan || '-';
                        document.getElementById('modalSifat').innerText = s.sifat_surat || s.sifat || '-';
                        document.getElementById('modalKlasifikasi').innerText = s.klasifikasi || 'PR.102';
                        if (s.penandatangan) {
                            document.getElementById('modalPenandatangan').innerText = s.penandatangan.nama || '-';
                            document.getElementById('modalJabatan').innerText = (s.penandatangan.jabatan || '') + (s.penandatangan.nip ? ' (NIP. ' + s.penandatangan.nip + ')' : '');
                        }
                        document.getElementById('modalHash').innerText = s.integritas_sha256 || (data.sertifikat && data.sertifikat.sha256_digest) || '-';
                        
                        document.getElementById('modalPdfBtn').href = s.preview_url || ('{{ url("/surat-keluar/preview") }}/' + (s.id || '2'));
                        document.getElementById('modalPublicLink').href = s.verify_page_url || ('{{ url("/verifikasi") }}/' + encodeURIComponent(token));

                        if (!verifyModalInstance) {
                            verifyModalInstance = new bootstrap.Modal(document.getElementById('liveVerifyModal'));
                        }
                        verifyModalInstance.show();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Token Tidak Ditemukan',
                            text: data.message || 'Token tanda tangan elektronik tidak terdaftar dalam pangkalan data resmi BKT PKST.',
                            confirmButtonColor: '#0A2540',
                            confirmButtonText: 'Tutup'
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    if (btn) btn.disabled = false;
                    if (spinner) spinner.classList.add('d-none');
                    if (icon) icon.classList.remove('d-none');
                    if (text) text.innerText = 'Cek Sertifikat';

                    Swal.fire({
                        icon: 'error',
                        title: 'Koneksi Bermasalah',
                        text: 'Terjadi kendala jaringan saat menghubungi server verifikasi BSrE.',
                        confirmButtonColor: '#0A2540'
                    });
                });
        }

        // Stepper Simulator Logic
        let currentStep = 1;
        const stepsData = {
            1: {
                title: 'Penyusunan Konsep & Naskah Dinas',
                role: 'Staf Analis Kebijakan (Konseptor)',
                roleBadge: 'Konseptor &bull; Eselon IV/Fungsional',
                sla: 'Estimasi: < 4 Jam Kerja',
                badgeColor: 'primary',
                desc: 'Konseptor menyusun draf naskah dinas keluar, melampirkan kajian telaah teknis sarana transportasi darat, kereta api, laut, atau udara, dan memilih kode klasifikasi arsip.',
                mockHeader: 'Form Penyusunan Konsep Naskah Dinas',
                mockDetails: [
                    { label: 'Kode Klasifikasi', val: 'PR.102 (Penyusunan Rekomendasi Sarana)' },
                    { label: 'Sifat Surat', val: 'Segera' },
                    { label: 'Tujuan Instansi', val: 'Sekretariat Jenderal Kementerian Perhubungan' },
                    { label: 'Dokumen Pendukung', val: 'Kajian_Teknis_Sarana_Kereta_2026.pdf (1.8 MB)' }
                ],
                mockActionText: 'Ajukan Paraf Koordinasi ke Kepala Bidang &rarr;'
            },
            2: {
                title: 'Pemeriksaan & Paraf Koordinasi Elektronik',
                role: 'Kepala Bidang (Kabid)',
                roleBadge: 'Pemeriksa Teknis &bull; Eselon III',
                sla: 'Estimasi: < 2 Jam Kerja',
                badgeColor: 'info',
                desc: 'Kepala Bidang meneliti substansi, konsistensi regulasi, dan akurasi naskah. Jika telah memenuhi standar, Kabid membubuhkan paraf koordinasi digital berenkripsi.',
                mockHeader: 'Panel Telaah & Paraf Koordinasi Kabid',
                mockDetails: [
                    { label: 'Catatan Pemeriksaan', val: 'Telah diteliti secara teknis dan materi kebijakan telah siap disahkan Kepala Pusat.' },
                    { label: 'Status Telaah', val: 'Lengkap & Memenuhi Pedoman Tata Naskah Kemenhub' },
                    { label: 'Status Paraf', val: 'Sah Diparaf Secara Elektronik' }
                ],
                mockActionText: 'Teruskan Naskah ke Kepala Pusat (Kapus) &rarr;'
            },
            3: {
                title: 'Pengesahan Tanda Tangan Elektronik (TTE BSrE)',
                role: 'Kepala Pusat Kebijakan Sarana Transportasi (Kapus)',
                roleBadge: 'Otoritas Pengesahan &bull; Eselon II',
                sla: 'Estimasi: Real-Time (< 1 Jam)',
                badgeColor: 'danger',
                desc: 'Kepala Pusat memvalidasi pengesahan akhir menggunakan Tanda Tangan Elektronik (TTE) tersertifikasi Balai Sertifikasi Elektronik (BSrE) BSSN Republik Indonesia.',
                mockHeader: 'Otorisasi Pengesahan TTE Digital Kepala Pusat',
                mockDetails: [
                    { label: 'Sertifikat TTE', val: 'BSrE BSSN RI Terakreditasi' },
                    { label: 'Otorisator', val: 'Kepala Pusat Kebijakan Sarana Transportasi' },
                    { label: 'Integritas Naskah', val: 'SHA-256 Hash Digest Valid & Tersegel Kriptografis' }
                ],
                mockActionText: 'Sahkan Naskah Dinas & Terbitkan QR Code &rarr;'
            },
            4: {
                title: 'Distribusi Resmi & Validasi Publik QR Code',
                role: 'Petugas Arsip & Pihak Eksternal',
                roleBadge: 'Distribusi & Verifikasi Publik',
                sla: 'Status: Terbit & Terdistribusi',
                badgeColor: 'success',
                desc: 'Naskah dinas resmi diterbitkan dengan nomor resmi baku dan QR Code validasi keaslian. Siapapun penerima surat dapat memindai QR Code untuk memeriksa keaslian dokumen.',
                mockHeader: 'Penerbitan Nomor Resmi & Verifikasi Publik',
                mockDetails: [
                    { label: 'Nomor Naskah Resmi', val: 'PR.102/001/PKST-BKT/2026' },
                    { label: 'Token BSrE', val: '{{ $sampleToken }}' },
                    { label: 'Akses Verifikasi', val: 'Dapat divalidasi publik 24/7 di e-surat.dephub.go.id/verifikasi' }
                ],
                mockActionText: 'Uji Verifikasi Token Sekarang &rarr;'
            }
        };

        function selectSimStep(step) {
            currentStep = step;
            const data = stepsData[step];

            // Update nav buttons
            for (let i = 1; i <= 4; i++) {
                const btn = document.getElementById('simNavBtn' + i);
                if (btn) {
                    if (i === step) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                }
            }

            // Update counter & controls
            document.getElementById('currentStepNum').innerText = step;
            document.getElementById('simPrevBtn').disabled = (step === 1);
            document.getElementById('simNextBtn').disabled = (step === 4);

            // Render Dynamic Box
            let detailsHtml = '';
            data.mockDetails.forEach(d => {
                detailsHtml += `
                    <div class="col-sm-6">
                        <div class="text-muted" style="font-size: 0.72rem; text-transform: uppercase;">${d.label}</div>
                        <div class="fw-bold small text-dark">${d.val}</div>
                    </div>
                `;
            });

            const contentHtml = `
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3 pb-3 border-bottom">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-${data.badgeColor}">${data.roleBadge}</span>
                            <span class="badge bg-light text-dark border">${data.sla}</span>
                        </div>
                        <h4 class="fs-5 fw-bold m-0" style="color: var(--brand-navy);">${data.title}</h4>
                    </div>
                    <div class="text-muted small fw-semibold">
                        Aktor: <strong class="text-primary">${data.role}</strong>
                    </div>
                </div>

                <p class="small text-muted mb-4" style="line-height: 1.7;">${data.desc}</p>

                <div class="p-3 bg-white rounded-3 border shadow-sm mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <div class="small fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-laptop text-primary"></i> ${data.mockHeader}
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25" style="font-size: 0.7rem;">
                            <i class="bi bi-check-circle-fill me-1"></i> Sistem Aktif
                        </span>
                    </div>
                    <div class="row g-3">
                        ${detailsHtml}
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-sm btn-kemenhub px-3" onclick="${step === 4 ? "useDemoToken('{{ $sampleToken }}')" : "selectSimStep(" + (step + 1) + ")"}">
                        ${data.mockActionText}
                    </button>
                </div>
            `;

            const box = document.getElementById('simContentBox');
            box.style.opacity = '0';
            setTimeout(() => {
                box.innerHTML = contentHtml;
                box.style.opacity = '1';
            }, 120);
        }

        function stepPrev() {
            if (currentStep > 1) selectSimStep(currentStep - 1);
        }

        function stepNext() {
            if (currentStep < 4) selectSimStep(currentStep + 1);
        }

        // Initialize upon page load
        document.addEventListener('DOMContentLoaded', function() {
            const activeTheme = document.documentElement.getAttribute('data-theme') || 'light';
            updateLandingThemeUI(activeTheme);
            selectSimStep(1);

            @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true
            });
            @endif

            @if(session('error'))
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'error',
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });
            @endif
        });
    </script>
</body>
</html>
