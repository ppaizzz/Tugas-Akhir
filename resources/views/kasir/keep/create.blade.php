@extends('layouts.app')
@section('title', 'Form Keep Barang')
@section('header', 'Buat Keep Barang Baru')

@section('content')
<div class="max-w-6xl mx-auto">
<div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Buat Keep Barang Baru</h1>
            <a href="{{ route('kasir.keep.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">&larr; Batal</a>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-md p-6">
            <form action="{{ route('kasir.keep.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 border-b pb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="tel" name="telepon_pelanggan" required oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Batas Waktu Keep (Jam)</label>
                        <input type="number" name="batas_waktu_jam" value="24" min="1" required class="w-full md:w-1/3 px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Sistem akan mengembalikan stok ke rak secara otomatis jika lewat dari batas waktu.</p>
                    </div>
                </div>

                <h3 class="text-lg font-semibold mb-4 text-gray-800">Pilih Barang dari Stok Cabang</h3>
                
                <div class="overflow-x-auto mb-6">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b text-gray-600 text-sm">
                                <th class="px-4 py-3 font-semibold">Nama Barang</th>
                                <th class="px-4 py-3 font-semibold">Kategori</th>
                                <th class="px-4 py-3 font-semibold text-center">Stok Tersedia</th>
                                <th class="px-4 py-3 font-semibold text-center w-32">Jumlah Keep</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($stoks as $s)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-gray-800 font-medium">
                                    {{ $s->barang->nama }}
                                    <input type="hidden" name="barang_id[]" value="{{ $s->barang->id }}">
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $s->barang->kategori }}</td>
                                <td class="px-4 py-3 text-center text-sm font-bold text-gray-900">{{ $s->jumlah }}</td>
                                <td class="px-4 py-3 text-center">
                                    <input type="number" name="jumlah[]" min="0" max="{{ $s->jumlah }}" value="0" class="w-20 px-2 py-1 border rounded text-center focus:ring-blue-500">
                                </td>
                            </tr>
                            @endforeach
                            @if($stoks->isEmpty())
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500 text-sm">Cabang Anda tidak memiliki stok barang yang tersedia saat ini.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 font-medium transition shadow-sm">
                        Simpan & Kurangi Stok
                    </button>
                </div>
            </form>
        </div>
</div>
@endsection
