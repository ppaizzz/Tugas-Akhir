@extends('layouts.app')
@section('title', 'Dashboard Admin Pusat')
@section('header', 'Dashboard Admin Pusat')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center">
        <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-2xl mr-4">
            <i class="fa-solid fa-box-open"></i>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-medium">Total Barang</p>
            <p class="text-3xl font-bold text-slate-800">{{ \App\Models\Product::count() }}</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center">
        <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-2xl mr-4">
            <i class="fa-solid fa-truck-fast"></i>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-medium">Permintaan Baru</p>
            <p class="text-3xl font-bold text-slate-800">{{ \App\Models\StockRequest::where('status', 'diajukan')->count() }}</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center">
        <div class="w-14 h-14 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-2xl mr-4">
            <i class="fa-solid fa-code-branch"></i>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-medium">Total Cabang</p>
            <p class="text-3xl font-bold text-slate-800">{{ \App\Models\Branch::count() }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
    <h2 class="text-xl font-bold text-slate-800 mb-4">Selamat Datang di Portal Admin Pusat</h2>
    <p class="text-slate-600 leading-relaxed">Gunakan menu di sebelah kiri untuk mengelola master data barang dan memproses permintaan pengiriman stok ke setiap cabang.</p>
</div>
@endsection