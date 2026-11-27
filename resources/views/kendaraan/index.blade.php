@extends('layouts.app')
@section('title', 'Kendaraan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Data Kendaraan</h3>
    <a href="{{ route('kendaraan.create') }}" class="btn btn-dark">+ Tambah Kendaraan</a>
</div>
<div class="card shadow-sm">
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