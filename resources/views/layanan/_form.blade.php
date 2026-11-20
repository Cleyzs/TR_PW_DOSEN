<div class="mb-3">
  <label class="form-label">Nama layanan</label>
  <input type="text" name="nama" value="{{ old('nama', $layanan->nama ?? '') }}"
         class="form-control @error('nama') is-invalid @enderror">
  @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
  <label class="form-label">Tarif (Rp)</label>
  <input type="number" min="0" name="tarif" value="{{ old('tarif', $layanan->tarif ?? '') }}"
         class="form-control @error('tarif') is-invalid @enderror">
  @error('tarif') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
  <label class="form-label">Keterangan</label>
  <textarea name="keterangan" rows="3"
            class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $layanan->keterangan ?? '') }}</textarea>
  @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<a href="{{ route('layanan.index') }}" class="btn btn-secondary">Batal</a>
<button class="btn btn-dark">Simpan</button>