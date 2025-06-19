<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Api\{
    EventController,
    ParticipantController,
    AttendanceController,
    CertificateController,
    UserController,
    AdminAuthController
};

// Login (tanpa token)
Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login']);
});

// Token-protected routes
Route::middleware('auth:sanctum')->group(function () {
    
    // Authenticated logout
    Route::post('/admin/logout', [AdminAuthController::class, 'logout']);

    // Event (semua dijaga token)
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{id}', [EventController::class, 'show']);
    Route::post('/admin/events', [EventController::class, 'store']);
    Route::put('/admin/events/{id}', [EventController::class, 'update']);
    Route::delete('/admin/events/{id}', [EventController::class, 'destroy']);

    // User data
    Route::get('/user', [UserController::class, 'me']);

    // Kehadiran dan peserta
    Route::post('/events/{eventId}/register', [ParticipantController::class, 'registerToEvent']);
    Route::get('/my-events', [ParticipantController::class, 'myEvents']);
    Route::get('/my-events/{eventId}/qr', [ParticipantController::class, 'myQrCode']);
    Route::put('/admin/kehadiran/{participantId}', [ParticipantController::class, 'updateKehadiran']);

    // Sertifikat
    Route::post('/certificates/generate/{participantId}', [CertificateController::class, 'generate']);
    Route::get('/certificates/download/{participantId}', [CertificateController::class, 'download']);

    // Scan kehadiran
    Route::post('/attendance/scan', [AttendanceController::class, 'scanQrCode']);
});

// Public route (boleh tanpa login)
Route::get('/participants/{id}/qr', [ParticipantController::class, 'generateQrCode']);
Route::get('/certificates/verify/{token}', [CertificateController::class, 'verify'])->name('qr.verify');