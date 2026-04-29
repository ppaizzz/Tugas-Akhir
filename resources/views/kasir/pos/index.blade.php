<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sale - Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Point of Sale (POS)</h1>
            <div class="space-x-4">
                <a href="{{ route('kasir.keep.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">Lihat Daftar Keep</a>
                <a href="{{ route('dashboard.kasir') }}" class="text-gray-600 hover:text-gray-800 font-medium">Dashboard</a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form POS -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 border-b pb-2 text-gray-800">Transaksi Penjualan Langsung</h2>
                <form action="{{ route('kasir.pos.process') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" required class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No Telepon (Opsional)</label>
                            <input type="text" name="telepon_pelanggan" class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500">
                        </div>
                    </div>

                    <h3 class="font-semibold text-gray-700 mb-2">Pilih Barang</h3>
                    <div class="overflow-x-auto mb-6">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b text-gray-600 text-sm">
                                    <th class="px-4 py-2">Barang</th>
                                    <th class="px-4 py-2">Harga</th>
                                    <th class="px-4 py-2 text-center">Tersedia</th>
                                    <th class="px-4 py-2 text-center w-24">Beli</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($stoks as $s)
                                <tr>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $s->barang->nama }}
                                        <input type="hidden" name="barang_id[]" value="{{ $s->barang->id }}">
                                    </td>
                                    <td class="px-4 py-3 text-sm">Rp {{ number_format($s->barang->harga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-sm text-center font-bold">{{ $s->jumlah }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <input type="number" name="jumlah[]" min="0" max="{{ $s->jumlah }}" value="0" class="w-16 px-2 py-1 border rounded text-center">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-end justify-between border-t pt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                            <select name="metode_bayar" class="w-full px-4 py-2 border rounded-lg bg-white">
                                <option value="tunai">Tunai (Bayar Langsung)</option>
                                <option value="transfer">Transfer Bank</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-8 py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition">Proses Transaksi</button>
                    </div>
                </form>
            </div>

            <!-- Konfirmasi Transfer Sidebar -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-semibold mb-4 border-b pb-2 text-yellow-600">Menunggu Transfer</h2>
                @if($pending_sales->isEmpty())
                    <p class="text-sm text-gray-500 text-center py-4">Tidak ada transaksi tertunda.</p>
                @else
                    <div class="space-y-4">
                        @foreach($pending_sales as $sale)
                        <div class="border rounded-lg p-3 bg-yellow-50 border-yellow-200">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="text-xs font-bold text-gray-800">{{ $sale->nomor_nota }}</p>
                                    <p class="text-xs text-gray-600">{{ $sale->pelanggan->nama ?? 'Unknown' }}</p>
                                </div>
                                <p class="text-sm font-bold text-red-600">Rp {{ number_format($sale->total, 0, ',', '.') }}</p>
                            </div>
                            <form action="{{ route('kasir.pos.konfirmasi', $sale->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-green-500 text-white text-xs py-2 rounded font-medium hover:bg-green-600">Konfirmasi Dana Masuk</button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
