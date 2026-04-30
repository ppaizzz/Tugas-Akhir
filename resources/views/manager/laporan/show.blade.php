@extends('layouts.app')
@section('title', 'Detail Transaksi - GCM')
@section('header', 'Detail Transaksi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-slate-800">Detail Transaksi</h1>
        <a href="{{ route('laporan.index') }}" class="bg-slate-200 text-slate-700 px-5 py-2.5 rounded-lg hover:bg-slate-300 font-medium transition flex items-center">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <!-- Informasi Umum -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-6 relative overflow-hidden">
        <!-- Dekorasi Background -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-slate-50 rounded-bl-full z-0"></div>
        <i class="fa-solid fa-file-invoice absolute top-8 right-8 text-5xl text-slate-100 z-0"></i>

        <div class="relative z-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 pb-6 border-b border-slate-100">
                <div>
                    <p class="text-sm text-slate-500 font-semibold uppercase tracking-wider mb-1">Nomor Nota</p>
                    <h2 class="text-2xl font-black text-slate-900">{{ $sale->nomor_nota }}</h2>
                </div>
                <div class="mt-4 md:mt-0 text-left md:text-right">
                    <p class="text-sm text-slate-500 font-semibold uppercase tracking-wider mb-1">Waktu Pembelian</p>
                    <p class="text-lg font-bold text-slate-800">{{ $sale->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Info Kasir & Cabang -->
                <div class="bg-slate-50 p-5 rounded-xl border border-slate-100">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 border-b border-slate-200 pb-2">Informasi Kasir</h3>
                    <div class="flex items-start mb-3">
                        <i class="fa-solid fa-shop text-slate-400 mt-1 mr-3 w-4"></i>
                        <div>
                            <p class="text-xs text-slate-500">Cabang</p>
                            <p class="font-bold text-slate-800">{{ $sale->cabang->nama ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fa-solid fa-user-tie text-slate-400 mt-1 mr-3 w-4"></i>
                        <div>
                            <p class="text-xs text-slate-500">Petugas (Kasir)</p>
                            <p class="font-bold text-slate-800">{{ $sale->kasir->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Info Pelanggan -->
                <div class="bg-blue-50 p-5 rounded-xl border border-blue-100">
                    <h3 class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-3 border-b border-blue-200 pb-2">Data Pelanggan</h3>
                    <div class="flex items-start mb-3">
                        <i class="fa-solid fa-user text-blue-400 mt-1 mr-3 w-4"></i>
                        <div>
                            <p class="text-xs text-blue-500">Nama Lengkap</p>
                            <p class="font-bold text-blue-900">{{ $sale->pelanggan->nama ?? 'Umum' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fa-solid fa-phone text-blue-400 mt-1 mr-3 w-4"></i>
                        <div>
                            <p class="text-xs text-blue-500">Nomor Telepon</p>
                            <p class="font-bold text-blue-900">{{ $sale->pelanggan->telepon ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Status Pembayaran -->
                <div class="bg-emerald-50 p-5 rounded-xl border border-emerald-100">
                    <h3 class="text-xs font-bold text-emerald-400 uppercase tracking-widest mb-3 border-b border-emerald-200 pb-2">Pembayaran</h3>
                    <div class="flex items-start mb-3">
                        <i class="fa-solid fa-money-bill-wave text-emerald-400 mt-1 mr-3 w-4"></i>
                        <div>
                            <p class="text-xs text-emerald-500">Metode</p>
                            <p class="font-bold text-emerald-900 uppercase">{{ $sale->metode_bayar }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fa-solid fa-circle-check text-emerald-400 mt-1 mr-3 w-4"></i>
                        <div>
                            <p class="text-xs text-emerald-500">Status</p>
                            <p class="font-bold text-emerald-900 uppercase">{{ $sale->status_bayar }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rincian Barang -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-5 border-b border-slate-100 bg-slate-50 flex items-center">
            <i class="fa-solid fa-box-open text-slate-400 mr-3 text-lg"></i>
            <h2 class="text-lg font-bold text-slate-800">Rincian Barang Belanjaan</h2>
        </div>
        <div class="p-0">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-8 py-4 font-semibold">Nama Produk</th>
                        <th class="px-8 py-4 font-semibold text-center">Jumlah</th>
                        <th class="px-8 py-4 font-semibold text-right">Harga Satuan</th>
                        <th class="px-8 py-4 font-semibold text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($sale->details as $item)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-8 py-4">
                            <p class="font-bold text-slate-800 text-sm">{{ optional($item->barang)->nama ?? 'Produk Tidak Ditemukan' }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">ID: {{ $item->barang_id }}</p>
                        </td>
                        <td class="px-8 py-4 text-center">
                            <span class="inline-flex items-center justify-center bg-slate-100 text-slate-700 font-bold px-3 py-1 rounded-lg text-sm border border-slate-200">
                                {{ $item->jumlah }}
                            </span>
                        </td>
                        <td class="px-8 py-4 text-right text-sm font-medium text-slate-600">
                            Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-4 text-right font-bold text-slate-900 text-sm">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-slate-50 border-t-2 border-slate-200">
                        <td colspan="3" class="px-8 py-5 text-right font-bold text-slate-600 uppercase tracking-wider text-sm">
                            Total Pembayaran
                        </td>
                        <td class="px-8 py-5 text-right font-black text-xl text-slate-900">
                            Rp {{ number_format($sale->total, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
    <div class="mt-8 text-center">
        <button onclick="window.print()" class="bg-slate-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20">
            <i class="fa-solid fa-print mr-2"></i> Cetak Struk Bukti
        </button>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; }
        .max-w-4xl, .max-w-4xl * { visibility: visible; }
        .max-w-4xl { position: absolute; left: 0; top: 0; width: 100%; padding: 0; margin: 0; }
        .bg-slate-200, button { display: none !important; }
        .shadow-sm, .shadow-lg { box-shadow: none !important; }
        .border, .border-b, .border-t-2 { border-color: #ddd !important; }
    }
</style>
@endsection
