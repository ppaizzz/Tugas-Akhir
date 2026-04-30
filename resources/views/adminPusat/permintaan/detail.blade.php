@extends('layouts.app')
@section('title', 'Detail Permintaan - Admin Pusat')
@section('header', 'Detail Permintaan: ' . ($permintaan->cabang->nama ?? 'Cabang'))

@section('content')
<div class="max-w-6xl mx-auto">
<div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Detail Permintaan: {{ $permintaan->cabang->nama ?? 'Cabang' }}</h1>
            <a href="{{ route('adminPusat.permintaan.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">&larr; Kembali</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-500">Status Saat Ini</p>
                    <p class="font-semibold text-lg uppercase text-blue-600">{{ $permintaan->status }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Pengajuan</p>
                    <p class="font-medium text-gray-800">{{ $permintaan->created_at->format('d M Y H:i') }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-500">Catatan Cabang</p>
                    <p class="text-gray-800 bg-gray-50 p-3 rounded mt-1">{{ $permintaan->catatan ?: '-' }}</p>
                </div>
            </div>

            <form action="{{ route('adminPusat.permintaan.proses', $permintaan->id) }}" method="POST">
                @csrf
                <div class="mt-6 border-t pt-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Daftar Barang Diminta</h3>
                    <table class="w-full text-left border-collapse mb-6">
                        <thead>
                            <tr class="bg-gray-100 border-b text-gray-600 text-sm">
                                <th class="px-4 py-2">Barang</th>
                                <th class="px-4 py-2 text-center">Stok Tersedia (Pusat)</th>
                                <th class="px-4 py-2 text-center">Jumlah Diminta</th>
                                <th class="px-4 py-2 text-center">Jumlah Dikirim</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permintaan->details as $d)
                            @php
                                // Ambil stok barang di Gudang Pusat (asumsi cabang_id = 1)
                                $stokPusat = optional($d->barang->stoks->where('cabang_id', 1)->first())->jumlah ?? 0;
                            @endphp
                            <tr class="border-b">
                                <td class="px-4 py-3">
                                    <span class="font-medium text-gray-800">{{ $d->barang->nama ?? '-' }}</span>
                                    <div class="text-xs text-gray-500">{{ $d->barang->kode ?? '-' }}</div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-bold {{ $stokPusat > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $stokPusat }} unit
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center font-bold text-gray-700">{{ $d->jumlah_diminta }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($permintaan->status == 'disiapkan' || $permintaan->status == 'diajukan')
                                        <input type="number" name="jumlah_dikirim[{{ $d->id }}]" value="{{ min($d->jumlah_diminta, $stokPusat > 0 ? $stokPusat : $d->jumlah_diminta) }}" max="{{ $stokPusat }}" class="w-20 px-2 py-1.5 border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded text-center outline-none transition-all">
                                        @if($stokPusat < $d->jumlah_diminta)
                                            <p class="text-[10px] text-red-500 mt-1">Stok tidak cukup</p>
                                        @endif
                                    @else
                                        <span class="font-bold text-green-600">{{ $d->jumlah_dikirim }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="flex gap-4">
                        @if($permintaan->status == 'diajukan')
                            <button type="submit" name="action" value="siapkan" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-medium w-full">Proses Penyiapan Barang</button>
                        @elseif($permintaan->status == 'disiapkan')
                            <button type="submit" name="action" value="kirim" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 font-medium w-full">Kirim Barang ke Cabang</button>
                        @elseif($permintaan->status == 'dikirim')
                            <div class="w-full text-center py-3 bg-yellow-50 text-yellow-800 rounded border border-yellow-200">
                                Menunggu konfirmasi penerimaan dari Kepala Cabang
                            </div>
                        @else
                            <div class="w-full text-center py-3 bg-green-50 text-green-800 rounded border border-green-200">
                                Permintaan Telah Selesai
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
</div>
@endsection
