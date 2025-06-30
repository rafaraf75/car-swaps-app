<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edytuj model auta
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Błędy --}}
                @if ($errors->any())
                    <div class="mb-4 text-red-500">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('car-models.update', $carModel) }}">
                    @csrf
                    @method('PATCH')

                    {{-- Marka --}}
                    <div class="mb-4">
                        <x-input-label for="brand" value="Marka" />
                        <x-text-input id="brand" name="brand" type="text" class="mt-1 block w-full"
                                      value="{{ old('brand', $carModel->brand) }}" required />
                        <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                    </div>

                    {{-- Model --}}
                    <div class="mb-4">
                        <x-input-label for="model" value="Model" />
                        <x-text-input id="model" name="model" type="text" class="mt-1 block w-full"
                                      value="{{ old('model', $carModel->model) }}" required />
                        <x-input-error :messages="$errors->get('model')" class="mt-2" />
                    </div>

                    {{-- Generacja --}}
                    <div class="mb-4">
                        <x-input-label for="generation" value="Generacja (opcjonalnie)" />
                        <x-text-input id="generation" name="generation" type="text" class="mt-1 block w-full"
                                      value="{{ old('generation', $carModel->generation) }}" />
                        <x-input-error :messages="$errors->get('generation')" class="mt-2" />
                    </div>

                    {{-- Rok start --}}
                    <div class="mb-4">
                        <x-input-label for="year_start" value="Rok początkowy" />
                        <x-text-input id="year_start" name="year_start" type="number" class="mt-1 block w-full"
                                      value="{{ old('year_start', $carModel->year_start) }}" required />
                        <x-input-error :messages="$errors->get('year_start')" class="mt-2" />
                    </div>

                    {{-- Rok koniec --}}
                    <div class="mb-4">
                        <x-input-label for="year_end" value="Rok końcowy (opcjonalnie)" />
                        <x-text-input id="year_end" name="year_end" type="number" class="mt-1 block w-full"
                                      value="{{ old('year_end', $carModel->year_end) }}" />
                        <x-input-error :messages="$errors->get('year_end')" class="mt-2" />
                    </div>

                    {{-- Silniki – wiele --}}
                    <div class="mb-4">
                        <x-input-label for="engines" value="Silniki oryginalne (możesz wybrać wiele)" />
                        <select id="engines" name="engines[]" multiple
                                class="block w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-black dark:text-white">
                            @foreach ($engines as $engine)
                                <option value="{{ $engine->id }}"
                                    {{ in_array($engine->id, old('engines', $carModel->engines->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $engine->code }} – {{ $engine->capacity }}L {{ $engine->fuel_type }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('engines')" class="mt-2" />
                    </div>

                    {{-- Przycisk --}}
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('car-models.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                            Anuluj
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Zapisz zmiany
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
