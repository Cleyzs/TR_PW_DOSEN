<?php

namespace App\Http\Controllers;

use App\Models\JenisLayanan;
use App\Support\Pesan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class JenisLayananController extends Controller
{
    private function aturan(): array
    {
        return [
            'nama'       => 'required|string|max:100',
            'tarif'      => 'required|integer|min:0|max:100000000',
            'keterangan' => 'nullable|string|max:255',
        ];
    }

    private function atribut(): array
    {
        return ['nama' => 'Nama layanan', 'tarif' => 'Tarif', 'keterangan' => 'Keterangan'];
    }

    public function index()
    {
        $layanan = JenisLayanan::orderBy('nama')->get();
        return view('layanan.index', compact('layanan'));
    }

    public function create()
    {
        return view('layanan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->aturan(), Pesan::umum(), $this->atribut());
        JenisLayanan::create($data);
        return redirect()->route('layanan.index')->with('sukses', 'Layanan berhasil ditambahkan.');
    }

    public function edit(JenisLayanan $layanan)
    {
        return view('layanan.edit', compact('layanan'));
    }

    public function update(Request $request, JenisLayanan $layanan)
    {
        $data = $request->validate($this->aturan(), Pesan::umum(), $this->atribut());
        $layanan->update($data);
        return redirect()->route('layanan.index')->with('sukses', 'Layanan diperbarui.');
    }

    public function destroy(JenisLayanan $layanan)
    {
        try {
            $layanan->delete();
        } catch (QueryException $e) {
            return back()->with('error', 'Layanan tidak bisa dihapus karena sudah dipakai di transaksi servis.');
        }
        return redirect()->route('layanan.index')->with('sukses', 'Layanan dihapus.');
    }
}