@extends('layouts.app')
@section('title', 'Dashboard Kepala Cabang')
@section('header', 'Dashboard Kepala Cabang')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center">
        <div class="w-14 h-14 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-2xl mr-4">
            <i class="fa-solid fa-boxes-stacked"></i>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-medium">Total Jenis Stok</p>
            <p class="text-3xl font-bold text-slate-800">{{ \App\Models\Stok::where('cabang_id', Auth::user()->cabang_id)->count() }}</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center">
        <div class="w-14 h-14 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 text-2xl mr-4">
            <i class="fa-solid fa-cart-flatbed"></i>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-medium">Permintaan Diproses</p>
            <p class="text-3xl font-bold text-slate-800">{{ \App\Models\StockRequest::where('cabang_id', Auth::user()->cabang_id)->whereIn('status', ['diajukan', 'disiapkan', 'dikirim'])->count() }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
    <h2 class="text-xl font-bold text-slate-800 mb-4">Selamat Datang, {{ Auth::user()->name }}</h2>
    <p class="text-slate-600 leading-relaxed">Anda sedang mengelola <strong>{{ Auth::user()->cabang->nama ?? 'Cabang' }}</strong>. Anda dapat melihat ketersediaan stok fisik dan mengajukan permintaan stok tambahan ke pusat jika persediaan mulai menipis.</p>
</div>
@endsection