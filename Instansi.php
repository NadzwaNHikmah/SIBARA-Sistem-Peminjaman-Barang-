<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instansi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_ins',
        'nama_ins',
        'alamat_ins',
    ];

    // Relasi: satu instansi bisa melakukan banyak transaksi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
