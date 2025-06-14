<?php

use App\Http\Controllers\Admin\Api\EventController;
use App\Http\Controllers\Admin\Api\ParticipantController;
use App\Http\Controllers\Admin\Api\AttendanceController;
use App\Http\Controllers\Admin\Api\CertificateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Api\UserController;
use App\Http\Controllers\Admin\Api\AdminAuthController;



Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AdminAuthController::class,'logout']);
    Route::post('/login', [AdminAuthController::class, 'login']);
});


// routes/api.php
Route::get('/events', [EventController::class, 'index']);
Route::get('/user', [UserController::class, 'me'])->middleware('auth:sanctum');
Route::get('/participants/{id}/qr', [ParticipantController::class, 'generateQrCode']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{id}', [EventController::class, 'show']);

    Route::post('/admin/events', [EventController::class, 'store']);
    Route::put('/admin/events/{id}', [EventController::class, 'update']);
    Route::delete('/admin/events/{id}', [EventController::class, 'destroy']);



    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/events/{eventId}/register', [ParticipantController::class, 'registerToEvent']);
        Route::get('/my-events', [ParticipantController::class, 'myEvents']);
        Route::get('/my-events/{eventId}/qr', [ParticipantController::class, 'myQrCode']);

        Route::put('/admin/kehadiran/{participantId}', [ParticipantController::class, 'updateKehadiran']);
    });


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/certificates/generate/{participantId}', [CertificateController::class, 'generate']);
        Route::get('/certificates/download/{participantId}', [CertificateController::class, 'download']);
    });

    // Verifikasi publik
    Route::get('/certificates/verify/{token}', [CertificateController::class, 'verify'])->name('qr.verify');


    Route::middleware('auth:sanctum')->post('/attendance/scan', [AttendanceController::class, 'scanQrCode']);

    Route::get('/certificates/verify/{token}', [CertificateController::class, 'verify'])->name('qr.verify');
});
