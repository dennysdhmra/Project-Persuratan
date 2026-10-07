<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\OtpVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $demoUsers = User::orderBy('id')->get();
        return view('auth.login', compact('demoUsers'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Status verification
            if ($user->isSuspended()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->with('error', 'Akun Anda dinonaktifkan oleh Administrator. Silakan hubungi pengelola.');
            }

            if ($user->isPending()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('otp.verify', ['email' => $user->email])
                    ->with('warning', 'Akun Anda belum diverifikasi. Silakan masukkan kode OTP yang telah dikirim.');
            }

            $request->session()->regenerate();
            ActivityLog::record(Auth::id(), 'LOGIN', 'Masuk ke dalam sistem persuratan.');
            return redirect()->intended(route('dashboard'))->with('success', 'Selamat datang kembali, ' . $user->name);
        }

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'jabatan' => 'nullable|string|max:255',
            'unit_kerja' => 'nullable|string|max:255',
        ], [
            'email.unique' => 'Alamat email ini sudah terdaftar di sistem persuratan.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        // Create pending user account
        $user = User::create([
            'name' => $validated['name'],
            'nip' => $validated['nip'] ?? null,
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
            'role' => 'pegawai', // Default RBAC role for new registrations
            'status' => 'pending', // Awaiting OTP verification
            'jabatan' => $validated['jabatan'] ?: 'Staf Analis Kebijakan',
            'unit_kerja' => $validated['unit_kerja'] ?: 'Pusat Kebijakan Sarana Transportasi',
        ]);

        // Generate 6-digit OTP code (valid for 10 minutes)
        $otp = OtpVerification::createOtp($user->email, 'register', ['user_id' => $user->id], 10);

        // In local development, log the OTP for inspection
        Log::info("OTP Registrasi Pegawai [{$user->email}]: {$otp->otp_code}");

        return redirect()->route('otp.verify', ['email' => $user->email])
            ->with('success', 'Pendaftaran awal berhasil! Kode OTP 6-digit telah dikirimkan ke email Anda.');
    }

    public function showVerifyOtp(Request $request)
    {
        $email = $request->query('email') ?? session('otp_email');

        if (!$email) {
            return redirect()->route('register')->with('warning', 'Silakan daftar akun terlebih dahulu.');
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('register')->with('error', 'Data pengguna tidak ditemukan.');
        }

        if ($user->isActive() && $user->email_verified_at) {
            return redirect()->route('login')->with('info', 'Email Anda sudah terverifikasi sebelumnya. Silakan masuk.');
        }

        $latestOtp = OtpVerification::where('email', $email)
            ->where('action', 'register')
            ->whereNull('verified_at')
            ->where('expires_at', '>', Carbon::now())
            ->latest()
            ->first();

        // If no active OTP exists, generate a fresh one
        if (!$latestOtp) {
            $latestOtp = OtpVerification::createOtp($email, 'register', ['user_id' => $user->id], 10);
            Log::info("OTP Registrasi Otomatis Dibuat [{$email}]: {$latestOtp->otp_code}");
        }

        return view('auth.verify-otp', [
            'email' => $email,
            'user' => $user,
            'latestOtp' => $latestOtp,
            'expiresInSeconds' => max(0, Carbon::now()->diffInSeconds($latestOtp->expires_at, false)),
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|string|size:6',
        ], [
            'otp_code.size' => 'Kode OTP harus berjumlah 6 digit angka.',
        ]);

        $email = strtolower(trim($request->email));
        $otpInput = trim($request->otp_code);

        $otp = OtpVerification::where('email', $email)
            ->where('action', 'register')
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (!$otp) {
            return back()->with('error', 'Kode OTP tidak ditemukan atau telah kadaluarsa. Silakan minta kode baru.');
        }

        if (!$otp->isValid($otpInput)) {
            $otp->recordFailedAttempt();
            return back()->with('error', 'Kode OTP yang Anda masukkan salah. Sisa percobaan: ' . (5 - $otp->attempts));
        }

        // OTP is valid!
        $otp->markAsVerified();

        $user = User::where('email', $email)->firstOrFail();
        $user->email_verified_at = Carbon::now();
        $user->status = 'active';
        $user->save();

        Auth::login($user);
        $request->session()->regenerate();

        ActivityLog::record($user->id, 'REGISTER_OTP_SUCCESS', 'Verifikasi OTP berhasil. Akun pegawai aktif dengan peran: ' . $user->role_label);

        return redirect()->route('dashboard')->with('success', 'Selamat! Akun pegawai Anda telah aktif dan terverifikasi.');
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = strtolower(trim($request->email));
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('error', 'Data pengguna tidak ditemukan.');
        }

        // Throttle: check if last OTP was created less than 60 seconds ago
        $lastOtp = OtpVerification::where('email', $email)
            ->where('action', 'register')
            ->latest()
            ->first();

        if ($lastOtp && $lastOtp->created_at->diffInSeconds(Carbon::now()) < 60) {
            $remaining = 60 - $lastOtp->created_at->diffInSeconds(Carbon::now());
            return back()->with('warning', "Harap tunggu {$remaining} detik sebelum meminta kode OTP kembali.");
        }

        $newOtp = OtpVerification::createOtp($email, 'register', ['user_id' => $user->id], 10);
        Log::info("OTP Dikirim Ulang [{$email}]: {$newOtp->otp_code}");

        return back()->with('success', 'Kode OTP baru telah diterbitkan. Silakan cek notifikasi Anda.');
    }

    public function quickLogin($role)
    {
        $user = User::where('role', $role)->first();
        if ($user) {
            Auth::login($user);
            request()->session()->regenerate();
            ActivityLog::record($user->id, 'QUICK_LOGIN', 'Masuk cepat sebagai ' . $user->role_label);
            return redirect()->route('dashboard')->with('success', 'Beralih peran sebagai: ' . $user->role_label);
        }

        return redirect()->route('login')->with('error', 'Akun untuk peran tersebut tidak ditemukan.');
    }

    public function switchRole($role)
    {
        $targetUser = User::where('role', $role)->first();
        if ($targetUser) {
            Auth::login($targetUser);
            request()->session()->regenerate();
            ActivityLog::record($targetUser->id, 'SWITCH_ROLE', 'Beralih ke profil ' . $targetUser->role_label);
            return back()->with('success', 'Mode aktif beralih ke: ' . $targetUser->name . ' (' . $targetUser->role_label . ')');
        }

        return back()->with('error', 'Profil tidak ditemukan.');
    }

    public function logout(Request $request)
    {
        $userId = Auth::id();
        if ($userId) {
            ActivityLog::record($userId, 'LOGOUT', 'Keluar dari sistem persuratan.');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Anda telah berhasil keluar.');
    }
}
