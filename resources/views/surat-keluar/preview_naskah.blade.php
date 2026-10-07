<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naskah Dinas Resmi - {{ $surat->no_surat }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-baketrans.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background: #F1F5F9;
            padding: 30px;
            color: #000;
            line-height: 1.6;
        }
        .paper {
            background: #FFF;
            max-width: 800px;
            margin: 0 auto;
            padding: 48px 56px;
            border: 1px solid #CBD5E1;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            min-height: 1050px;
            position: relative;
        }
        .header-kop {
            position: relative;
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 12px;
            margin-bottom: 24px;
            min-height: 85px;
        }
        .header-kop .kop-logo {
            position: absolute;
            left: 10px;
            top: 2px;
            width: 78px;
            height: auto;
        }
        .header-kop-text {
            padding-left: 80px;
            padding-right: 80px;
        }
        .header-kop h2 {
            font-size: 14pt;
            margin: 0;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .header-kop h3 {
            font-size: 13pt;
            margin: 2px 0;
            font-weight: bold;
        }
        .header-kop h4 {
            font-size: 11pt;
            margin: 2px 0;
            font-weight: bold;
        }
        .header-kop p {
            font-size: 8.5pt;
            margin: 2px 0;
            font-style: italic;
        }
        .table-letter-meta {
            width: 100%;
            margin-bottom: 24px;
            font-size: 11pt;
        }
        .table-letter-meta td {
            vertical-align: top;
            padding: 2px 0;
        }
        .letter-content {
            font-size: 11.5pt;
            text-align: justify;
            white-space: pre-line;
            margin-bottom: 36px;
        }
        .tte-signature-block {
            float: right;
            width: 320px;
            text-align: center;
            font-size: 11pt;
            margin-top: 20px;
        }
        .tte-box {
            border: 1px dashed #0A2540;
            padding: 10px;
            margin: 12px auto;
            background: #F8FAFC;
            display: flex;
            align-items: center;
            gap: 12px;
            text-align: left;
            border-radius: 6px;
        }
        .qr-placeholder {
            width: 60px;
            height: 60px;
            background: #0A2540;
            color: #F5A623;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            flex-shrink: 0;
            border-radius: 4px;
        }
        .print-nav {
            text-align: center;
            margin-bottom: 24px;
        }
        .btn-action {
            background: #0A2540;
            color: #FFF;
            padding: 10px 20px;
            font-size: 10.5pt;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        @media print {
            body {
                background: #FFF;
                padding: 0;
            }
            .paper {
                box-shadow: none;
                border: none;
                padding: 20px;
            }
            .print-nav {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="print-nav">
        <button class="btn-action" onclick="window.print()"><i class="bi bi-printer-fill" style="margin-right: 6px;"></i> Cetak Dokumen Resmi (PDF / Print)</button>
        <button class="btn-action" style="background: #475569; margin-left: 10px;" onclick="window.close()">Tutup Pratinjau</button>
    </div>

    <div class="paper">
        <!-- KOP SURAT RESMI -->
        <div class="header-kop">
            <img src="{{ asset('images/logo-baketrans.png') }}" alt="Logo Baketrans" class="kop-logo">
            <div class="header-kop-text">
                <h2>KEMENTERIAN PERHUBUNGAN</h2>
                <h3>BADAN KEBIJAKAN TRANSPORTASI</h3>
                <h4>PUSAT KEBIJAKAN SARANA TRANSPORTASI</h4>
                <p>Jalan Medan Merdeka Timur No. 5, Gambir, Jakarta Pusat 10110 | Telp: (021) 3847519</p>
            </div>
        </div>

        <!-- META SURAT -->
        <table class="table-letter-meta">
            <tr>
                <td style="width: 15%;">Nomor</td>
                <td style="width: 3%;">:</td>
                <td style="width: 47%;"><strong>{{ $surat->no_surat }}</strong></td>
                <td style="width: 35%; text-align: right;">Jakarta, {{ $surat->tanggal_surat->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Klasifikasi</td>
                <td>:</td>
                <td>{{ $surat->sifat_surat }}</td>
                <td></td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>{{ $surat->file_lampiran ? '1 (satu) Berkas' : '-' }}</td>
                <td></td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>:</td>
                <td colspan="2"><strong>{{ $surat->perihal }}</strong></td>
            </tr>
        </table>

        <!-- TUJUAN -->
        <div style="margin-bottom: 24px; font-size: 11pt;">
            Yth.<br>
            <strong>{{ $surat->tujuan_surat }}</strong><br>
            di Tempat
        </div>

        <!-- ISI SURAT -->
        <div class="letter-content">
            {{ $surat->isi_surat }}
        </div>

        <!-- TANDA TANGAN / TTE BLOCK -->
        <div class="tte-signature-block">
            <p><strong>KEPALA PUSAT KEBIJAKAN SARANA TRANSPORTASI</strong></p>

            @if($surat->tte_kapus_at)
                <!-- TTE VALID BER-QR CODE -->
                <div class="tte-box">
                    <div class="qr-placeholder">
                        QR
                    </div>
                    <div style="font-size: 8pt; line-height: 1.3;">
                        <span style="font-weight: bold; color: #0A2540;">DITANDATANGANI ELEKTRONIK</span><br>
                        <span>Sertifikat Digital BSrE Kemenhub</span><br>
                        <span>Tgl: {{ $surat->tte_kapus_at->format('d/m/Y H:i') }} WIB</span><br>
                        <span style="font-family: monospace; color: #0284C7;">ID: {{ substr($surat->qr_code_token, 0, 16) }}...</span>
                    </div>
                </div>
                <p><strong><u>{{ $surat->tteKapus ? $surat->tteKapus->name : 'Dr. Ir. Bambang Priyanto, M.T.' }}</u></strong></p>
                <p>NIP. {{ $surat->tteKapus ? $surat->tteKapus->nip : '19720415 199803 1 001' }}</p>
            @else
                <div style="height: 80px; display: flex; align-items: center; justify-content: center; color: #94A3B8; font-style: italic; border: 1px dashed #CBD5E1; margin: 12px 0;">
                    [ Menunggu Tanda Tangan Elektronik ]
                </div>
                <p><strong><u>Dr. Ir. Bambang Priyanto, M.T.</u></strong></p>
                <p>NIP. 19720415 199803 1 001</p>
            @endif
        </div>

        <div style="clear: both;"></div>

        <!-- TEMBUSAN & PARAF HIERARKI (FOOTER) -->
        <div style="margin-top: 40px; font-size: 9pt; border-top: 1px solid #CBD5E1; padding-top: 10px; color: #475569;">
            <p><strong>Tembusan Yth:</strong></p>
            <ol style="margin-left: 18px; margin-top: 4px;">
                <li>Kepala Badan Kebijakan Transportasi (sebagai laporan)</li>
                <li>Sekretaris Badan Kebijakan Transportasi</li>
                <li>Kepala Bidang Terkait</li>
            </ol>

            @if($surat->paraf_kabid_at)
            <div style="margin-top: 10px; font-size: 8pt; color: #059669;">
                <i class="bi bi-check2-circle" style="margin-right: 4px;"></i> Paraf Koordinasi Kepala Bidang: {{ $surat->parafKabid ? $surat->parafKabid->name : 'Ir. H. Agus Wahyudi, M.Sc.' }} ({{ $surat->paraf_kabid_at->format('d/m/Y H:i') }} WIB)
            </div>
            @endif
        </div>
    </div>

</body>
</html>
