<?php

use App\Http\Controllers\ResepMakananController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;

Route::get('/users', function () {
    return User::all();
});

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/resepmakanan/rekomendasi', [ResepMakananController::class, 'rekomendasi']);
Route::get('/resepmakanan/search', [ResepMakananController::class, 'search']);
Route::get('/resepmakanan/{id}', [ResepMakananController::class, 'show']);
Route::get('/resepmakanan', [ResepMakananController::class, 'index']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route untuk Resep Favorit
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/resep/{resep}/favorite', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/resep/{resep}/favorite', [FavoriteController::class, 'destroy'])->name('favorites.destroy'); // Menggunakan metode DELETE yang lebih RESTful
    Route::get('/resep/{resep}/is-favorited', [FavoriteController::class, 'isFavorited'])->name('favorites.isFavorited');

});
