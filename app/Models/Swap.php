<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\CarModel;
use App\Models\Tag;
use App\Models\Engine;

class Swap extends Model
{
    // Pola do masowego przypisywania
    protected $fillable = [
        'car_model_id',
    ];

    // Relacja: swap należy do jednego modelu auta
    public function carModel(): BelongsTo
    {
        return $this->belongsTo(CarModel::class);
    }

    // Relacja wiele-do-wielu: tagi ogólne przypisane do swapa
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    // Relacja wiele-do-wielu: silniki przypisane do swapa, z notatką
    public function engines(): BelongsToMany
    {
        return $this->belongsToMany(Engine::class, 'engine_swap')
                    ->withPivot('note')
                    ->withTimestamps();
    }

    // Relacja wiele-do-wielu: tagi przypisane do silników w ramach swapa
    public function engineTags()
    {
        return $this->belongsToMany(Tag::class, 'swap_engine_tag')
            ->withPivot('engine_id')
            ->withTimestamps();
    }
}
