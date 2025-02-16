<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah No Perkara Perdata') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-4">
        <form action="{{ route('no_perkara.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="no" class="block text-gray-700">No Perkara</label>
                <input type="text" name="no" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('no_perkara.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
        </form>
    </div>
</x-app-layout>
