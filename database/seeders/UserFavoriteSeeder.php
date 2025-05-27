<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ResepMakanan;

class UserFavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $resepMakanans = ResepMakanan::all();

        // Pastikan ada user dan resep sebelum mencoba membuat favorit
        if ($users->isEmpty() || $resepMakanans->isEmpty()) {
            $this->command->warn('Tidak ada Users atau ResepMakanan untuk membuat data favorit. Lewati UserFavoriteSeeder.');
            return;
        }

        foreach ($users as $user) {
            // Setiap user akan memfavoritkan beberapa resep secara acak (misalnya 0 sampai 5 resep)
            $numberOfFavorites = rand(0, min(5, $resepMakanans->count()));
            if ($numberOfFavorites > 0) {
                // Ambil beberapa resep secara acak
                $recipesToFavorite = $resepMakanans->random($numberOfFavorites);

                // Attach resep-resep ini ke user
                // Metode attach() akan menangani pembuatan entri di tabel pivot 'user_favorites'
                // Pastikan relasi 'favoriteRecipes' sudah didefinisikan di model User
                $user->favoriteRecipes()->attach($recipesToFavorite->pluck('id')->toArray());
            }
        }
        $this->command->info('UserFavorite seeder executed successfully!');
    }
}