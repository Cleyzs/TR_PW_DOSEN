<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Support\Pesan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KendaraanController extends Controller
{
    private function atribut(): array
    {
        return [
            'pelanggan_id' => 'Pemilik', 'no_polisi' => 'No. polisi',
            'merek' => 'Merek', 'tipe' => 'Tipe', 'tahun' => 'Tahun',
        ];
    }

    private function aturan(?int $ignoreId = null): array
    {
        return [
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'no_polisi' => ['required', 'string', 'max:15',
                Rule::unique('kendaraan', 'no_polisi')->ignore($ignoreId)],
            'merek' => 'required|string|max:50',
            'tipe' => 'required|string|max:50',
            'tahun' => 'nullable|integer|min:1980|max:' . date('Y'),
        ];
    }

    public function index()
    {
        $kendaraan = Kendaraan::with('pelanggan')->orderBy('no_polisi')->get();
        return view('kendaraan.index', compact('kendaraan'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::orderBy('nama')->get();
        return view('kendaraan.create', compact('pelanggan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->aturan(), Pesan::umum(), $this->atribut());
        Kendaraan::create($data);
        return redirect()->route('kendaraan.index')->with('sukses', 'Kendaraan berhasil ditambahkan.');
    }

    public function edit(Kendaraan $kendaraan)
    {
        $pelanggan = Pelanggan::orderBy('nama')->get();
        return view('kendaraan.edit', compact('kendaraan', 'pelanggan'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $data = $request->validate($this->aturan($kendaraan->id), Pesan::umum(), $this->atribut());
        $kendaraan->update($data);
        return redirect()->route('kendaraan.index')->with('sukses', 'Data kendaraan diperbarui.');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        try {
            $kendaraan->delete();
        } catch (QueryException $e) {
            return back()->with('error', 'Kendaraan tidak bisa dihapus karena sudah punya transaksi servis.');
        }
        return redirect()->route('kendaraan.index')->with('sukses', 'Kendaraan dihapus.');
    }
}