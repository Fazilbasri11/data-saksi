<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Pihak Menghadirkan') }}
        </h2>
    </x-slot>

    <!-- Tambahkan CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mx-auto p-4">
                    <form action="{{ route('jenis_pihak.store') }}" method="POST" id="form-container">
                        @csrf

                        <div id="form-list">
                            <div class="form-item grid grid-cols-2 gap-4 bg-gray-100 p-4 rounded mb-4">
                                <!-- Kolom Pihak -->
                                <div>
                                    <label for="pihak" class="block text-gray-700 dark:text-white">Pihak</label>
                                    <select name="pihak[]"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                        <option value="">-- Pilih Jenis Pihak --</option>
                                        @foreach ($pihaks as $pihakx)
                                            <option value="{{ $pihakx->id }}">
                                                {{ $pihakx->jenis ?? 'Tanpa Jenis' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Kolom Nama Pihak -->
                                <div>
                                    <label for="nama" class="block text-gray-700 dark:text-white">Nama Pihak</label>
                                    <input type="text" name="nama[]"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Tambah Form -->
                        <button type="button" id="add-form-btn" class="bg-green-500 text-white px-4 py-2 rounded mt-2">
                            + Tambah Form Lagi
                        </button>

                        <!-- Tombol Simpan & Kembali -->
                        <div class="mt-4 flex justify-end space-x-2">
                            <a href="{{ route('jenis_pihak.index') }}"
                                class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert untuk Notifikasi -->
    <script>
        $(document).ready(function() {
            let options = `@foreach ($pihaks as $pihakx)
                        <option value="{{ $pihakx->id }}">
                            {{ $pihakx->jenis ?? 'Tanpa Jenis' }}
                        </option>
                    @endforeach`;

            $("#add-form-btn").on("click", function() {
                let newForm = `
            <div class="form-item grid grid-cols-2 gap-4 bg-gray-100 p-4 rounded mb-4">
                <div>
                    <label for="pihak" class="block text-gray-700 dark:text-white">Pihak</label>
                    <select name="pihak[]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">-- Pilih Pihak --</option>
                        ${options} <!-- Sisipkan opsi dari Blade -->
                    </select>
                </div>

                <div>
                    <label for="nama" class="block text-gray-700 dark:text-white">Nama Pihak</label>
                    <input type="text" name="nama[]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <!-- Tombol Hapus Form -->
                <button type="button" class="remove-form bg-red-500 text-white px-4 py-2 rounded mt-2">Hapus</button>
            </div>
        `;

                $("#form-list").append(newForm);
            });

            // Hapus Form
            $(document).on("click", ".remove-form", function() {
                $(this).closest(".form-item").remove();
            });
        });
    </script>

</x-app-layout>
