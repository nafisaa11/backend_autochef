<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ResepMakanan extends Model
{
    use HasFactory, Searchable;

    protected $table = 'resep_makanan'; // Nama tabel di database
    protected $primaryKey = 'id'; // Primary Key
    public $timestamps = false; // Matikan jika tabel tidak punya created_at & updated_at

    protected $fillable = [
        'nama_resep', 'bahan', 'steps', 'gambar' // Kolom yang bisa diisi
    ];

    public function toSearchableArray()
    {
        return [
            'nama_resep' => $this->nama_resep,
            'bahan' => $this->bahan,
        ];
    }

    public function getScoutKey()
{
    return $this->id;
}

public function getScoutKeyName()
{
    return 'id';
}

}
