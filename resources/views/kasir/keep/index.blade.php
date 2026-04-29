<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keep Barang - Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">
    <div class="container mx-auto px-4 py-8 max-w-5xl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Keep Barang</h1>
            <div class="space-x-4">
                <a href="{{ route('kasir.keep.create') }}" class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-lg font-medium transition">+ Buat Keep Baru</a>
                <a href="{{ route('dashboard.kasir') }}" class="text-gray-600 hover:text-gray-800 font-medium">Dashboard</a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm">
                            <th class="px-6 py-3 font-semibold">Pelanggan</th>
                            <th class="px-6 py-3 font-semibold">Batas Waktu</th>
                            <th class="px-6 py-3 font-semibold">Item & Jumlah</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($keeps as $k)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-800 font-medium">
                                {{ $k->pelanggan->nama ?? 'Unknown' }}<br>
                                <span class="text-xs text-gray-500">{{ $k->pelanggan->telepon ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800">
                                {{ \Carbon\Carbon::parse($k->batas_waktu)->format('d M Y, H:i') }}
                                @if($k->status == 'aktif' && \Carbon\Carbon::parse($k->batas_waktu)->isPast())
                                    <br><span class="text-xs text-red-500 font-bold">(Expired)</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <ul class="list-disc pl-4">
                                @foreach($k->details as $d)
                                    <li>{{ $d->barang->nama }} ({{ $d->jumlah }})</li>
                                @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                    @if($k->status == 'aktif') bg-blue-100 text-blue-800 
                                    @elseif($k->status == 'selesai') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($k->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                @if($k->status == 'aktif')
                                <a href="{{ route('kasir.pos.checkoutKeep', $k->id) }}" class="bg-green-500 text-white hover:bg-green-600 px-3 py-1.5 rounded-md font-medium transition text-xs">Checkout</a>
                                @else
                                <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @if($keeps->isEmpty())
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada data keep barang.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
