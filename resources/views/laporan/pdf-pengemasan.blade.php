<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengemasan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        h3 { margin-bottom: 5px; }
    </style>
</head>
<body>
    <h3>Laporan Pengemasan</h3>
    <p>Periode: {{ \Carbon\Carbon::parse($tanggalAwal)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Kemasan</th>
                <th>Tgl Pengemasan</th>
                <th>Target</th>
                <th>Hasil</th>
                <th>Status</th>
                <th>Expired Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengemasan as $i => $p)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $p->produk->nama_produk ?? '-' }}</td>
                <td>{{ $p->kemasan->nama_kemasan ?? '-' }}</td>
                <td class="text-center">{{ $p->tgl_pengemasan->format('d/m/Y') }}</td>
                <td class="text-end">{{ number_format($p->target_jumlah, 0, ',', '.') }}</td>
                <td class="text-end">{{ number_format($p->hasil_pengemasan, 0, ',', '.') }}</td>
                <td class="text-center">{{ ucfirst($p->status) }}</td>
                <td class="text-center">{{ $p->expired_date->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top:15px;">
        <strong>Total Batch:</strong> {{ $totalBatch }} &nbsp;|&nbsp;
        <strong>Total Target:</strong> {{ number_format($totalTarget, 0, ',', '.') }} &nbsp;|&nbsp;
        <strong>Total Hasil:</strong> {{ number_format($totalHasil, 0, ',', '.') }}
    </p>
</body>
</html>
