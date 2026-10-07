<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Disposisi;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. General Metrics
        $totalSuratMasuk = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();
        $totalDisposisiAktif = Disposisi::whereIn('status', ['Menunggu', 'Sedang Dikerjakan'])->count();
        $totalSelesai = SuratMasuk::where('status', 'Selesai')->count() + SuratKeluar::where('status', 'Terkirim')->count();

        // 2. Role-specific counts & query lists
        $pendingDisposisiCount = 0;
        $myDisposisiList = collect();
        $needParafCount = 0;
        $needTteCount = 0;

        if ($user->isPegawai()) {
            $myDisposisiList = Disposisi::with('suratMasuk', 'pemberi')
                ->where('kepada_user_id', $user->id)
                ->whereIn('status', ['Menunggu', 'Sedang Dikerjakan'])
                ->orderBy('batas_waktu', 'asc')
                ->take(5)
                ->get();
            $pendingDisposisiCount = $myDisposisiList->count();
        }

        if ($user->isKabid() || $user->isAdmin()) {
            $needParafCount = SuratKeluar::where('status', 'Menunggu Paraf Kabid')->count();
        }

        if ($user->isKapus() || $user->isAdmin()) {
            $needTteCount = SuratKeluar::where('status', 'Menunggu TTE Kapus')->count();
        }

        // 3. Recent Incoming & Outgoing letters
        $recentSuratMasuk = SuratMasuk::with('creator', 'disposisi.penerima')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentSuratKeluar = SuratKeluar::with('konseptor', 'parafKabid', 'tteKapus')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 4. Overdue SLA Disposisi
        $overdueDisposisi = Disposisi::with('suratMasuk', 'penerima')
            ->whereIn('status', ['Menunggu', 'Sedang Dikerjakan'])
            ->whereNotNull('batas_waktu')
            ->whereDate('batas_waktu', '<', now()->toDateString())
            ->take(5)
            ->get();

        // 5. Activity stream
        $recentLogs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('dashboard.index', compact(
            'user',
            'totalSuratMasuk',
            'totalSuratKeluar',
            'totalDisposisiAktif',
            'totalSelesai',
            'myDisposisiList',
            'pendingDisposisiCount',
            'needParafCount',
            'needTteCount',
            'recentSuratMasuk',
            'recentSuratKeluar',
            'overdueDisposisi',
            'recentLogs'
        ));
    }
}
