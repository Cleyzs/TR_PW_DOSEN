<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Servis</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { margin-bottom: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #444; padding: 6px; }
        th { background: #eee; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <h2>Laporan Servis Bengkel</h2>
    <div>Periode:
        {{ $dari ? \Carbon\Carbon::parse($dari)->format('d/m/Y') : 'awal' }}
        s/d
        {{ $sampai ? \Carbon\Carbon::parse($sampai)->format('d/m/Y') : 'sekarang' }}
    </div>

    <table>
        <thead>
            <tr><th>#</th><th>Tanggal</th><th>No. Polisi</th><th>Pemilik</th><th>Total (Rp)</th></tr>
        </thead>
        <tbody>
            @forelse ($servis as $s)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($s->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $s->kendaraan->no_polisi }}</td>
                <td>{{ $s->kendaraan->pelanggan->nama }}</td>
                <td class="right">{{ number_format($s->total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr><th colspan="4" class="right">Total</th>
                <th class="right">{{ number_format($total, 0, ',', '.') }}</th></tr>
        </tfoot>
    </table>
</body>
</html>