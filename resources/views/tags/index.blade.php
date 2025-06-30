<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Lista tagów
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Komunikaty --}}
                @if (session('success'))
                    <div class="mb-4 text-green-500">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Przycisk dodawania po prawej --}}
                <div class="mb-6 flex justify-end">
                    <a href="{{ route('tags.create') }}"
                       class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                        + Dodaj nowy tag
                    </a>
                </div>

                {{-- Tabela --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-600 text-white">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nazwa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Akcje</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 divide-y divide-gray-700">
                            @forelse ($tags as $tag)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $tag->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $tag->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                        <a href="{{ route('tags.edit', $tag) }}"
                                           class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                            Edytuj
                                        </a>

                                        <form method="POST" action="{{ route('tags.destroy', $tag) }}" onsubmit="return confirm('Na pewno usunąć ten tag?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                Usuń
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-400">Brak tagów.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
