<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign Key ke tabel users
            $table->foreignId('resep_id')->constrained('resep_makanan')->onDelete('cascade'); // Foreign Key ke tabel resep_makanan
            $table->timestamps(); 

            // Menambahkan unique constraint untuk mencegah duplikasi (satu user hanya bisa memfavoritkan satu resep sekali)
            $table->unique(['user_id', 'resep_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_favorites');
    }
};
