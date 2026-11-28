@extends('layouts.app')
@section('title', 'Detail Servis')
@section('content')
@php
  $warna = ['menunggu' => 'secondary', 'dikerjakan' => 'warning', 'selesai' => 'success'][$servis->status] ?? 'secondary';
@endphp
<div class="page-header">
  <div>
    <h3>Detail Servis #{{ $servis->id }}</h3>
    <p>Kelola status pengerjaan, pembayaran, dan keluhan servis ini.</p>
  </div>
  <a href="{{ route('servis.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="row g-3 mb-3">
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-body">
        <p class="mb-1"><b>Tanggal:</b> {{ $servis->tanggal->format('d/m/Y') }}</p>
        <p class="mb-1"><b>Pemilik:</b> {{ $servis->kendaraan->pelanggan->nama }}</p>
        <p class="mb-1"><b>Kendaraan:</b> {{ $servis->kendaraan->no_polisi }} -
          {{ $servis->kendaraan->merek }} {{ $servis->kendaraan->tipe }}</p>
        <p class="mb-1"><b>Status:</b>
          <span class="badge text-bg-{{ $warna }}">{{ ucfirst($servis->status) }}</span></p>
        <p class="mb-0"><b>Pembayaran:</b>
          {{ $servis->status_pembayaran == 'lunas' ? 'Lunas' : 'Belum lunas' }}</p>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-body">
        <form action="{{ route('servis.status', $servis) }}" method="POST" class="mb-3">
          @csrf
          @method('PATCH')
          <label for="status" class="form-label">Status pengerjaan</label>
          <div class="d-flex gap-2">
            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
              @foreach (['menunggu', 'dikerjakan', 'selesai'] as $s)
                <option value="{{ $s }}" @selected(old('status', $servis->status) == $s)>{{ ucfirst($s) }}</option>
              @endforeach
            </select>
            <button type="submit" class="btn btn-dark text-nowrap">Ubah status</button>
          </div>
          @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </form>

        <form action="{{ route('servis.pembayaran', $servis) }}" method="POST">
          @csrf
          @method('PATCH')
          <label for="status_pembayaran" class="form-label">Status pembayaran</label>
          <div class="d-flex gap-2">
            <select id="status_pembayaran" name="status_pembayaran"
                    class="form-select @error('status_pembayaran') is-invalid @enderror">
              <option value="belum_lunas" @selected(old('status_pembayaran', $servis->status_pembayaran) == 'belum_lunas')>Belum lunas</option>
              <option value="lunas" @selected(old('status_pembayaran', $servis->status_pembayaran) == 'lunas')>Lunas</option>
            </select>
            <button type="submit" class="btn btn-dark">Simpan</button>
          </div>
          @error('status_pembayaran') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </form>
      </div>
    </div>
  </div>
</div>

<div class="card mb-3">
  <div class="card-body">
    <form action="{{ route('servis.keluhan', $servis) }}" method="POST">
      @csrf
      @method('PATCH')
      <label for="keluhan" class="form-label">Keluhan</label>
      <textarea id="keluhan" name="keluhan" rows="3"
                class="form-control @error('keluhan') is-invalid @enderror">{{ old('keluhan', $servis->keluhan) }}</textarea>
      @error('keluhan') <div class="invalid-feedback">{{ $message }}</div> @enderror
      <button type="submit" class="btn btn-dark mt-2">Simpan keluhan</button>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header">Rincian layanan</div>
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th scope="col">Layanan</th>
          <th scope="col" class="text-end">Harga</th>
          <th scope="col" class="text-end">Jumlah</th>
          <th scope="col" class="text-end">Subtotal</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($servis->detailServis as $d)
        <tr>
          <td>{{ $d->jenisLayanan->nama }}</td>
          <td class="text-end">Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
          <td class="text-end">{{ $d->jumlah }}</td>
          <td class="text-end">Rp {{ number_format($d->harga * $d->jumlah, 0, ',', '.') }}</td>
        </tr>
      @endforeach
        <tr class="fw-bold">
          <td colspan="3" class="text-end">Total biaya</td>
          <td class="text-end">Rp {{ number_format($servis->total_biaya, 0, ',', '.') }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
