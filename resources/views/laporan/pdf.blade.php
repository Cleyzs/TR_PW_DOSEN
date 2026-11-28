<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Servis - Bengkel G8</title>
    <style>
        /* DomPDF: hanya CSS dasar yang didukung. Tema gelap tidak dipakai
           karena hasilnya dicetak di kertas putih. */
        @page { margin: 28px 30px; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            line-height: 1.45;
        }

        .head {
            border-bottom: 3px solid #FF6B00;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }

        .brand {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #111;
        }

        .brand span { color: #FF6B00; }

        .sub {
            font-size: 10px;
            color: #666;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        h2 {
            font-size: 14px;
            margin: 14px 0 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .periode {
            font-size: 10px;
            color: #555;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead th {
            background: #23272b;
            color: #ffffff;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .6px;
            padding: 7px 8px;
            border: 1px solid #23272b;
            text-align: left;
        }

        tbody td {
            padding: 6px 8px;
            border: 1px solid #d8d8d8;
            font-size: 10.5px;
        }

        tbody tr:nth-child(even) td { background: #f7f7f7; }

        tfoot th {
            padding: 7px 8px;
            border: 1px solid #d8d8d8;
            border-top: 2px solid #FF6B00;
            background: #f1f1f1;
            font-size: 11px;
            color: #111;
        }

        .right { text-align: right; }

        .foot {
            margin-top: 16px;
            padding-top: 8px;
            border-top: 1px solid #d8d8d8;
            font-size: 9px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="head">
        <div class="brand">BENGKEL <span>G8</span></div>
        <div class="sub">Workshop &amp; Service &middot; Sistem Informasi Bengkel</div>
    </div>

    <h2>Laporan Servis</h2>
    <div class="periode">
        Periode:
        {{ $dari ? \Carbon\Carbon::parse($dari)->format('d/m/Y') : 'awal' }}
        s/d
        {{ $sampai ? \Carbon\Carbon::parse($sampai)->format('d/m/Y') : 'sekarang' }}
    </div>

    <table>
        <thead>
            <tr><th>#</th><th>Tanggal</th><th>No. Polisi</th><th>Pemilik</th><th class="right">Total (Rp)</th></tr>
        </thead>
        <tbody>
            @forelse ($servis as $s)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($s->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $s->kendaraan->no_polisi }}</td>
                <td>{{ $s->kendaraan->pelanggan->nama }}</td>
                <td class="right">{{ number_format($s->total_biaya, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:#777">Tidak ada data pada periode ini.</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="right">Total</th>
                <th class="right">{{ number_format($total, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="foot">
        Dicetak dari Sistem Informasi Bengkel G8 &middot; {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>