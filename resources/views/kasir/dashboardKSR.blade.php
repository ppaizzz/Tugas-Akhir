@extends('layouts.app')
@section('title', 'Dashboard Kasir')
@section('header', 'Dashboard Kasir')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center">
        <div class="w-14 h-14 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 text-2xl mr-4">
            <i class="fa-solid fa-bookmark"></i>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-medium">Keep Aktif</p>
            <p class="text-3xl font-bold text-slate-800">{{ \App\Models\KeepItem::where('cabang_id', Auth::user()->cabang_id)->where('status', 'aktif')->count() }}</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center">
        <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-2xl mr-4">
            <i class="fa-solid fa-receipt"></i>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-medium">Transaksi Hari Ini</p>
            <p class="text-3xl font-bold text-slate-800">{{ \App\Models\Sale::where('cabang_id', Auth::user()->cabang_id)->whereDate('created_at', \Carbon\Carbon::today())->count() }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
    <h2 class="text-xl font-bold text-slate-800 mb-4">Aplikasi Point of Sale</h2>
    <p class="text-slate-600 leading-relaxed">Gunakan menu Point of Sale untuk melayani pembeli secara langsung, atau gunakan Keep Barang jika pelanggan ingin mereservasi barang dengan batas waktu tertentu.</p>
</div>
@endsection