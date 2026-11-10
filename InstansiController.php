<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $instansis = Instansi::when($search, function ($query, $search) {
            $query->where('kode_ins', 'like', "%$search%")
            ->orWhere('nama_ins', 'like', "%$search%");
        })->latest()->paginate(10);

        return view('instansi.index', compact('instansis', 'search'));
    }

    public function create()
    {
        return view('instansi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ins'   => 'required',
            'alamat_ins' => 'required',
        ]);

        // Generate kode instansi
        $validated['kode_ins'] = uniqid('INS-');

        Instansi::create($validated);

        return redirect()
            ->route('instansi.index')
            ->with('success', 'Instansi berhasil ditambahkan');
    }


    public function edit(Instansi $instansi)
    {
        return view('instansi.edit', compact('instansi'));
    }

    public function update(Request $request, Instansi $instansi)
    {
        $validated = $request->validate([
            'nama_ins'   => 'required',
            'alamat_ins' => 'required',
        ]);

        $instansi->update($validated);

        return redirect()
            ->route('instansi.index')
            ->with('success', 'Instansi berhasil diperbarui');
    }


    public function show(Instansi $instansi)
    {
        return view('instansi.show', compact('instansi'));
    }

    public function destroy(Instansi $instansi)
    {
        $instansi->delete();
        return redirect()->route('instansi.index')->with('success', 'Instansi berhasil dihapus');
    }
}
