<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TagController extends Controller
{
    /**
     * Display a listing of the tags.
     */
    public function index(): View
    {
        $tags = Tag::all();
        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new tag.
     */
    public function create(): View
    {
        return view('tags.create');
    }

    /**
     * Store a newly created tag in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Tag::create($validated);

        return redirect()->route('tags.index')->with('success', 'Tag został dodany.');
    }

    /**
     * Show the form for editing the specified tag.
     */
    public function edit(Tag $tag): View
    {
        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified tag in storage.
     */
    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tag->update($validated);

        return redirect()->route('tags.index')->with('success', 'Tag został zaktualizowany.');
    }

    /**
     * Remove the specified tag from storage.
     */
    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return redirect()->route('tags.index')->with('success', 'Tag został usunięty.');
    }
}
