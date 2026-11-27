@extends('layouts.app')
@section('title', 'Laporan')
@section('content')
<h3 class="mb-3">Laporan Servis</h3>

<div class="card shadow-sm mb-3"><div class="card-body">
    <form method="GET" action="{{ route('laporan.index') }}" class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Dari tanggal</label>
            <input type="date" name="dari" value="{{ request('dari') }}"
                   class="form-control @error('dari') is-invalid @enderror">
            @error('dari') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label">Sampai tanggal</label>
            <input type="date" name="sampai" value="{{ request('sampai') }}"
                   class="form-control @error('sampai') is-invalid @enderror">
            @error('sampai') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button class="btn btn-dark">Tampilkan</button>
            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Reset</a>
            <a href="{{ route('laporan.pdf', request()->only('dari', 'sampai')) }}"
               class="btn btn-danger">Unduh PDF</a>
        </div>
    </form>
</div></div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Tanggal</th><th>No. Polisi</th><th>Pemilik</th>
                    <th class="text-end">Total (Rp)</th></tr>
            </thead>
            <tbody>
                @forelse ($servis as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($s->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $s->kendaraan->no_polisi }}</td>
                    <td>{{ $s->kendaraan->pelanggan->nama }}</td>
                    <td class="text-end">{{ number_format($s->total, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
            @if ($servis->count())
            <tfoot class="table-light">
                <tr><th colspan="4" class="text-end">Total</th>
                    <th class="text-end">{{ number_format($total, 0, ',', '.') }}</th></tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection