@extends('layouts.app')
@section('title', 'Layanan')
@section('content')
<div class="page-header">
  <div>
    <h3>Jenis Layanan</h3>
    <p>Daftar tarif dan keterangan pekerjaan bengkel.</p>
  </div>
  <a href="{{ route('layanan.create') }}" class="btn btn-dark">Tambah Layanan</a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nama</th>
          <th scope="col">Tarif</th>
          <th scope="col">Keterangan</th>
          <th scope="col" class="text-end">Aksi</th>
        </tr>
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
              <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5">
            <div class="empty-state">
              <strong>Belum ada data</strong>
              Tambahkan layanan pertama untuk mulai mengisi daftar.
            </div>
          </td>
        </tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
