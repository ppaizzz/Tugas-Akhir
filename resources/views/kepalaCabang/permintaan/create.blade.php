@extends('layouts.app')
@section('title', 'Ajukan Permintaan Barang')
@section('header', 'Ajukan Permintaan Barang ke Pusat')

@section('content')
<div class="max-w-6xl mx-auto">
<div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Ajukan Permintaan Barang ke Pusat</h1>
            <a href="{{ route('kepalaCabang.permintaan.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">&larr; Batal</a>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden p-6">
            <form action="{{ route('kepalaCabang.permintaan.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Permintaan (Opsional)</label>
                    <textarea name="catatan" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Misal: Stok untuk persiapan promo akhir tahun"></textarea>
                </div>

                <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Pilih Barang yang Diminta</h3>
                
                <div class="overflow-x-auto mb-6">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b text-gray-600 text-sm">
                                <th class="px-4 py-3 font-semibold">Nama Barang</th>
                                <th class="px-4 py-3 font-semibold">Kategori</th>
                                <th class="px-4 py-3 font-semibold text-center w-32">Jumlah Minta</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($barangs as $b)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-gray-800">
                                    {{ $b->nama }}
                                    <input type="hidden" name="barang_id[]" value="{{ $b->id }}">
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $b->kategori }}</td>
                                <td class="px-4 py-3 text-center">
                                    <input type="number" name="jumlah[]" min="0" value="0" class="w-20 px-2 py-1 border rounded text-center focus:ring-blue-500">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 font-medium transition shadow-sm">
                        Kirim Pengajuan Permintaan
                    </button>
                </div>
            </form>
        </div>
</div>
@endsection
