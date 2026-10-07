<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\MasterKlasifikasi;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SuratKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratKeluar::with(['konseptor', 'parafKabid', 'tteKapus', 'klasifikasi'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_surat', 'like', "%{$search}%")
                  ->orWhere('tujuan_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $suratKeluar = $query->paginate(10)->withQueryString();
        $klasifikasiList = MasterKlasifikasi::all();

        return view('surat-keluar.index', compact('suratKeluar', 'klasifikasiList'));
    }

    public function create()
    {
        $year = date('Y');
        $lastRecord = SuratKeluar::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        $nextSeq = $lastRecord ? ($lastRecord->id + 1) : 1;
        $suggestedNo = sprintf('PR.102/%03d/PKST-BKT/%s', $nextSeq, $year);

        $klasifikasiList = MasterKlasifikasi::all();

        return view('surat-keluar.create', compact('suggestedNo', 'klasifikasiList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_surat' => 'required|unique:surat_keluar,no_surat',
            'tujuan_surat' => 'required',
            'perihal' => 'required',
            'tanggal_surat' => 'required|date',
            'sifat_surat' => 'required|in:Sangat Segera,Segera,Biasa,Rahasia',
            'klasifikasi_kode' => 'required',
            'ringkasan_isi' => 'nullable|string',
            'isi_surat' => 'required|string',
            'file_lampiran' => 'nullable|file|mimes:pdf,docx,doc|max:10240',
        ]);

        $fileName = null;
        if ($request->hasFile('file_lampiran')) {
            $file = $request->file('file_lampiran');
            $fileName = 'draft_' . time() . '_' . $file->getClientOriginalName();
            $file->storeAs('draft_surat', $fileName, 'public');
        }

        $surat = SuratKeluar::create([
            'no_surat' => $validated['no_surat'],
            'tujuan_surat' => $validated['tujuan_surat'],
            'perihal' => $validated['perihal'],
            'tanggal_surat' => $validated['tanggal_surat'],
            'sifat_surat' => $validated['sifat_surat'],
            'klasifikasi_kode' => $validated['klasifikasi_kode'],
            'ringkasan_isi' => $validated['ringkasan_isi'],
            'isi_surat' => $validated['isi_surat'],
            'file_lampiran' => $fileName,
            'status' => 'Draft Konsep',
            'konseptor_id' => Auth::id(),
            'qr_code_token' => 'BKT-PKST-' . strtoupper(Str::random(16)),
        ]);

        ActivityLog::record(Auth::id(), 'DRAFT_SURAT_KELUAR', "Membuat konsep surat keluar baru: {$surat->no_surat}");

        return redirect()->route('surat-keluar.show', $surat->id)
            ->with('success', "Konsep surat {$surat->no_surat} berhasil dibuat.");
    }

    public function show($id)
    {
        $surat = SuratKeluar::with(['konseptor', 'parafKabid', 'tteKapus', 'klasifikasi'])
            ->findOrFail($id);

        return view('surat-keluar.show', compact('surat'));
    }

    public function ajukanParaf($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        $user = Auth::user();

        if ($surat->konseptor_id != $user->id && !$user->isAdmin()) {
            abort(403, 'Hanya konseptor yang dapat mengajukan surat ke Kepala Bidang.');
        }

        $surat->update(['status' => 'Menunggu Paraf Kabid']);

        ActivityLog::record($user->id, 'AJUKAN_PARAF', "Mengajukan paraf Kepala Bidang untuk Surat: {$surat->no_surat}");

        return redirect()->route('surat-keluar.show', $surat->id)
            ->with('success', 'Konsep surat berhasil diajukan ke Kepala Bidang untuk proses paraf koordinasi.');
    }

    public function parafKabid(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isKabid() && !$user->isAdmin()) {
            abort(403, 'Hanya Kepala Bidang yang berwenang memberikan paraf koordinasi pada surat ini.');
        }

        $surat = SuratKeluar::findOrFail($id);
        $request->validate([
            'catatan' => 'nullable|string',
        ]);

        $surat->update([
            'status' => 'Menunggu TTE Kapus',
            'paraf_kabid_by' => $user->id,
            'paraf_kabid_at' => now(),
            'paraf_kabid_catatan' => $request->input('catatan', 'Telah diteliti secara teknis dan disetujui untuk pengesahan TTE Kepala Pusat.'),
        ]);

        ActivityLog::record($user->id, 'PARAF_KABID', "Memberikan paraf elektronik pada Surat: {$surat->no_surat}");

        return redirect()->route('surat-keluar.show', $surat->id)
            ->with('success', 'Paraf elektronik Kepala Bidang berhasil disematkan. Naskah dinas diteruskan ke Kepala Pusat untuk TTE.');
    }

    public function tteKapus(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isKapus() && !$user->isAdmin()) {
            abort(403, 'Hanya Kepala Pusat Kebijakan Sarana Transportasi yang berwenang melakukan pengesahan TTE.');
        }

        $surat = SuratKeluar::findOrFail($id);
        $request->validate([
            'catatan' => 'nullable|string',
        ]);

        $surat->update([
            'status' => 'Disetujui/TTE',
            'tte_kapus_by' => $user->id,
            'tte_kapus_at' => now(),
            'tte_kapus_catatan' => $request->input('catatan', 'Disahkan dengan Tanda Tangan Elektronik (TTE) tersertifikasi Kepala Pusat Kebijakan Sarana Transportasi.'),
        ]);

        ActivityLog::record($user->id, 'TTE_KAPUS', "Melakukan pengesahan Tanda Tangan Elektronik (TTE) pada Surat: {$surat->no_surat}");

        return redirect()->route('surat-keluar.show', $surat->id)
            ->with('success', 'Tanda Tangan Elektronik (TTE) Kepala Pusat berhasil disahkan. QR Code verifikasi aktif!');
    }

    public function kirimSurat($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        $user = Auth::user();

        $surat->update(['status' => 'Terkirim']);
        ActivityLog::record($user->id, 'KIRIM_SURAT_KELUAR', "Mengirim dan mengarsipkan Surat Keluar: {$surat->no_surat}");

        return redirect()->route('surat-keluar.show', $surat->id)
            ->with('success', "Surat {$surat->no_surat} telah resmi dikirimkan dan diarsipkan.");
    }

    public function previewNaskah($id)
    {
        $surat = SuratKeluar::with(['konseptor', 'parafKabid', 'tteKapus', 'klasifikasi'])
            ->findOrFail($id);

        return view('surat-keluar.preview_naskah', compact('surat'));
    }
}
