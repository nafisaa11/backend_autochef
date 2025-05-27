<?php

namespace App\Http\Controllers;

use App\Models\ResepMakanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Menampilkan daftar resep yang difavoritkan oleh pengguna yang sedang login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = $request->user(); // Mendapatkan pengguna yang sedang login

        // Mengambil resep favorit pengguna
        // Relasi 'favoriteRecipes' sudah didefinisikan di model User
        $favoriteRecipes = $user->favoriteRecipes()->orderBy('user_favorites.created_at', 'desc')->get();

        if ($favoriteRecipes->isEmpty()) {
            return response()->json([
                'message' => 'Anda belum memiliki resep favorit.',
                'data' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Daftar resep favorit berhasil diambil.',
            'data' => $favoriteRecipes
        ], 200);
    }

    /**
     * Menambahkan resep ke daftar favorit pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResepMakanan  $resep (Route Model Binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ResepMakanan $resep)
    {
        $user = $request->user();

        // Cek apakah resep sudah ada di favorit pengguna
        // Relasi 'favoriteRecipes' adalah belongsToMany, kita bisa menggunakan 'wherePivot' atau cek eksistensi
        if ($user->favoriteRecipes()->where('resep_makanan.id', $resep->id)->exists()) {
            return response()->json([
                'message' => 'Resep ini sudah ada di daftar favorit Anda.',
                'data' => $resep
            ], 409); // 409 Conflict
        }

        // Menambahkan resep ke favorit pengguna
        // 'attach' akan menambahkan entri baru di tabel pivot 'user_favorites'
        $user->favoriteRecipes()->attach($resep->id);

        return response()->json([
            'message' => 'Resep berhasil ditambahkan ke favorit.',
            'data' => $resep
        ], 201); // 201 Created
    }

    /**
     * Menghapus resep dari daftar favorit pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResepMakanan  $resep (Route Model Binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, ResepMakanan $resep)
    {
        $user = $request->user();

        // Menghapus resep dari favorit pengguna
        // 'detach' akan menghapus entri dari tabel pivot 'user_favorites'
        // 'detach' mengembalikan jumlah record yang dihapus.
        $detachedCount = $user->favoriteRecipes()->detach($resep->id);

        if ($detachedCount > 0) {
            return response()->json([
                'message' => 'Resep berhasil dihapus dari favorit.'
            ], 200);
        }

        return response()->json([
            'message' => 'Resep ini tidak ditemukan di daftar favorit Anda.'
        ], 404); // 404 Not Found
    }

    /**
     * Memeriksa apakah sebuah resep sudah difavoritkan oleh pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResepMakanan  $resep
     * @return \Illuminate\Http\JsonResponse
     */
    public function isFavorited(Request $request, ResepMakanan $resep)
    {
        $user = $request->user();
        $isFavorited = $user->favoriteRecipes()->where('resep_makanan.id', $resep->id)->exists();

        return response()->json([
            'is_favorited' => $isFavorited,
            'resep_id' => $resep->id
        ], 200);
    }
}