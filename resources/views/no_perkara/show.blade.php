<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail No Perkara Perdata') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-4">
        <p class="text-gray-700"><strong>No Perkara:</strong> {{ $noPerkaraPerdata->no }}</p>
        <a href="{{ route('no_perkara.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
    </div>
</x-app-layout>
