<?php

namespace App\Http\Controllers;

use App\Models\TransaksiServis;
use App\Support\Pesan;
use Illuminate\Http\Request;

class StatusServisController extends Controller
{
    public function show(TransaksiServis $servis)
    {
        $servis->load('kendaraan.pelanggan', 'detailServis.jenisLayanan');
        return view('servis.detail', compact('servis'));
    }

    public function updateStatus(Request $request, TransaksiServis $servis)
    {
        $data = $request->validate([
            'status' => 'required|in:menunggu,dikerjakan,selesai',
        ], Pesan::umum(), ['status' => 'Status']);

        $servis->update($data);
        return back()->with('sukses', 'Status servis diperbarui.');
    }

    public function updatePembayaran(Request $request, TransaksiServis $servis)
    {
        $data = $request->validate([
            'status_pembayaran' => 'required|in:belum_lunas,lunas',
        ], Pesan::umum(), ['status_pembayaran' => 'Status pembayaran']);

        $servis->update($data);
        return back()->with('sukses', 'Status pembayaran diperbarui.');
    }

    public function updateKeluhan(Request $request, TransaksiServis $servis)
    {
        $data = $request->validate([
            'keluhan' => 'required|string|max:500',
        ], Pesan::umum(), ['keluhan' => 'Keluhan']);

        $servis->update($data);
        return back()->with('sukses', 'Keluhan diperbarui.');
    }
}
