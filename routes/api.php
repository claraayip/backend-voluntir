<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

// 🔓 AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 🔐 PROTECTED ROUTES
Route::middleware('auth:sanctum')->group(function () {

    // AUTH
    Route::post('/logout', [AuthController::class, 'logout']);

    // PROFILE
    Route::get('/me', [ProfileController::class, 'me']);
    Route::post('/profile/update', [ProfileController::class, 'update']);

    // KEGIATAN
    Route::get('/kegiatan', [KegiatanController::class, 'index']);
    Route::post('/kegiatan', [KegiatanController::class, 'store']);
    Route::get('/kegiatan/{id}', [KegiatanController::class, 'show']);
    Route::put('/kegiatan/{id}', [KegiatanController::class, 'update']);
    Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy']);

    // PENDAFTARAN
    Route::get('/pendaftaran', [PendaftaranController::class, 'index']);
    Route::post('/pendaftaran', [PendaftaranController::class, 'store']);
    Route::delete('/pendaftaran/{id}', [PendaftaranController::class, 'destroy']);

    // PESERTA
    Route::get('/kegiatan/{id}/peserta', [PendaftaranController::class, 'peserta']);

    // FAVORITES
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy']);

    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
});