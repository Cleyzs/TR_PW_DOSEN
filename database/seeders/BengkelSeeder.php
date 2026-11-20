<?php

namespace Database\Seeders;

use App\Models\DetailServis;
use App\Models\JenisLayanan;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\TransaksiServis;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BengkelSeeder extends Seeder
{
    public function run(): void
    {
        // Akun admin (aman dijalankan berulang)
        User::updateOrCreate(
            ['email' => 'admin@bengkel.test'],
            ['name' => 'Admin Bengkel', 'password' => Hash::make('password')]
        );

        // Data contoh hanya diisi kalau tabel masih kosong
        if (Pelanggan::exists()) {
            return;
        }

        $layanan = [
            ['nama' => 'Ganti Oli',          'tarif' => 75000,  'keterangan' => 'Ganti oli mesin'],
            ['nama' => 'Tune Up',            'tarif' => 250000, 'keterangan' => 'Pengecekan dan penyetelan mesin'],
            ['nama' => 'Servis Rem',         'tarif' => 150000, 'keterangan' => 'Kampas rem dan minyak rem'],
            ['nama' => 'Ganti Ban',          'tarif' => 400000, 'keterangan' => 'Ganti ban per buah'],
            ['nama' => 'Spooring Balancing', 'tarif' => 200000, 'keterangan' => 'Spooring dan balancing roda'],
            ['nama' => 'Servis AC',          'tarif' => 300000, 'keterangan' => 'Cuci dan isi freon AC'],
        ];
        foreach ($layanan as $l) {
            JenisLayanan::create($l);
        }

        $budi  = Pelanggan::create(['nama' => 'Budi Santoso',   'no_hp' => '081200000001', 'alamat' => 'Jl. Merdeka No. 1']);
        $sari  = Pelanggan::create(['nama' => 'Sari Wulandari', 'no_hp' => '081200000002', 'alamat' => 'Jl. Melati No. 5']);
        $andre = Pelanggan::create(['nama' => 'Andre Pratama',  'no_hp' => '081200000003', 'alamat' => 'Jl. Kenanga No. 9']);

        $k1 = Kendaraan::create(['pelanggan_id' => $budi->id,  'no_polisi' => 'H 1234 AB', 'merek' => 'Toyota', 'tipe' => 'Avanza', 'tahun' => 2018]);
        $k2 = Kendaraan::create(['pelanggan_id' => $budi->id,  'no_polisi' => 'H 5678 CD', 'merek' => 'Honda',  'tipe' => 'Beat',   'tahun' => 2020]);
        $k3 = Kendaraan::create(['pelanggan_id' => $sari->id,  'no_polisi' => 'H 2468 EF', 'merek' => 'Suzuki', 'tipe' => 'Ertiga', 'tahun' => 2019]);
        $k4 = Kendaraan::create(['pelanggan_id' => $andre->id, 'no_polisi' => 'H 1357 GH', 'merek' => 'Yamaha', 'tipe' => 'NMAX',   'tahun' => 2021]);

        // Helper bikin transaksi + detail + hitung total
        $buatServis = function (Kendaraan $k, string $tgl, string $keluhan, string $status, string $bayar, array $items) {
            $trx = TransaksiServis::create([
                'kendaraan_id'      => $k->id,
                'tanggal'           => $tgl,
                'keluhan'           => $keluhan,
                'status'            => $status,
                'total_biaya'       => 0,
                'status_pembayaran' => $bayar,
            ]);

            $total = 0;
            foreach ($items as $namaLayanan => $jumlah) {
                $l = JenisLayanan::where('nama', $namaLayanan)->first();
                DetailServis::create([
                    'transaksi_servis_id' => $trx->id,
                    'jenis_layanan_id'    => $l->id,
                    'harga'               => $l->tarif,
                    'jumlah'              => $jumlah,
                ]);
                $total += $l->tarif * $jumlah;
            }

            $trx->update(['total_biaya' => $total]);
        };

        $buatServis($k1, '2026-11-10', 'Mesin kasar dan oli bocor', 'selesai',    'lunas',       ['Ganti Oli' => 1, 'Tune Up' => 1]);
        $buatServis($k3, '2026-11-12', 'Rem bunyi decit',            'dikerjakan', 'belum_lunas', ['Servis Rem' => 1]);
        $buatServis($k4, '2026-11-14', 'Ban aus, setir bergetar',    'menunggu',   'belum_lunas', ['Ganti Ban' => 2, 'Spooring Balancing' => 1]);
        $buatServis($k2, '2026-11-15', 'Servis rutin',               'selesai',    'lunas',       ['Ganti Oli' => 1]);
    }
}
