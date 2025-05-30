<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeView extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'recipe_id',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(ResepMakanan::class, 'recipe_id');
    }
}