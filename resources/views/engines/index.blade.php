<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Lista silników
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Przycisk dodawania --}}
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('engines.create') }}"
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition">
                        + Dodaj silnik
                    </a>
                </div>

                {{-- Tabela silników --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium">ID</th>
                                <th class="px-4 py-2 text-left text-sm font-medium">Kod</th>
                                <th class="px-4 py-2 text-left text-sm font-medium">Moc (KM)</th>
                                <th class="px-4 py-2 text-left text-sm font-medium">Rodzaj paliwa</th>
                                <th class="px-4 py-2 text-left text-sm font-medium">Pojemność (L)</th>
                                <th class="px-4 py-2 text-left text-sm font-medium">Akcje</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900 dark:text-gray-100">
                            @forelse ($engines as $engine)
                                <tr>
                                    <td class="px-4 py-2">{{ $engine->id }}</td>
                                    <td class="px-4 py-2">{{ $engine->code }}</td>
                                    <td class="px-4 py-2">{{ $engine->power }}</td>
                                    <td class="px-4 py-2">{{ $engine->fuel_type }}</td>
                                    <td class="px-4 py-2">{{ $engine->capacity }}</td>
                                    <td class="px-4 py-2 flex gap-2">
                                        <a href="{{ route('engines.edit', $engine) }}"
                                           class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md text-sm">
                                            Edytuj
                                        </a>
                                        <form action="{{ route('engines.destroy', $engine) }}" method="POST"
                                              onsubmit="return confirm('Na pewno usunąć silnik?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm">
                                                Usuń
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Brak silników w bazie danych.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
