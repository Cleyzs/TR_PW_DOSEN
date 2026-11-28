<div class="row g-3">
  <div class="col-md-7">
    <label for="nama" class="form-label">Nama</label>
    <input type="text" id="nama" name="nama" value="{{ old('nama', $pelanggan->nama ?? '') }}"
           class="form-control @error('nama') is-invalid @enderror" placeholder="Contoh: Budi Santoso">
    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
  <div class="col-md-5">
    <label for="no_hp" class="form-label">No. HP</label>
    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $pelanggan->no_hp ?? '') }}"
           class="form-control @error('no_hp') is-invalid @enderror" placeholder="Contoh: 081200000001">
    @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
  <div class="col-12">
    <label for="alamat" class="form-label">Alamat</label>
    <textarea id="alamat" name="alamat" rows="3"
              class="form-control @error('alamat') is-invalid @enderror"
              placeholder="Alamat lengkap (opsional)">{{ old('alamat', $pelanggan->alamat ?? '') }}</textarea>
    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
</div>

<div class="d-flex flex-wrap gap-2 pt-4">
  <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
  <button type="submit" class="btn btn-primary">
    <span class="ico ico--gear" aria-hidden="true"></span>
    Simpan
  </button>
</div>
