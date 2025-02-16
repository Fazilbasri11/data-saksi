<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use Illuminate\Http\Request;
use App\Models\Saksi;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $saksiJenis2 = Saksi::with(['pihak', 'noPerkara']) // Tambahkan 'noPerkara'
            ->where('id_jenis_perkara', 2)
            ->whereIn('id_pihak', [1, 2])
            ->select('id_no_perkara', 'id_pihak', 'tgl_kehadiran', 'id_status_perkara', 'akan_hadir') // Tambahkan akan_hadir
            ->get()
            ->groupBy('id_no_perkara')
            ->map(function ($groupByPerkara) {
                return $groupByPerkara->groupBy('tgl_kehadiran')->map(function ($groupByTanggal) {
                    // Ambil angka terbesar dari akan_hadir berdasarkan id_pihak
                    $akanHadirTerbesar1 = $groupByTanggal->where('id_pihak', 1)->max('akan_hadir');
                    $akanHadirTerbesar2 = $groupByTanggal->where('id_pihak', 2)->max('akan_hadir');

                    $first = $groupByTanggal->first(); // Ambil satu data acuan untuk field lain

                    return [
                        'id_no_perkara' => $first->id_no_perkara,
                        'no_perkara' => $first->noPerkara->no ?? 'Tidak Ditemukan', // Ambil nama perkara
                        'tgl_kehadiran' => $first->tgl_kehadiran,
                        'akan_hadir1' => $akanHadirTerbesar1 ?? 0, // Ambil angka terbesar untuk pihak 1
                        'akan_hadir2' => $akanHadirTerbesar2 ?? 0, // Ambil angka terbesar untuk pihak 2
                        'id_status_perkara' => $first->id_status_perkara,
                        'pihak_1' => null,
                        'jumlah_saksi_1' => $groupByTanggal->where('id_pihak', 1)->count(),
                        'jumlah_izin_1' => $groupByTanggal->where('id_pihak', 1)->where('id_izin', 2)->count(),
                        'pihak_2' => null,
                        'jumlah_saksi_2' => $groupByTanggal->where('id_pihak', 2)->count(),
                        'jumlah_izin_2' => $groupByTanggal->where('id_pihak', 2)->where('id_izin', 2)->count(),
                    ];
                })->values();
            })->values();

        $saksiJenis2 = $saksiJenis2->flatten(1);

        // dd($saksiJenis2);

        $saksiJenis1 = Saksi::with(['pihak', 'noPerkara']) // Tambahkan 'noPerkara'
            ->where('id_jenis_perkara', 2)
            ->where('id_pihak', 3)
            ->select('id_no_perkara', 'id_pihak', 'tgl_kehadiran', 'id_status_perkara', 'id_izin', 'akan_hadir') // Tambahkan akan_hadir
            ->get()
            ->groupBy('id_no_perkara')
            ->map(function ($groupByPerkara) {
                return $groupByPerkara->groupBy('tgl_kehadiran')->map(function ($groupByTanggal) {
                    // Ambil angka terbesar dari akan_hadir untuk id_pihak = 3
                    $akanHadirTerbesar = $groupByTanggal->max('akan_hadir');

                    $first = $groupByTanggal->first(); // Ambil satu data acuan untuk field lain

                    return [
                        'id_no_perkara' => $first->id_no_perkara,
                        'no_perkara' => $first->noPerkara->no ?? 'Tidak Ditemukan', // Ambil nomor perkara
                        'tgl_kehadiran' => $first->tgl_kehadiran,
                        'akan_hadir' => $akanHadirTerbesar ?? 0, // Ambil angka terbesar untuk pihak 3
                        'id_status_perkara' => $first->id_status_perkara,
                        'jumlah_saksi_3' => $groupByTanggal->count(), // Hitung jumlah saksi (id_pihak = 3)
                        'jumlah_izin_3' => $groupByTanggal->where('id_izin', 2)->count(), // Hitung izin
                    ];
                })->values();
            })->values();

        // Flatten hasilnya agar bisa digunakan di view
        $saksiJenis1 = $saksiJenis1->flatten(1);


        // dd($saksiJenis1);
        return view('dashboard', compact('saksiJenis2', 'saksiJenis1'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
