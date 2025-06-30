<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Engine;

class CarModel extends Model
{
    // Pola do masowego przypisywania
    protected $fillable = [
        'brand',
        'model',
        'generation',
        'year_start',
        'year_end',
    ];

    // Relacja: jeden model może mieć wiele swapów
    public function swaps(): HasMany
    {
        return $this->hasMany(Swap::class);
    }

    // Relacja wiele-do-wielu: model ma wiele silników
    public function engines(): BelongsToMany
    {
        return $this->belongsToMany(
            Engine::class,
            'car_model_engine',
            'car_model_id',
            'engine_id'
        );
    }
}
