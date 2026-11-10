<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $barangs = Barang::when($search, function ($query, $search) {
            $query->where('kode_brg', 'like', "%$search%")
             ->orWhere('nama_brg', 'like', "%$search%");
        })->latest()->paginate(10);

        return view('barang.index', compact('barangs', 'search'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_brg' => 'required',
            'foto_brg' => 'nullable|image|max:2048',
            'stok' => 'required|integer|min:0',
            'kondisi_brg' => 'required',
            'deskripsi_brg' => 'nullable|max:255',
        ]);
        if ($request->hasFile('foto_brg')) {
            $validated['foto_brg'] = $request->file('foto_brg')->store('barangs', 'public');
        }
        $kodeBarang = uniqid('BRG-');
        $validated['kode_brg'] = $kodeBarang;
        Barang::create($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'nama_brg' => 'required',
            'foto_brg' => 'nullable|image|max:2048',
            'stok' => 'required|integer|min:0',
            'kondisi_brg' => 'required',
            'deskripsi_brg' => 'nullable|max:255',
        ]);

        if ($request->hasFile('foto_brg')) {
            if ($barang->foto_brg) {
                Storage::disk('public')->delete($barang->foto_brg);
            }
            $validated['foto_brg'] = $request->file('foto_brg')->store('barangs', 'public');
        }

        $barang->update($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui');
    }

    public function show(Barang $barang)
    {
        return view('barang.show', compact('barang'));
    }

    public function destroy(Barang $barang)
    {
        if ($barang->foto_brg) {
            Storage::disk('public')->delete($barang->foto_brg);
        }

        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }
}
