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
        Schema::create('resep_makanan', function (Blueprint $table) {
            $table->id();
            $table->text('nama_resep');
            $table->text('bahan');
            $table->text('steps');
            $table->text('gambar')->nullable();
            $table->text('kategori')->nullable();
            $table->text('negara')->nullable();
            $table->integer('waktu')->nullable();
            $table->integer('kalori')->nullable();
            $table->integer('protein')->nullable();
            $table->integer('karbohidrat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep_makanan');
    }
};
