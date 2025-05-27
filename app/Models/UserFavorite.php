<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFavorite extends Model
{
    use HasFactory;
    protected $table = 'user_favorites';
    protected $fillable = [
        'user_id',
        'resep_id',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke ResepMakanan
    public function resep(): BelongsTo
    {
        return $this->belongsTo(ResepMakanan::class, 'resep_id', 'id');
    }
}