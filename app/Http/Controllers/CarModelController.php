<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use Illuminate\Http\Request;
use App\Models\Swap;
use App\Models\Engine;
use Illuminate\Support\Arr;

class CarModelController extends Controller
{
    /**
     * Display a listing of car models.
     */
    public function index()
    {
        $carModels = CarModel::with('engines')->get();
        $brands = CarModel::select('brand')->distinct()->pluck('brand');
        return view('car_models.index', compact('carModels', 'brands'));
    }

    /**
     * Show the form for creating a new car model.
     */
    public function create()
    {
        $engines = Engine::orderBy('code')->get();
        return view('car_models.create', compact('engines'));
    }

    /**
     * Store a newly created car model in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'generation' => 'nullable|string|max:255',
            'year_start' => 'required|integer|min:1900|max:2100',
            'year_end' => 'nullable|integer|min:1900|max:2100|gte:year_start',
            'engines' => 'nullable|array',
            'engines.*' => 'exists:engines,id',
        ]);

        $carModel = CarModel::create(Arr::except($validated, 'engines'));
        $carModel->engines()->sync($request->input('engines', []));

        return redirect()->route('car-models.index')->with('success', 'Model auta został dodany.');
    }

    /**
     * Show the form for editing the specified car model.
     */
    public function edit(CarModel $carModel)
    {
        $engines = Engine::orderBy('code')->get();
        $carModel->load('engines');
        return view('car_models.edit', compact('carModel', 'engines'));
    }

    /**
     * Update the specified car model in storage.
     */
    public function update(Request $request, CarModel $carModel)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'generation' => 'nullable|string|max:255',
            'year_start' => 'required|integer|min:1900|max:2100',
            'year_end' => 'nullable|integer|min:1900|max:2100|gte:year_start',
            'engines' => 'nullable|array',
            'engines.*' => 'exists:engines,id',
        ]);

        $carModel->update(Arr::except($validated, 'engines'));
        $carModel->engines()->sync($request->input('engines', []));

        return redirect()->route('car-models.index')->with('success', 'Model auta został zaktualizowany.');
    }

    /**
     * Remove the specified car model from storage.
     */
    public function destroy(CarModel $carModel)
    {
        $carModel->delete();
        return redirect()->route('car-models.index')->with('success', 'Model auta został usunięty.');
    }

    /**
     * Return models for a selected brand.
     */
    public function getModelsByBrand(Request $request)
    {
        $brand = $request->input('brand');

        if (!$brand) {
            return response()->json([], 400);
        }

        $models = CarModel::where('brand', $brand)
                          ->pluck('model')
                          ->unique()
                          ->values();

        return response()->json($models);
    }

    /**
     * Search swaps based on filters.
     */
    public function searchSwaps(Request $request)
    {
        $request->validate([
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'year' => 'nullable|integer',
            'engine' => 'nullable|string',
        ]);

        $query = Swap::query()->with(['carModel', 'engines']);

        if ($request->filled('brand')) {
            $query->whereHas('carModel', fn ($q) =>
                $q->where('brand', $request->brand)
            );
        }

        if ($request->filled('model')) {
            $query->whereHas('carModel', fn ($q) =>
                $q->where('model', $request->model)
            );
        }

        if ($request->filled('year')) {
            $query->whereHas('carModel', function ($q) use ($request) {
                $q->where('year_start', '<=', $request->year)
                ->where(function ($q2) use ($request) {
                    $q2->whereNull('year_end')
                        ->orWhere('year_end', '>=', $request->year);
                });
            });
        }

        return response()->json($query->get());
    }

    /**
     * Return available years and engines for given brand and model.
     */
    public function getYearsAndEngines(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');

        if (!$brand || !$model) {
            return response()->json(['years' => [], 'engines' => []], 400);
        }

        $carModels = CarModel::with('engines')
            ->where('brand', $brand)
            ->where('model', $model)
            ->get();

        $years = [];

        foreach ($carModels as $carModel) {
            $start = $carModel->year_start;
            $end = $carModel->year_end ?? date('Y');
            for ($year = $start; $year <= $end; $year++) {
                $years[] = $year;
            }
        }

        $uniqueYears = array_values(array_unique($years));
        sort($uniqueYears);

        $engines = $carModels->flatMap(fn ($model) => $model->engines)
                             ->filter()
                             ->unique('id')
                             ->values();

        return response()->json([
            'years' => $uniqueYears,
            'engines' => $engines,
        ]);
    }
}
