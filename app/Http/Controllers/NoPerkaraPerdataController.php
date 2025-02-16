<?php

namespace App\Http\Controllers;

use App\Models\NoPerkaraPerdata;
use Illuminate\Http\Request;

class NoPerkaraPerdataController extends Controller
{
    public function index()
    {
        $noPerkara = NoPerkaraPerdata::all();
        return view('no_perkara.index', compact('noPerkara'));
    }

    public function create()
    {
        return view('no_perkara.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no' => 'required|string|max:255',
        ]);

        NoPerkaraPerdata::create($request->all());
        return redirect()->route('no_perkara.index')->with('success', 'No Perkara berhasil ditambahkan.');
    }

    public function show(NoPerkaraPerdata $noPerkaraPerdata)
    {
        return view('no_perkara.show', compact('noPerkaraPerdata'));
    }

    public function edit(NoPerkaraPerdata $noPerkaraPerdata)
    {
        return view('no_perkara.edit', compact('noPerkaraPerdata'));
    }

    public function update(Request $request, NoPerkaraPerdata $noPerkaraPerdata)
    {
        $request->validate([
            'no' => 'required|string|max:255',
        ]);

        $noPerkaraPerdata->update($request->all());
        return redirect()->route('no_perkara.index')->with('success', 'No Perkara berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $noPerkaraPerdata = NoPerkaraPerdata::findOrFail($id);
        $noPerkaraPerdata->delete();

        return redirect()->route('no_perkara.index')->with('success', 'No Perkara berhasil dihapus.');
    }
}
