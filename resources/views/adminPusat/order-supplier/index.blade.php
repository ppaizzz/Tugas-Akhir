@extends('layouts.app')
@section('title', 'Order Supplier - Admin Pusat')
@section('header', 'Order Supplier')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <p class="text-slate-500 mt-1">Kelola pesanan barang dari supplier untuk menambah stok gudang.</p>
    </div>
    <a href="{{ route('adminPusat.order.create') }}" class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-slate-900 px-6 py-3 rounded-xl font-semibold hover:from-yellow-500 hover:to-yellow-600 transition-all shadow-lg shadow-yellow-500/20 flex items-center">
        <i class="fa-solid fa-plus mr-2"></i> Buat Order Baru
    </a>
</div>

{{-- Ringkasan Status --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center">
        <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 text-xl mr-4">
            <i class="fa-solid fa-clock"></i>
        </div>
        <div>
            <p class="text-slate-500 text-xs font-medium">Menunggu</p>
            <p class="text-2xl font-bold text-slate-800">{{ $orders->where('status', 'menunggu')->count() }}</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center">
        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xl mr-4">
            <i class="fa-solid fa-spinner"></i>
        </div>
        <div>
            <p class="text-slate-500 text-xs font-medium">Diproses</p>
            <p class="text-2xl font-bold text-slate-800">{{ $orders->where('status', 'diproses')->count() }}</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center">
        <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-xl mr-4">
            <i class="fa-solid fa-check-circle"></i>
        </div>
        <div>
            <p class="text-slate-500 text-xs font-medium">Selesai</p>
            <p class="text-2xl font-bold text-slate-800">{{ $orders->where('status', 'selesai')->count() }}</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center">
        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-600 text-xl mr-4">
            <i class="fa-solid fa-ban"></i>
        </div>
        <div>
            <p class="text-slate-500 text-xs font-medium">Batal</p>
            <p class="text-2xl font-bold text-slate-800">{{ $orders->where('status', 'batal')->count() }}</p>
        </div>
    </div>
</div>

{{-- Tabel Order --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 bg-slate-50">
        <h2 class="text-lg font-bold text-slate-800">Daftar Order Supplier</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white border-b border-slate-200 text-slate-600 text-sm">
                    <th class="px-6 py-4 font-semibold">No</th>
                    <th class="px-6 py-4 font-semibold">Tanggal Order</th>
                    <th class="px-6 py-4 font-semibold">Supplier</th>
                    <th class="px-6 py-4 font-semibold">Jumlah Item</th>
                    <th class="px-6 py-4 font-semibold">Total Estimasi</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $index => $order)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm">
                        <div class="font-medium text-slate-800">{{ $order->tanggal_order->format('d M Y') }}</div>
                        <div class="text-xs text-slate-400">oleh {{ optional($order->admin)->name ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-slate-800">{{ optional($order->supplier)->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-slate-700">{{ $order->details->count() }} barang</td>
                    <td class="px-6 py-4 text-sm font-bold text-slate-900">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm">
                        @php
                            $statusColors = [
                                'menunggu' => 'bg-amber-100 text-amber-700',
                                'diproses' => 'bg-blue-100 text-blue-700',
                                'selesai' => 'bg-emerald-100 text-emerald-700',
                                'batal' => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <span class="px-3 py-1.5 rounded-full text-xs font-semibold uppercase {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-600' }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('adminPusat.order.show', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition">
                            <i class="fa-solid fa-eye mr-1.5"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-2xl mb-4">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>
                            <p class="text-slate-500 font-medium">Belum ada order supplier.</p>
                            <p class="text-slate-400 text-sm mt-1">Klik tombol "Buat Order Baru" untuk memulai.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
