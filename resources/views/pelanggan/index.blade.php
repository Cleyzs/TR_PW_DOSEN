@extends('layouts.app')
@section('title', 'Pelanggan')
@section('content')
<div class="page-header">
  <div>
    <h3>Data Pelanggan</h3>
    <p>Daftar pemilik kendaraan yang tercatat di bengkel.</p>
  </div>
  <a href="{{ route('pelanggan.create') }}" class="btn btn-dark">Tambah Pelanggan</a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nama</th>
          <th scope="col">No. HP</th>
          <th scope="col">Alamat</th>
          <th scope="col">Kendaraan</th>
          <th scope="col" class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse ($pelanggan as $p)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $p->nama }}</td>
          <td>{{ $p->no_hp }}</td>
          <td>{{ $p->alamat ?? '-' }}</td>
          <td>{{ $p->kendaraan_count }}</td>
          <td class="text-end">
            <a href="{{ route('pelanggan.edit', $p) }}" class="btn btn-sm btn-outline-primary">Ubah</a>
            <form action="{{ route('pelanggan.destroy', $p) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Hapus pelanggan ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6">
            <div class="empty-state">
              <strong>Belum ada data</strong>
              Tambahkan pelanggan pertama untuk mulai mengisi daftar.
            </div>
          </td>
        </tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
