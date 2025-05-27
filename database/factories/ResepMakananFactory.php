<?php

// database/factories/ResepMakananFactory.php
namespace Database\Factories;

use App\Models\ResepMakanan;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResepMakananFactory extends Factory
{
    protected $model = ResepMakanan::class;

    public function definition(): array
    {
        return [
            'nama_resep' => 'Resep Lezat: ' . fake()->unique()->words(3, true),
            'bahan' => "1. " . fake()->sentence(3) . "\n2. " . fake()->sentence(4) . "\n3. " . fake()->sentence(2),
            'steps' => "Langkah 1: " . fake()->paragraph(1) . "\nLangkah 2: " . fake()->paragraph(1) . "\nLangkah 3: " . fake()->paragraph(1),
            'gambar' => fake()->imageUrl(640, 480, 'food', true, 'delicous ' . fake()->word), // URL gambar placeholder
            'kategori' => fake()->randomElement(['Hidangan Utama', 'Sarapan', 'Camilan', 'Minuman', 'Kue', 'Salad']),
            'negara' => fake()->randomElement(['Indonesia', 'Italia', 'Jepang', 'Prancis', 'Thailand', 'India']),
            'waktu' => fake()->numberBetween(10, 180), // dalam menit
            'kalori' => fake()->numberBetween(100, 1200),
            'protein' => fake()->numberBetween(5, 70),
            'karbohidrat' => fake()->numberBetween(10, 150),
            // 'created_at' => now(), // Otomatis jika $timestamps = true di model
            // 'updated_at' => now(), // Otomatis jika $timestamps = true di model
        ];
    }
}
