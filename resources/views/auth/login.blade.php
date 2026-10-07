<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - Single Sign-On (SSO) HUBNET Kementerian Perhubungan</title>
    
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

        /* Ambient subtle blur over background */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            z-index: 0;
            pointer-events: none;
        }

        /* MAIN SPLIT FRAME CONTAINER */
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

        /* LEFT SIDE: HUBNET BRANDING PANEL */
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

        /* HUBNET Logo Emblem */
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

        /* BOTTOM BADGES ROW */
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

        /* RIGHT SIDE: FORM LOGIN / SIGN UP PANEL */
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

        /* Modern Segmented Tab Switcher (Log In vs Sign Up) */
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
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tab-btn.active {
            background: #FFFFFF;
            color: #0F172A;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .tab-btn:active {
            transform: scale(0.97);
        }

        /* Form Headings */
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
            margin: 0 0 22px 0;
        }

        /* Form Labels & Inputs */
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
            padding: 12px 14px;
            font-size: 0.92rem;
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

        /* Segmented Radio Options */
        .radio-options-row {
            display: flex;
            align-items: center;
            gap: 20px;
            margin: 20px 0 22px 0;
            flex-wrap: wrap;
        }

        .radio-option-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            margin: 0;
        }

        .radio-option-item input[type="radio"] {
            width: 16px;
            height: 16px;
            accent-color: var(--hub-blue);
            cursor: pointer;
            margin: 0;
        }

        .radio-option-item span {
            font-size: 0.74rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: var(--text-main);
            text-transform: uppercase;
        }

        /* Primary Action Button (Blue) */
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
            box-shadow: 0 6px 18px rgba(29, 100, 216, 0.4);
            color: #FFFFFF;
        }

        .btn-hub-primary:active {
            transform: scale(0.98) !important;
        }

        /* Secondary SSO Button */
        .btn-sso-link {
            width: 100%;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 9px 16px;
            font-size: 0.82rem;
            font-weight: 700;
            color: #334155;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
            transition: all 0.2s ease;
        }

        .btn-sso-link:hover {
            background: #EFF6FF;
            border-color: #BFDBFE;
            color: var(--hub-blue);
            transform: translateY(-1px);
        }

        /* Footer Info */
        .hubnet-footer-text {
            text-align: center;
            font-size: 0.74rem;
            color: var(--text-sub);
            margin-top: 24px;
            line-height: 1.45;
        }

        .hubnet-footer-text .version-tag {
            display: inline-block;
            font-family: monospace;
            font-size: 0.7rem;
            color: #94A3B8;
            margin-top: 2px;
        }

        /* Fast Role Simulation pills */
        .quick-role-row {
            display: flex;
            gap: 6px;
            margin-top: 14px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .role-pill-btn {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            background: #F1F5F9;
            color: #475569;
            border: 1px solid #E2E8F0;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .role-pill-btn:hover {
            background: #E2E8F0;
            color: #0F172A;
            transform: translateY(-1px);
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

        [data-theme="dark"] .btn-sso-link {
            background: #07192C;
            border-color: #1E3A5F;
            color: #CBD5E1;
        }

        [data-theme="dark"] .btn-sso-link:hover {
            background: #143D69;
            border-color: #0284C7;
            color: #FFFFFF;
        }

        [data-theme="dark"] .role-pill-btn {
            background: #07192C;
            border-color: #1E3A5F;
            color: #94A3B8;
        }

        [data-theme="dark"] .role-pill-btn:hover {
            background: #143D69;
            color: #FFFFFF;
        }

        /* RESPONSIVE DESIGN FOR SMALLER SCREENS */
        @media (max-width: 900px) {
            .hubnet-split-frame {
                flex-direction: column;
                max-width: 520px;
                min-height: auto;
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

    <!-- MAIN SPLIT FRAME -->
    <div class="hubnet-split-frame">

        <!-- ============================================== -->
        <!-- LEFT PANEL: HUBNET BRANDING & OFFICIAL BADGES -->
        <!-- ============================================== -->
        <div class="hubnet-left-panel">
            
            <div class="hubnet-center-block">
                <!-- HUBNET Logo Row (Geometric Hub Emblem + Text) -->
                <div class="hubnet-logo-row">
                    <svg class="hubnet-emblem-svg" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Stylized Geometric Cross Emblem -->
                        <path d="M19 4H33V18H47V32H33V46H19V32H5V18H19V4Z" fill="#FFFFFF" fill-opacity="0.95"/>
                        <path d="M23 23H29V29H23V23Z" fill="#091F38"/>
                        <!-- Cyan Accent Notch Accents -->
                        <path d="M7 23H17V27H7V23ZM35 23H45V27H35V23ZM23 7H27V17H23V7ZM23 35H27V45H23V35Z" fill="#38BDF8"/>
                    </svg>
                    <h1 class="hubnet-main-title">HUBNET</h1>
                </div>

                <div class="hubnet-sub-title-1">SISTEM PENGHUBUNG LAYANAN TRANSPORTASI</div>
                <div class="hubnet-sub-title-2">KEMENTERIAN PERHUBUNGAN</div>

                <!-- App Subtitle Pill -->
                <div class="hubnet-badge-subapp">
                    <i class="bi bi-shield-lock-fill text-warning"></i>
                    <span>E-SURAT PKST &bull; BKT KEMENHUB RI</span>
                </div>
            </div>

            <!-- THREE OFFICIAL FOOTER BADGES -->
            <div class="hubnet-badges-row">
                
                <!-- 1. DIGIPORTASI -->
                <div class="badge-logo-item" title="DIGIPORTASI - Transformasi Digital Sektor Transportasi">
                    <svg width="105" height="34" viewBox="0 0 210 68" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Globe Grid -->
                        <ellipse cx="44" cy="34" rx="28" ry="28" stroke="#38BDF8" stroke-width="3" fill="none"/>
                        <ellipse cx="44" cy="34" rx="13" ry="28" stroke="#38BDF8" stroke-width="2.2" fill="none"/>
                        <line x1="16" y1="34" x2="72" y2="34" stroke="#38BDF8" stroke-width="2.2"/>
                        <line x1="22" y1="20" x2="66" y2="20" stroke="#38BDF8" stroke-width="1.8"/>
                        <line x1="22" y1="48" x2="66" y2="48" stroke="#38BDF8" stroke-width="1.8"/>
                        <!-- Speed Wings -->
                        <path d="M62 20H108L96 28H58Z" fill="#E2E8F0"/>
                        <path d="M68 31H112L100 39H62Z" fill="#E2E8F0"/>
                        <path d="M58 42H98L88 49H54Z" fill="#E2E8F0"/>
                        <!-- Text -->
                        <text x="116" y="32" fill="#38BDF8" font-size="16" font-weight="900" font-family="'Plus Jakarta Sans', sans-serif" letter-spacing="1">DIGIPORTASI</text>
                        <text x="116" y="46" fill="#94A3B8" font-size="8.5" font-weight="700" font-family="'Plus Jakarta Sans', sans-serif" letter-spacing="0.5">TRANSFORMASI DIGITAL SEKTOR TRANSPORTASI</text>
                    </svg>
                </div>

                <!-- 2. SPBE -->
                <div class="badge-logo-item" title="SPBE - Sistem Pemerintahan Berbasis Elektronik">
                    <svg width="78" height="32" viewBox="0 0 140 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 38C22 38 32 24 54 22C70 20 84 28 92 34" stroke="#38BDF8" stroke-width="4.5" stroke-linecap="round"/>
                        <path d="M12 46C26 46 38 32 60 30C72 28 82 36 88 42" stroke="#FFFFFF" stroke-width="3.5" stroke-linecap="round"/>
                        <text x="74" y="36" fill="#FFFFFF" font-size="28" font-weight="900" font-family="'Plus Jakarta Sans', sans-serif" letter-spacing="1.5">SPBE</text>
                    </svg>
                </div>

                <!-- 3. KEMENHUB CSIRT (Yellow/Gold Shield) -->
                <div class="badge-logo-item" title="Kemenhub CSIRT - Computer Security Incident Response Team">
                    <svg width="42" height="42" viewBox="0 0 70 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Outer Shield -->
                        <polygon points="35,4 66,18 66,54 35,76 4,54 4,18" fill="#F59E0B" stroke="#D97706" stroke-width="2.5"/>
                        <polygon points="35,9 61,21 61,51 35,71 9,51 9,21" fill="#FBBF24"/>
                        <!-- Inner Crest Details -->
                        <polygon points="35,16 53,26 53,46 35,60 17,46 17,26" fill="#0A1E34"/>
                        <path d="M28 35L33 40L43 28" stroke="#FBBF24" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <!-- Ribbon CSIRT -->
                        <rect x="14" y="48" width="42" height="13" rx="3" fill="#061525" stroke="#FBBF24" stroke-width="1.5"/>
                        <text x="35" y="58" fill="#FBBF24" font-size="9" font-weight="900" font-family="'Plus Jakarta Sans', sans-serif" text-anchor="middle" letter-spacing="1">CSIRT</text>
                    </svg>
                </div>

            </div>
        </div>

        <!-- ============================================== -->
        <!-- RIGHT PANEL: LOG IN / SIGN UP AUTHENTICATION   -->
        <!-- ============================================== -->
        <div class="hubnet-right-panel">
            
            <!-- TOP CONTROLS: TABS & THEME TOGGLE -->
            <div class="panel-top-controls">
                <div class="hubnet-tab-switcher">
                    <button type="button" class="tab-btn active" id="btnTabLogin" onclick="switchTab('login')">
                        Log In
                    </button>
                    <button type="button" class="tab-btn" id="btnTabRegister" onclick="switchTab('register')">
                        Sign Up
                    </button>
                </div>

                <!-- Theme Toggle Button -->
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle p-1 border-0" onclick="toggleTheme()" title="Beralih Mode Gelap/Terang" id="loginThemeBtn" style="width: 34px; height: 34px;">
                    <i class="bi bi-moon-stars-fill text-warning fs-6" id="loginThemeIcon"></i>
                </button>
            </div>

            <!-- FLASH ALERTS -->
            @if(session('error'))
                <div class="alert alert-danger py-2 px-3 small d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success py-2 px-3 small d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning py-2 px-3 small d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div>{{ session('warning') }}</div>
                </div>
            @endif

            <!-- ============================================== -->
            <!-- TAB 1: LOG IN FORM (EXACT MATCH SCREENSHOT)     -->
            <!-- ============================================== -->
            <div id="panelLogin" class="tab-content-block">
                <h2 class="form-title">Log In</h2>
                <p class="form-subtitle">Single Sign-On (SSO)</p>

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    
                    <!-- USERNAME FIELD -->
                    <div class="mb-3">
                        <label class="form-label-caps" for="login_email">USERNAME</label>
                        <input type="email" id="login_email" name="email" class="form-input-hub" value="{{ old('email', 'pegawai@bkt.dephub.go.id') }}" placeholder="username@bkt.dephub.go.id" required autofocus>
                    </div>

                    <!-- PASSWORD FIELD -->
                    <div class="mb-2">
                        <label class="form-label-caps" for="login_password">PASSWORD</label>
                        <input type="password" id="login_password" name="password" class="form-input-hub" value="password123" placeholder="••••••••••••" required>
                    </div>

                    <!-- RADIO SEGMENTATION OPTIONS (EXACT TO SCREENSHOT) -->
                    <div class="radio-options-row">
                        <label class="radio-option-item">
                            <input type="radio" name="user_type" value="pegawai" checked>
                            <span>PEGAWAI KEMENHUB</span>
                        </label>
                        <label class="radio-option-item">
                            <input type="radio" name="user_type" value="oss">
                            <span>OSS</span>
                        </label>
                        <label class="radio-option-item">
                            <input type="radio" name="user_type" value="lainnya">
                            <span>LAINNYA</span>
                        </label>
                    </div>

                    <!-- PRIMARY BLUE LOG IN BUTTON -->
                    <button type="submit" class="btn-hub-primary">
                        <span>Log In</span>
                    </button>
                </form>

                <!-- SSO 1-CLICK & GOOGLE SHORTCUTS -->
                <div class="mt-3">
                    <a href="{{ route('sso.redirect', 'kemenhub') }}" class="btn-sso-link">
                        <img src="{{ asset('images/logo-baketrans.png') }}" style="width: 18px; height: 18px; object-fit: contain;">
                        <span>Masuk via Portal SSO Kemenhub</span>
                    </a>
                </div>

                <!-- FAST DEMO SIMULATION SHORTCUTS (RBAC Test) -->
                <div class="mt-3 pt-2 text-center">
                    <span class="small text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.8px;">Simulasi Uji Cepat Peran:</span>
                    <div class="quick-role-row">
                        <a href="{{ route('quick.login', 'pegawai') }}" class="role-pill-btn text-info" title="Login sebagai Staf Analis">Staf Analis</a>
                        <a href="{{ route('quick.login', 'kepala_bidang') }}" class="role-pill-btn text-primary" title="Login sebagai Kabid">Kabid</a>
                        <a href="{{ route('quick.login', 'kepala_pusat') }}" class="role-pill-btn text-warning" title="Login sebagai Kapus">Kapus</a>
                        <a href="{{ route('quick.login', 'admin') }}" class="role-pill-btn text-danger" title="Login sebagai Admin">Admin</a>
                    </div>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- TAB 2: SIGN UP FORM (INSIDE SAME FRAME)         -->
            <!-- ============================================== -->
            <div id="panelRegister" class="tab-content-block d-none">
                <h2 class="form-title">Sign Up</h2>
                <p class="form-subtitle">Registrasi Pegawai Mandiri (Verifikasi OTP)</p>

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    
                    <div class="mb-2">
                        <label class="form-label-caps" for="reg_name">NAMA LENGKAP & GELAR</label>
                        <input type="text" id="reg_name" name="name" class="form-input-hub" placeholder="Contoh: Pratama Wicaksana, S.T., M.Sc." required>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label-caps" for="reg_nip">NIP</label>
                            <input type="text" id="reg_nip" name="nip" class="form-input-hub font-monospace" placeholder="1995xxxx xxxxx x xxx">
                        </div>
                        <div class="col-6">
                            <label class="form-label-caps" for="reg_email">EMAIL KEMENHUB</label>
                            <input type="email" id="reg_email" name="email" class="form-input-hub" placeholder="nama@bkt.dephub.go.id" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label-caps" for="reg_jabatan">JABATAN FUNGSIONAL</label>
                        <input type="text" id="reg_jabatan" name="jabatan" class="form-input-hub" value="Analis Kebijakan Transportasi">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-caps" for="reg_password">KATA SANDI</label>
                            <input type="password" id="reg_password" name="password" class="form-input-hub" placeholder="Min. 6 karakter" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-caps" for="reg_password_confirmation">KONFIRMASI SANDI</label>
                            <input type="password" id="reg_password_confirmation" name="password_confirmation" class="form-input-hub" placeholder="Ulangi kata sandi" required>
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

            <!-- FOOTER INFO (EXACT MATCH TO SCREENSHOT) -->
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
        // Switch between Log In and Sign Up tabs
        function switchTab(tab) {
            const btnLogin = document.getElementById('btnTabLogin');
            const btnRegister = document.getElementById('btnTabRegister');
            const panelLogin = document.getElementById('panelLogin');
            const panelRegister = document.getElementById('panelRegister');

            if (tab === 'register') {
                btnLogin.classList.remove('active');
                btnRegister.classList.add('active');
                panelLogin.classList.add('d-none');
                panelRegister.classList.remove('d-none');
                const nameInput = document.getElementById('reg_name');
                if (nameInput) nameInput.focus();
            } else {
                btnRegister.classList.remove('active');
                btnLogin.classList.add('active');
                panelRegister.classList.add('d-none');
                panelLogin.classList.remove('d-none');
                const emailInput = document.getElementById('login_email');
                if (emailInput) emailInput.focus();
            }
        }

        // Theme toggle
        function toggleTheme() {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme') || 'light';
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('esurat_theme', next);
            updateThemeIcon(next);
        }

        function updateThemeIcon(theme) {
            const icon = document.getElementById('loginThemeIcon');
            if (icon) {
                if (theme === 'dark') {
                    icon.className = 'bi bi-sun-fill text-warning fs-6';
                } else {
                    icon.className = 'bi bi-moon-stars-fill text-warning fs-6';
                }
            }
        }

        // URL Query parameter check (e.g. /login?tab=register)
        document.addEventListener('DOMContentLoaded', function() {
            const current = document.documentElement.getAttribute('data-theme') || 'light';
            updateThemeIcon(current);

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('tab') === 'register' || urlParams.get('tab') === 'signup') {
                switchTab('register');
            }
        });
    </script>
</body>
</html>
