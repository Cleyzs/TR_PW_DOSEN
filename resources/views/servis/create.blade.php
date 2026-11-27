@extends('layouts.app')
@section('title', 'Tambah Servis')
@section('content')
<div class="page-header">
  <div>
    <h3>Tambah Transaksi Servis</h3>
    <p>Pilih kendaraan, tulis keluhan, lalu isi jumlah layanan yang dikerjakan.</p>
  </div>
</div>

<form action="{{ route('servis.store') }}" method="POST">
  @csrf

  <div class="card mb-3">
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-8">
          <label for="kendaraan_id" class="form-label">Kendaraan</label>
          <select id="kendaraan_id" name="kendaraan_id"
                  class="form-select @error('kendaraan_id') is-invalid @enderror">
            <option value="">-- Pilih kendaraan --</option>
            @foreach ($kendaraan as $k)
              <option value="{{ $k->id }}" @selected(old('kendaraan_id') == $k->id)>
                {{ $k->no_polisi }} - {{ $k->merek }} {{ $k->tipe }} ({{ $k->pelanggan->nama }})
              </option>
            @endforeach
          </select>
          @error('kendaraan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4">
          <label for="tanggal" class="form-label">Tanggal</label>
          <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', now('Asia/Jakarta')->format('Y-m-d')) }}"
                 class="form-control @error('tanggal') is-invalid @enderror">
          @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-12">
          <label for="keluhan" class="form-label">Keluhan</label>
          <textarea id="keluhan" name="keluhan" rows="3" placeholder="Contoh: Mesin kasar saat dinyalakan"
                    class="form-control @error('keluhan') is-invalid @enderror">{{ old('keluhan') }}</textarea>
          @error('keluhan') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
      </div>
    </div>
  </div>

  @error('jumlah') <div class="alert alert-danger">{{ $message }}</div> @enderror
  @error('jumlah.*') <div class="alert alert-danger">{{ $message }}</div> @enderror

  <div class="card mb-3">
    <div class="card-header">Layanan (isi jumlah, 0 berarti tidak dipakai)</div>
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th scope="col">Layanan</th>
            <th scope="col" class="text-end">Tarif</th>
            <th scope="col" class="col-3 col-md-2">Jumlah</th>
          </tr>
        </thead>
        <tbody>
        @forelse ($layanan as $l)
          <tr>
            <td><label for="jumlah-{{ $l->id }}">{{ $l->nama }}</label></td>
            <td class="text-end text-nowrap">Rp {{ number_format($l->tarif, 0, ',', '.') }}</td>
            <td>
              <input type="number" id="jumlah-{{ $l->id }}" name="jumlah[{{ $l->id }}]"
                     min="0" max="99" value="{{ old('jumlah.' . $l->id, 0) }}"
                     data-tarif="{{ $l->tarif }}"
                     class="form-control input-jumlah @error('jumlah.' . $l->id) is-invalid @enderror">
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="3">
              <div class="empty-state">
                <strong>Belum ada layanan</strong>
                Tambahkan jenis layanan terlebih dahulu.
              </div>
            </td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer d-flex justify-content-between">
      <span>Estimasi total</span>
      <strong id="estimasi">Rp 0</strong>
    </div>
  </div>

  <div class="d-flex flex-wrap gap-2">
    <a href="{{ route('servis.index') }}" class="btn btn-secondary">Batal</a>
    <button type="submit" class="btn btn-dark">Simpan</button>
  </div>
</form>

{{-- Estimasi hanya untuk tampilan. Total yang disimpan dihitung ulang di controller. --}}
<script>
  const inputJumlah = document.querySelectorAll('.input-jumlah');

  function hitungEstimasi() {
    let total = 0;
    inputJumlah.forEach(function (input) {
      total += Number(input.dataset.tarif) * (parseInt(input.value) || 0);
    });
    document.getElementById('estimasi').textContent = 'Rp ' + total.toLocaleString('id-ID');
  }

  inputJumlah.forEach(function (input) {
    input.addEventListener('input', hitungEstimasi);
  });
  hitungEstimasi();
</script>
@endsection
