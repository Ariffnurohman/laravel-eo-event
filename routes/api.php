<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ✅ Import controller yang sesuai dengan file kamu
use App\Http\Controllers\Web\AdminAuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\ParticipantController;


// ✅ ROUTE PUBLIK - Bisa diakses dari Ionic tanpa token
Route::get('/events', [EventController::class, 'index']);

// ✅ ROUTE AUTENTIKASI ADMIN (bisa kamu ganti nama jika buat peserta juga)
Route::post('/login', [AdminAuthController::class, 'login']);
Route::post('/register', [AdminAuthController::class, 'register']);

// ✅ ROUTE UNTUK PESERTA - Dilindungi oleh token Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AdminAuthController::class, 'user']);
    Route::post('/logout', [AdminAuthController::class, 'logout']);

    Route::get('/events/joined', [ParticipantController::class, 'joinedEvents']);
    Route::post('/events/{eventId}/join', [ParticipantController::class, 'joinEvent']);
    Route::post('/upload-payment-proof', [ParticipantController::class, 'uploadPaymentProof']);
});

Route::get('/events', [EventController::class, 'index']); // ini untuk Ionic

// AUTHENTICATION
Route::post('/login', [AdminAuthController::class, 'login']);
Route::post('/register', [AdminAuthController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AdminAuthController::class, 'user']);
    Route::post('/logout', [AdminAuthController::class, 'logout']);
});
