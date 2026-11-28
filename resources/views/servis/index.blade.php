@extends('layouts.app')
@section('title', 'Servis')
@section('content')
<div class="page-header">
  <div>
    <span class="eyebrow">Operasional</span>
    <h3>Transaksi Servis</h3>
    <p>Daftar kendaraan yang masuk servis beserta total biayanya.</p>
  </div>
  <a href="{{ route('servis.create') }}" class="btn btn-primary">
    <span class="ico ico--wrench" aria-hidden="true"></span>
    Tambah Servis
  </a>
</div>

<div class="card reveal">
  <div class="card-header">
    <span class="ico ico--calendar" aria-hidden="true"></span>
    Daftar Transaksi
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Tanggal</th>
          <th scope="col">Pemilik</th>
          <th scope="col">Kendaraan</th>
          <th scope="col">Status</th>
          <th scope="col">Pembayaran</th>
          <th scope="col" class="text-end">Total</th>
          <th scope="col" class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse ($servis as $s)
        @php
          $warna = [
              'menunggu'   => 'secondary',
              'dikerjakan' => 'warning',
              'selesai'    => 'success',
          ][$s->status] ?? 'secondary';
        @endphp
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $s->tanggal->format('d/m/Y') }}</td>
          <td>{{ $s->kendaraan->pelanggan->nama }}</td>
          <td class="text-nowrap">{{ $s->kendaraan->no_polisi }}</td>
          <td><span class="badge text-bg-{{ $warna }}">{{ ucfirst($s->status) }}</span></td>
          <td>{{ $s->status_pembayaran === 'lunas' ? 'Lunas' : 'Belum lunas' }}</td>
          <td class="text-end text-nowrap">Rp {{ number_format($s->total_biaya, 0, ',', '.') }}</td>
          <td class="text-end text-nowrap">
            <a href="{{ route('servis.detail', $s) }}" class="btn btn-sm btn-outline-primary">Detail</a>
            <form action="{{ route('servis.destroy', $s) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Hapus transaksi servis ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="8">
            <div class="empty-state">
              <strong>Belum ada transaksi</strong>
              Tambahkan transaksi servis pertama untuk mulai mengisi daftar.
            </div>
          </td>
        </tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
