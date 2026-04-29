@extends('layouts.app')
@section('title', 'Laporan Penjualan - Manager')
@section('header', 'Laporan Penjualan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-8">
    <h2 class="text-lg font-semibold text-slate-800 mb-4">Filter Laporan</h2>
    <form action="{{ route('manager.laporan.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-slate-50 text-slate-700">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-slate-50 text-slate-700">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Pilih Cabang</label>
            <select name="cabang_id" class="px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-slate-50 text-slate-700 min-w-[200px]">
                <option value="">Semua Cabang</option>
                @foreach($branches as $b)
                    <option value="{{ $b->id }}" {{ request('cabang_id') == $b->id ? 'selected' : '' }}>{{ $b->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 font-medium transition shadow-sm"><i class="fa-solid fa-filter mr-2"></i> Terapkan</button>
            <a href="{{ route('manager.laporan.index') }}" class="bg-slate-200 text-slate-700 px-5 py-2.5 rounded-lg hover:bg-slate-300 font-medium transition">Reset</a>
            <a href="{{ route('manager.laporan.export', request()->all()) }}" target="_blank" class="bg-red-600 text-white px-5 py-2.5 rounded-lg hover:bg-red-700 font-medium transition shadow-sm"><i class="fa-solid fa-file-pdf mr-2"></i> Cetak PDF</a>
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
        <h2 class="text-xl font-bold text-slate-800">Daftar Transaksi Lunas</h2>
        <div class="bg-emerald-100 text-emerald-800 px-4 py-2 rounded-lg font-bold">
            Total: Rp {{ number_format($totalRevenue, 0, ',', '.') }}
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white border-b border-slate-200 text-slate-600 text-sm">
                    <th class="px-6 py-4 font-semibold">Tanggal & Nota</th>
                    <th class="px-6 py-4 font-semibold">Cabang</th>
                    <th class="px-6 py-4 font-semibold">Kasir & Pelanggan</th>
                    <th class="px-6 py-4 font-semibold">Metode</th>
                    <th class="px-6 py-4 font-semibold text-right">Nominal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($sales as $s)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-sm">
                        <div class="font-bold text-slate-800">{{ $s->nomor_nota }}</div>
                        <div class="text-slate-500">{{ $s->created_at->format('d M Y H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-700 font-medium">{{ $s->cabang->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">
                        <div class="text-slate-800"><i class="fa-solid fa-user-tie text-xs text-slate-400 mr-1"></i> {{ $s->kasir->name ?? '-' }}</div>
                        <div class="text-slate-500"><i class="fa-solid fa-user text-xs text-slate-400 mr-1"></i> {{ $s->pelanggan->nama ?? 'Umum' }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 uppercase">{{ $s->metode_bayar }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-slate-900 text-right">
                        Rp {{ number_format($s->total, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
                @if($sales->isEmpty())
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">Tidak ada data transaksi yang sesuai filter.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
