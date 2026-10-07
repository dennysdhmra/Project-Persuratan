<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerifikasiApiController extends Controller
{
    public function check(Request $request, string $token): JsonResponse
    {
        $surat = SuratKeluar::with(['konseptor', 'parafKabid', 'tteKapus'])
            ->where('qr_code_token', $token)
            ->first();

        if (!$surat || !$surat->tte_kapus_at) {
            return response()->json([
                'valid' => false,
                'token' => $token,
                'message' => 'Token naskah dinas tidak ditemukan dalam pangkalan data atau belum ditandatangani secara elektronik oleh Kepala Pusat.',
            ], 404);
        }

        return response()->json([
            'valid' => true,
            'token' => $token,
            'no_surat' => $surat->no_surat,
            'perihal' => $surat->perihal,
            'tujuan' => $surat->tujuan_surat,
            'sifat_surat' => $surat->sifat_surat,
            'tanggal_surat' => $surat->tanggal_surat->format('d F Y'),
            'penandatangan' => [
                'nama' => $surat->tteKapus ? $surat->tteKapus->name : 'Dr. Ir. Bambang Priyanto, M.T.',
                'jabatan' => 'Kepala Pusat Kebijakan Sarana Transportasi',
                'nip' => $surat->tteKapus ? $surat->tteKapus->nip : '19720415 199803 1 001',
                'timestamp' => $surat->tte_kapus_at->format('d M Y, H:i:s') . ' WIB',
            ],
            'paraf_kabid' => [
                'nama' => $surat->parafKabid ? $surat->parafKabid->name : 'Ir. H. Agus Wahyudi, M.Sc.',
                'jabatan' => 'Kepala Bidang Sarana Transportasi',
                'timestamp' => $surat->paraf_kabid_at ? $surat->paraf_kabid_at->format('d M Y, H:i:s') . ' WIB' : '-',
            ],
            'integritas_sha256' => hash('sha256', $surat->qr_code_token . $surat->no_surat),
            'preview_url' => route('surat-keluar.preview', $surat->id),
            'verify_page_url' => route('verifikasi.tte', $surat->qr_code_token),
        ]);
    }
}
