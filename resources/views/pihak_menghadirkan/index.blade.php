<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Pihak') }}
        </h2>
    </x-slot>
    <!-- Tambahkan CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between mb-4">
                    <a href="{{ route('pihak_menghadirkan.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Tambah Pihak Menghadirkan
                    </a>
                </div>

                @if (session('success'))
                    <div class="bg-green-500 text-white p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table id="saksi-table" class="table table-striped mb-5">
                        <thead class="table-light">
                            <tr>
                                <th class="py-2 px-4 border-b">No</th>
                                <th class="py-2 px-4 border-b">Pihak</th>
                                <th class="py-2 px-4 border-b">Nama</th>
                                <th class="py-2 px-4 border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pihak as $no)
                                <tr class="hover:bg-gray-100">
                                    <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                                    <!-- Penomoran otomatis -->
                                    <td class="py-2 px-4 border-b">{{ $no->pihak->jenis ?? '-' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $no->nama }}</td>
                                    <td class="py-2 px-4 border-b">
                                        {{-- <a href="{{ route('pihak_menghadirkan.edit', $no->id) }}"
                                            class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a> --}}
                                        <form action="{{ route('pihak_menghadirkan.destroy', $no->id) }}" method="POST"
                                            class="delete-form inline-block" data-id="{{ $no->id }}">
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
            </div>
        </div>
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
