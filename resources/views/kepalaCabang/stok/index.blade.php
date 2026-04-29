@extends('layouts.app')
@section('title', 'Stok Cabang - Kepala Cabang')
@section('header', 'Manajemen Stok Cabang')

@section('content')
<div class="max-w-6xl mx-auto">
<div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Stok Cabang</h1>
            <div class="space-x-4">
                <a href="{{ route('kepalaCabang.permintaan.create') }}" class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-lg font-medium transition">+ Ajukan Permintaan</a>
                <a href="{{ route('dashboard.kepalaCabang') }}" class="text-gray-600 hover:text-gray-800 font-medium">Dashboard</a>
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
                            <th class="px-6 py-3 font-semibold">Kode</th>
                            <th class="px-6 py-3 font-semibold">Nama Barang</th>
                            <th class="px-6 py-3 font-semibold">Kategori</th>
                            <th class="px-6 py-3 font-semibold">Stok Saat Ini</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($stoks as $s)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $s->barang->kode ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $s->barang->nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $s->barang->kategori ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $s->jumlah }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($s->jumlah <= $s->stok_minimum)
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Menipis</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Aman</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <form action="{{ route('kepalaCabang.stok.update', $s->id) }}" method="POST" class="flex items-center justify-center space-x-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="jumlah" value="{{ $s->jumlah }}" class="w-16 px-2 py-1 border border-gray-300 rounded text-center focus:ring-blue-500 focus:border-blue-500">
                                    <button type="submit" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1 rounded transition text-xs font-medium">Update</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if($stoks->isEmpty())
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data stok. Silakan ajukan permintaan barang ke pusat.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
</div>
@endsection
