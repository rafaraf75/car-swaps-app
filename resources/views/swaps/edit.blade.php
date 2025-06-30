<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edytuj swap
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 text-red-500">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('swaps.update', $swap->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label for="car_model_id" value="Model auta" />
                        <select id="car_model_id" name="car_model_id" required class="block mt-1 w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm">
                            @foreach ($carModels as $carModel)
                                <option value="{{ $carModel->id }}" @selected($carModel->id == $swap->car_model_id)>
                                    {{ $carModel->brand }} {{ $carModel->model }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <x-input-label value="Silniki do swapa (możesz edytować kilka)" />
                        <div class="space-y-4">
                            @foreach ($engines as $engine)
                                @php
                                    $isSelected = $swap->engines->contains('id', $engine->id);
                                    $note = $engineData[$engine->id]['note'] ?? '';
                                    $tagIds = $engineData[$engine->id]['tags'] ?? [];
                                @endphp

                                <div class="p-4 border rounded-md bg-gray-700 text-white mb-4">
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="engines[{{ $engine->id }}][selected]" value="1"
                                            class="rounded text-blue-500" {{ $isSelected ? 'checked' : '' }}>
                                        <span>{{ $engine->code }} – {{ $engine->capacity }}L {{ $engine->fuel_type }}</span>
                                    </label>

                                    <div class="mt-2">
                                        <span class="block text-sm mb-1">Tagi:</span>
                                        <div class="flex flex-wrap gap-4">
                                            @foreach ($allTags as $tag)
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox"
                                                        name="engines[{{ $engine->id }}][tags][{{ $tag->id }}]"
                                                        value="1"
                                                        class="form-checkbox text-blue-500"
                                                        {{ in_array($tag->id, $tagIds) ? 'checked' : '' }}>
                                                    <span class="ml-2 text-white">{{ $tag->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <label for="note_{{ $engine->id }}" class="block text-sm">Notatka:</label>
                                        <textarea name="engines[{{ $engine->id }}][note]" id="note_{{ $engine->id }}" rows="2"
                                            class="w-full mt-1 rounded-md dark:bg-gray-800 border-gray-600">{{ $note }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('swaps.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                            Anuluj
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Zapisz zmiany
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
