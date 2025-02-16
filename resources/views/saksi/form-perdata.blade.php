<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>{{ $saksi ? 'Edit Data Saksi' : 'Input Data Saksi' }}</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Pendataan Saksi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>{{ $saksi ? 'Edit Data Saksi' : 'Input Data Saksi' }}</h2>

        <form action="{{ route('saksi.store') }}" method="POST" id="saksiForm">
            @csrf

            <!-- Card Data Perkara -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Data Perkara Perdata</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_no_perkara" class="form-label">Nomor Perkara</label>
                                <select class="form-control" id="id_no_perkara" name="id_no_perkara" required>
                                    <option value="">Pilih Nomor Perkara</option>
                                    @foreach ($noPerkara as $perkara)
                                        <option value="{{ $perkara->id }}"
                                            {{ old('id_no_perkara', $saksi->id_no_perkara ?? '') == $perkara->id ? 'selected' : '' }}>
                                            {{ $perkara->no }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_jenis_perkara" class="form-label">Jenis Perkara</label>
                                <input type="hidden" id="id_jenis_perkara" name="id_jenis_perkara"
                                    value="{{ old('id_jenis_perkara', $saksi->id_jenis_perkara ?? 2) }}">
                                @php
                                    $jenisPerkaraName =
                                        $jenisPerkara->firstWhere(
                                            'id',
                                            old('id_jenis_perkara', $saksi->id_jenis_perkara ?? 2),
                                        )->jenis ?? 'Tidak Diketahui';
                                @endphp
                                <input type="text" class="form-control" value="{{ $jenisPerkaraName }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="id_perdata" class="form-label">Jenis Perdata</label>
                                <select class="form-select" id="id_perdata" name="id_perdata" required>
                                    <option value="">Pilih Perdata</option>
                                    @foreach ($perdata as $jenis)
                                        <option value="{{ $jenis->id }}"
                                            {{ old('id_perdata', $saksi->id_perdata ?? '') == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->jenis }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_pihak" class="form-label">Pihak Yang Menghadirkan</label>
                                <select class="form-select" id="id_pihak" name="id_pihak" required>
                                    <option value="">Pilih Pihak</option>
                                    @foreach ($pihak as $jenis)
                                        <option value="{{ $jenis->id }}"
                                            {{ old('id_pihak', $saksi->id_pihak ?? '') == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->jenis }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tgl_kehadiran" class="form-label">Tanggal Kehadiran</label>
                                <input type="date" readonly class="form-control" id="tgl_kehadiran"
                                    name="tgl_kehadiran"
                                    value="{{ old('tgl_kehadiran', $saksi->tgl_kehadiran ?? now()->toDateString()) }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="tgl_kehadiran" class="form-label">Jumlah Saksi Akan Hadir</label>
                                <input type="number" class="form-control" id="akan_hadir" name="akan_hadir" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Container untuk Card Identitas Saksi -->
            <div id="saksiContainer">
                <!-- Template Card Identitas Saksi -->
                <div class="card mb-4 saksi-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Identitas Saksi</h5>
                        <button type="button" class="btn btn-danger btn-sm remove-saksi"
                            onclick="removeSaksiCard(this)" style="display: none;">
                            <i class="fas fa-times"></i> Hapus Saksi
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Saksi</label>
                                    <input type="text" class="form-control" name="saksi[0][nama_saksi]" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" name="saksi[0][tempat_lahir]"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="saksi[0][tanggal_lahir]"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" name="saksi[0][id_jeniskelamin]" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        @foreach ($jenisKelamin as $jenis)
                                            <option value="{{ $jenis->id }}">{{ $jenis->jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" class="form-control" name="saksi[0][alamat]" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">No HP</label>
                                    <input type="text" class="form-control" name="saksi[0][no_hp]" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Tambah Saksi -->
            <div class="mb-3">
                <button type="button" class="btn btn-success" onclick="addSaksiCard()">
                    <i class="fas fa-plus"></i> Tambah Saksi
                </button>
            </div>

            <button type="submit" class="btn btn-primary">{{ $saksi ? 'Update' : 'Submit' }}</button>
        </form>

        <script>
            let saksiCount = 0;

            function addSaksiCard() {
                saksiCount++;

                // Clone template card
                const template = document.querySelector('.saksi-card').cloneNode(true);

                // Update form names with new index
                const inputs = template.querySelectorAll('input, select');
                inputs.forEach(input => {
                    if (input.name) {
                        input.name = input.name.replace('[0]', `[${saksiCount}]`);
                        input.value = ''; // Clear values
                    }
                });

                // Show remove button for additional cards
                const removeButton = template.querySelector('.remove-saksi');
                removeButton.style.display = 'block';

                // Add the new card
                document.getElementById('saksiContainer').appendChild(template);
            }

            function removeSaksiCard(button) {
                const card = button.closest('.saksi-card');
                card.remove();
            }

            // Show remove button for existing cards if there's more than one
            function updateRemoveButtons() {
                const cards = document.querySelectorAll('.saksi-card');
                cards.forEach((card, index) => {
                    const removeButton = card.querySelector('.remove-saksi');
                    if (index > 0) {
                        removeButton.style.display = 'block';
                    }
                });
            }

            // Initialize on page load
            document.addEventListener('DOMContentLoaded', function() {
                updateRemoveButtons();
            });
        </script>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="text-center p-3">
            © 2023 Saksi App. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: '{{ session('success') }}',
            });
        @endif
    </script>
</body>

</html>
