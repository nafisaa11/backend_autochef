<?php

use App\Http\Controllers\ResepMakananController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\User;

Route::get('/users', function () {
    return User::all();
});

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (perlu token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/resepmakanan/rekomendasi', [ResepMakananController::class, 'rekomendasi']); // Pindahkan ke atas
Route::get('/resepmakanan/search', [ResepMakananController::class, 'search']);
Route::get('/resepmakanan/{id}', [ResepMakananController::class, 'show']); // Letakkan terakhir
Route::get('/resepmakanan', [ResepMakananController::class, 'index']);