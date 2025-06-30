<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Lista swapów
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 text-green-500">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Filtrowanie po tagach --}}
                @isset($selectedSwap)
                    <form method="GET" action="{{ route('swaps.index') }}" class="mb-6">
                        <input type="hidden" name="selected" value="{{ $selectedSwap->id }}">
                        <label class="block mb-2 text-white font-semibold">Filtruj po tagach:</label>
                        <div class="flex flex-wrap gap-4 text-white">
                            @foreach ($tags as $tag)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->name }}"
                                        class="form-checkbox text-blue-600"
                                        {{ request()->has('tags') && in_array($tag->name, request('tags')) ? 'checked' : '' }}>
                                    <span class="ml-2">{{ $tag->name }}</span>
                                </label>
                            @endforeach
                            <button type="submit" class="ml-auto px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Filtruj
                            </button>
                        </div>
                    </form>
                @endisset

                {{-- Szczegóły swapa --}}
                @isset($selectedSwap)
                    <div id="selected-swap" class="mb-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Szczegóły swapa</h3>

                        <div class="text-gray-200 mb-4">
                            <strong>Marka:</strong> {{ $selectedSwap->carModel->brand }}<br>
                            <strong>Model:</strong> {{ $selectedSwap->carModel->model }}<br>
                            <strong>Generacja:</strong> {{ $selectedSwap->carModel->generation ?? 'brak' }}<br>
                            <strong>Lata:</strong> {{ $selectedSwap->carModel->year_start }} - {{ $selectedSwap->carModel->year_end ?? 'obecnie' }}
                        </div>

                        <div class="overflow-x-auto mb-4">
                            <table class="min-w-full border border-gray-700 text-gray-200 text-sm">
                                <thead class="bg-gray-700">
                                    <tr>
                                        <th class="border px-2 py-1">Silnik</th>
                                        <th class="border px-2 py-1">Tagi</th>
                                        <th class="border px-2 py-1">Notatka</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($filteredEngines as $engine)
                                        <tr>
                                            <td class="border px-2 py-1">
                                                {{ $engine->code }}<br>
                                                {{ $engine->power }} KM / {{ $engine->capacity }} L / {{ $engine->fuel_type }}
                                            </td>
                                            <td class="border px-2 py-1">
                                                @php
                                                    $tagsForEngine = $selectedSwap->engineTags->where('pivot.engine_id', $engine->id)->pluck('name')->toArray();
                                                @endphp
                                                {{ count($tagsForEngine) ? implode(', ', $tagsForEngine) : 'brak' }}
                                            </td>
                                            <td class="border px-2 py-1">
                                                {{ $engine->pivot->note ?? '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-gray-400 py-2">Brak wyników dla wybranych filtrów.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endisset

                {{-- Przycisk dodawania --}}
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('swaps.create') }}"
                       class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                        + Dodaj nowy swap
                    </a>
                </div>

                {{-- Tabela swapów --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto text-left">
                        <thead class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                            <tr>
                                <th class="px-4 py-2">Model</th>
                                <th class="px-4 py-2">Silnik</th>
                                <th class="px-4 py-2">Akcje</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                            @forelse ($swaps as $swap)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-2">
                                        {{ $swap->carModel->brand }} {{ $swap->carModel->model }}
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($swap->engines->isNotEmpty())
                                            <ul class="list-disc list-inside space-y-1">
                                                @foreach ($swap->engines as $engine)
                                                    <li>
                                                        {{ $engine->code }} – {{ $engine->capacity }}L {{ $engine->fuel_type }}
                                                        @php
                                                            $tags = $swap->engineTags->where('pivot.engine_id', $engine->id)->pluck('name');
                                                        @endphp
                                                        @if ($tags->isNotEmpty())
                                                            <span class="text-sm text-yellow-400">({{ $tags->implode(', ') }})</span>
                                                        @endif
                                                        @if ($engine->pivot->note)
                                                            <br><span class="text-xs text-gray-400 italic">{{ $engine->pivot->note }}</span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-gray-400">brak</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 flex space-x-2">
                                        <a href="{{ route('swaps.edit', $swap->id) }}"
                                           class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                           Edytuj
                                        </a>
                                        <form action="{{ route('swaps.destroy', $swap->id) }}" method="POST" onsubmit="return confirm('Na pewno chcesz usunąć ten swap?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                Usuń
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-2 text-center text-gray-500">
                                        Brak swapów do wyświetlenia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const el = document.getElementById('selected-swap');
            if (el) el.scrollIntoView({ behavior: 'smooth' });
        });
    </script>
</x-app-layout>
