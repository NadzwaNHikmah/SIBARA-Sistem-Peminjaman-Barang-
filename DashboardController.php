<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;
use App\Models\Instansi;
use App\Models\Transaksi;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {

        // Coba cek koneksi + waktu respon
        $startTime = microtime(true);
        try {
            DB::connection()->getPdo();
            $dbConnected = true;
            $elapsed = (microtime(true) - $startTime) * 1000; // ms

            if ($elapsed < 100) {
                $connectionStatus = 'Stabil';
                $connectionClass = 'success';
            } elseif ($elapsed < 500) {
                $connectionStatus = 'Kurang Stabil';
                $connectionClass = 'warning';
            } else {
                $connectionStatus = 'Lambat';
                $connectionClass = 'danger';
            }

        } catch (\Exception $e) {
            $dbConnected = false;
            $elapsed = null;
            $connectionStatus = 'Gagal Terhubung';
            $connectionClass = 'danger';
        }

        $startServer = microtime(true);
        try {
            // Simulasi proses server (cek respon internal)
            $serverResponsive = true;
            $serverElapsed = (microtime(true) - $startServer) * 1000; // dalam milidetik

            if ($serverElapsed < 100) {
                $serverStatus = 'Online';
                $serverClass = 'success';
                $serverMessage = 'Semua layanan berjalan normal';
            } elseif ($serverElapsed < 500) {
                $serverStatus = 'Lambat';
                $serverClass = 'warning';
                $serverMessage = 'Sistem merespons agak lambat';
            } else {
                $serverStatus = 'Tidak Stabil';
                $serverClass = 'danger';
                $serverMessage = 'Respon server lambat';
            }

        } catch (\Exception $e) {
            $serverResponsive = false;
            $serverStatus = 'Offline';
            $serverClass = 'danger';
            $serverMessage = 'Server tidak merespons';
            $serverElapsed = null;
        }


        // Data lain
        $totalBarang = \App\Models\Barang::count();
        $totalInstansi = \App\Models\Instansi::count();
        $totalTransaksi = \App\Models\Transaksi::count();
        $totalUser = \App\Models\User::count();

        return view('dashboard', compact(
            'serverResponsive',
            'serverStatus',
            'serverClass',
            'serverMessage',
            'serverElapsed',
            'dbConnected',
            'elapsed',
            'connectionStatus',
            'connectionClass',
            'totalBarang',
            'totalInstansi',
            'totalTransaksi',
            'totalUser'
        ));
    }
}
