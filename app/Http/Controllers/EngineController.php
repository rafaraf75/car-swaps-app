<?php

namespace App\Http\Controllers;

use App\Models\Engine;
use Illuminate\Http\Request;

class EngineController extends Controller
{
    /**
     * Display a listing of the engines.
     */
    public function index()
    {
        $engines = Engine::all();
        return view('engines.index', compact('engines'));
    }

    /**
     * Show the form for creating a new engine.
     */
    public function create()
    {
        return view('engines.create');
    }

    /**
     * Store a newly created engine in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'power' => 'required|integer|min:1',
            'fuel_type' => 'required|string|max:255',
            'capacity' => 'required|numeric|min:0.1',
        ]);

        Engine::create($validated);

        return redirect()->route('engines.index')->with('success', 'Silnik został dodany.');
    }

    /**
     * Show the form for editing the specified engine.
     */
    public function edit(Engine $engine)
    {
        return view('engines.edit', compact('engine'));
    }

    /**
     * Update the specified engine in storage.
     */
    public function update(Request $request, Engine $engine)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'power' => 'required|integer|min:1',
            'fuel_type' => 'required|string|max:255',
            'capacity' => 'required|numeric|min:0.1',
        ]);

        $engine->update($validated);

        return redirect()->route('engines.index')->with('success', 'Silnik został zaktualizowany.');
    }

    /**
     * Remove the specified engine from storage.
     */
    public function destroy(Engine $engine)
    {
        $engine->delete();

        return redirect()->route('engines.index')->with('success', 'Silnik został usunięty.');
    }
}
