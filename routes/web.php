<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\EngineController;
use App\Http\Controllers\SwapController;
use App\Http\Controllers\TagController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// AJAX-owe trasy dostępne publicznie
Route::get('/car-models/by-brand', [CarModelController::class, 'getModelsByBrand']);
Route::get('/car-models/years-and-engines', [CarModelController::class, 'getYearsAndEngines']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/search-swaps', [CarModelController::class, 'searchSwaps'])->name('search.swaps');

    Route::resource('engines', EngineController::class);
    Route::resource('swaps', SwapController::class);
    Route::resource('tags', TagController::class);
    Route::resource('car-models', CarModelController::class)->except(['show']);
});

require __DIR__.'/auth.php';
