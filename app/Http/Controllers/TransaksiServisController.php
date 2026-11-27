<?php

namespace App\Http\Controllers;

use App\Models\JenisLayanan;
use App\Models\Kendaraan;
use App\Models\TransaksiServis;
use App\Support\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiServisController extends Controller
{
    // Daftar transaksi, yang terbaru di atas
    public function index()
    {
        $servis = TransaksiServis::with('kendaraan.pelanggan')
            ->latest('tanggal')
            ->latest('id')
            ->get();

        return view('servis.index', compact('servis'));
    }

    // Form tambah transaksi
    public function create()
    {
        $kendaraan = Kendaraan::with('pelanggan')->orderBy('no_polisi')->get();
        $layanan   = JenisLayanan::orderBy('nama')->get();

        return view('servis.create', compact('kendaraan', 'layanan'));
    }

    // Validasi, hitung total, lalu simpan transaksi beserta detailnya
    public function store(Request $request)
    {
        $data = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraan,id',
            'tanggal'      => 'required|date',
            'keluhan'      => 'required|string|max:500',
            'jumlah'       => 'required|array',
            'jumlah.*'     => 'nullable|integer|min:0|max:99',
        ], Pesan::umum(), [
            'kendaraan_id' => 'Kendaraan',
            'tanggal'      => 'Tanggal',
            'keluhan'      => 'Keluhan',
            'jumlah'       => 'Layanan',
            'jumlah.*'     => 'Jumlah',
        ]);

        // Ambil hanya layanan yang jumlahnya lebih dari 0
        $item = collect($data['jumlah'])->filter(fn ($jumlah) => (int) $jumlah > 0);

        if ($item->isEmpty()) {
            return back()
                ->withErrors(['jumlah' => 'Pilih minimal satu layanan.'])
                ->withInput();
        }

        // Kalau salah satu penyimpanan gagal, semuanya dibatalkan
        DB::transaction(function () use ($data, $item) {
            $transaksi = TransaksiServis::create([
                'kendaraan_id' => $data['kendaraan_id'],
                'tanggal'      => $data['tanggal'],
                'keluhan'      => $data['keluhan'],
            ]);

            $total = 0;

            foreach ($item as $layananId => $jumlah) {
                $layanan = JenisLayanan::findOrFail($layananId);

                $transaksi->detailServis()->create([
                    'jenis_layanan_id' => $layanan->id,
                    'harga'            => $layanan->tarif, // salin tarif saat ini
                    'jumlah'           => (int) $jumlah,
                ]);

                $total += $layanan->tarif * (int) $jumlah;
            }

            $transaksi->update(['total_biaya' => $total]);
        });

        return redirect()->route('servis.index')
            ->with('sukses', 'Transaksi servis berhasil dibuat.');
    }

    // Hapus transaksi, baris detail ikut terhapus (cascade di database)
    public function destroy(TransaksiServis $servis)
    {
        $servis->delete();

        return redirect()->route('servis.index')
            ->with('sukses', 'Transaksi servis dihapus.');
    }
}
