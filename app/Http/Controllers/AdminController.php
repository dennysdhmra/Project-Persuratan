<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\MasterKlasifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::withCount(['disposisiDiterima', 'suratKeluarDikonsep'])->orderBy('id')->get();
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,kepala_pusat,kepala_bidang,pegawai',
        ]);

        $user = User::findOrFail($id);

        // Prevent self demotion from admin
        if ($user->id === Auth::id() && $request->role !== 'admin') {
            return back()->with('error', 'Anda tidak dapat menurunkan peran administrator akun Anda sendiri.');
        }

        $oldRole = $user->role_label;
        $user->role = $request->role;
        $user->save();

        ActivityLog::record(
            Auth::id(),
            'RBAC_UPDATE_ROLE',
            "Memperbarui hak akses pegawai {$user->name} dari '{$oldRole}' menjadi '{$user->role_label}'."
        );

        return back()->with('success', "Hak akses pegawai {$user->name} berhasil diperbarui menjadi {$user->role_label}.");
    }

    public function toggleStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun administrator Anda sendiri.');
        }

        $newStatus = $user->status === 'active' ? 'suspended' : 'active';
        $user->status = $newStatus;
        $user->save();

        $actionLabel = $newStatus === 'active' ? 'diaktifkan kembali' : 'dinonaktifkan (suspended)';
        ActivityLog::record(
            Auth::id(),
            'RBAC_STATUS_CHANGE',
            "Status akun pegawai {$user->name} telah {$actionLabel}."
        );

        return back()->with('success', "Status akun pegawai {$user->name} berhasil {$actionLabel}.");
    }

    public function logs()
    {
        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.logs', compact('logs'));
    }

    public function klasifikasi()
    {
        $klasifikasi = MasterKlasifikasi::orderBy('kode')->get();
        return view('admin.klasifikasi', compact('klasifikasi'));
    }
}
