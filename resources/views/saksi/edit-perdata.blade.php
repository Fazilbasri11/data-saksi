<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Data Saksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($saksiList->isEmpty())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">No Data Found!</strong>
                    <span class="block sm:inline">There are no witnesses available for the given case.</span>
                </div>
            @else
                <!-- Displaying the case details above the cards -->
                <div class="bg-gray-100 p-4 rounded-lg mb-6">
                    <p><strong>No Perkara:</strong> {{ $saksiList->first()->no_perkara }}</p>
                    <p><strong>Tanggal Kehadiran:</strong>
                        {{ \Carbon\Carbon::parse($saksiList->first()->tgl_kehadiran)->format('d-m-Y') }}</p>
                    <p><strong>Status Perkara:</strong> {{ $saksiList->first()->id_status_perkara }}</p>
                    <p><strong>Jenis Perkara:</strong> {{ $saksiList->first()->id_jenis_perkara }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-6">
                    <form method="GET" action="{{ route('saksi.search') }}" class="flex items-center">
                        <input type="text" name="search" placeholder="Search by name..."
                            class="border rounded-lg p-2 w-full" />
                        <button type="submit" class="ml-2 bg-blue-500 text-white rounded-lg px-4 py-2">Search</button>
                    </form>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($saksiList as $saksi)
                        <div class="bg-white shadow-md rounded-lg p-6 transition-transform transform hover:scale-105">
                            <h3 class="text-lg font-bold">Nama: {{ $saksi->nama_saksi }}</h3>
                            <p><strong>Tempat Lahir:</strong> {{ $saksi->tempat_lahir }}</p>
                            <p><strong>Tanggal Lahir:</strong>
                                {{ \Carbon\Carbon::parse($saksi->tanggal_lahir)->format('d-m-Y') }}</p>
                            <p><strong>Alamat:</strong> {{ $saksi->alamat }}</p>
                            <p><strong>No HP:</strong> {{ $saksi->no_hp }}</p>
                            <p><strong>Jenis Kelamin:</strong>
                                {{ $saksi->id_jeniskelamin == 1 ? 'Laki-laki' : 'Perempuan' }}</p>

                            <!-- Switch for id_izin -->
                            <div class="mt-4 flex items-center">
                                <span class="mr-2">Izin:</span>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="toggle-izin" data-id="{{ $saksi->id }}"
                                        {{ $saksi->id_izin == 1 ? 'checked' : '' }} />
                                    <span class="ml-2">{{ $saksi->id_izin == 1 ? 'Aktif' : 'Nonaktif' }}</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('change', '.toggle-izin', function() {
            const saksiId = $(this).data('id');
            const newIzin = $(this).is(':checked') ? 1 : 2;

            $.ajax({
                url: `/saksi/${saksiId}/update-izin`,
                method: 'PATCH',
                data: {
                    id_izin: newIzin,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Status izin berhasil diperbarui menjadi ' +
                                (newIzin === 1 ? 'Aktif' : 'Nonaktif'),
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false,
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message ||
                            'Terjadi kesalahan saat memperbarui izin.',
                        icon: 'error',
                    });
                },
            });
        });
    </script>


</x-app-layout>
