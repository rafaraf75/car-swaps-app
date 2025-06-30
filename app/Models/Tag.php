<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    // Pola do masowego przypisywania
    protected $fillable = ['name'];

    // Relacja wiele-do-wielu: tagi przypisane do modeli aut
    public function carModels(): BelongsToMany
    {
        return $this->belongsToMany(CarModel::class);
    }

    // Relacja wiele-do-wielu: tagi przypisane ogólnie do swapów
    public function swaps(): BelongsToMany
    {
        return $this->belongsToMany(Swap::class);
    }
}
