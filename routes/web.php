<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\VerifikasiApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SsoController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\VerifikasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - E-Surat PKST BKT Kemenhub
|--------------------------------------------------------------------------
*/

// 1. Public Landing Page (Beranda Umum / Profil Sistem)
Route::get('/', [LandingController::class, 'index'])->name('landing');

// 2. Public Authentication & Registration
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/quick-login/{role}', [AuthController::class, 'quickLogin'])->name('quick.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2a. Self-Service Registration & Email OTP Verification
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('otp.verify');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.check');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('otp.resend');

// 2b. Single Sign-On (SSO) Kemenhub & Google Workspace
Route::prefix('auth/sso')->name('sso.')->group(function () {
    Route::get('/{provider}', [SsoController::class, 'redirect'])->name('redirect');
    Route::get('/{provider}/portal', [SsoController::class, 'portal'])->name('portal');
    Route::post('/{provider}/authorize', [SsoController::class, 'authorizePortal'])->name('authorize');
    Route::get('/{provider}/callback', [SsoController::class, 'callback'])->name('callback');
});

// 3. Public Document TTE Verification (Scan QR Code & AJAX API)
Route::get('/verifikasi/{token}', [VerifikasiController::class, 'verify'])->name('verifikasi.tte');
Route::get('/api/verifikasi/{token}', [VerifikasiApiController::class, 'check'])->name('api.verifikasi.check');

// 4. Authenticated Routes (Internal Unit Kerja PKST)
Route::middleware('auth')->group(function () {

    // Fast Role Switcher (for testing & evaluation seamlessly)
    Route::get('/switch-role/{role}', [AuthController::class, 'switchRole'])->name('switch.role');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    // 1. Surat Masuk
    Route::prefix('surat-masuk')->name('surat-masuk.')->group(function () {
        Route::get('/', [SuratMasukController::class, 'index'])->name('index');
        Route::get('/create', [SuratMasukController::class, 'create'])->name('create');
        Route::post('/', [SuratMasukController::class, 'store'])->name('store');
        Route::get('/{id}', [SuratMasukController::class, 'show'])->name('show');
        Route::get('/{id}/lembar-disposisi', [SuratMasukController::class, 'lembarDisposisi'])->name('disposisi.cetak');
    });

    // 2. Disposisi
    Route::prefix('disposisi')->name('disposisi.')->group(function () {
        Route::get('/', [DisposisiController::class, 'index'])->name('index');
        Route::post('/', [DisposisiController::class, 'store'])->name('store');
        Route::post('/{id}/tindak-lanjut', [DisposisiController::class, 'tindakLanjut'])->name('tindak-lanjut');
    });

    // 3. Surat Keluar
    Route::prefix('surat-keluar')->name('surat-keluar.')->group(function () {
        Route::get('/', [SuratKeluarController::class, 'index'])->name('index');
        Route::get('/create', [SuratKeluarController::class, 'create'])->name('create');
        Route::post('/', [SuratKeluarController::class, 'store'])->name('store');
        Route::get('/{id}', [SuratKeluarController::class, 'show'])->name('show');
        Route::post('/{id}/ajukan', [SuratKeluarController::class, 'ajukanParaf'])->name('ajukan');
        Route::post('/{id}/paraf-kabid', [SuratKeluarController::class, 'parafKabid'])->name('paraf-kabid');
        Route::post('/{id}/tte-kapus', [SuratKeluarController::class, 'tteKapus'])->name('tte-kapus');
        Route::post('/{id}/kirim', [SuratKeluarController::class, 'kirimSurat'])->name('kirim');
        Route::get('/{id}/preview-naskah', [SuratKeluarController::class, 'previewNaskah'])->name('preview');
    });

    // 4. Admin Management (Restricted to Admin)
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users/{id}/role', [AdminController::class, 'updateRole'])->name('users.role');
        Route::post('/users/{id}/status', [AdminController::class, 'toggleStatus'])->name('users.status');
        Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
        Route::get('/klasifikasi', [AdminController::class, 'klasifikasi'])->name('klasifikasi');
    });
});
