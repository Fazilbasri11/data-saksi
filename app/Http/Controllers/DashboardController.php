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
        $saksiJenis2 = Saksi::with('pihak')
            ->where('id_jenis_perkara', 2)
            ->select('no_perkara', 'id_pihak', 'tgl_kehadiran', 'id_status_perkara')
            ->get()
            ->groupBy('no_perkara')
            ->map(function ($groupByPerkara) {
                return $groupByPerkara->groupBy('tgl_kehadiran')->map(function ($groupByTanggal) {
                    $result = [
                        'no_perkara' => $groupByTanggal->first()->no_perkara,
                        'tgl_kehadiran' => $groupByTanggal->first()->tgl_kehadiran,
                        'id_status_perkara' => $groupByTanggal->first()->id_status_perkara,
                        'pihak_1' => null,
                        'jumlah_saksi_1' => 0, // Will be for Tergugat (id_pihak = 1)
                        'jumlah_izin_1' => 0,
                        'pihak_2' => null,
                        'jumlah_saksi_2' => 0, // Will be for Penggugat (id_pihak = 2)
                        'jumlah_izin_2' => 0,
                    ];

                    // Process Tergugat (id_pihak = 1)
                    $saksiTergugat = $groupByTanggal->where('id_pihak', 1)->first();
                    if ($saksiTergugat) {
                        $result['jumlah_saksi_1'] = Saksi::where('no_perkara', $saksiTergugat->no_perkara)
                            ->where('id_pihak', 1)
                            ->where('tgl_kehadiran', $saksiTergugat->tgl_kehadiran)
                            ->count();

                        $result['jumlah_izin_1'] = Saksi::where('no_perkara', $saksiTergugat->no_perkara)
                            ->where('id_pihak', 1)
                            ->where('tgl_kehadiran', $saksiTergugat->tgl_kehadiran)
                            ->where('id_izin', 2)
                            ->count();
                    }

                    // Process Penggugat (id_pihak = 2)
                    $saksiPenggugat = $groupByTanggal->where('id_pihak', 2)->first();
                    if ($saksiPenggugat) {
                        $result['jumlah_saksi_2'] = Saksi::where('no_perkara', $saksiPenggugat->no_perkara)
                            ->where('id_pihak', 2)
                            ->where('tgl_kehadiran', $saksiPenggugat->tgl_kehadiran)
                            ->count();

                        $result['jumlah_izin_2'] = Saksi::where('no_perkara', $saksiPenggugat->no_perkara)
                            ->where('id_pihak', 2)
                            ->where('tgl_kehadiran', $saksiPenggugat->tgl_kehadiran)
                            ->where('id_izin', 2)
                            ->count();
                    }

                    return $result;
                })->values();
            })->values();

        $saksiJenis2 = $saksiJenis2->flatten(1);
        // dd($saksiJenis2);
        return view('dashboard', compact('saksiJenis2'));
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
