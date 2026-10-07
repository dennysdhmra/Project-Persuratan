<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function verify($token)
    {
        $surat = SuratKeluar::with(['konseptor', 'parafKabid', 'tteKapus'])
            ->where('qr_code_token', $token)
            ->first();

        return view('verifikasi.index', compact('surat', 'token'));
    }
}
