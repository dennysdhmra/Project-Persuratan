<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisposisiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Disposisi::with(['suratMasuk', 'pemberi', 'penerima'])
            ->orderBy('created_at', 'desc');

        if ($user->isPegawai()) {
            $query->where('kepada_user_id', $user->id);
        } elseif ($user->isKabid()) {
            $query->where(function ($q) use ($user) {
                $q->where('dari_user_id', $user->id)
                  ->orWhere('kepada_user_id', $user->id);
            });
        } elseif ($user->isKapus()) {
            $query->where(function ($q) use ($user) {
                $q->where('dari_user_id', $user->id)
                  ->orWhere('kepada_user_id', $user->id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $disposisiList = $query->paginate(10)->withQueryString();

        return view('disposisi.index', compact('disposisiList'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->isPimpinan() && !$user->isAdmin()) {
            abort(403, 'Hanya Pimpinan (Kapus / Kabid) dan Admin yang dapat memberikan instruksi disposisi.');
        }

        $validated = $request->validate([
            'surat_masuk_id' => 'required|exists:surat_masuk,id',
            'kepada_user_id' => 'required|exists:users,id',
            'instruksi' => 'required|array|min:1',
            'catatan_disposisi' => 'required|string',
            'batas_waktu' => 'nullable|date',
        ]);

        $disposisi = Disposisi::create([
            'surat_masuk_id' => $validated['surat_masuk_id'],
            'dari_user_id' => $user->id,
            'kepada_user_id' => $validated['kepada_user_id'],
            'instruksi' => $validated['instruksi'],
            'catatan_disposisi' => $validated['catatan_disposisi'],
            'batas_waktu' => $validated['batas_waktu'] ?? now()->addDays(3)->toDateString(),
            'status' => 'Menunggu',
        ]);

        // Update status surat masuk
        $surat = SuratMasuk::find($validated['surat_masuk_id']);
        $surat->update(['status' => 'Telah Didisposisi']);

        $penerima = User::find($validated['kepada_user_id']);
        ActivityLog::record(
            $user->id,
            'DISPOSISI_SURAT',
            "Memberikan lembar disposisi pada Surat Masuk {$surat->no_agenda} kepada {$penerima->name} dengan instruksi: " . implode(', ', $validated['instruksi'])
        );

        return redirect()->route('surat-masuk.show', $surat->id)
            ->with('success', "Lembar disposisi berhasil diteruskan kepada {$penerima->name}.");
    }

    public function tindakLanjut(Request $request, $id)
    {
        $disposisi = Disposisi::with('suratMasuk')->findOrFail($id);
        $user = Auth::user();

        // Validasi kepemilikan tugas disposisi
        if ($disposisi->kepada_user_id != $user->id && !$user->isAdmin()) {
            abort(403, 'Hanya pegawai yang ditugaskan yang dapat memperbarui tindak lanjut disposisi ini.');
        }

        $validated = $request->validate([
            'status' => 'required|in:Sedang Dikerjakan,Selesai',
            'tanggapan_pegawai' => 'required|string',
            'file_laporan' => 'nullable|file|mimes:pdf,docx,doc,zip|max:10240',
        ]);

        $fileName = $disposisi->file_laporan;
        if ($request->hasFile('file_laporan')) {
            $file = $request->file('file_laporan');
            $fileName = 'laporan_' . time() . '_' . $file->getClientOriginalName();
            $file->storeAs('laporan', $fileName, 'public');
        }

        $disposisi->update([
            'status' => $validated['status'],
            'tanggapan_pegawai' => $validated['tanggapan_pegawai'],
            'file_laporan' => $fileName,
            'tanggal_selesai' => ($validated['status'] === 'Selesai') ? now() : null,
        ]);

        // Jika semua disposisi selesai, update status surat masuk
        if ($validated['status'] === 'Selesai') {
            $surat = $disposisi->suratMasuk;
            $allDone = $surat->disposisi()->where('status', '!=', 'Selesai')->count() === 0;
            if ($allDone) {
                $surat->update(['status' => 'Selesai']);
            } else {
                $surat->update(['status' => 'Sedang Ditindaklanjuti']);
            }
        }

        ActivityLog::record(
            $user->id,
            'TINDAK_LANJUT_DISPOSISI',
            "Memperbarui progres tindak lanjut disposisi ({$validated['status']}) untuk Surat Masuk: {$disposisi->suratMasuk->no_agenda}"
        );

        return redirect()->route('surat-masuk.show', $disposisi->surat_masuk_id)
            ->with('success', 'Laporan tindak lanjut disposisi berhasil disimpan.');
    }
}
