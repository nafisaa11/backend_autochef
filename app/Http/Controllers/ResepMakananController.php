<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResepMakanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\TypoHelper;

class ResepMakananController extends Controller
{
    public function index()
    {
        $data = ResepMakanan::all();
        return response()->json([
            'message' => count($data) > 0 ? 'Data resep berhasil diambil' : 'Tidak ada data resep',
            'data' => $data
        ]);
    }

    public function search(Request $request)
    {
        $query = ResepMakanan::query();

        if ($request->has('nama_resep')) {
            $query->where('nama_resep', 'like', '%' . $request->nama_resep . '%');
        }

        if ($request->has('bahan')) {
            $bahanArray = explode(',', $request->bahan);
            foreach ($bahanArray as $bahan) {
                $query->where('bahan', 'like', '%' . trim($bahan) . '%');
            }
        }

        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $data = $query->get();
        return response()->json([
            'message' => count($data) > 0 ? 'Resep ditemukan berdasarkan pencarian' : 'Tidak ada resep yang cocok',
            'data' => $data
        ]);
    }

    public function rekomendasi(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Dapatkan kategori resep yang sering dilihat oleh pengguna
            $popularCategories = DB::table('recipe_views')
                ->join('resep_makanan', 'recipe_views.recipe_id', '=', 'resep_makanan.id')
                ->where('recipe_views.user_id', $user->id)
                ->select('resep_makanan.kategori', DB::raw('COUNT(*) as count'))
                ->groupBy('resep_makanan.kategori')
                ->orderBy('count', 'desc')
                ->limit(3)
                ->pluck('kategori');

            // Jika pengguna memiliki riwayat tontonan
            if ($popularCategories->count() < 0) {
                // Dapatkan resep berdasarkan kategori yang populer
                $resep = ResepMakanan::whereIn('kategori', $popularCategories)
                    ->inRandomOrder()
                    ->limit(18)
                    ->get();

                if ($resep->count() > 0) {
                    return response()->json([
                        'message' => 'Rekomendasi resep berhasil diambil',
                        'data' => $resep
                    ]);
                }
            }
        }

        // Jika tidak ada riwayat atau pengguna tidak login, berikan rekomendasi umum
        $resep = ResepMakanan::inRandomOrder()->limit(18)->get();

        return response()->json([
            'message' => count($resep) > 0 ? 'Rekomendasi resep berhasil diambil' : 'Tidak ada resep untuk direkomendasikan',
            'data' => $resep
        ]);
    }

    public function show($id)
    {
        $resep = ResepMakanan::find($id);
        if (!$resep) {
            return response()->json([
                'message' => 'Resep tidak ditemukan',
                'data' => null
            ], 404);
        }
        return response()->json([
            'message' => 'Resep berhasil ditemukan',
            'data' => $resep
        ]);
    }
}
