<?php

use App\Http\Controllers\Web\AdController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Web\AuthController;
use App\Models\Event;
use App\Http\Controllers\Web\EventAdminController;
use App\Http\Controllers\Web\ParticipantAdminController;
use App\Http\Controllers\Web\EventUserController;
use App\Http\Controllers\Web\ParticipantDashboardController;
use App\Http\Controllers\Web\CertificateController;
use App\Http\Controllers\Web\ProfileController;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\ScanController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Web\AdminProfileController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\ExploreController;




Route::get('/profile', [ProfileController::class, 'index']);

// Pembayaran

Route::post('/upload-bukti/{event}', [PaymentController::class, 'upload'])->name('peserta.upload.bukti');
Route::post('/upload-bukti/{participant}', [ParticipantDashboardController::class, 'uploadBukti'])->name('pesertad.upload.bukti');
Route::put('/admin/participants/{id}/verify-payment', [ParticipantAdminController::class, 'verifyPayment'])->name('admin.participants.verifyPayment');
Route::get('/scan', function () {
    return view('admin.scan'); // Pastikan path ini sesuai
})->name('admin.scan.page');

Route::post('/scan', [ScanController::class, 'scanFromQR'])->name('admin.scan.from.qr');


Route::get('/scan', [ScanController::class, 'index'])->name('scan'); // Tampilkan halaman scan
Route::post('/scan', [ScanController::class, 'submit'])->name('scanSubmit'); // Submit hasil scan
Route::post('/scan', [ScanController::class, 'scanFromQR'])->name('admin.scan.from.qr');
Route::get('/scan', [ScanController::class, 'index'])->name('admin.scan.page');
Route::post('/scan', [ScanController::class, 'scanFromQR'])->name('admin.scan.from.qr');
Route::post('/admin/scan', [ParticipantAdminController::class, 'scanFromQr'])->name('scan.from.qr');


// Halaman scan QR di dashboard admin
Route::get('/admin/scan', [\App\Http\Controllers\Admin\ScanController::class, 'index'])->name('admin.scan.from.qr');

// Proses kirim hasil scan QR
Route::post('/admin/scan', [\App\Http\Controllers\Admin\ScanController::class, 'submit'])->name('admin.scanSubmit');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('admin.profile');
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
});

Route::get('/admin/scan', [ScanController::class, 'index'])->name('admin.scan');


Route::get('/scan/verify', function (Request $request) {
    return 'Verifikasi QR: User ' . $request->user_id . ' Event ' . $request->event_id;
})->name('scan.verify');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::middleware(['auth'])->prefix('admin')->group(function () {
        Route::get('/events', [EventAdminController::class, 'index'])->name('admin.events.index');
        Route::get('/events/create', [EventAdminController::class, 'create'])->name('admin.events.create');
        Route::get('/events/{event}/stats', [EventAdminController::class, 'stats'])->name('admin.events.stats');
        Route::post('/events', [EventAdminController::class, 'store'])->name('admin.events.store');
        Route::get('/dashboard', [EventAdminController::class, 'index']);
        Route::get('/admin/stats', [EventAdminController::class, 'stats'])->name('admin.events.stats');
    });

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile')->middleware('auth');




    Route::middleware(['auth'])->prefix('admin')->group(function () {
        Route::get('/events/{event}/participants', [ParticipantAdminController::class, 'index'])->name('admin.participants.index');
        Route::get('/generate-sertifikat/{participantId}', [CertificateController::class, 'generate'])->name('admin.certificate.generate');
    });


    Route::prefix('admin')->middleware(['auth'])->group(function () {
        Route::get('/participants', [ParticipantAdminController::class, 'index'])->name('admin.participants.index');
        Route::get('/participants/{participant}/edit', [ParticipantAdminController::class, 'edit'])->name('admin.participants.edit');
        Route::put('/participants/{participant}', [ParticipantAdminController::class, 'update'])->name('admin.participants.update');
    });

    // Iklan
    Route::prefix('admin')->middleware(['auth'])->group(function () {
        Route::get('/ads', [AdController::class, 'index'])->name('admin.ads.index');
        Route::get('/ads/create', [AdController::class, 'create'])->name('admin.ads.create');
        Route::post('/ads', [AdController::class, 'store'])->name('admin.ads.store');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/explore', [ExploreController::class, 'index'])->name('user.explore');
        Route::get('/explore', [AdController::class, 'index'])->name('user.explore');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth']);






    Route::middleware(['auth'])->prefix('admin')->group(function () {
        Route::get('/participants/{participant}/edit', [ParticipantAdminController::class, 'edit'])->name('admin.participants.edit');
        Route::put('/participants/{participant}', [ParticipantAdminController::class, 'update'])->name('admin.participants.update');
        Route::delete('/participants/{participant}', [ParticipantAdminController::class, 'destroy'])->name('admin.participants.destroy');
    });


    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password')->middleware('auth');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update')->middleware('auth');


    Route::middleware(['auth'])->prefix('events')->group(function () {
        Route::get('/', [EventUserController::class, 'index'])->name('user.events.index');
        Route::get('/{event}', [EventUserController::class, 'show'])->name('user.events.show');
        Route::post('/{event}/register', [EventUserController::class, 'register'])->name('user.events.register');
    });

    // routes/web.php
    Route::get('/download-sertifikat/{participantId}', [CertificateController::class, 'generate'])
        ->middleware('auth')
        ->name('user.certificate.download');


    Route::get('/events/{event}', [EventUserController::class, 'show'])->name('user.events.show');
    Route::get('/verify/{token}', function ($token) {
        $certificate = \App\Models\Certificate::where('verification_token', $token)->firstOrFail();
        return view('certificates.verify', compact('certificate'));
    })->name('verify.certificate');

    Route::get('/dashboard', function () {
        $user = Auth::user();

        return $user->role === 'admin'
            ? app(AdminController::class)->index()
            : app(ParticipantDashboardController::class)->index();
    })->middleware('auth')->name('dashboard');
});
