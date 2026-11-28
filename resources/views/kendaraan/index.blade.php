@extends('layouts.app')
@section('title', 'Kendaraan')
@section('content')
<div class="page-header">
    <div>
        <span class="eyebrow">Data Master</span>
        <h3>Data Kendaraan</h3>
        <p>Daftar unit kendaraan beserta pemiliknya.</p>
    </div>
    <a href="{{ route('kendaraan.create') }}" class="btn btn-primary">
        <span class="ico ico--car" aria-hidden="true"></span>
        Tambah Kendaraan
    </a>
</div>
<div class="card reveal">
    <div class="card-header">
        <span class="ico ico--car" aria-hidden="true"></span>
        Daftar Kendaraan
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>No. Polisi</th><th>Merek</th><th>Tipe</th><th>Tahun</th>
                    <th>Pemilik</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
                @forelse ($kendaraan as $k)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $k->no_polisi }}</td>
                    <td>{{ $k->merek }}</td>
                    <td>{{ $k->tipe }}</td>
                    <td>{{ $k->tahun ?? '-' }}</td>
                    <td>{{ $k->pelanggan->nama }}</td>
                    <td class="text-end">
                        <a href="{{ route('kendaraan.edit', $k) }}" class="btn btn-sm btn-outline-primary">Ubah</a>
                        <form action="{{ route('kendaraan.destroy', $k) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus kendaraan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection