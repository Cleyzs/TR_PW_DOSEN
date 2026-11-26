@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="page-header">
  <div>
    <h3>Dashboard</h3>
    <p>Ringkasan pelanggan, kendaraan, dan status pengerjaan servis.</p>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-6 col-lg-4">
    <div class="stat-card">
      <div class="label">Pelanggan</div>
      <div class="angka">{{ $jumlahPelanggan }}</div>
    </div>
  </div>
  <div class="col-6 col-lg-4">
    <div class="stat-card">
      <div class="label">Kendaraan</div>
      <div class="angka">{{ $jumlahKendaraan }}</div>
    </div>
  </div>
  <div class="col-6 col-lg-4">
    <div class="stat-card">
      <div class="label">Servis Menunggu</div>
      <div class="angka">{{ $servisMenunggu }}</div>
    </div>
  </div>
  <div class="col-6 col-lg-4">
    <div class="stat-card">
      <div class="label">Servis Dikerjakan</div>
      <div class="angka">{{ $servisDikerjakan }}</div>
    </div>
  </div>
  <div class="col-6 col-lg-4">
    <div class="stat-card">
      <div class="label">Servis Selesai</div>
      <div class="angka">{{ $servisSelesai }}</div>
    </div>
  </div>
  <div class="col-12 col-lg-4">
    <div class="stat-card">
      <div class="label">Pendapatan (Lunas)</div>
      <div class="angka">Rp {{ number_format($pendapatan, 0, ',', '.') }}</div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header">Servis terbaru</div>
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th scope="col">Tanggal</th>
          <th scope="col">Pemilik</th>
          <th scope="col">Kendaraan</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody>
      @forelse ($terbaru as $t)
        @php
          $warna = ['menunggu' => 'secondary', 'dikerjakan' => 'warning', 'selesai' => 'success'][$t->status] ?? 'secondary';
        @endphp
        <tr>
          <td>{{ $t->tanggal->format('d/m/Y') }}</td>
          <td>{{ $t->kendaraan->pelanggan->nama }}</td>
          <td>{{ $t->kendaraan->no_polisi }}</td>
          <td><span class="badge text-bg-{{ $warna }}">{{ ucfirst($t->status) }}</span></td>
        </tr>
      @empty
        <tr>
          <td colspan="4">
            <div class="empty-state">
              <strong>Belum ada servis</strong>
              Transaksi servis terbaru akan tampil di sini.
            </div>
          </td>
        </tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
