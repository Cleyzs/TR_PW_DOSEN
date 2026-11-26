<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\TransaksiServis;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'jumlahPelanggan'  => Pelanggan::count(),
            'jumlahKendaraan'  => Kendaraan::count(),
            'servisMenunggu'   => TransaksiServis::where('status', 'menunggu')->count(),
            'servisDikerjakan' => TransaksiServis::where('status', 'dikerjakan')->count(),
            'servisSelesai'    => TransaksiServis::where('status', 'selesai')->count(),
            'pendapatan'       => TransaksiServis::where('status_pembayaran', 'lunas')->sum('total_biaya'),
            'terbaru'          => TransaksiServis::with('kendaraan.pelanggan')
                                    ->latest('tanggal')->latest('id')->take(5)->get(),
        ];

        return view('dashboard', $data);
    }
}
