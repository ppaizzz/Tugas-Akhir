<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #2c3e50; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 24px; color: #2c3e50; }
        .header p { margin: 5px 0; color: #7f8c8d; font-size: 14px; }
        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 3px; border: none; }
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .data-table th, .data-table td { border: 1px solid #bdc3c7; padding: 8px 10px; text-align: left; }
        .data-table th { background-color: #ecf0f1; color: #2c3e50; font-weight: bold; }
        .total-row { font-weight: bold; background-color: #e8f4f8; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { position: fixed; bottom: -20px; left: 0px; right: 0px; height: 30px; text-align: right; font-size: 10px; color: #95a5a6; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Penjualan Grandcitra</h1>
        <p>Sistem Informasi Penjualan Terintegrasi</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Cabang</strong></td>
            <td width="35%">: {{ $namaCabang }}</td>
            <td width="15%"><strong>Dicetak Pada</strong></td>
            <td width="35%">: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</td>
        </tr>
        <tr>
            <td><strong>Periode</strong></td>
            <td>: {{ $periode }}</td>
            <td><strong>Oleh</strong></td>
            <td>: {{ Auth::user()->name }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="18%">Waktu Transaksi</th>
                <th width="15%">Nomor Nota</th>
                <th width="17%">Cabang</th>
                <th width="25%">Pelanggan (Kasir)</th>
                <th width="20%" class="text-right">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $index => $s)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $s->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $s->nomor_nota }}</td>
                <td>{{ $s->cabang->nama ?? '-' }}</td>
                <td>{{ $s->pelanggan->nama ?? 'Umum' }} <br><small>({{ $s->kasir->name ?? '-' }})</small></td>
                <td class="text-right">{{ number_format($s->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            
            @if($sales->isEmpty())
            <tr>
                <td colspan="6" class="text-center" style="padding: 20px;">Tidak ada data penjualan pada periode ini.</td>
            </tr>
            @endif

            <tr class="total-row">
                <td colspan="5" class="text-right">TOTAL PENDAPATAN</td>
                <td class="text-right">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dicetak otomatis oleh Sistem Grandcitra &copy; {{ date('Y') }}
    </div>
</body>
</html>
