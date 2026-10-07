<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal SSO Terpadu Kemenhub - Layanan Identitas Tunggal ASN</title>
    
    <!-- Google Fonts: Atkinson Hyperlegible + Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-baketrans.png') }}">
    <link rel="stylesheet" href="{{ asset('css/kemenhub.css') }}">
    
    <style>
        body {
            background: linear-gradient(135deg, #07192C 0%, #0A2540 50%, #0F355A 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 16px;
            font-family: var(--font-body);
            color: #F8FAFC;
        }

        .sso-gateway-card {
            background: #0D2847;
            border-radius: 20px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.75);
            overflow: hidden;
            border: 1px solid #1E3A5F;
            animation: cardAppear 0.4s ease-out forwards;
        }

        @keyframes cardAppear {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .sso-header {
            background: linear-gradient(135deg, #051322 0%, #08213B 100%);
            padding: 28px 24px;
            text-align: center;
            border-bottom: 3px solid #F5A623;
            position: relative;
        }

        .sso-header h1 {
            font-family: var(--font-heading);
            color: #FFFFFF;
        }

        .sso-seal {
            width: 70px;
            height: 70px;
            background: #FFFFFF;
            border: 2px solid #F5A623;
            border-radius: 50%;
            margin: 0 auto 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.5);
        }

        .sso-seal img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .sso-account-item {
            background: #07192C;
            border: 1px solid #1E3A5F;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            color: #F8FAFC;
            cursor: pointer;
        }

        .sso-account-item:hover {
            background: #143D69;
            border-color: #0284C7;
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(2, 132, 199, 0.2);
            color: #FFFFFF;
        }

        .sso-account-item:active {
            transform: scale(0.98) !important;
        }

        .nav-tabs-sso .nav-link {
            color: #94A3B8;
            border: none;
            border-bottom: 3px solid transparent;
            font-weight: 600;
            padding: 10px 16px;
            background: transparent;
        }

        .nav-tabs-sso .nav-link.active {
            color: #38BDF8;
            border-bottom-color: #38BDF8;
            background: transparent;
        }

        .form-control-sso {
            background: #07192C;
            border: 1px solid #1E3A5F;
            color: #F8FAFC;
            border-radius: 8px;
            padding: 10px 14px;
        }

        .form-control-sso:focus {
            background: #0A2540;
            border-color: #0284C7;
            color: #F8FAFC;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.3);
        }
    </style>
</head>
<body>

    <div class="sso-gateway-card">
        <!-- HEADER -->
        <div class="sso-header">
            <div class="sso-seal">
                <img src="{{ asset('images/logo-baketrans.png') }}" alt="Logo Kementerian Perhubungan">
            </div>
            <div class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-50 px-3 py-1 mb-2 font-monospace" style="font-size: 0.72rem;">
                <i class="bi bi-shield-lock-fill me-1"></i> IdP Gateway &bull; Kemenhub Auth v2.6
            </div>
            <h1 class="fs-4 fw-bold mb-1 tracking-tight">SINGLE SIGN-ON (SSO) KEMENHUB</h1>
            <p class="small text-light text-opacity-75 m-0" style="font-size: 0.78rem;">
                Gerbang Masuk Tunggal ASN &bull; Kementerian Perhubungan Republik Indonesia
            </p>
        </div>

        <!-- BODY -->
        <div class="p-4 p-md-5">

            <div class="alert alert-info py-2 px-3 small border-info border-opacity-25 mb-4 d-flex align-items-center gap-2" style="background: rgba(2, 132, 199, 0.12); color: #BAE6FD;">
                <i class="bi bi-info-circle-fill text-info fs-5"></i>
                <div>
                    Aplikasi <strong>E-Surat PKST (BKT Kemenhub)</strong> meminta akses profil terverifikasi identitas ASN Anda.
                </div>
            </div>

            <!-- TABS -->
            <ul class="nav nav-tabs nav-tabs-sso mb-4 border-bottom border-secondary border-opacity-25" id="ssoTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="preset-tab" data-bs-toggle="tab" data-bs-target="#preset-content" type="button" role="tab">
                        <i class="bi bi-people-fill me-1"></i> Pilih Akun ASN (1-Klik)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="custom-tab" data-bs-toggle="tab" data-bs-target="#custom-content" type="button" role="tab">
                        <i class="bi bi-person-plus-fill me-1"></i> Akun ASN Baru (Kustom)
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="ssoTabContent">
                <!-- TAB 1: PRESET ACCOUNTS -->
                <div class="tab-pane fade show active" id="preset-content" role="tabpanel">
                    <p class="small text-muted mb-3">
                        Pilih profil simulasi ASN untuk masuk (*Sign In*) atau melakukan pendaftaran otomatis (*Sign Up via SSO*):
                    </p>

                    @foreach($ssoAccounts as $acc)
                        <form action="{{ route('sso.authorize', $provider) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="name" value="{{ $acc['name'] }}">
                            <input type="hidden" name="nip" value="{{ $acc['nip'] }}">
                            <input type="hidden" name="email" value="{{ $acc['email'] }}">
                            <input type="hidden" name="jabatan" value="{{ $acc['jabatan'] }}">
                            <input type="hidden" name="unit_kerja" value="{{ $acc['unit_kerja'] }}">

                            <button type="submit" class="sso-account-item w-100 text-start border-0">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background: rgba(2, 132, 199, 0.2); color: #38BDF8;">
                                        <i class="bi bi-person-badge fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-white small">{{ $acc['name'] }}</div>
                                        <div class="text-muted font-monospace" style="font-size: 0.72rem;">NIP. {{ $acc['nip'] }} &bull; {{ $acc['email'] }}</div>
                                        <div class="text-info text-truncate" style="font-size: 0.72rem;">{{ $acc['jabatan'] }}</div>
                                    </div>
                                </div>
                                <div>
                                    @if($acc['is_existing'])
                                        <span class="badge bg-primary bg-opacity-25 text-info border border-info border-opacity-50" style="font-size: 0.7rem;">
                                            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                                        </span>
                                    @else
                                        <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50" style="font-size: 0.7rem;">
                                            <i class="bi bi-sparkles me-1"></i> Sign Up Baru
                                        </span>
                                    @endif
                                </div>
                            </button>
                        </form>
                    @endforeach
                </div>

                <!-- TAB 2: CUSTOM ASN FORM -->
                <div class="tab-pane fade" id="custom-content" role="tabpanel">
                    <p class="small text-muted mb-3">
                        Masukkan identitas kredensial ASN kustom untuk menguji alur otorisasi SSO Kemenhub:
                    </p>

                    <form action="{{ route('sso.authorize', $provider) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small text-muted mb-1">Nama Lengkap & Gelar ASN</label>
                            <input type="text" name="name" class="form-control form-control-sso" placeholder="Contoh: Hendra Pratama, S.Tr.Tra." required>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small text-muted mb-1">Nomor Induk Pegawai (NIP)</label>
                                <input type="text" name="nip" class="form-control form-control-sso font-monospace" placeholder="19980101 202401 1 001">
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted mb-1">Email Kemenhub</label>
                                <input type="email" name="email" class="form-control form-control-sso" placeholder="hendra@bkt.dephub.go.id" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted mb-1">Jabatan Fungsional</label>
                            <input type="text" name="jabatan" class="form-control form-control-sso" value="Analis Kebijakan Sarana Transportasi">
                        </div>

                        <input type="hidden" name="unit_kerja" value="Pusat Kebijakan Sarana Transportasi">

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mt-2">
                            <i class="bi bi-shield-check me-1"></i> Otorisasi & Lanjutkan ke E-Surat
                        </button>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4 pt-3 border-top border-secondary border-opacity-25">
                <a href="{{ route('login') }}" class="small text-muted text-decoration-none">
                    <i class="bi bi-x-circle me-1"></i> Batalkan & Kembali ke Halaman Masuk
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
