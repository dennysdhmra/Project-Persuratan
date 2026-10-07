<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\MasterKlasifikasi;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratMasuk::with(['creator', 'disposisi.penerima', 'klasifikasi'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_agenda', 'like', "%{$search}%")
                  ->orWhere('no_surat_asal', 'like', "%{$search}%")
                  ->orWhere('asal_instansi', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('sifat')) {
            $query->where('sifat_surat', $request->sifat);
        }

        $suratMasuk = $query->paginate(10)->withQueryString();
        $klasifikasiList = MasterKlasifikasi::all();

        return view('surat-masuk.index', compact('suratMasuk', 'klasifikasiList'));
    }

    public function create()
    {
        // Auto-generate nomor agenda
        $year = date('Y');
        $lastRecord = SuratMasuk::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        $nextSeq = $lastRecord ? ($lastRecord->id + 1) : 1;
        $suggestedAgenda = sprintf('AGD/PKST/%s/%03d', $year, $nextSeq);

        $klasifikasiList = MasterKlasifikasi::all();
        $stafList = User::where('role', 'pegawai')->get();

        return view('surat-masuk.create', compact('suggestedAgenda', 'klasifikasiList', 'stafList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_agenda' => 'required|unique:surat_masuk,no_agenda',
            'no_surat_asal' => 'required',
            'asal_instansi' => 'required',
            'perihal' => 'required',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'sifat_surat' => 'required|in:Sangat Segera,Segera,Biasa,Rahasia',
            'klasifikasi_kode' => 'required',
            'ringkasan_isi' => 'nullable|string',
            'catatan_penerima' => 'nullable|string',
            'file_lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:10240',
        ]);

        $fileName = 'lampiran_surat_' . time() . '.pdf';
        if ($request->hasFile('file_lampiran')) {
            $file = $request->file('file_lampiran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('lampiran', $fileName, 'public');
        }

        $surat = SuratMasuk::create([
            'no_agenda' => $validated['no_agenda'],
            'no_surat_asal' => $validated['no_surat_asal'],
            'asal_instansi' => $validated['asal_instansi'],
            'perihal' => $validated['perihal'],
            'tanggal_surat' => $validated['tanggal_surat'],
            'tanggal_diterima' => $validated['tanggal_diterima'],
            'sifat_surat' => $validated['sifat_surat'],
            'klasifikasi_kode' => $validated['klasifikasi_kode'],
            'ringkasan_isi' => $validated['ringkasan_isi'],
            'file_lampiran' => $fileName,
            'catatan_penerima' => $validated['catatan_penerima'],
            'status' => 'Baru Masuk',
            'created_by' => Auth::id(),
        ]);

        ActivityLog::record(Auth::id(), 'REGISTRASI_SURAT_MASUK', "Mencatat surat masuk baru No. Agenda: {$surat->no_agenda} dari {$surat->asal_instansi}");

        return redirect()->route('surat-masuk.show', $surat->id)
            ->with('success', "Surat Masuk No. Agenda {$surat->no_agenda} berhasil didaftarkan.");
    }

    public function show($id)
    {
        $surat = SuratMasuk::with(['creator', 'disposisi.pemberi', 'disposisi.penerima', 'klasifikasi'])
            ->findOrFail($id);

        $stafList = User::whereIn('role', ['pegawai', 'kepala_pusat'])->get();

        return view('surat-masuk.show', compact('surat', 'stafList'));
    }

    public function lembarDisposisi($id)
    {
        $surat = SuratMasuk::with(['creator', 'disposisi.pemberi', 'disposisi.penerima'])
            ->findOrFail($id);

        return view('surat-masuk.lembar_disposisi', compact('surat'));
    }
}
