<?php

namespace App\Http\Controllers;
use App\Models\RecipeView;
use Illuminate\Http\Request;

class RecipeViewController extends Controller
{
    public function logView(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:resep_makanan,id',
        ]);

        $user = $request->user();

        // Simpan log view
        RecipeView::create([
            'user_id' => $user->id,
            'recipe_id' => $request->recipe_id,
        ]);

        // Hapus log lama jika melebihi 100
        $viewCount = RecipeView::where('user_id', $user->id)->count();
        if ($viewCount > 100) {
            $oldestViews = RecipeView::where('user_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->limit($viewCount - 100)
                ->pluck('id');

            RecipeView::whereIn('id', $oldestViews)->delete();
        }

        return response()->json(['message' => 'View logged successfully']);
    }

    public function getUserViewHistory(Request $request)
    {
        $user = $request->user();
        
        // Ambil riwayat view dengan informasi resep
        $viewHistory = RecipeView::where('user_id', $user->id)
            ->with('recipe:id,nama_resep,gambar,kategori')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($view) {
                return [
                    'id' => $view->id,
                    'recipe_id' => $view->recipe_id,
                    'recipe_name' => $view->recipe->nama_resep,
                    'recipe_image' => $view->recipe->gambar,
                    'category' => $view->recipe->kategori,
                    'viewed_at' => $view->created_at->format('Y-m-d H:i:s')
                ];
            });
        
        return response()->json([
            'message' => 'Riwayat view resep berhasil diambil',
            'count' => $viewHistory->count(),
            'data' => $viewHistory
        ]);
    }
}
