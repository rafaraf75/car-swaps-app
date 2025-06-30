<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modele aut') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Przycisk dodawania --}}
                <div class="flex justify-end mb-4">
                    <a href="{{ route('car-models.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                        + Dodaj model auta
                    </a>
                </div>

                {{-- Formularz wyszukiwania --}}
                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Wyszukaj możliwość swapa</h3>

                <form method="GET" action="#" onsubmit="event.preventDefault();">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                        <div>
                            <x-input-label for="brand" value="Marka" />
                            <select id="brand" name="brand" class="block w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-black dark:text-white">
                                <option value="">Wybierz markę</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand }}">{{ $brand }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="model" value="Model" />
                            <select id="model" name="model" class="block w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-black dark:text-white">
                                <option value="">Wybierz model</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="year" value="Rok produkcji" />
                            <select id="year" name="year" class="block w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-black dark:text-white">
                                <option value="">Wybierz rok</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" id="searchBtn" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Wyszukaj
                        </button>
                    </div>
                </form>

                {{-- Wyniki wyszukiwania --}}
                <div id="results" class="mt-8 text-gray-200 text-sm">
                    Wybierz parametry, aby zobaczyć dostępne opcje swapa.
                </div>

                {{-- Lista istniejących modeli --}}
                <div class="mt-12">
                    <h3 class="text-lg font-semibold text-gray-200 mb-4">Wszystkie modele</h3>
                    <table class="min-w-full text-sm text-gray-300">
                        <thead>
                            <tr class="border-b border-gray-600">
                                <th class="text-left py-2">Marka</th>
                                <th class="text-left py-2">Model</th>
                                <th class="text-left py-2">Lata</th>
                                <th class="text-left py-2">Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carModels as $car)
                                <tr class="border-b border-gray-700">
                                    <td class="py-1">{{ $car->brand }}</td>
                                    <td class="py-1">{{ $car->model }}</td>
                                    <td class="py-1">{{ $car->year_start }} - {{ $car->year_end ?? 'obecnie' }}</td>
                                    <td class="py-1 flex gap-2">
                                        <a href="{{ route('car-models.edit', $car) }}"
                                           class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                           Edytuj
                                        </a>

                                        <form action="{{ route('car-models.destroy', $car) }}" method="POST" onsubmit="return confirm('Na pewno chcesz usunąć ten model?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                Usuń
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    {{-- JS --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const brandSelect = document.getElementById('brand');
        const modelSelect = document.getElementById('model');
        const yearSelect = document.getElementById('year');
        const searchBtn = document.getElementById('searchBtn');
        const resultsDiv = document.getElementById('results');

        brandSelect.addEventListener('change', function () {
            const brand = this.value;
            modelSelect.innerHTML = '<option value="">Wybierz model</option>';
            yearSelect.innerHTML = '<option value="">Wybierz rok</option>';
            resultsDiv.innerHTML = '';

            if (brand) {
                fetch(`/car-models/by-brand?brand=${encodeURIComponent(brand)}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(model => {
                            const option = document.createElement('option');
                            option.value = model;
                            option.textContent = model;
                            modelSelect.appendChild(option);
                        });
                    })
                    .catch(() => alert("Błąd przy pobieraniu modeli."));
            }
        });

        modelSelect.addEventListener('change', function () {
            const brand = brandSelect.value;
            const model = this.value;
            yearSelect.innerHTML = '<option value="">Wybierz rok</option>';
            resultsDiv.innerHTML = '';

            if (brand && model) {
                fetch(`/car-models/years-and-engines?brand=${encodeURIComponent(brand)}&model=${encodeURIComponent(model)}`)
                    .then(response => response.json())
                    .then(data => {
                        data.years.forEach(year => {
                            const option = document.createElement('option');
                            option.value = year;
                            option.textContent = year;
                            yearSelect.appendChild(option);
                        });
                    })
                    .catch(() => alert("Błąd przy pobieraniu lat."));
            }
        });

        searchBtn.addEventListener('click', function () {
            const brand = brandSelect.value;
            const model = modelSelect.value;
            const year = yearSelect.value;

            resultsDiv.innerHTML = 'Ładowanie wyników...';

            const params = new URLSearchParams({ brand, model, year });

            fetch(`/search-swaps?${params.toString()}`)
                .then(res => res.json())
                .then(data => {
                    if (!data.length) {
                        resultsDiv.innerHTML = 'Brak wyników.';
                        return;
                    }

                    let html = `<table class="min-w-full text-sm text-gray-300 border border-gray-600 mt-4">
                                    <thead>
                                        <tr class="bg-gray-700 text-white">
                                            <th class="border px-2 py-1">Marka</th>
                                            <th class="border px-2 py-1">Model</th>
                                            <th class="border px-2 py-1">Silnik</th>
                                            <th class="border px-2 py-1">Moc</th>
                                            <th class="border px-2 py-1">Paliwo</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                    data.forEach(swap => {
                        swap.engines.forEach(engine => {
                            html += `<tr class="cursor-pointer hover:bg-gray-700 transition"
                                        onclick="window.location.href='/swaps?selected=${swap.id}'">
                                        <td class="border px-2 py-1">${swap.car_model.brand}</td>
                                        <td class="border px-2 py-1">${swap.car_model.model}</td>
                                        <td class="border px-2 py-1">${engine.code}</td>
                                        <td class="border px-2 py-1">${engine.power}</td>
                                        <td class="border px-2 py-1">${engine.fuel_type}</td>
                                    </tr>`;
                        });
                    });

                    html += '</tbody></table>';
                    resultsDiv.innerHTML = html;
                })
                .catch(error => {
                    resultsDiv.innerHTML = 'Błąd podczas wyszukiwania.';
                    console.error('Search error:', error);
                });
        });
    });
    </script>
</x-app-layout>
