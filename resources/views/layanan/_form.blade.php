<div class="row g-3">
  <div class="col-md-7">
    <label for="nama" class="form-label">Nama layanan</label>
    <input type="text" id="nama" name="nama" value="{{ old('nama', $layanan->nama ?? '') }}"
           class="form-control @error('nama') is-invalid @enderror" placeholder="Contoh: Ganti Oli">
    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
  <div class="col-md-5">
    <label for="tarif" class="form-label">Tarif (Rp)</label>
    <div class="input-group">
      <span class="input-group-text">Rp</span>
      <input type="number" id="tarif" name="tarif" min="0" step="1"
             value="{{ old('tarif', $layanan->tarif ?? '') }}"
             class="form-control @error('tarif') is-invalid @enderror" placeholder="75000">
    </div>
    @error('tarif') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
  </div>
  <div class="col-12">
    <label for="keterangan" class="form-label">Keterangan</label>
    <textarea id="keterangan" name="keterangan" rows="3"
              class="form-control @error('keterangan') is-invalid @enderror"
              placeholder="Ringkasan pekerjaan (opsional)">{{ old('keterangan', $layanan->keterangan ?? '') }}</textarea>
    @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
</div>

<div class="d-flex flex-wrap gap-2 pt-4">
  <a href="{{ route('layanan.index') }}" class="btn btn-secondary">Batal</a>
  <button type="submit" class="btn btn-dark">Simpan</button>
</div>
