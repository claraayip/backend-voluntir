<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

// PUBLIC
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

Route::get('/kegiatan', [KegiatanController::class, 'index']);
Route::get('/kegiatan/{id}', [KegiatanController::class, 'show']);

Route::get('/users', [AuthController::class, 'users']);

// PROTECTED
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/kegiatan', [KegiatanController::class, 'store']);
    Route::put('/kegiatan/{id}', [KegiatanController::class, 'update']);
    Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy']);

 // PENDAFTARAN
    Route::get('/pendaftaran', [PendaftaranController::class, 'index']);
    Route::post('/pendaftaran', [PendaftaranController::class, 'store']);
    Route::delete('/pendaftaran/{id}', [PendaftaranController::class, 'destroy']);

    Route::put('/pendaftaran/{id}/approve', [PendaftaranController::class, 'approve']);

    Route::put('/pendaftaran/{id}/reject', [PendaftaranController::class, 'reject']);
    Route::get('/kegiatan/{id}/peserta', [PendaftaranController::class, 'peserta']);
    Route::put('/kegiatan/{id}/approve', [KegiatanController::class, 'approve']);

    Route::put('/kegiatan/{id}/reject', [KegiatanController::class, 'reject']);

    Route::get('/organizer/peserta', [PendaftaranController::class, 'organizerPeserta']);
    
});