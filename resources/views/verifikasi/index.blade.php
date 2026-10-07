<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Keaslian TTE Naskah Dinas - BKT Kemenhub</title>
    <!-- Google Fonts: Atkinson Hyperlegible + Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-baketrans.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
            padding: 24px;
            transition: background 0.3s ease;
        }
        .verify-card {
            background: #FFFFFF;
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 620px;
            box-shadow: 0 20px 40px -15px rgba(10, 37, 64, 0.15);
            overflow: hidden;
            border: 1px solid #CBD5E1;
            color: #0F172A;
        }
        .verify-header {
            background: #0A2540;
            color: #FFFFFF;
            padding: 24px;
            text-align: center;
            border-bottom: 3px solid var(--kemenhub-gold);
            position: relative;
        }
        .verify-body {
            padding: 30px;
        }
        .badge-verified {
            background: #ECFDF5;
            border: 2px solid #10B981;
            color: #065F46;
            padding: 14px 18px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }
        .verify-info-box {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: var(--radius-sm);
            padding: 20px;
            font-size: 0.88rem;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .verify-token-box {
            background: #EFF6FF;
            border: 1px solid #BFDBFE;
            border-radius: var(--radius-sm);
            padding: 12px;
            font-size: 0.75rem;
            color: #1E40AF;
            margin-bottom: 24px;
        }
        .verify-title {
            color: var(--kemenhub-navy);
        }
        .verify-val {
            color: #1E293B;
        }

        /* Dark Theme Support */
        [data-theme="dark"] body {
            background: linear-gradient(135deg, #051322 0%, #07192C 50%, #0A2540 100%) !important;
        }
        [data-theme="dark"] .verify-card {
            background: #0D2847;
            border-color: #1E3A5F;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.8);
            color: #F8FAFC;
        }
        [data-theme="dark"] .verify-header {
            background: #07192C;
        }
        [data-theme="dark"] .badge-verified {
            background: rgba(16, 185, 129, 0.15);
            border-color: #10B981;
            color: #34D399;
        }
        [data-theme="dark"] .verify-info-box {
            background: #07192C !important;
            border-color: #1E3A5F !important;
            color: #F8FAFC !important;
        }
        [data-theme="dark"] .verify-token-box {
            background: rgba(2, 132, 199, 0.15) !important;
            border-color: rgba(2, 132, 199, 0.35) !important;
            color: #7DD3FC !important;
        }
        [data-theme="dark"] .verify-title {
            color: #F8FAFC !important;
        }
        [data-theme="dark"] .verify-val {
            color: #F8FAFC !important;
        }
    </style>
</head>
<body>

    <div class="verify-card">
        <div class="verify-header">
            <div style="margin-bottom: 12px;">
                <img src="{{ asset('images/logo-baketrans.png') }}" alt="Logo Badan Kebijakan Transportasi" style="width: 72px; height: auto; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.35));">
            </div>
            <h2 style="font-size: 1.25rem; font-weight: 800; letter-spacing: -0.5px;">Sistem Verifikasi Naskah Dinas Elektronik</h2>
            <p style="font-size: 0.75rem; color: #CBD5E1; text-transform: uppercase; letter-spacing: 0.75px;">
                Badan Kebijakan Transportasi - Kementerian Perhubungan RI
            </p>
        </div>

        <div class="verify-body">
            @if($surat && $surat->tte_kapus_at)
                <!-- STATUS VALID -->
                <div class="badge-verified">
                    <i class="bi bi-shield-check text-success" style="font-size: 2.5rem;"></i>
                    <div>
                        <h4 style="font-size: 1.05rem; font-weight: 800; margin: 0; color: #065F46;">DOKUMEN ASLI & TERVERIFIKASI</h4>
                        <p style="font-size: 0.78rem; margin-top: 2px; color: #047857;">Tanda Tangan Elektronik (TTE) Tersertifikasi Balai Sertifikasi Elektronik (BSrE)</p>
                    </div>
                </div>

                <div class="verify-info-box">
                    <div style="margin-bottom: 12px; border-bottom: 1px solid var(--border-color, #E2E8F0); padding-bottom: 8px;">
                        <span style="font-size: 0.72rem; color: #94A3B8; font-weight: 700; text-transform: uppercase;">Nomor Naskah Dinas:</span>
                        <div class="verify-title" style="font-weight: 800; font-size: 1.05rem;">{{ $surat->no_surat }}</div>
                    </div>

                    <div style="margin-bottom: 12px; border-bottom: 1px solid var(--border-color, #E2E8F0); padding-bottom: 8px;">
                        <span style="font-size: 0.72rem; color: #94A3B8; font-weight: 700; text-transform: uppercase;">Perihal:</span>
                        <div class="verify-val" style="font-weight: 600;">{{ $surat->perihal }}</div>
                    </div>

                    <div style="margin-bottom: 12px; border-bottom: 1px solid var(--border-color, #E2E8F0); padding-bottom: 8px;">
                        <span style="font-size: 0.72rem; color: #94A3B8; font-weight: 700; text-transform: uppercase;">Penandatangan Resmi (TTE):</span>
                        <div class="verify-title" style="font-weight: 700;">
                            {{ $surat->tteKapus ? $surat->tteKapus->name : 'Dr. Ir. Bambang Priyanto, M.T.' }}
                        </div>
                        <div style="font-size: 0.75rem; color: #94A3B8;">
                            Kepala Pusat Kebijakan Sarana Transportasi (NIP. {{ $surat->tteKapus ? $surat->tteKapus->nip : '19720415 199803 1 001' }})
                        </div>
                    </div>

                    <div style="margin-bottom: 12px; border-bottom: 1px solid var(--border-color, #E2E8F0); padding-bottom: 8px;">
                        <span style="font-size: 0.72rem; color: #94A3B8; font-weight: 700; text-transform: uppercase;">Paraf Pimpinan Bidang Pengusul:</span>
                        <div class="verify-val" style="font-weight: 700;">
                            {{ $surat->parafKabid ? $surat->parafKabid->name : 'Ir. H. Agus Wahyudi, M.Sc.' }}
                        </div>
                        <div style="font-size: 0.75rem; color: #94A3B8;">Kepala Bidang Sarana Transportasi</div>
                    </div>

                    <div>
                        <span style="font-size: 0.72rem; color: #94A3B8; font-weight: 700; text-transform: uppercase;">Waktu Penandatanganan (Timestamp):</span>
                        <div class="verify-val" style="font-weight: 700;">{{ $surat->tte_kapus_at->format('d F Y, H:i:s') }} WIB</div>
                    </div>
                </div>

                <div class="verify-token-box">
                    <strong>Token Integritas Kriptografis:</strong><br>
                    <code style="font-family: monospace; word-break: break-all;">{{ hash('sha256', $surat->qr_code_token . $surat->no_surat) }}</code>
                </div>

                <div style="display: flex; gap: 12px;">
                    <a href="{{ route('surat-keluar.preview', $surat->id) }}" target="_blank" class="btn btn-primary" style="flex: 1; justify-content: center;">
                        <i class="bi bi-file-earmark-pdf-fill" style="margin-right: 6px;"></i> Lihat Salinan Naskah Lengkap
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline">
                        Ke Aplikasi &rarr;
                    </a>
                </div>
            @else
                <div style="text-align: center; padding: 24px 0;">
                    <i class="bi bi-search text-secondary" style="font-size: 2.8rem; margin-bottom: 8px; display: inline-block;"></i>
                    <h3 class="verify-title" style="font-size: 1.1rem; font-weight: 800; margin-top: 12px;">
                        Verifikasi Kode Dokumen
                    </h3>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 4px; margin-bottom: 24px;">
                        Masukkan kode token verifikasi TTE naskah dinas untuk memeriksa keasliannya.
                    </p>

                    <form action="" method="GET" onsubmit="event.preventDefault(); window.location.href='/verifikasi/' + document.getElementById('searchToken').value;">
                        <input type="text" id="searchToken" placeholder="Contoh: BKT-PKST-TTE-2026-9874128471" class="form-control" style="margin-bottom: 14px; text-align: center; font-weight: bold;" value="{{ $token != 'demo-scan' ? $token : '' }}" required>
                        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                            Cek Keaslian Dokumen
                        </button>
                    </form>

                    <div style="margin-top: 24px; font-size: 0.8rem; color: #64748B;">
                        Contoh token aktif untuk pengujian:<br>
                        <a href="{{ route('verifikasi.tte', 'BKT-PKST-TTE-2026-9874128471') }}" style="color: var(--kemenhub-blue); font-weight: bold;">
                            BKT-PKST-TTE-2026-9874128471
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

</body>
</html>
