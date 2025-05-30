<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;
use Workbench\App\Models\User;


class ResepMakanan extends Model
{
    use HasFactory, Searchable;

    protected $table = 'resep_makanan'; // Nama tabel di database
    protected $primaryKey = 'id'; // Primary Key
    public $timestamps = false; // Matikan jika tabel tidak punya created_at & updated_at

    protected $fillable = [
        'nama_resep', 'bahan', 'steps', 'gambar', 'kategori', 'negara', 'waktu', 'kalori', 'protein', 'karbohidrat' 
    ];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'nama_resep' => $this->nama_resep,
            'bahan' => $this->bahan,
            'kategori' => $this->kategori,
        ];
    }

//     public function getScoutKey()
// {
//     return $this->id;
// }

// public function getScoutKeyName()
// {
//     return 'id';
// }

    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_favorites', 'resep_id', 'user_id');
    }
}
