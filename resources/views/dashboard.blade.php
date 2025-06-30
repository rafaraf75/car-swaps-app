<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight text-center">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-16 bg-gray-900">
        <div class="max-w-2xl mx-auto px-4">
            <div class="bg-gray-800 text-white text-center p-10 rounded-2xl shadow-xl border border-gray-600">

                <h1 class="text-5xl font-extrabold mb-6">Witaj w SwapFinder</h1>

                <p class="text-lg text-gray-300 mb-2">
                    Aplikacja pomoże Ci znaleźć odpowiedni silnik do Twojego auta.
                </p>
                <p class="text-lg text-gray-300 mb-8">
                    Wybierz markę, model i sprawdź dostępne możliwości swapa.
                </p>

                <a href="{{ route('car-models.index') }}"
                   class="inline-block px-8 py-3 bg-gray-600 hover:bg-gray-500 rounded-lg text-white text-base font-semibold transition">
                    Rozpocznij
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
