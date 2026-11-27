<div class="mb-3">
    <label class="form-label">Pemilik</label>
    <select name="pelanggan_id" class="form-select @error('pelanggan_id') is-invalid @enderror">
        <option value="">-- pilih pemilik --</option>
        @foreach ($pelanggan as $p)
            <option value="{{ $p->id }}"
                @selected(old('pelanggan_id', $kendaraan->pelanggan_id ?? '') == $p->id)>{{ $p->nama }}</option>
        @endforeach
    </select>
    @error('pelanggan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
@foreach ([['no_polisi','No. Polisi'], ['merek','Merek'], ['tipe','Tipe'], ['tahun','Tahun']] as [$f, $label])
<div class="mb-3">
    <label class="form-label">{{ $label }}</label>
    <input type="text" name="{{ $f }}" value="{{ old($f, $kendaraan->$f ?? '') }}"
           class="form-control @error($f) is-invalid @enderror">
    @error($f) <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
@endforeach
<a href="{{ route('kendaraan.index') }}" class="btn btn-secondary">Batal</a>
<button class="btn btn-dark">Simpan</button>