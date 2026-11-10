<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $tanggal_awal;
    protected $tanggal_akhir;

    public function __construct($tanggal_awal = null, $tanggal_akhir = null)
    {
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function collection()
    {
        $query = Transaksi::with(['instansi', 'barangs']);

        if ($this->tanggal_awal && $this->tanggal_akhir) {
            $query->whereBetween('tanggal_pinjam', [
                $this->tanggal_awal,
                $this->tanggal_akhir
            ]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Instansi',
            'Nama Perwakilan',
            'Kontak',
            'Barang',
            'Jumlah Pinjam (Total Unit)',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Status'
        ];
    }

    public function map($transaksi): array
    {
        // Gabungkan nama barang
        $namaBarang = $transaksi->barangs
            ->pluck('nama_brg')
            ->implode(', ');

        // TOTAL jumlah pinjam (SUM pivot)
        $totalJumlah = $transaksi->barangs
            ->sum(fn ($barang) => $barang->pivot->jumlah_pinjam);

        return [
            $transaksi->kode_transaksi,
            $transaksi->instansi?->nama_ins ?? '-',
            $transaksi->nama_perwakilan ?? '-',
            $transaksi->kontak ?? '-',
            $namaBarang ?: '-',
            $totalJumlah, // ⬅️ TOTAL UNIT
            $transaksi->tanggal_pinjam,
            $transaksi->tanggal_kembali,
            ucfirst($transaksi->status),
        ];
    }
}
