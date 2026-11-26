<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Support\Pesan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    private function aturan(): array
    {
        return [
            'nama'   => 'required|string|max:100',
            'no_hp'  => 'required|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ];
    }

    private function atribut(): array
    {
        return ['nama' => 'Nama', 'no_hp' => 'No. HP', 'alamat' => 'Alamat'];
    }

    public function index()
    {
        $pelanggan = Pelanggan::withCount('kendaraan')->orderBy('nama')->get();
        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->aturan(), Pesan::umum(), $this->atribut());
        Pelanggan::create($data);
        return redirect()->route('pelanggan.index')->with('sukses', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $data = $request->validate($this->aturan(), Pesan::umum(), $this->atribut());
        $pelanggan->update($data);
        return redirect()->route('pelanggan.index')->with('sukses', 'Data pelanggan diperbarui.');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        try {
            $pelanggan->delete();
        } catch (QueryException $e) {
            return back()->with('error', 'Pelanggan tidak bisa dihapus karena kendaraannya punya riwayat servis.');
        }
        return redirect()->route('pelanggan.index')->with('sukses', 'Pelanggan dihapus.');
    }
}
