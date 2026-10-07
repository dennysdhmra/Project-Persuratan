<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $totalSuratMasuk = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();
        $totalDisposisi = Disposisi::count();
        $sampleToken = SuratKeluar::whereNotNull('tte_kapus_at')->whereNotNull('qr_code_token')->latest()->value('qr_code_token') ?? 'BKT-PKST-TTE-2026-9874128471';

        return view('landing', compact(
            'totalSuratMasuk',
            'totalSuratKeluar',
            'totalDisposisi',
            'sampleToken'
        ));
    }
}
