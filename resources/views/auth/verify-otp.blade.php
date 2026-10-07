<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP Email - E-Surat PKST BKT Kemenhub</title>
    
    <!-- Google Fonts: Atkinson Hyperlegible + Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-baketrans.png') }}">
    <link rel="stylesheet" href="{{ asset('css/kemenhub.css') }}">
    
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
        body {
            background: radial-gradient(circle at 85% 15%, rgba(2, 132, 199, 0.12) 0%, transparent 40%),
                        linear-gradient(135deg, #EFF6FF 0%, #F1F5F9 50%, #E2E8F0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 16px;
            font-family: var(--font-body);
            transition: background 0.3s ease;
        }

        .otp-card {
            background: #FFFFFF;
            border-radius: 20px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 40px -15px rgba(10, 37, 64, 0.15);
            overflow: hidden;
            border: 1px solid #CBD5E1;
            animation: cardAppear 0.4s ease-out forwards;
        }

        @keyframes cardAppear {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .otp-header {
            background: linear-gradient(135deg, #0A2540 0%, #07192C 100%);
            color: #FFFFFF;
            padding: 28px 24px;
            text-align: center;
            border-bottom: 3px solid #F5A623;
            position: relative;
        }

        .otp-header h1 {
            font-family: var(--font-heading);
        }

        .otp-icon-circle {
            width: 64px;
            height: 64px;
            background: rgba(2, 132, 199, 0.2);
            border: 2px solid #0284C7;
            border-radius: 50%;
            margin: 0 auto 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #38BDF8;
            font-size: 28px;
        }

        /* 6-box OTP input styling */
        .otp-inputs-wrapper {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin: 20px 0;
        }

        .otp-digit {
            width: 50px;
            height: 58px;
            font-size: 24px;
            font-weight: 700;
            font-family: var(--font-heading);
            text-align: center;
            border-radius: 10px;
            border: 2px solid #CBD5E1;
            background: #F8FAFC;
            color: #0F172A;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .otp-digit:focus {
            border-color: #0284C7;
            background: #FFFFFF;
            box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.2);
            outline: none;
            transform: scale(1.05);
        }

        /* Dark Theme Support */
        [data-theme="dark"] body {
            background: linear-gradient(135deg, #051322 0%, #07192C 50%, #0A2540 100%) !important;
        }

        [data-theme="dark"] .otp-card {
            background: #0D2847;
            border-color: #1E3A5F;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
        }

        [data-theme="dark"] .otp-digit {
            background: #07192C;
            border-color: #1E3A5F;
            color: #F8FAFC;
        }

        [data-theme="dark"] .otp-digit:focus {
            background: #0A2540;
            border-color: #0284C7;
            color: #F8FAFC;
            box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.3);
        }

        [data-theme="dark"] .text-secondary {
            color: #CBD5E1 !important;
        }
    </style>
</head>
<body>

    <div class="otp-card">
        <!-- HEADER -->
        <div class="otp-header">
            <!-- Theme Toggle Button -->
            <button type="button" class="btn-theme-toggle position-absolute top-0 end-0 m-3" onclick="toggleTheme()" title="Beralih Mode Gelap/Terang" id="themeBtn">
                <i class="bi bi-moon-stars-fill text-warning" id="themeIcon"></i>
            </button>

            <div class="otp-icon-circle">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h1 class="fs-4 fw-bold mb-1 tracking-tight">VERIFIKASI KODE OTP</h1>
            <p class="small text-light text-opacity-75 m-0" style="font-size: 0.76rem;">
                Sistem Keamanan Autentikasi E-Surat PKST
            </p>
        </div>

        <!-- BODY -->
        <div class="p-4 p-md-5 text-center">

            <!-- Development Helper Alert -->
            @if($latestOtp)
                <div class="alert alert-warning py-2 px-3 small border-warning border-2 d-flex align-items-center justify-content-between mb-4 text-start">
                    <div>
                        <div class="fw-bold text-dark d-flex align-items-center gap-1">
                            <i class="bi bi-terminal-fill text-dark"></i>
                            <span>Simulasi OTP Aktif:</span>
                        </div>
                        <div class="font-monospace fw-bold fs-5 text-primary mt-1 letter-spacing-1">
                            {{ $latestOtp->otp_code }}
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-dark py-1 px-3 fw-bold" onclick="autoFillOtp('{{ $latestOtp->otp_code }}')">
                        <i class="bi bi-magic me-1"></i> Isi Otomatis
                    </button>
                </div>
            @endif

            <p class="text-secondary small mb-1">
                Kode verifikasi 6-digit telah dikirimkan ke alamat email kedinasan Anda:
            </p>
            <div class="fw-bold text-primary font-monospace fs-6 mb-3">
                {{ $email }}
            </div>

            @if(session('error'))
                <div class="alert alert-danger py-2 small d-flex align-items-center gap-2 mb-3 text-start">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success py-2 small d-flex align-items-center gap-2 mb-3 text-start">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning py-2 small d-flex align-items-center gap-2 mb-3 text-start">
                    <i class="bi bi-clock-history"></i>
                    <div>{{ session('warning') }}</div>
                </div>
            @endif

            <form action="{{ route('otp.check') }}" method="POST" id="otpForm">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="otp_code" id="otp_code" required>

                <!-- 6 Digit Boxes -->
                <div class="otp-inputs-wrapper" id="otpBoxes">
                    <input type="text" maxlength="1" class="otp-digit" data-index="0" inputmode="numeric" autocomplete="one-time-code" autofocus>
                    <input type="text" maxlength="1" class="otp-digit" data-index="1" inputmode="numeric">
                    <input type="text" maxlength="1" class="otp-digit" data-index="2" inputmode="numeric">
                    <input type="text" maxlength="1" class="otp-digit" data-index="3" inputmode="numeric">
                    <input type="text" maxlength="1" class="otp-digit" data-index="4" inputmode="numeric">
                    <input type="text" maxlength="1" class="otp-digit" data-index="5" inputmode="numeric">
                </div>

                <!-- Countdown Timer -->
                <div class="mb-4">
                    <span class="small text-muted">Masa berlaku kode:</span>
                    <span id="countdown" class="fw-bold font-monospace text-danger ms-1">10:00</span>
                </div>

                <button type="submit" class="btn btn-kemenhub w-100 py-2 fw-bold justify-content-center mb-3" id="btnVerify" disabled>
                    <i class="bi bi-shield-check me-1"></i> Verifikasi & Masuk Dashboard
                </button>
            </form>

            <!-- Resend Form -->
            <form action="{{ route('otp.resend') }}" method="POST" id="resendForm">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="small text-muted">
                    Tidak menerima kode? 
                    <button type="submit" class="btn btn-link p-0 small fw-bold text-primary text-decoration-none" id="btnResend">
                        Kirim Ulang Kode OTP
                    </button>
                </div>
            </form>

            <div class="text-center mt-4 pt-3 border-top">
                <a href="{{ route('register') }}" class="small text-muted text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Form Pendaftaran
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
            const icon = document.getElementById('themeIcon');
            if (icon) {
                icon.className = theme === 'dark' ? 'bi bi-sun-fill text-warning' : 'bi bi-moon-stars-fill text-warning';
            }
        }

        // Auto-advance & OTP digits management
        const digits = document.querySelectorAll('.otp-digit');
        const hiddenOtp = document.getElementById('otp_code');
        const btnVerify = document.getElementById('btnVerify');

        function updateHiddenOtp() {
            let code = '';
            digits.forEach(d => code += d.value.trim());
            hiddenOtp.value = code;
            btnVerify.disabled = code.length !== 6;
            if (code.length === 6) {
                // Optional auto-submit when all 6 digits entered
            }
        }

        digits.forEach((digit, idx) => {
            digit.addEventListener('input', (e) => {
                const val = e.target.value;
                if (val.length > 0) {
                    e.target.value = val[val.length - 1]; // Only keep last typed character
                    if (idx < digits.length - 1) {
                        digits[idx + 1].focus();
                    }
                }
                updateHiddenOtp();
            });

            digit.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && idx > 0) {
                    digits[idx - 1].focus();
                }
            });

            digit.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasted = (e.clipboardData || window.clipboardData).getData('text').trim();
                if (/^\d{6}$/.test(pasted)) {
                    pasted.split('').forEach((char, i) => {
                        if (digits[i]) digits[i].value = char;
                    });
                    digits[5].focus();
                    updateHiddenOtp();
                }
            });
        });

        // 1-Click Auto Fill
        function autoFillOtp(code) {
            if (code && code.length === 6) {
                code.split('').forEach((char, i) => {
                    if (digits[i]) digits[i].value = char;
                });
                updateHiddenOtp();
                digits[5].focus();
            }
        }

        // Countdown Timer
        let remainingSeconds = {{ $expiresInSeconds ?? 600 }};
        const countdownEl = document.getElementById('countdown');

        function updateTimer() {
            if (remainingSeconds <= 0) {
                countdownEl.textContent = 'Kedaluwarsa';
                countdownEl.classList.remove('text-danger');
                countdownEl.classList.add('text-muted');
                btnVerify.disabled = true;
                return;
            }
            const mins = Math.floor(remainingSeconds / 60);
            const secs = remainingSeconds % 60;
            countdownEl.textContent = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
            remainingSeconds--;
        }

        setInterval(updateTimer, 1000);
        updateTimer();

        document.addEventListener('DOMContentLoaded', function() {
            const current = document.documentElement.getAttribute('data-theme') || 'light';
            updateThemeIcon(current);
            if (digits[0]) digits[0].focus();
        });
    </script>
</body>
</html>
