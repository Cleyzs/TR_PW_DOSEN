@extends('layouts.app')
@section('title', 'Layanan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Jenis Layanan</h3>
  <a href="{{ route('layanan.create') }}" class="btn btn-dark">+ Tambah Layanan</a>
</div>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr><th>#</th><th>Nama</th><th>Tarif</th><th>Keterangan</th><th class="text-end">Aksi</th></tr>
      </thead>
      <tbody>
      @forelse ($layanan as $l)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $l->nama }}</td>
          <td>Rp {{ number_format($l->tarif, 0, ',', '.') }}</td>
          <td>{{ $l->keterangan ?? '-' }}</td>
          <td class="text-end">
            <a href="{{ route('layanan.edit', $l) }}" class="btn btn-sm btn-outline-primary">Ubah</a>
            <form action="{{ route('layanan.destroy', $l) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Hapus layanan ini?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection