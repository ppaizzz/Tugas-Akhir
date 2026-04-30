<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - GCM</title>
    <link rel="icon" href="{{ asset('images/logo_GCM.png') }}">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; color: #333; line-height: 1.5; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #1a1a1a; padding-bottom: 15px; }
        .header h1 { margin: 0; font-size: 24px; color: #1a1a1a; letter-spacing: 1px; text-transform: uppercase; }
        .header h2 { margin: 4px 0 0 0; font-size: 14px; color: #666; font-weight: normal; }
        .info-table { width: 100%; margin-bottom: 20px; font-size: 13px; }
        .info-table td { padding: 4px; border: none; }
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th, .data-table td { border: 1px solid #ccc; padding: 10px; text-align: left; font-size: 12px; }
        .data-table th { background-color: #f8f9fa; color: #1a1a1a; font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; border-bottom: 2px solid #ccc; }
        .data-table tbody tr:nth-child(even) { background-color: #fafafa; }
        .total-row { font-weight: bold; background-color: #fff9e6 !important; }
        .total-row td { border-top: 2px solid #1a1a1a !important; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 40px; text-align: right; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
        
        @media print {
            body { padding: 0; margin: 0; }
            @page { size: landscape; margin: 10mm; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body onload="window.print()">
    <!-- Tombol cetak manual jika otomatis gagal -->
    <div class="no-print" style="text-align: right; margin-bottom: 20px;">
        <button onclick="window.print()" style="background: #FFE500; color: #000; border: none; padding: 10px 20px; font-weight: bold; border-radius: 5px; cursor: pointer; font-size: 14px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">🖨️ Cetak Sekarang</button>
        <button onclick="window.close()" style="background: #f1f1f1; color: #333; border: 1px solid #ccc; padding: 10px 20px; font-weight: bold; border-radius: 5px; cursor: pointer; font-size: 14px; margin-left: 10px;">Tutup</button>
    </div>

    <div class="header">
        <h1>LAPORAN PENJUALAN</h1>
        <h2>PT Grand Citra Mandiri</h2>
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
            <td><strong>Jumlah Data</strong></td>
            <td>: {{ $sales->count() }} transaksi</td>
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
            @forelse($sales as $index => $s)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ optional($s->created_at)->format('d/m/Y H:i') ?? '-' }}</td>
                <td>{{ $s->nomor_nota ?? '-' }}</td>
                <td>{{ optional($s->cabang)->nama ?? '-' }}</td>
                <td>
                    {{ optional($s->pelanggan)->nama ?? 'Umum' }}
                    @if($s->pelanggan && $s->pelanggan->telepon && $s->pelanggan->telepon != '-')
                        <br><span style="color: #666; font-size: 10px;">Tel: {{ $s->pelanggan->telepon }}</span>
                    @endif
                    <br><span style="color: #666; font-size: 11px;">(Kasir: {{ optional($s->kasir)->name ?? '-' }})</span>
                </td>
                <td class="text-right">{{ number_format($s->total ?? 0, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 30px; color: #666;">Tidak ada data penjualan pada periode ini.</td>
            </tr>
            @endforelse

            <tr class="total-row">
                <td colspan="5" class="text-right">TOTAL PENDAPATAN : </td>
                <td class="text-right" style="font-size: 14px;">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dicetak otomatis oleh Sistem Informasi Penjualan - PT Grand Citra Mandiri &copy; {{ date('Y') }}
    </div>
</body>
</html>

