<?php

namespace App\Http\Controllers;

use App\Models\Swap;
use App\Models\CarModel;
use App\Models\Engine;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SwapController extends Controller
{
    /**
     * Display a listing of swaps and optionally filter engines by tags.
     */
    public function index(Request $request)
    {
        $swaps = Swap::with(['carModel', 'engines', 'engineTags'])->get();

        $selectedSwap = null;
        $filteredEngines = [];

        if ($request->has('selected')) {
            $selectedSwap = Swap::with(['carModel', 'tags'])->find($request->get('selected'));

            if ($selectedSwap) {
                $allEngines = $selectedSwap->engines()
                    ->with(['tags' => fn($q) => $q->withPivot('swap_id')])
                    ->get();

                if ($request->filled('tags')) {
                    $tagNames = $request->input('tags');

                    $selectedTagIds = Tag::whereIn('name', $tagNames)
                        ->pluck('id')
                        ->toArray();

                    $filteredEngines = $allEngines->filter(function ($engine) use ($selectedTagIds, $selectedSwap) {
                        return $engine->tags
                            ->filter(fn($tag) => $tag->pivot->swap_id == $selectedSwap->id)
                            ->pluck('id')
                            ->intersect($selectedTagIds)
                            ->isNotEmpty();
                    });
                } else {
                    $filteredEngines = $allEngines;
                }
            }
        }

        $tags = Tag::all();

        return view('swaps.index', compact('swaps', 'selectedSwap', 'filteredEngines', 'tags'));
    }

    /**
     * Show the form for creating a new swap.
     */
    public function create()
    {
        $carModels = CarModel::all();
        $engines = Engine::where('is_swap_candidate', true)->get();
        $allTags = Tag::all();

        return view('swaps.create', compact('carModels', 'engines', 'allTags'));
    }

    /**
     * Store a newly created swap in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_model_id' => 'required|exists:car_models,id',
            'engines' => 'required|array',
            'engines.*.selected' => 'nullable|boolean',
            'engines.*.note' => 'nullable|string|max:1000',
        ]);

        $swap = Swap::create([
            'car_model_id' => $request->car_model_id,
        ]);

        $pivotData = [];
        $tagSyncData = [];

        foreach ($request->engines as $engineId => $data) {
            if (!empty($data['selected'])) {
                $pivotData[$engineId] = [
                    'note' => $data['note'] ?? null,
                ];

                if (isset($data['tags']) && is_array($data['tags'])) {
                    foreach (array_keys($data['tags']) as $tagId) {
                        $tagSyncData[$tagId] = ['engine_id' => $engineId];
                    }
                }
            }
        }

        $swap->engines()->sync($pivotData);
        $swap->engineTags()->sync($tagSyncData);

        return redirect()->route('swaps.index')->with('success', 'Swap został dodany.');
    }

    /**
     * Display the specified swap.
     */
    public function show(Swap $swap)
    {
        $swap->load(['carModel', 'engines.tags']);
        return view('swaps.show', compact('swap'));
    }

    /**
     * Show the form for editing the specified swap.
     */
    public function edit(Swap $swap)
    {
        $carModels = CarModel::all();
        $engines = Engine::where('is_swap_candidate', true)->get();
        $allTags = Tag::all();

        $swap->load(['engines.tags', 'engineTags']);

        $engineData = [];
        foreach ($swap->engines as $engine) {
            $engineData[$engine->id] = [
                'note' => $engine->pivot->note ?? null,
                'tags' => $swap->engineTags
                    ->where('pivot.engine_id', $engine->id)
                    ->pluck('id')
                    ->toArray(),
            ];
        }

        return view('swaps.edit', compact(
            'swap', 'carModels', 'engines', 'engineData', 'allTags'
        ));
    }

    /**
     * Update the specified swap in storage.
     */
    public function update(Request $request, Swap $swap)
    {
        $request->validate([
            'car_model_id' => 'required|exists:car_models,id',
            'engines' => 'required|array',
            'engines.*.selected' => 'nullable|boolean',
            'engines.*.note' => 'nullable|string|max:1000',
        ]);

        $swap->update([
            'car_model_id' => $request->car_model_id,
        ]);

        $pivotData = [];
        $tagSyncData = [];

        foreach ($request->engines as $engineId => $data) {
            if (!empty($data['selected'])) {
                $pivotData[$engineId] = [
                    'note' => $data['note'] ?? null,
                ];

                if (isset($data['tags']) && is_array($data['tags'])) {
                    foreach (array_keys($data['tags']) as $tagId) {
                        $tagSyncData[$tagId] = ['engine_id' => $engineId];
                    }
                }
            }
        }

        $swap->engines()->sync($pivotData);
        $swap->engineTags()->detach();
        $swap->engineTags()->syncWithoutDetaching($tagSyncData);

        return redirect()->route('swaps.index')->with('success', 'Swap został zaktualizowany.');
    }

    /**
     * Remove the specified swap from storage.
     */
    public function destroy(Swap $swap)
    {
        $swap->delete();
        return redirect()->route('swaps.index')->with('success', 'Swap został usunięty.');
    }
}
