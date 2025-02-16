<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Saksi;
use App\Models\JenisPerkara;
use App\Models\StatusPerkara;
use App\Models\JenisKelamin;
use App\Models\PihakMenghadirkan;
use App\Models\Perdata;
use App\Models\NoPerkaraPerdata;
use Illuminate\Http\Request;


class SaksiController extends Controller
{
    /**
     * Tampilkan form input atau edit data saksi.
     */
    public function index(Request $request)
    {
        // Ambil semua nomor perkara untuk dropdown
        $noPerkara = NoPerkaraPerdata::all();

        // Data relasi lainnya
        $jenisPerkara = JenisPerkara::all();
        $statusPerkara = StatusPerkara::all();
        $jenisKelamin = JenisKelamin::all();
        $pihakMenghadirkan = PihakMenghadirkan::with('pihak')->get();

        // dd($pihakMenghadirkan);

        $perdata = Perdata::all();

        // Cek apakah ada data berdasarkan nomor perkara dan tanggal hari ini
        $today = now()->toDateString();
        $saksi = Saksi::where('id_no_perkara', $request->input('id_no_perkara'))
            ->whereDate('tgl_kehadiran', $today)
            ->first();

        return view('saksi.form-perdata', compact('saksi', 'jenisPerkara', 'pihakMenghadirkan', 'perdata', 'statusPerkara', 'jenisKelamin', 'noPerkara'));
    }

    /**
     * Simpan atau perbarui data saksi.
     */
    public function store(Request $request)
    {

        // Validate common fields
        // $request->validate([
        //     'id_jenis_perkara' => 'required|integer',
        //     'id_pihak' => 'required|integer',
        //     'id_perdata' => 'required|integer',
        //     'id_no_perkara' => 'required|string|max:255',
        //     'tgl_kehadiran' => 'required|date',
        //     'akan_hadir' => 'required|integer',
        //     'permohonan' => 'nullable|string|max:255',
        //     'gugatan' => 'nullable|string|max:255',
        // ]);
        // Pisahkan value yang dikirim dari form
        list($id_jenis_pihak, $id_pihak) = explode('|', $request->input('id_pihak'));


        // Validate each saksi entry
        // foreach ($request->saksi as $index => $saksiData) {
        //     $request->validate([
        //         "saksi.$index.nama_saksi" => 'required|string|max:255',
        //         "saksi.$index.tempat_lahir" => 'required|string|max:255',
        //         "saksi.$index.tanggal_lahir" => 'required|date',
        //         "saksi.$index.id_jeniskelamin" => 'required|integer',
        //         "saksi.$index.alamat" => 'required|string|max:255',
        //         "saksi.$index.no_hp" => 'required|string|max:255',
        //     ]);
        // }



        // Simpan data saksi
        foreach ($request->saksi as $saksiData) {
            Saksi::create([
                'id_jenis_perkara' => $request->id_jenis_perkara,
                'id_jenis_pihak' => $id_jenis_pihak,  // Simpan id_jenis_pihak
                'id_pihak' => $id_pihak,  // Simpan id_pihak
                'id_perdata' => $request->id_perdata,
                'id_no_perkara' => $request->id_no_perkara,
                'tgl_kehadiran' => $request->tgl_kehadiran,
                'permohonan' => $request->permohonan,
                'gugatan' => $request->gugatan,
                'akan_hadir' => $request->akan_hadir,
                'nama_saksi' => $saksiData['nama_saksi'],
                'tempat_lahir' => $saksiData['tempat_lahir'],
                'tanggal_lahir' => $saksiData['tanggal_lahir'],
                'id_jeniskelamin' => $saksiData['id_jeniskelamin'],
                'alamat' => $saksiData['alamat'],
                'no_hp' => $saksiData['no_hp'],
                'id_izin' => '1',
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function updateStatusPerkara(Request $request)
    {
        try {
            // Validasi request
            $request->validate([
                'id_no_perkara' => 'required',
                'tgl_kehadiran' => 'required|date'
            ]);

            // Cek status sekarang di database
            $saksi = Saksi::where('id_no_perkara', $request->id_no_perkara)
                ->where('tgl_kehadiran', $request->tgl_kehadiran)
                ->first();

            if (!$saksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Toggle status: jika 1 jadi 2, jika 2 jadi 1
            $newStatus = $saksi->id_status_perkara == 1 ? 2 : 1;

            // Update status
            $updated = Saksi::where('id_no_perkara', $request->id_no_perkara)
                ->where('tgl_kehadiran', $request->tgl_kehadiran)
                ->update(['id_status_perkara' => $newStatus]);

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diupdate',
                'new_status' => $newStatus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id_no_perkara, $tgl_kehadiran)
    {
        // Ambil semua data saksi dengan no_perkara dan tgl_kehadiran yang sama
        $saksiList = Saksi::with(['jenisPerkara', 'statusPerkara']) // Eager load relationships
            ->where('id_no_perkara', $id_no_perkara)
            ->where('tgl_kehadiran', $tgl_kehadiran)
            ->get();

        // Debugging: Check the retrieved data
        // dd($saksiList);

        // Return the view with the retrieved data
        return view('saksi.edit-perdata', compact('saksiList'));
    }

    public function update(Request $request, $id_no_perkara, $tgl_kehadiran)
    {
        $request->validate([
            'jumlah_saksi_penggugat' => 'required|integer|min:0',
            'jumlah_izin_penggugat' => 'required|integer|min:0',
            'jumlah_saksi_tergugat' => 'required|integer|min:0',
            'jumlah_izin_tergugat' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Update atau create data saksi penggugat
            $this->updateSaksiData(
                $id_no_perkara,
                $tgl_kehadiran,
                2,
                $request->jumlah_saksi_penggugat,
                $request->jumlah_izin_penggugat
            );

            // Update atau create data saksi tergugat
            $this->updateSaksiData(
                $id_no_perkara,
                $tgl_kehadiran,
                1,
                $request->jumlah_saksi_tergugat,
                $request->jumlah_izin_tergugat
            );

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Data saksi berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    private function updateSaksiData($id_no_perkara, $tgl_kehadiran, $id_pihak, $jumlah_saksi, $jumlah_izin)
    {
        // Hapus data yang ada
        Saksi::where('id_no_perkara', $id_no_perkara)
            ->where('tgl_kehadiran', $tgl_kehadiran)
            ->where('id_pihak', $id_pihak)
            ->delete();

        // Insert data baru
        for ($i = 0; $i < $jumlah_saksi; $i++) {
            Saksi::create([
                'id_no_perkara' => $id_no_perkara,
                'tgl_kehadiran' => $tgl_kehadiran,
                'id_pihak' => $id_pihak,
                'id_izin' => $i < $jumlah_izin ? 2 : 1
            ]);
        }
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $saksiList = Saksi::where('nama_saksi', 'LIKE', '%' . $searchTerm . '%')->get();

        return view('saksi.edit-perdata', compact('saksiList'));
    }

    public function updateIzin(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_izin' => 'required|in:1,2',
        ]);

        // Cari saksi berdasarkan ID
        $saksi = Saksi::findOrFail($id);

        // Update nilai id_izin
        $saksi->id_izin = $request->id_izin;
        $saksi->save();

        // Kirim respons
        return response()->json([
            'success' => true,
            'message' => 'ID izin berhasil diperbarui.',
            'id_izin' => $saksi->id_izin,
        ]);
    }
}
