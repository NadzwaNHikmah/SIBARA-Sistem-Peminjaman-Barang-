<?php

namespace App\Http\Controllers;

use App\Exports\TransaksiExport;
use App\Models\Transaksi;
use App\Models\Instansi;
use App\Models\Barang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $transaksis = Transaksi::with(['instansi', 'barangs'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('instansi', function ($q) use ($search) {
                    $q->where('nama_ins', 'like', "%$search%");
                })->orWhereHas('barangs', function ($q) use ($search) {
                    $q->where('nama_brg', 'like', "%$search%");
                });
            })
            ->when($tanggal_awal, fn ($q) =>
                $q->whereDate('tanggal_pinjam', '>=', $tanggal_awal)
            )
            ->when($tanggal_akhir, fn ($q) =>
                $q->whereDate('tanggal_pinjam', '<=', $tanggal_akhir)
            )
            ->latest()
            ->paginate(10)
            ->appends($request->all());

        return view('transaksi.index', compact(
            'transaksis',
            'search',
            'tanggal_awal',
            'tanggal_akhir'
        ));
    }

    public function create()
    {
        return view('transaksi.create', [
            'instansis' => Instansi::all(),
            'barangs' => Barang::where('stok', '>', 0)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'instansi_id'     => 'required|exists:instansis,id',
            'barang_id'       => 'required|array',
            'barang_id.*'     => 'exists:barangs,id',
            'jumlah_pinjam'   => 'required|array',
            'tanggal_pinjam'  => 'required|date',
            'tanggal_kembali' => 'nullable|date',
            'status'          => 'required',
            'nama_perwakilan' => 'required|string|max:255',
            'kontak'          => 'required|string|max:20',
            'surat_file'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {

            DB::transaction(function () use ($request) {

                $transaksi = Transaksi::create([
                    'kode_transaksi' => 'TXN-' . now()->format('YmdHis'),
                    'instansi_id' => $request->instansi_id,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'status' => $request->status,
                    'nama_perwakilan' => $request->nama_perwakilan,
                    'kontak' => $request->kontak,
                    'surat_file' => $request->hasFile('surat_file')
                        ? $request->file('surat_file')->store('surat_files', 'public')
                        : null,
                ]);

                foreach ($request->barang_id as $index => $barangId) {

                    if (!isset($request->jumlah_pinjam[$index])) continue;

                    $jumlah = (int) $request->jumlah_pinjam[$index];
                    $barang = Barang::findOrFail($barangId);

                    // CEK STOK
                    if ($barang->stok < $jumlah) {
                        throw new \Exception("Stok {$barang->nama_brg} hanya {$barang->stok} unit");
                    }

                    // CEK KONDISI
                    if ($barang->kondisi_brg !== 'Baik') {
                        throw new \Exception("{$barang->nama_brg} tidak layak dipinjam (kondisi: {$barang->kondisi_brg})");
                    }

                    $barang->decrement('stok', $jumlah);

                    $transaksi->barangs()->attach($barangId, [
                        'jumlah_pinjam' => $jumlah
                    ]);
                }
            });

        } catch (\Exception $e) {

            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dibuat');
    }


    public function edit(Transaksi $transaksi)
    {
        return view('transaksi.edit', [
            'transaksi' => $transaksi->load('barangs'),
            'instansis' => Instansi::all(),
            'barangs'   => Barang::all(),
        ]);
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $rules = [
            'status'          => 'required',
            'tanggal_kembali' => 'nullable|date',
            'nama_perwakilan' => 'required|string|max:255',
            'kontak'          => 'required|string|max:20',
        ];

        if ($request->hasFile('surat_file')) {
            $rules['surat_file'] = 'file|mimes:jpg,jpeg,png,pdf|max:2048';
        }

        $data = $request->validate($rules);

        if ($request->hasFile('surat_file')) {
            if ($transaksi->surat_file) {
                Storage::disk('public')->delete($transaksi->surat_file);
            }
            $data['surat_file'] = $request
                ->file('surat_file')
                ->store('surat_files', 'public');
        }

        $transaksi->update($data);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui');
    }

    public function show(Transaksi $transaksi)
    {
        return view('transaksi.show', [
            'transaksi' => $transaksi->load('barangs', 'instansi')
        ]);
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new TransaksiExport($request->tanggal_awal, $request->tanggal_akhir),
            'laporan_transaksi.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $transaksis = Transaksi::with(['instansi', 'barangs'])
            ->when(
                $request->filled(['tanggal_awal', 'tanggal_akhir']),
                fn ($q) =>
                $q->whereBetween('tanggal_pinjam', [
                    $request->tanggal_awal,
                    $request->tanggal_akhir
                ])
            )->get();

        $pdf = Pdf::loadView('transaksi.pdf', compact('transaksis'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_transaksi.pdf');
    }

    public function markAsReturned(Transaksi $transaksi)
    {
        DB::transaction(function () use ($transaksi) {

            foreach ($transaksi->barangs as $barang) {
                $barang->increment('stok', $barang->pivot->jumlah_pinjam);
            }

            $transaksi->update([
                'status' => 'Dikembalikan',
                'tanggal_kembali' => now(),
            ]);
        });

        return redirect()
            ->route('transaksi.show', $transaksi->id)
            ->with('success', 'Barang berhasil dikembalikan');
    }
}