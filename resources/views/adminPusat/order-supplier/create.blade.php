@extends('layouts.app')
@section('title', 'Buat Order Supplier - Admin Pusat')
@section('header', 'Buat Order Supplier')

@section('content')
<div class="max-w-5xl">
    <form action="{{ route('adminPusat.order.store') }}" method="POST" id="orderForm">
        @csrf

        {{-- Info Order --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
            <h2 class="text-lg font-bold text-slate-800 mb-5 flex items-center">
                <span class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center text-sm font-bold mr-3">1</span>
                Informasi Order
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Supplier <span class="text-red-500">*</span></label>
                    <select name="supplier_id" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 bg-slate-50 text-slate-800 transition">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $s)
                            <option value="{{ $s->id }}" {{ old('supplier_id') == $s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Order <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_order" value="{{ old('tanggal_order', date('Y-m-d')) }}" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 bg-slate-50 text-slate-800 transition">
                    @error('tanggal_order') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Daftar Barang --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-lg font-bold text-slate-800 flex items-center">
                    <span class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center text-sm font-bold mr-3">2</span>
                    Daftar Barang Dipesan
                </h2>
                <button type="button" onclick="addRow()" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center">
                    <i class="fa-solid fa-plus mr-2"></i> Tambah Barang
                </button>
            </div>

            @error('barang_id')
                <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm">
                    <i class="fa-solid fa-triangle-exclamation mr-1"></i> {{ $message }}
                </div>
            @enderror

            <div class="overflow-x-auto">
                <table class="w-full text-left" id="itemsTable">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-600 text-sm">
                            <th class="px-4 py-3 font-semibold w-[40%]">Nama Barang</th>
                            <th class="px-4 py-3 font-semibold w-[15%]">Jumlah</th>
                            <th class="px-4 py-3 font-semibold w-[25%]">Harga Beli (Rp)</th>
                            <th class="px-4 py-3 font-semibold w-[15%] text-right">Subtotal</th>
                            <th class="px-4 py-3 font-semibold w-[5%]"></th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody">
                        {{-- Row template akan ditambahkan oleh JS --}}
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-slate-300">
                            <td colspan="3" class="px-4 py-4 text-right font-bold text-slate-800 text-lg">TOTAL ESTIMASI :</td>
                            <td class="px-4 py-4 text-right font-bold text-lg text-slate-900" id="grandTotal">Rp 0</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Tombol Submit --}}
        <div class="flex items-center gap-4">
            <button type="submit" class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-slate-900 px-8 py-3.5 rounded-xl font-bold hover:from-yellow-500 hover:to-yellow-600 transition-all shadow-lg shadow-yellow-500/20 flex items-center text-lg">
                <i class="fa-solid fa-paper-plane mr-3"></i> Kirim Order
            </button>
            <button type="button" onclick="confirmBatalForm()" class="bg-slate-200 text-slate-700 px-6 py-3.5 rounded-xl font-medium hover:bg-slate-300 transition">
                Batal
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function confirmBatalForm() {
        Swal.fire({
            title: 'Batalkan Pembuatan?',
            text: "Data order yang sudah diisi akan hilang.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Kembali'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('adminPusat.order.index') }}";
            }
        })
    }
    // Data produk untuk dropdown
    var products = @json($products);
    var rowCount = 0;

    function addRow() {
        rowCount++;
        var tbody = document.getElementById('itemsBody');
        var tr = document.createElement('tr');
        tr.className = 'border-b border-slate-100 item-row';
        tr.id = 'row-' + rowCount;
        tr.innerHTML = `
            <td class="px-4 py-3">
                <select name="barang_id[]" required onchange="updateRow(this)" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 bg-slate-50 text-sm">
                    <option value="">-- Pilih Barang --</option>
                    ${products.map(p => `<option value="${p.id}" data-harga="${p.harga}">${p.kode} - ${p.nama}</option>`).join('')}
                </select>
            </td>
            <td class="px-4 py-3">
                <input type="number" name="jumlah[]" min="1" value="1" required oninput="calcSubtotal(this)" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 bg-slate-50 text-sm text-center">
            </td>
            <td class="px-4 py-3">
                <input type="number" name="harga_beli[]" min="0" value="0" required oninput="calcSubtotal(this)" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 bg-slate-50 text-sm harga-input">
            </td>
            <td class="px-4 py-3 text-right font-semibold text-slate-800 subtotal-cell">Rp 0</td>
            <td class="px-4 py-3 text-center">
                <button type="button" onclick="removeRow('row-${rowCount}')" class="w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 text-red-500 transition flex items-center justify-center">
                    <i class="fa-solid fa-trash-can text-xs"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    }

    function updateRow(select) {
        var row = select.closest('tr');
        var selected = select.options[select.selectedIndex];
        var harga = selected.getAttribute('data-harga') || 0;
        row.querySelector('.harga-input').value = Math.round(harga);
        calcSubtotal(select);
    }

    function calcSubtotal(el) {
        var row = el.closest('tr');
        var jumlah = parseInt(row.querySelector('input[name="jumlah[]"]').value) || 0;
        var harga = parseFloat(row.querySelector('input[name="harga_beli[]"]').value) || 0;
        var subtotal = jumlah * harga;
        row.querySelector('.subtotal-cell').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        calcGrandTotal();
    }

    function calcGrandTotal() {
        var total = 0;
        document.querySelectorAll('.item-row').forEach(function(row) {
            var jumlah = parseInt(row.querySelector('input[name="jumlah[]"]').value) || 0;
            var harga = parseFloat(row.querySelector('input[name="harga_beli[]"]').value) || 0;
            total += jumlah * harga;
        });
        document.getElementById('grandTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    function removeRow(id) {
        var row = document.getElementById(id);
        if (row) {
            row.remove();
            calcGrandTotal();
        }
    }

    // Tambahkan 1 baris default saat halaman dimuat
    addRow();
</script>
@endpush
@endsection
