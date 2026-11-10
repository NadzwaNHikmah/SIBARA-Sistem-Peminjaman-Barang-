<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'instansi_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'nama_perwakilan',
        'kontak',
        'surat_file',
    ];

    /**
     * Relasi ke Instansi
     * 1 transaksi milik 1 instansi
     */
    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    /**
     * Relasi ke Barang
     * 1 transaksi bisa memiliki banyak barang
     */
    public function barangs()
    {
        return $this->belongsToMany(Barang::class, 'barang_transaksi')
            ->withPivot('jumlah_pinjam')
            ->withTimestamps();
    }
}
