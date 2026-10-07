<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Disposisi - {{ $surat->no_agenda }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-baketrans.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #F1F5F9;
            padding: 30px;
            color: #000;
        }
        .disposisi-paper {
            background: #FFF;
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #000;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .header-kop {
            position: relative;
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 12px;
            margin-bottom: 16px;
            min-height: 75px;
        }
        .header-kop .kop-logo {
            position: absolute;
            left: 5px;
            top: 0;
            width: 70px;
            height: auto;
        }
        .header-kop-text {
            padding-left: 75px;
            padding-right: 75px;
        }
        .header-kop h2 {
            font-size: 14pt;
            margin: 0;
            text-transform: uppercase;
        }
        .header-kop h3 {
            font-size: 12pt;
            margin: 2px 0;
            text-transform: uppercase;
        }
        .header-kop h4 {
            font-size: 11pt;
            margin: 2px 0;
            font-weight: normal;
        }
        .header-kop p {
            font-size: 9pt;
            margin: 2px 0;
        }
        .doc-title {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 16px;
        }
        .table-meta {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 10pt;
        }
        .table-meta td {
            border: 1px solid #000;
            padding: 6px 10px;
            vertical-align: top;
        }
        .table-instructions {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
            margin-bottom: 16px;
        }
        .table-instructions td {
            border: 1px solid #000;
            padding: 8px 10px;
            vertical-align: top;
        }
        .print-btn-bar {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-print {
            background: #0A2540;
            color: #FFF;
            border: none;
            padding: 10px 24px;
            font-size: 11pt;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
        }
        @media print {
            body {
                background: #FFF;
                padding: 0;
            }
            .disposisi-paper {
                border: 2px solid #000;
                box-shadow: none;
                max-width: 100%;
            }
            .print-btn-bar {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="print-btn-bar">
        <button class="btn-print" onclick="window.print()"><i class="bi bi-printer-fill" style="margin-right: 6px;"></i> Cetak Lembar Disposisi (Print)</button>
        <button class="btn-print" style="background: #475569; margin-left: 10px;" onclick="window.close()">Tutup</button>
    </div>

    <div class="disposisi-paper">
        <div class="header-kop">
            <img src="{{ asset('images/logo-baketrans.png') }}" alt="Logo Baketrans" class="kop-logo">
            <div class="header-kop-text">
                <h2>KEMENTERIAN PERHUBUNGAN</h2>
                <h3>BADAN KEBIJAKAN TRANSPORTASI</h3>
                <h4>PUSAT KEBIJAKAN SARANA TRANSPORTASI</h4>
                <p>Jl. Medan Merdeka Timur No. 5, Gambir, Jakarta Pusat 10110 | Telp: (021) 3847519</p>
            </div>
        </div>

        <div class="doc-title">LEMBAR DISPOSISI</div>

        <table class="table-meta">
            <tr>
                <td style="width: 25%;"><strong>Nomor Agenda:</strong><br>{{ $surat->no_agenda }}</td>
                <td style="width: 25%;"><strong>Tingkat Keamanan:</strong><br>{{ $surat->sifat_surat }}</td>
                <td style="width: 25%;"><strong>Tanggal Penerimaan:</strong><br>{{ $surat->tanggal_diterima->format('d/m/Y') }}</td>
                <td style="width: 25%;"><strong>Kode Klasifikasi:</strong><br>{{ $surat->klasifikasi_kode }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Nomor Surat Asal:</strong><br>{{ $surat->no_surat_asal }}</td>
                <td colspan="2"><strong>Tanggal Surat Asal:</strong><br>{{ $surat->tanggal_surat->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td colspan="4"><strong>Asal Instansi / Pengirim:</strong><br>{{ $surat->asal_instansi }}</td>
            </tr>
            <tr>
                <td colspan="4"><strong>Perihal:</strong><br>{{ $surat->perihal }}</td>
            </tr>
        </table>

        <table class="table-instructions">
            <tr>
                <td style="width: 50%; font-weight: bold; background: #F3F4F6;">DISPOSISI KEPADA:</td>
                <td style="width: 50%; font-weight: bold; background: #F3F4F6;">PETUNJUK / INSTRUKSI:</td>
            </tr>
            <tr>
                <td>
                    @if($surat->disposisi->count() > 0)
                        @foreach($surat->disposisi as $d)
                            <div style="margin-bottom: 10px;">
                                [ &times; ] <strong>{{ $d->penerima->name }}</strong><br>
                                <span style="font-size: 8.5pt; color: #4B5563;">{{ $d->penerima->jabatan }}</span>
                            </div>
                        @endforeach
                    @else
                        [ &nbsp; ] Kepala Bagian Tata Usaha<br>
                        [ &nbsp; ] Analis Kebijakan Sarana Darat<br>
                        [ &nbsp; ] Analis Kebijakan Sarana Perkeretaapian<br>
                        [ &nbsp; ] Analis Kebijakan Sarana Laut & Udara
                    @endif
                </td>
                <td>
                    @php 
                        $allInst = $surat->disposisi->pluck('instruksi')->flatten()->toArray();
                    @endphp
                    <div>[ {{ in_array('Tindak Lanjuti', $allInst) ? '&times;' : '&nbsp;' }} ] Tindak Lanjuti</div>
                    <div>[ {{ in_array('Selesaikan', $allInst) ? '&times;' : '&nbsp;' }} ] Selesaikan</div>
                    <div>[ {{ in_array('Pelajari / Kaji', $allInst) ? '&times;' : '&nbsp;' }} ] Pelajari / Kaji</div>
                    <div>[ {{ in_array('Koordinasikan', $allInst) ? '&times;' : '&nbsp;' }} ] Koordinasikan</div>
                    <div>[ {{ in_array('Siapkan Bahan / Tanggapan', $allInst) ? '&times;' : '&nbsp;' }} ] Siapkan Bahan / Tanggapan</div>
                    <div>[ {{ in_array('Hadiri / Wakilkan', $allInst) ? '&times;' : '&nbsp;' }} ] Hadiri / Wakilkan</div>
                    <div>[ {{ in_array('Simpan / Arsipkan', $allInst) ? '&times;' : '&nbsp;' }} ] Simpan / Arsipkan</div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>CATATAN / ARAHAN PIMPINAN:</strong>
                    <div style="min-height: 80px; padding: 8px; font-style: italic;">
                        @foreach($surat->disposisi as $d)
                            <p style="margin: 4px 0;">"{{ $d->catatan_disposisi }}" &mdash; <strong>{{ $d->pemberi->name }}</strong> ({{ $d->created_at->format('d/m/Y') }})</p>
                        @endforeach
                    </div>
                </td>
            </tr>
        </table>

        <div style="display: flex; justify-content: space-between; margin-top: 20px; font-size: 10pt;">
            <div style="text-align: center; width: 220px;">
                <p>Penerima Disposisi,</p>
                <div style="height: 60px;"></div>
                @if($surat->disposisi->count() > 0)
                    <p style="font-weight: bold; text-decoration: underline;">{{ $surat->disposisi->first()->penerima->name }}</p>
                    <p>NIP. {{ $surat->disposisi->first()->penerima->nip ?? '-' }}</p>
                @else
                    <p style="font-weight: bold; text-decoration: underline;">(....................................................)</p>
                @endif
            </div>

            <div style="text-align: center; width: 240px;">
                <p>Kepala Pusat Kebijakan Sarana Transportasi,</p>
                <div style="height: 60px;"></div>
                <p style="font-weight: bold; text-decoration: underline;">Dr. Ir. Bambang Priyanto, M.T.</p>
                <p>NIP. 19730514 199803 1 001</p>
            </div>
        </div>
    </div>

</body>
</html>
