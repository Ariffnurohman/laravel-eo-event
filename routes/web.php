<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AdminProfileController;
use App\Http\Controllers\Web\EventAdminController;
use App\Http\Controllers\Web\ParticipantAdminController;
use App\Http\Controllers\Web\AdController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\EventUserController;
use App\Http\Controllers\Web\ParticipantDashboardController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Web\CertificateController;
use App\Http\Controllers\Web\ExploreController;
use App\Http\Controllers\Admin\ScanController;

Route::get('/', function () {
    return view('welcome');
});
// =======================
// Auth Routes
// =======================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =======================
// Scan Routes
// =======================
Route::get('/scan/verify', function (Request $request) {
    return 'Verifikasi QR: User ' . $request->user_id . ' Event ' . $request->event_id;
})->name('scan.verify');

Route::get('/scan', [ScanController::class, 'index'])->name('admin.scan.page');
Route::post('/scan', [ScanController::class, 'scanFromQR'])->name('admin.scan.from.qr');
Route::post('/admin/scan', [ParticipantAdminController::class, 'scanFromQr'])->name('scan.from.qr');

// =======================
// Authenticated Routes
// =======================


Route::middleware(['auth'])->get('/dashboard', function () {
    $user = Auth::user();

    return $user->role === 'admin'
        ? app(AdminController::class)->index()
        : app(ParticipantDashboardController::class)->index();
})->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $user = Auth::user();
        return $user->role === 'admin'
            ? app(AdminController::class)->index()
            : app(ParticipantDashboardController::class)->index();
    })->name('dashboard');

    // ============ Profile ============
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // ============ Sertifikat ============
    Route::get('/download-sertifikat/{participantId}', [CertificateController::class, 'generate'])
        ->name('user.certificate.download');
    Route::get('/verify/{token}', function ($token) {
        $certificate = \App\Models\Certificate::where('verification_token', $token)->firstOrFail();
        return view('certificates.verify', compact('certificate'));
    })->name('verify.certificate');

    // ============ Explore ============
    Route::get('/explore', [ExploreController::class, 'index'])->name('user.explore');

    // ============ Events Peserta ============
    Route::prefix('events')->group(function () {
        Route::get('/', [EventUserController::class, 'index'])->name('user.events.index');
        Route::get('/{event}', [EventUserController::class, 'show'])->name('user.events.show');
        Route::post('/{event}/register', [EventUserController::class, 'register'])->name('user.events.register');
    });

    // ============ Pembayaran ============
    Route::post('/upload-bukti/{event}', [PaymentController::class, 'upload'])->name('peserta.upload.bukti');
    Route::post('/upload-bukti/{participant}', [ParticipantDashboardController::class, 'uploadBukti'])->name('pesertad.upload.bukti');

    // ============ Admin Area ============
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [AdminController::class, 'index']);

        Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');

        Route::get('/events', [EventAdminController::class, 'index'])->name('events.index');
        Route::get('/events/create', [EventAdminController::class, 'create'])->name('events.create');
        Route::post('/events', [EventAdminController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/stats', [EventAdminController::class, 'stats'])->name('events.stats');

        Route::get('/events/{event}/participants', [ParticipantAdminController::class, 'index'])->name('participants.index');
        Route::get('/participants/{participant}/edit', [ParticipantAdminController::class, 'edit'])->name('participants.edit');
        Route::put('/participants/{participant}', [ParticipantAdminController::class, 'update'])->name('participants.update');
        Route::delete('/participants/{participant}', [ParticipantAdminController::class, 'destroy'])->name('participants.destroy');
        Route::put('/participants/{id}/verify-payment', [ParticipantAdminController::class, 'verifyPayment'])->name('participants.verifyPayment');

        Route::get('/generate-sertifikat/{participantId}', [CertificateController::class, 'generate'])->name('certificate.generate');

        Route::get('/ads', [AdController::class, 'index'])->name('ads.index');
        Route::get('/ads/create', [AdController::class, 'create'])->name('ads.create');
        Route::post('/ads', [AdController::class, 'store'])->name('ads.store');

        Route::put('/kehadiran/{participantId}', [ParticipantAdminController::class, 'updateKehadiran'])->name('updateKehadiran');
    });
});
