<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Registrasi Pegawai HUBNET Kementerian Perhubungan</title>
    
    <!-- Google Fonts: Atkinson Hyperlegible + Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-baketrans.png') }}">
    
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
    
    <style>
        :root {
            --font-heading: 'Plus Jakarta Sans', 'Atkinson Hyperlegible', sans-serif;
            --font-body: 'Plus Jakarta Sans', 'Atkinson Hyperlegible', sans-serif;
            --hub-blue: #1D64D8;
            --hub-blue-hover: #1551B5;
            --hub-navy: #0A1E34;
            --hub-navy-dark: #061525;
            --input-bg: #EEF4FF;
            --input-border: #CBD5E1;
            --input-text: #0F172A;
            --card-bg: #FFFFFF;
            --text-main: #0F172A;
            --text-sub: #64748B;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            margin: 0;
            padding: 24px 16px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(8, 24, 44, 0.78) 0%, rgba(10, 37, 64, 0.88) 100%),
                        url('{{ asset('images/kemenhub-building.jpg') }}') center center / cover no-repeat fixed;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            z-index: 0;
            pointer-events: none;
        }

        .hubnet-split-frame {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1040px;
            min-height: 560px;
            background: #FFFFFF;
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.75), 0 0 0 1px rgba(255, 255, 255, 0.15);
            animation: frameFadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes frameFadeIn {
            from { opacity: 0; transform: translateY(24px) scale(0.99); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .hubnet-left-panel {
            flex: 1 1 48%;
            background: linear-gradient(160deg, #091F38 0%, #061527 100%);
            color: #FFFFFF;
            padding: 44px 36px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            position: relative;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }

        .hubnet-center-block {
            margin: auto 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .hubnet-logo-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 8px;
        }

        .hubnet-emblem-svg {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
        }

        .hubnet-main-title {
            font-size: 2.75rem;
            font-weight: 900;
            letter-spacing: 2px;
            line-height: 1;
            color: #FFFFFF;
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .hubnet-sub-title-1 {
            font-size: 0.68rem;
            font-weight: 700;
            color: #93C5FD;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .hubnet-sub-title-2 {
            font-size: 0.92rem;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .hubnet-badge-subapp {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(2, 132, 199, 0.18);
            border: 1px solid rgba(56, 189, 248, 0.35);
            color: #BAE6FD;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-top: 18px;
        }

        .hubnet-badges-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 24px;
            width: 100%;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .badge-logo-item {
            display: flex;
            align-items: center;
            opacity: 0.9;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .badge-logo-item:hover {
            opacity: 1;
            transform: translateY(-2px);
        }

        .hubnet-right-panel {
            flex: 1 1 52%;
            background: var(--card-bg);
            padding: 44px 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: background 0.3s ease;
        }

        .panel-top-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .hubnet-tab-switcher {
            display: inline-flex;
            background: #F1F5F9;
            padding: 3px;
            border-radius: 10px;
            border: 1px solid #E2E8F0;
        }

        .tab-btn {
            border: none;
            background: transparent;
            padding: 6px 18px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            color: #64748B;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tab-btn.active {
            background: #FFFFFF;
            color: #0F172A;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .form-title {
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0 0 2px 0;
            font-family: var(--font-heading);
            letter-spacing: -0.5px;
        }

        .form-subtitle {
            font-size: 0.92rem;
            font-weight: 500;
            color: var(--text-sub);
            margin: 0 0 20px 0;
        }

        .form-label-caps {
            display: block;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.8px;
            color: var(--text-main);
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .form-input-hub {
            width: 100%;
            background-color: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 8px;
            padding: 11px 14px;
            font-size: 0.9rem;
            font-family: var(--font-body);
            color: var(--input-text);
            outline: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-input-hub:focus {
            background-color: #FFFFFF;
            border-color: #0F172A;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
        }

        .btn-hub-primary {
            width: 100%;
            background-color: var(--hub-blue);
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 0.98rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(29, 100, 216, 0.3);
        }

        .btn-hub-primary:hover {
            background-color: var(--hub-blue-hover);
            transform: translateY(-1px);
            color: #FFFFFF;
        }

        .btn-hub-primary:active {
            transform: scale(0.98) !important;
        }

        .hubnet-footer-text {
            text-align: center;
            font-size: 0.74rem;
            color: var(--text-sub);
            margin-top: 20px;
            line-height: 1.45;
        }

        .hubnet-footer-text .version-tag {
            display: inline-block;
            font-family: monospace;
            font-size: 0.7rem;
            color: #94A3B8;
        }

        /* DARK THEME STYLING */
        [data-theme="dark"] {
            --input-bg: #07192C;
            --input-border: #1E3A5F;
            --input-text: #F8FAFC;
            --card-bg: #0D2847;
            --text-main: #F8FAFC;
            --text-sub: #94A3B8;
        }

        [data-theme="dark"] .hubnet-tab-switcher {
            background: #07192C;
            border-color: #1E3A5F;
        }

        [data-theme="dark"] .tab-btn {
            color: #94A3B8;
        }

        [data-theme="dark"] .tab-btn.active {
            background: #143D69;
            color: #FFFFFF;
        }

        [data-theme="dark"] .form-input-hub:focus {
            background-color: #0A2540;
            border-color: #38BDF8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2);
        }

        @media (max-width: 900px) {
            .hubnet-split-frame {
                flex-direction: column;
                max-width: 520px;
            }

            .hubnet-left-panel {
                padding: 36px 24px;
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .hubnet-main-title {
                font-size: 2.2rem;
            }

            .hubnet-right-panel {
                padding: 36px 28px;
            }
        }
    </style>
</head>
<body>

    <div class="hubnet-split-frame">

        <!-- LEFT PANEL: HUBNET BRANDING -->
        <div class="hubnet-left-panel">
            <div class="hubnet-center-block">
                <div class="hubnet-logo-row">
                    <svg class="hubnet-emblem-svg" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 4H33V18H47V32H33V46H19V32H5V18H19V4Z" fill="#FFFFFF" fill-opacity="0.95"/>
                        <path d="M23 23H29V29H23V23Z" fill="#091F38"/>
                        <path d="M7 23H17V27H7V23ZM35 23H45V27H35V23ZM23 7H27V17H23V7ZM23 35H27V45H23V35Z" fill="#38BDF8"/>
                    </svg>
                    <h1 class="hubnet-main-title">HUBNET</h1>
                </div>
                <div class="hubnet-sub-title-1">SISTEM PENGHUBUNG LAYANAN TRANSPORTASI</div>
                <div class="hubnet-sub-title-2">KEMENTERIAN PERHUBUNGAN</div>
                <div class="hubnet-badge-subapp">
                    <i class="bi bi-shield-lock-fill text-warning"></i>
                    <span>E-SURAT PKST &bull; BKT KEMENHUB RI</span>
                </div>
            </div>

            <!-- THREE BADGES: DIGIPORTASI, SPBE, CSIRT -->
            <div class="hubnet-badges-row">
                <div class="badge-logo-item" title="DIGIPORTASI">
                    <svg width="105" height="34" viewBox="0 0 210 68" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="44" cy="34" rx="28" ry="28" stroke="#38BDF8" stroke-width="3" fill="none"/>
                        <ellipse cx="44" cy="34" rx="13" ry="28" stroke="#38BDF8" stroke-width="2.2" fill="none"/>
                        <line x1="16" y1="34" x2="72" y2="34" stroke="#38BDF8" stroke-width="2.2"/>
                        <line x1="22" y1="20" x2="66" y2="20" stroke="#38BDF8" stroke-width="1.8"/>
                        <line x1="22" y1="48" x2="66" y2="48" stroke="#38BDF8" stroke-width="1.8"/>
                        <path d="M62 20H108L96 28H58Z" fill="#E2E8F0"/>
                        <path d="M68 31H112L100 39H62Z" fill="#E2E8F0"/>
                        <path d="M58 42H98L88 49H54Z" fill="#E2E8F0"/>
                        <text x="116" y="32" fill="#38BDF8" font-size="16" font-weight="900" font-family="'Plus Jakarta Sans', sans-serif" letter-spacing="1">DIGIPORTASI</text>
                        <text x="116" y="46" fill="#94A3B8" font-size="8.5" font-weight="700" font-family="'Plus Jakarta Sans', sans-serif" letter-spacing="0.5">TRANSFORMASI DIGITAL SEKTOR TRANSPORTASI</text>
                    </svg>
                </div>
                <div class="badge-logo-item" title="SPBE">
                    <svg width="78" height="32" viewBox="0 0 140 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 38C22 38 32 24 54 22C70 20 84 28 92 34" stroke="#38BDF8" stroke-width="4.5" stroke-linecap="round"/>
                        <path d="M12 46C26 46 38 32 60 30C72 28 82 36 88 42" stroke="#FFFFFF" stroke-width="3.5" stroke-linecap="round"/>
                        <text x="74" y="36" fill="#FFFFFF" font-size="28" font-weight="900" font-family="'Plus Jakarta Sans', sans-serif" letter-spacing="1.5">SPBE</text>
                    </svg>
                </div>
                <div class="badge-logo-item" title="Kemenhub CSIRT">
                    <svg width="42" height="42" viewBox="0 0 70 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <polygon points="35,4 66,18 66,54 35,76 4,54 4,18" fill="#F59E0B" stroke="#D97706" stroke-width="2.5"/>
                        <polygon points="35,9 61,21 61,51 35,71 9,51 9,21" fill="#FBBF24"/>
                        <polygon points="35,16 53,26 53,46 35,60 17,46 17,26" fill="#0A1E34"/>
                        <path d="M28 35L33 40L43 28" stroke="#FBBF24" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <rect x="14" y="48" width="42" height="13" rx="3" fill="#061525" stroke="#FBBF24" stroke-width="1.5"/>
                        <text x="35" y="58" fill="#FBBF24" font-size="9" font-weight="900" font-family="'Plus Jakarta Sans', sans-serif" text-anchor="middle" letter-spacing="1">CSIRT</text>
                    </svg>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL: SIGN UP -->
        <div class="hubnet-right-panel">
            <div class="panel-top-controls">
                <div class="hubnet-tab-switcher">
                    <a href="{{ route('login') }}" class="tab-btn">
                        Log In
                    </a>
                    <a href="{{ route('register') }}" class="tab-btn active">
                        Sign Up
                    </a>
                </div>

                <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle p-1 border-0" onclick="toggleTheme()" title="Beralih Mode Gelap/Terang" id="themeBtn" style="width: 34px; height: 34px;">
                    <i class="bi bi-moon-stars-fill text-warning fs-6" id="themeIcon"></i>
                </button>
            </div>

            @if(isset($errors) && $errors->any())
                <div class="alert alert-danger py-2 px-3 small mb-3">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="tab-content-block">
                <h2 class="form-title">Sign Up</h2>
                <p class="form-subtitle">Registrasi Pegawai Mandiri (Verifikasi OTP)</p>

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    
                    <div class="mb-2">
                        <label class="form-label-caps" for="name">NAMA LENGKAP & GELAR</label>
                        <input type="text" id="name" name="name" class="form-input-hub" value="{{ old('name') }}" placeholder="Contoh: Pratama Wicaksana, S.T., M.Sc." required autofocus>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label-caps" for="nip">NIP</label>
                            <input type="text" id="nip" name="nip" class="form-input-hub font-monospace" value="{{ old('nip') }}" placeholder="1995xxxx xxxxx x xxx">
                        </div>
                        <div class="col-6">
                            <label class="form-label-caps" for="email">EMAIL KEMENHUB</label>
                            <input type="email" id="email" name="email" class="form-input-hub" value="{{ old('email') }}" placeholder="nama@bkt.dephub.go.id" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label-caps" for="jabatan">JABATAN FUNGSIONAL</label>
                        <input type="text" id="jabatan" name="jabatan" class="form-input-hub" value="{{ old('jabatan', 'Analis Kebijakan Transportasi') }}">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-caps" for="password">KATA SANDI</label>
                            <input type="password" id="password" name="password" class="form-input-hub" placeholder="Min. 6 karakter" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-caps" for="password_confirmation">KONFIRMASI SANDI</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input-hub" placeholder="Ulangi kata sandi" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-hub-primary">
                        <i class="bi bi-send-check"></i>
                        <span>Daftar & Kirim Kode OTP</span>
                    </button>
                </form>

                <div class="mt-2 text-center">
                    <span class="small text-muted" style="font-size: 0.74rem;">Atau gunakan </span>
                    <a href="{{ route('sso.redirect', 'kemenhub') }}" class="fw-bold text-primary text-decoration-none small">
                        Daftar Cepat via SSO Kemenhub
                    </a>
                </div>
            </div>

            <div class="hubnet-footer-text">
                <div>Pusat Data dan Teknologi Informasi</div>
                <div>Kementerian Perhubungan</div>
                <div class="version-tag">v1.1.02</div>
            </div>
        </div>

    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme') || 'light';
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('esurat_theme', next);
            updateThemeIcon(next);
        }

        function updateThemeIcon(theme) {
            const icon = document.getElementById('themeIcon');
            if (icon) {
                icon.className = theme === 'dark' ? 'bi bi-sun-fill text-warning fs-6' : 'bi bi-moon-stars-fill text-warning fs-6';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const current = document.documentElement.getAttribute('data-theme') || 'light';
            updateThemeIcon(current);
        });
    </script>
</body>
</html>
