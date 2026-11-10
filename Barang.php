<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_brg',
        'nama_brg',
        'foto_brg',
        'stok',
        'kondisi_brg',
        'deskripsi_brg',
    ];

    /**
     * Relasi ke Transaksi
     * 1 barang bisa dipinjam di banyak transaksi
     */
    public function transaksis()
    {
        return $this->belongsToMany(Transaksi::class, 'barang_transaksi')
            ->withPivot('jumlah_pinjam')
            ->withTimestamps();
    }
}
