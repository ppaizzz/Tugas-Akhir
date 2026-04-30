@extends('layouts.app')
@section('title', 'Detail Order #' . $order->id . ' - Admin Pusat')
@section('header', 'Detail Order Supplier')

@section('content')
<div class="max-w-5xl">
    {{-- Tombol Kembali --}}
    <a href="{{ route('adminPusat.order.index') }}" class="inline-flex items-center text-slate-500 hover:text-slate-800 font-medium mb-6 transition">
        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Order
    </a>

    {{-- Header Info --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
        <div class="flex flex-wrap justify-between items-start gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Order #{{ $order->id }}</h2>
                <p class="text-slate-500 mt-1">Dibuat pada {{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div>
                @php
                    $statusColors = [
                        'menunggu' => 'bg-amber-100 text-amber-700 border-amber-200',
                        'diproses' => 'bg-blue-100 text-blue-700 border-blue-200',
                        'selesai' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                        'batal' => 'bg-red-100 text-red-700 border-red-200',
                    ];
                @endphp
                <span class="px-5 py-2 rounded-full text-sm font-bold uppercase border {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-600' }}">
                    <i class="fa-solid fa-circle text-[6px] mr-1.5 align-middle"></i>{{ $order->status }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t border-slate-100">
            <div class="bg-slate-50 rounded-xl p-4">
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide mb-1">Supplier</p>
                <p class="font-bold text-slate-800 text-lg">{{ optional($order->supplier)->nama ?? '-' }}</p>
                <p class="text-sm text-slate-500 mt-0.5">{{ optional($order->supplier)->kontak ?? '-' }}</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-4">
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide mb-1">Tanggal Order</p>
                <p class="font-bold text-slate-800 text-lg">{{ $order->tanggal_order->format('d M Y') }}</p>
                @if($order->tanggal_terima)
                    <p class="text-sm text-emerald-600 mt-0.5"><i class="fa-solid fa-check-circle mr-1"></i>Diterima: {{ $order->tanggal_terima->format('d M Y') }}</p>
                @endif
            </div>
            <div class="bg-slate-50 rounded-xl p-4">
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide mb-1">Admin</p>
                <p class="font-bold text-slate-800 text-lg">{{ optional($order->admin)->name ?? '-' }}</p>
                <p class="text-sm text-slate-500 mt-0.5">Admin Pusat</p>
            </div>
        </div>
    </div>

    {{-- Tabel Detail Barang --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
        <div class="p-6 border-b border-slate-100 bg-slate-50">
            <h3 class="text-lg font-bold text-slate-800">Barang yang Dipesan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-600 text-sm">
                        <th class="px-6 py-4 font-semibold w-[5%]">No</th>
                        <th class="px-6 py-4 font-semibold w-[15%]">Kode</th>
                        <th class="px-6 py-4 font-semibold w-[30%]">Nama Barang</th>
                        <th class="px-6 py-4 font-semibold w-[15%] text-center">Jumlah</th>
                        <th class="px-6 py-4 font-semibold w-[17%] text-right">Harga Beli</th>
                        <th class="px-6 py-4 font-semibold w-[18%] text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($order->details as $i => $d)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $i + 1 }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded font-mono text-xs">{{ optional($d->barang)->kode ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-800">{{ optional($d->barang)->nama ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-center font-semibold text-slate-700">{{ $d->jumlah }}</td>
                        <td class="px-6 py-4 text-sm text-right text-slate-700">Rp {{ number_format($d->harga_beli, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-right font-bold text-slate-900">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-slate-300 bg-yellow-50">
                        <td colspan="5" class="px-6 py-5 text-right font-bold text-slate-800 text-lg">TOTAL :</td>
                        <td class="px-6 py-5 text-right font-bold text-xl text-slate-900">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Tombol Aksi Status --}}
    @if($order->status !== 'selesai' && $order->status !== 'batal')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Ubah Status Order</h3>
        <div class="flex flex-wrap gap-3">
            @if($order->status === 'menunggu')
                <form action="{{ route('adminPusat.order.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="diproses">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl font-medium transition flex items-center shadow-sm">
                        <i class="fa-solid fa-gear mr-2"></i> Tandai Diproses
                    </button>
                </form>
            @endif

    @if($order->status === 'diproses')
                <form id="form-selesai" action="{{ route('adminPusat.order.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="selesai">
                    <button type="button" onclick="confirmSelesai()" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-3 rounded-xl font-medium transition flex items-center shadow-sm">
                        <i class="fa-solid fa-check-double mr-2"></i> Tandai Selesai & Tambah Stok
                    </button>
                </form>
            @endif

            <form id="form-batal" action="{{ route('adminPusat.order.updateStatus', $order->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="batal">
                <button type="button" onclick="confirmBatal()" class="bg-red-100 hover:bg-red-500 hover:text-white text-red-600 px-6 py-3 rounded-xl font-medium transition flex items-center">
                    <i class="fa-solid fa-ban mr-2"></i> Batalkan Order
                </button>
            </form>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    function confirmSelesai() {
        Swal.fire({
            title: 'Tandai Selesai?',
            text: "Barang dari order ini akan otomatis ditambahkan ke stok Gudang Pusat.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Selesai & Tambah Stok!',
            cancelButtonText: 'Kembali'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-selesai').submit();
            }
        })
    }

    function confirmBatal() {
        Swal.fire({
            title: 'Batalkan Order?',
            text: "Apakah Anda yakin ingin membatalkan order supplier ini? Proses ini tidak dapat diubah.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Batalkan Order!',
            cancelButtonText: 'Tutup'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-batal').submit();
            }
        })
    }
</script>
@endpush
@endsection
