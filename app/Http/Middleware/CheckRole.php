<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $user = auth()->user();

        if ($user->isSuspended()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Akun Anda dinonaktifkan oleh Administrator. Silakan hubungi pengelola sistem.');
        }

        if ($user->isPending()) {
            return redirect()->route('otp.verify', ['email' => $user->email])->with('warning', 'Silakan selesaikan verifikasi OTP email Anda.');
        }

        if (empty($roles) || in_array($user->role, $roles)) {
            return $next($request);
        }

        abort(403, 'Akses ditolak: Anda tidak memiliki wewenang (' . implode(', ', $roles) . ') untuk membuka halaman ini.');
    }
}
