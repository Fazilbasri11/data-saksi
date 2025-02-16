<?php

namespace App\Http\Controllers;

use App\Models\DataJenisPihak;
use App\Models\JenisPihak;
use Illuminate\Http\Request;

class DataJenisPihakController extends Controller
{
    public function index()
    {
        $pihak = DataJenisPihak::all();
        // dd($pihak);
        return view('jenis_pihak.index', compact('pihak'));
    }

    public function create()
    {
        $pihaks = JenisPihak::all();
        // dd($pihaks);
        return view('jenis_pihak.create', compact('pihaks'));
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

        try {
            // Simpan semua data dalam loop
            foreach ($request->pihak as $key => $id_pihak) {
                DataJenisPihak::create([
                    'id_jenis_pihak' => $id_pihak,
                    'nama'     => $request->nama[$key]
                ]);
            }

            // Set pesan sukses
            return redirect()->route('jenis_pihak.index')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }


    public function show(DataJenisPihak $noPerkaraPerdata)
    {
        return view('jenis_pihak.show', compact('noPerkaraPerdata'));
    }

    public function edit(DataJenisPihak $noPerkaraPerdata)
    {
        return view('jenis_pihak.edit', compact('noPerkaraPerdata'));
    }

    public function update(Request $request, DataJenisPihak $noPerkaraPerdata)
    {
        $request->validate([
            'no' => 'required|string|max:255',
        ]);

        $noPerkaraPerdata->update($request->all());
        return redirect()->route('jenis_pihak.index')->with('success', 'No Perkara berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $noPerkaraPerdata = DataJenisPihak::findOrFail($id);
        $noPerkaraPerdata->delete();

        return redirect()->route('jenis_pihak.index')->with('success', 'Data berhasil dihapus.');
    }
}
