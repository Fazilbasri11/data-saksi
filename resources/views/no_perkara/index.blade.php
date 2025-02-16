<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('No Perkara Perdata') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-4">
        <div class="flex justify-between mb-4">
            <a href="{{ route('no_perkara.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah No
                Perkara</a>
        </div>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">No</th>
                    <th class="py-2 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($noPerkara as $no)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $no->no }}</td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('no_perkara.edit', $no->id) }}"
                                class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                            <form action="{{ route('no_perkara.destroy', $no->id) }}" method="POST" class="delete-form"
                                data-id="{{ $no->id }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    class="bg-red-500 text-white px-2 py-1 rounded delete-btn">Hapus</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".delete-btn").forEach(button => {
                button.addEventListener("click", function() {
                    let form = this.closest(".delete-form");
                    let id = form.getAttribute("data-id");

                    Swal.fire({
                        title: "Apakah Anda yakin?",
                        text: "Data ini akan dihapus secara permanen!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

</x-app-layout>
