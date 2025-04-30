<?php

use App\Http\Controllers\ResepMakananController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/resepmakanan/rekomendasi', [ResepMakananController::class, 'rekomendasi']); 
Route::get('/resepmakanan/search', [ResepMakananController::class, 'search']);
Route::get('/resepmakanan/{id}', [ResepMakananController::class, 'show']); 
Route::get('/resepmakanan', [ResepMakananController::class, 'index']);
