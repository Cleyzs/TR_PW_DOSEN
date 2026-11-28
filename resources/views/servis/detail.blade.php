@extends('layouts.app')
@section('title', 'Detail Servis')
@section('content')
@php
  $warna = ['menunggu' => 'secondary', 'dikerjakan' => 'warning', 'selesai' => 'success'][$servis->status] ?? 'secondary';
@endphp
<div class="page-header">
  <div>
    <span class="eyebrow">Operasional</span>
    <h3>Detail Servis <span class="text-primary">#{{ $servis->id }}</span></h3>
    <p>Kelola status pengerjaan, pembayaran, dan keluhan servis ini.</p>
  </div>
  <a href="{{ route('servis.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="row g-3 mb-3">
  <div class="col-md-6">
    <div class="card h-100 reveal">
      <div class="card-header">
        <span class="ico ico--calendar" aria-hidden="true"></span>
        Informasi Servis
      </div>
      <div class="card-body">
        <dl class="detail-list mb-0">
          <div>
            <dt>Tanggal</dt>
            <dd>{{ $servis->tanggal->format('d/m/Y') }}</dd>
          </div>
          <div>
            <dt>Pemilik</dt>
            <dd>{{ $servis->kendaraan->pelanggan->nama }}</dd>
          </div>
          <div>
            <dt>Kendaraan</dt>
            <dd>{{ $servis->kendaraan->no_polisi }} &mdash;
              {{ $servis->kendaraan->merek }} {{ $servis->kendaraan->tipe }}</dd>
          </div>
          <div>
            <dt>Status</dt>
            <dd><span class="badge text-bg-{{ $warna }}">{{ ucfirst($servis->status) }}</span></dd>
          </div>
          <div>
            <dt>Pembayaran</dt>
            <dd>{{ $servis->status_pembayaran == 'lunas' ? 'Lunas' : 'Belum lunas' }}</dd>
          </div>
        </dl>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card h-100 reveal">
      <div class="card-header">
        <span class="ico ico--gear" aria-hidden="true"></span>
        Status &amp; Pembayaran
      </div>
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
            <button type="submit" class="btn btn-primary text-nowrap">Ubah status</button>
          </div>
          @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </form>

        <form action="{{ route('servis.pembayaran', $servis) }}" method="POST" class="mb-0">
          @csrf
          @method('PATCH')
          <label for="status_pembayaran" class="form-label">Status pembayaran</label>
          <div class="d-flex gap-2">
            <select id="status_pembayaran" name="status_pembayaran"
                    class="form-select @error('status_pembayaran') is-invalid @enderror">
              <option value="belum_lunas" @selected(old('status_pembayaran', $servis->status_pembayaran) == 'belum_lunas')>Belum lunas</option>
              <option value="lunas" @selected(old('status_pembayaran', $servis->status_pembayaran) == 'lunas')>Lunas</option>
            </select>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          @error('status_pembayaran') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </form>
      </div>
    </div>
  </div>
</div>

<div class="card reveal mb-3">
  <div class="card-header">
    <span class="ico ico--wrench" aria-hidden="true"></span>
    Keluhan Pelanggan
  </div>
  <div class="card-body">
    <form action="{{ route('servis.keluhan', $servis) }}" method="POST">
      @csrf
      @method('PATCH')
      <label for="keluhan" class="form-label">Keluhan</label>
      <textarea id="keluhan" name="keluhan" rows="3"
                class="form-control @error('keluhan') is-invalid @enderror">{{ old('keluhan', $servis->keluhan) }}</textarea>
      @error('keluhan') <div class="invalid-feedback">{{ $message }}</div> @enderror
      <button type="submit" class="btn btn-primary mt-3">
        <span class="ico ico--gear" aria-hidden="true"></span>
        Simpan keluhan
      </button>
    </form>
  </div>
</div>

<div class="card reveal">
  <div class="card-header">
    <span class="ico ico--piston" aria-hidden="true"></span>
    Rincian Layanan
  </div>
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
        <tr class="fw-bold total-row">
          <td colspan="3" class="text-end">Total biaya</td>
          <td class="text-end">Rp {{ number_format($servis->total_biaya, 0, ',', '.') }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
