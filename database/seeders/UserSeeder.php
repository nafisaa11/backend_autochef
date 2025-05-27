<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User spesifik untuk testing login
        User::factory()->create([
            'name' => 'Test User Satu',
            'email' => 'user1@example.com',
            'password' => Hash::make('password123'), // Password: password123
        ]);

        User::factory()->create([
            'name' => 'Test User Dua',
            'email' => 'user2@example.com',
            'password' => Hash::make('password123'), // Password: password123
        ]);

        // Beberapa user random tambahan
        User::factory(3)->create();

        $this->command->info('User seeder executed successfully!');
    }
}