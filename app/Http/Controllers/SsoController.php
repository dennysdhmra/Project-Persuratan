<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SsoController extends Controller
{
    /**
     * Redirect to the specified SSO provider.
     */
    public function redirect(string $provider)
    {
        $allowedProviders = ['kemenhub', 'google'];

        if (!in_array($provider, $allowedProviders)) {
            return redirect()->route('login')->with('error', 'Penyedia SSO tidak didukung.');
        }

        // Redirect to the interactive SSO Gateway Portal
        return redirect()->route('sso.portal', ['provider' => $provider]);
    }

    /**
     * Show interactive SSO Identity Provider (IdP) Gateway.
     */
    public function portal(Request $request, string $provider)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $allowedProviders = ['kemenhub', 'google'];
        if (!in_array($provider, $allowedProviders)) {
            return redirect()->route('login')->with('error', 'Penyedia SSO tidak valid.');
        }

        // Demo ASN accounts available in SSO IdP for fast 1-click test
        $ssoAccounts = [
            [
                'name' => 'Dimas Surya Wicaksana, S.T., M.Sc.',
                'nip' => '19950720 202012 1 002',
                'email' => 'pegawai@bkt.dephub.go.id',
                'jabatan' => 'Analis Kebijakan Sarana Transportasi Darat & Multimoda',
                'unit_kerja' => 'Pusat Kebijakan Sarana Transportasi',
                'role' => 'pegawai',
                'is_existing' => true,
            ],
            [
                'name' => 'Ir. H. Agus Wahyudi, M.Sc.',
                'nip' => '19780812 200312 1 002',
                'email' => 'kabid@bkt.dephub.go.id',
                'jabatan' => 'Kepala Bidang Sarana Transportasi Darat & Perkeretaapian',
                'unit_kerja' => 'Pusat Kebijakan Sarana Transportasi',
                'role' => 'kepala_bidang',
                'is_existing' => true,
            ],
            [
                'name' => 'Dr. Ir. Bambang Priyanto, M.T.',
                'nip' => '19730514 199803 1 001',
                'email' => 'kapus@bkt.dephub.go.id',
                'jabatan' => 'Kepala Pusat Kebijakan Sarana Transportasi',
                'unit_kerja' => 'Pusat Kebijakan Sarana Transportasi',
                'role' => 'kepala_pusat',
                'is_existing' => true,
            ],
            [
                'name' => 'Fajar Hendrawan, S.T., M.Eng.',
                'nip' => '19961108 202302 1 005',
                'email' => 'fajar.hendrawan@bkt.dephub.go.id',
                'jabatan' => 'Analis Standardisasi Sarana Transportasi Udara',
                'unit_kerja' => 'Pusat Kebijakan Sarana Transportasi',
                'role' => 'pegawai',
                'is_existing' => false, // New Officer testing auto-provisioning!
            ],
        ];

        return view('auth.sso-portal', [
            'provider' => $provider,
            'ssoAccounts' => $ssoAccounts,
        ]);
    }

    /**
     * Process SSO Identity authorization from IdP Portal.
     */
    public function authorizePortal(Request $request, string $provider)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:255',
            'unit_kerja' => 'nullable|string|max:255',
        ]);

        $ssoId = 'SSO-' . strtoupper($provider) . '-' . substr(md5($validated['email']), 0, 10);

        return redirect()->route('sso.callback', [
            'provider' => $provider,
            'email' => $validated['email'],
            'name' => $validated['name'],
            'nip' => $validated['nip'] ?? null,
            'jabatan' => $validated['jabatan'] ?? 'Analis Kebijakan Sarana Transportasi',
            'unit_kerja' => $validated['unit_kerja'] ?? 'Pusat Kebijakan Sarana Transportasi',
            'sso_id' => $ssoId,
            'token' => hash_hmac('sha256', $validated['email'] . $ssoId, config('app.key')),
        ]);
    }

    /**
     * Handle incoming SSO Callback (Sign In or Auto Sign Up).
     */
    public function callback(Request $request, string $provider)
    {
        $email = strtolower(trim($request->query('email')));
        $name = trim($request->query('name'));
        $nip = $request->query('nip');
        $ssoId = $request->query('sso_id');
        $jabatan = $request->query('jabatan') ?: 'Analis Kebijakan Sarana Transportasi';
        $unitKerja = $request->query('unit_kerja') ?: 'Pusat Kebijakan Sarana Transportasi';

        if (!$email || !$name) {
            return redirect()->route('login')->with('error', 'Data autentikasi SSO tidak lengkap.');
        }

        // Find existing user by email or sso_id
        $user = User::where('email', $email)
            ->orWhere(function ($query) use ($provider, $ssoId) {
                if ($ssoId) {
                    $query->where('sso_provider', $provider)->where('sso_id', $ssoId);
                }
            })->first();

        if ($user) {
            // Check status
            if ($user->isSuspended()) {
                return redirect()->route('login')->with('error', 'Akun Anda dinonaktifkan oleh Administrator.');
            }

            // Sync SSO metadata
            $user->sso_provider = $provider;
            $user->sso_id = $ssoId;
            $user->status = 'active';
            if (!$user->email_verified_at) {
                $user->email_verified_at = Carbon::now();
            }
            $user->save();

            Auth::login($user);
            $request->session()->regenerate();

            ActivityLog::record($user->id, 'SSO_LOGIN', "Masuk sistem menggunakan SSO {$provider}.");

            return redirect()->route('dashboard')->with('success', "Berhasil masuk melalui Single Sign-On (SSO) {$provider}. Selamat bertugas, {$user->name}.");
        }

        // AUTO-PROVISIONING: User does not exist, automatically Sign Up!
        $newUser = User::create([
            'name' => $name,
            'nip' => $nip,
            'email' => $email,
            'password' => Hash::make(Str::random(32)),
            'role' => 'pegawai', // Default RBAC role
            'status' => 'active', // Instantly verified via SSO
            'email_verified_at' => Carbon::now(),
            'sso_provider' => $provider,
            'sso_id' => $ssoId ?: ('SSO-' . Str::upper(Str::random(10))),
            'jabatan' => $jabatan,
            'unit_kerja' => $unitKerja,
        ]);

        Auth::login($newUser);
        $request->session()->regenerate();

        ActivityLog::record($newUser->id, 'SSO_REGISTER', "Registrasi otomatis (Sign Up) pegawai baru melalui SSO {$provider}.");

        return redirect()->route('dashboard')->with('success', "Pendaftaran berhasil! Akun Anda telah terverifikasi otomatis melalui SSO {$provider}.");
    }
}
