@extends('layouts.app')
@section('title', 'Status Permintaan Barang - Cabang')
@section('header', 'Riwayat Permintaan Barang')

@section('content')
<div class="max-w-6xl mx-auto">
<div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Riwayat Permintaan Barang</h1>
            <div class="space-x-4">
                <a href="{{ route('kepalaCabang.permintaan.create') }}" class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-lg font-medium transition">+ Buat Permintaan</a>
                <a href="{{ route('kepalaCabang.stok.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">Lihat Stok</a>
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
                            <th class="px-6 py-3 font-semibold">Tanggal</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold">Catatan</th>
                            <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($permintaans as $p)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $p->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                    @if($p->status == 'diajukan') bg-yellow-100 text-yellow-800 
                                    @elseif($p->status == 'disiapkan') bg-blue-100 text-blue-800
                                    @elseif($p->status == 'dikirim') bg-indigo-100 text-indigo-800
                                    @elseif($p->status == 'selesai') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($p->catatan, 40) }}</td>
                            <td class="px-6 py-4 text-sm text-center">
                                @if($p->status == 'dikirim')
                                <form action="{{ route('kepalaCabang.permintaan.terima', $p->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white hover:bg-green-600 px-3 py-1.5 rounded-md font-medium transition text-xs">Konfirmasi Terima</button>
                                </form>
                                @else
                                <span class="text-gray-400 text-xs">Tidak ada aksi</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</div>
@endsection
