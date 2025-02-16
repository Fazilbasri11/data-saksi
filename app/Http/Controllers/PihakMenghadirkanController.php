<?php

namespace App\Http\Controllers;

use App\Models\PihakMenghadirkan;
use App\Models\Pihak;
use Illuminate\Http\Request;

class PihakMenghadirkanController extends Controller
{
    public function index()
    {
        $pihak = PihakMenghadirkan::all();
        // dd($pihak);
        return view('pihak_menghadirkan.index', compact('pihak'));
    }

    public function create()
    {
        $pihaks = Pihak::all();
        // dd($pihaks);
        return view('pihak_menghadirkan.create', compact('pihaks'));
    }

    public function store(Request $request)
    {
        // Validasi input agar menerima array
        $request->validate([
            'pihak'   => 'required|array',
            'pihak.*' => 'required', // Pastikan setiap elemen pihak ada di tabel
            'nama'    => 'required|array',
            'nama.*'  => 'required|string|max:255'
        ]);
        // dd($request->all());

        try {
            // Simpan semua data dalam loop
            foreach ($request->pihak as $key => $id_pihak) {
                PihakMenghadirkan::create([
                    'id_pihak' => $id_pihak,
                    'nama'     => $request->nama[$key]
                ]);
            }

            // Set pesan sukses
            return redirect()->route('pihak_menghadirkan.index')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }



    public function show(PihakMenghadirkan $noPerkaraPerdata)
    {
        return view('pihak_menghadirkan.show', compact('noPerkaraPerdata'));
    }

    public function edit(PihakMenghadirkan $noPerkaraPerdata)
    {
        return view('pihak_menghadirkan.edit', compact('noPerkaraPerdata'));
    }

    public function update(Request $request, PihakMenghadirkan $noPerkaraPerdata)
    {
        $request->validate([
            'no' => 'required|string|max:255',
        ]);

        $noPerkaraPerdata->update($request->all());
        return redirect()->route('pihak_menghadirkan.index')->with('success', 'No Perkara berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $noPerkaraPerdata = PihakMenghadirkan::findOrFail($id);
        $noPerkaraPerdata->delete();

        return redirect()->route('pihak_menghadirkan.index')->with('success', 'Data berhasil dihapus.');
    }
}