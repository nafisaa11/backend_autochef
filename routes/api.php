<?php

use App\Http\Controllers\ResepMakananController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/resepmakanan/rekomendasi', [ResepMakananController::class, 'rekomendasi']); // Pindahkan ke atas
Route::get('/resepmakanan/search', [ResepMakananController::class, 'search']);
Route::get('/resepmakanan/{id}', [ResepMakananController::class, 'show']); // Letakkan terakhir
Route::get('/resepmakanan', [ResepMakananController::class, 'index']);