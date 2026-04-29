@extends('layouts.app')
@section('title', 'Checkout Keep Barang')
@section('header', 'Checkout Keep Barang')

@section('content')
<div class="max-w-6xl mx-auto">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Keep Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-lg w-full">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Checkout Keep Barang</h1>
        
        <div class="mb-6">
            <p class="text-sm text-gray-500">Pelanggan</p>
            <p class="font-semibold text-lg">{{ $keep->pelanggan->nama ?? '-' }}</p>
            <p class="text-sm text-gray-600">{{ $keep->pelanggan->telepon ?? '-' }}</p>
        </div>

        <div class="mb-6">
            <p class="text-sm text-gray-500 mb-2">Daftar Barang (Sudah dipisahkan dari rak)</p>
            <ul class="space-y-2">
                @php $total = 0; @endphp
                @foreach($keep->details as $d)
                    @php $subtotal = $d->jumlah * $d->barang->harga; $total += $subtotal; @endphp
                    <li class="flex justify-between text-sm">
                        <span>{{ $d->barang->nama }} x {{ $d->jumlah }}</span>
                        <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="border-t pt-4 mb-6">
            <div class="flex justify-between items-center text-xl font-bold text-gray-900">
                <span>Total Tagihan:</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>

        <form action="{{ route('kasir.pos.processKeep', $keep->id) }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="border rounded-lg p-3 cursor-pointer flex items-center bg-gray-50 hover:bg-gray-100 transition">
                        <input type="radio" name="metode_bayar" value="tunai" checked class="mr-2">
                        <span class="font-medium">Uang Tunai</span>
                    </label>
                    <label class="border rounded-lg p-3 cursor-pointer flex items-center bg-gray-50 hover:bg-gray-100 transition">
                        <input type="radio" name="metode_bayar" value="transfer" class="mr-2">
                        <span class="font-medium">Transfer Bank</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('kasir.keep.index') }}" class="w-1/3 text-center py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">Batal</a>
                <button type="submit" class="w-2/3 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium shadow-sm transition">Selesaikan Pembayaran</button>
            </div>
        </form>
</div>
@endsection
