<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\CarModel;

class Engine extends Model
{
    // Pola do masowego przypisywania
    protected $fillable = ['code', 'power', 'fuel_type', 'capacity', 'is_swap_candidate'];

    // Konwersja typu
    protected $casts = [
        'is_swap_candidate' => 'boolean',
    ];

    // Relacja wiele-do-wielu: silnik pasuje do wielu modeli aut
    public function carModels(): BelongsToMany
    {
        return $this->belongsToMany(
            CarModel::class,
            'car_model_engine',
            'engine_id',
            'car_model_id'
        );
    }

    // Relacja wiele-do-wielu: silnik może być częścią wielu swapów (z notatką)
    public function swaps()
    {
        return $this->belongsToMany(Swap::class, 'engine_swap')
                    ->withPivot( 'note')
                    ->withTimestamps();
    }

    // Relacja wiele-do-wielu: tagi przypisane do silnika w ramach konkretnego swapa
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'swap_engine_tag',
            'engine_id',
            'tag_id'
        )->withPivot('swap_id')->withTimestamps();
    }

    // Tagi silnika tylko dla konkretnego swapa
    public function tagsForSwap(int $swapId): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'swap_engine_tag',
            'engine_id',
            'tag_id'
        )->withPivot('swap_id')
        ->wherePivot('swap_id', $swapId)
        ->withTimestamps();
    }
}
