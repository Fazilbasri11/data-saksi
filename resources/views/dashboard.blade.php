<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
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
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Data Saksi Perkara Perdata (Gugatan)</h3>
                    <table id="saksi-table" class="table table-striped mb-5">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>No Perkara</th>
                                <th>Tgl Kehadiran</th>
                                <th>Jumlah Saksi Tergugat</th>
                                <th>Sedang Izin (Tergugat)</th>
                                <th>Jumlah Saksi Penggugat</th>
                                <th>Sedang Izin (Penggugat)</th>
                                <th>Status Perkara</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($saksiJenis2 as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item['no_perkara'] }}</td>
                                    <td>{{ $item['tgl_kehadiran'] }}</td>
                                    <td>{{ $item['jumlah_saksi_1'] }} hadir, dari {{ $item['akan_hadir1'] }} akan hadir
                                    </td>
                                    <td>{{ $item['jumlah_izin_1'] }}</td>
                                    <td>{{ $item['jumlah_saksi_2'] }} hadir, dari {{ $item['akan_hadir2'] }} akan hadir
                                    </td>
                                    <td>{{ $item['jumlah_izin_2'] }}</td>
                                    <td>
                                        <div class="flex items-center">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="toggle-status sr-only peer"
                                                    data-no-perkara="{{ $item['id_no_perkara'] }}"
                                                    data-tgl-kehadiran="{{ $item['tgl_kehadiran'] }}"
                                                    {{ $item['id_status_perkara'] == 1 ? 'checked' : '' }}>
                                                <div
                                                    class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                </div>
                                            </label>
                                            <span
                                                class="ml-2 status-text {{ $item['id_status_perkara'] == 2 ? 'text-red-500' : 'text-green-500' }}">
                                                {{ $item['id_status_perkara'] == 1 ? 'Selesai' : 'Berlangsung' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('saksi.edit-perdata', ['id_no_perkara' => $item['id_no_perkara'], 'tgl_kehadiran' => $item['tgl_kehadiran']]) }}"
                                            class="text-blue-600 hover:text-blue-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold mb-4">Data Saksi Perkara Perdata (Pemohon)</h3>
                <table id="saksi-table-pemohon" class="table table-striped mb-5">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>No Perkara</th>
                            <th>Tgl Kehadiran</th>
                            <th>Jumlah Saksi Pemohon</th>
                            <th>Sedang Izin (Pemohon)</th>
                            <th>Status Perkara</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saksiJenis1 as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['no_perkara'] }}</td>
                                <td>{{ $item['tgl_kehadiran'] }}</td>
                                <td>{{ $item['jumlah_saksi_3'] }} hadir, dari {{ $item['akan_hadir'] }} akan hadir
                                </td>
                                <td>{{ $item['jumlah_izin_3'] }}</td>
                                <td>
                                    <div class="flex items-center">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="toggle-status sr-only peer"
                                                data-no-perkara="{{ $item['id_no_perkara'] }}"
                                                data-tgl-kehadiran="{{ $item['tgl_kehadiran'] }}"
                                                {{ $item['id_status_perkara'] == 1 ? 'checked' : '' }}>
                                            <div
                                                class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                            </div>
                                        </label>
                                        <span
                                            class="ml-2 status-text {{ $item['id_status_perkara'] == 2 ? 'text-red-500' : 'text-green-500' }}">
                                            {{ $item['id_status_perkara'] == 1 ? 'Selesai' : 'Berlangsung' }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('saksi.edit-perdata', ['id_no_perkara' => $item['id_no_perkara'], 'tgl_kehadiran' => $item['tgl_kehadiran']]) }}"
                                        class="text-blue-600 hover:text-blue-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tambahkan Script DataTables -->
    <script>
        $(document).ready(function() {
            $('#saksi-table').DataTable({
                paging: true, // Pagination
                searching: true, // Search bar
                ordering: true, // Column ordering
                responsive: true, // Responsive table
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Selanjutnya"
                    }
                }
            });
            $('#saksi-table-pemohon').DataTable({
                paging: true, // Pagination
                searching: true, // Search bar
                ordering: true, // Column ordering
                responsive: true, // Responsive table
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Selanjutnya"
                    }
                }
            }); // Handle toggle switch changes
            $('.toggle-status').on('change', function() {
                const noPerkara = $(this).data('no-perkara');
                const tglKehadiran = $(this).data('tgl-kehadiran');
                const isChecked = $(this).prop('checked');
                const statusText = $(this).closest('td').find('.status-text');

                $.ajax({
                    url: '{{ route('update.status.perkara') }}',
                    method: 'POST',
                    data: {
                        id_no_perkara: noPerkara,
                        tgl_kehadiran: tglKehadiran,
                        status: isChecked,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update status text and color
                            statusText.text(response.new_status === 2 ? 'Selesai' :
                                    'Incomplete')
                                .removeClass('text-red-500 text-green-500')
                                .addClass(response.new_status === 2 ? 'text-green-500' :
                                    'text-red-500');

                            // Show success notification
                            alert('Status berhasil diupdate');
                        }
                    },
                    error: function(xhr) {
                        // Revert toggle if update fails
                        $(this).prop('checked', !isChecked);
                        alert('Gagal mengupdate status. Silakan coba lagi.');
                    }
                });
            });
        });
    </script>
</x-app-layout>
