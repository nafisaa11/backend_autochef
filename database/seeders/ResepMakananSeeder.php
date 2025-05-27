<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ResepMakanan;

class ResepMakananSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 25 resep makanan menggunakan factory
        ResepMakanan::factory(25)->create();

        $this->command->info('ResepMakanan seeder executed successfully!');
    }
}