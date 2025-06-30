<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dodaj nowy silnik
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Komunikaty --}}
                @if ($errors->any())
                    <div class="mb-4 text-red-500">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 text-green-500">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Formularz --}}
                <form method="POST" action="{{ route('engines.store') }}">
                    @csrf

                    {{-- Kod silnika --}}
                    <div class="mb-4">
                        <x-input-label for="code" value="Kod silnika" />
                        <x-text-input id="code" name="code" type="text" class="mt-1 block w-full"
                                      value="{{ old('code') }}" required />
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>

                    {{-- Moc (KM) --}}
                    <div class="mb-4">
                        <x-input-label for="power" value="Moc (KM)" />
                        <x-text-input id="power" name="power" type="number" class="mt-1 block w-full"
                                      value="{{ old('power') }}" required />
                        <x-input-error :messages="$errors->get('power')" class="mt-2" />
                    </div>

                    {{-- Rodzaj paliwa --}}
                    <div class="mb-4">
                        <x-input-label for="fuel_type" value="Rodzaj paliwa" />
                        <select name="fuel_type" id="fuel_type"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-gray-500">
                            <option value="">-- Wybierz --</option>
                            <option value="Benzyna" {{ old('fuel_type') == 'Benzyna' ? 'selected' : '' }}>Benzyna</option>
                            <option value="Diesel" {{ old('fuel_type') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="Elektryczny" {{ old('fuel_type') == 'Elektryczny' ? 'selected' : '' }}>Elektryczny</option>
                            <option value="Hybryda" {{ old('fuel_type') == 'Hybryda' ? 'selected' : '' }}>Hybryda</option>
                        </select>
                        <x-input-error :messages="$errors->get('fuel_type')" class="mt-2" />
                    </div>

                    {{-- Pojemność (L) --}}
                    <div class="mb-4">
                        <x-input-label for="capacity" value="Pojemność (L)" />
                        <x-text-input id="capacity" name="capacity" type="number" step="0.1" class="mt-1 block w-full"
                                      value="{{ old('capacity') }}" required />
                        <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                    </div>

                    {{-- Przycisk --}}
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('engines.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                            Anuluj
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Zapisz
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
