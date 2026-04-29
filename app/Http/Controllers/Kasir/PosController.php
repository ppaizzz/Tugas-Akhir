<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Stok;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Pelanggan;
use App\Models\KeepItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stoks = Stok::with('barang')->where('cabang_id', $user->cabang_id)->where('jumlah', '>', 0)->get();
        $pending_sales = Sale::where('cabang_id', $user->cabang_id)->where('status_bayar', 'pending')->latest()->get();
        return view('kasir.pos.index', compact('stoks', 'pending_sales'));
    }

    public function processDirect(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|array',
            'jumlah' => 'required|array',
            'metode_bayar' => 'required|in:tunai,transfer',
            'nama_pelanggan' => 'required'
        ]);

        $user = Auth::user();
        
        $pelanggan = Pelanggan::firstOrCreate(
            ['telepon' => $request->telepon_pelanggan ?? '-'],
            ['nama' => $request->nama_pelanggan, 'is_member' => false]
        );

        $total = 0;
        $itemsToProcess = [];

        foreach ($request->barang_id as $index => $barang_id) {
            $jumlah = $request->jumlah[$index];
            if ($jumlah > 0) {
                $stok = Stok::with('barang')->where('cabang_id', $user->cabang_id)->where('barang_id', $barang_id)->first();
                if ($stok && $stok->jumlah >= $jumlah) {
                    $harga = $stok->barang->harga;
                    $subtotal = $jumlah * $harga;
                    $total += $subtotal;
                    
                    $itemsToProcess[] = [
                        'stok' => $stok,
                        'barang_id' => $barang_id,
                        'jumlah' => $jumlah,
                        'harga_satuan' => $harga,
                        'subtotal' => $subtotal,
                    ];
                } else {
                    return back()->withErrors(['Stok barang tidak mencukupi untuk salah satu item.']);
                }
            }
        }

        if (count($itemsToProcess) == 0) {
            return back()->withErrors(['Tidak ada barang yang dipilih.']);
        }

        $status_bayar = ($request->metode_bayar == 'tunai') ? 'lunas' : 'pending';
        $nota = 'INV-' . time() . '-' . rand(100, 999);

        $sale = Sale::create([
            'nomor_nota' => $nota,
            'kasir_id' => $user->id,
            'pelanggan_id' => $pelanggan->id,
            'cabang_id' => $user->cabang_id,
            'keep_id' => null,
            'metode_bayar' => $request->metode_bayar,
            'total' => $total,
            'status_bayar' => $status_bayar,
        ]);

        foreach ($itemsToProcess as $item) {
            $stok = $item['stok'];
            $stok->jumlah -= $item['jumlah'];
            $stok->save();

            SaleItem::create([
                'transaksi_id' => $sale->id,
                'barang_id' => $item['barang_id'],
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $item['harga_satuan'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        return redirect()->route('kasir.pos.index')->with('success', 'Transaksi berhasil dibuat. (' . ucfirst($status_bayar) . ')');
    }

    public function checkoutKeep($id)
    {
        $keep = KeepItem::with('details.barang', 'pelanggan')->findOrFail($id);
        
        if ($keep->status != 'aktif') {
            return back()->withErrors(['Keep barang ini sudah tidak aktif.']);
        }
        
        return view('kasir.pos.checkout_keep', compact('keep'));
    }

    public function processKeep(Request $request, $id)
    {
        $request->validate([
            'metode_bayar' => 'required|in:tunai,transfer'
        ]);

        $user = Auth::user();
        $keep = KeepItem::with('details.barang')->findOrFail($id);
        
        if ($keep->status != 'aktif') {
            return redirect()->route('kasir.keep.index')->withErrors(['Keep barang sudah tidak aktif.']);
        }

        $total = 0;
        foreach ($keep->details as $d) {
            $total += ($d->jumlah * $d->barang->harga);
        }

        $nota = 'INV-' . time() . '-' . rand(100, 999);
        $status_bayar = ($request->metode_bayar == 'tunai') ? 'lunas' : 'pending';

        $sale = Sale::create([
            'nomor_nota' => $nota,
            'kasir_id' => $user->id,
            'pelanggan_id' => $keep->pelanggan_id,
            'cabang_id' => $user->cabang_id,
            'keep_id' => $keep->id,
            'metode_bayar' => $request->metode_bayar,
            'total' => $total,
            'status_bayar' => $status_bayar,
        ]);

        foreach ($keep->details as $d) {
            SaleItem::create([
                'transaksi_id' => $sale->id,
                'barang_id' => $d->barang_id,
                'jumlah' => $d->jumlah,
                'harga_satuan' => $d->barang->harga,
                'subtotal' => $d->jumlah * $d->barang->harga,
            ]);
        }

        $keep->status = 'selesai';
        $keep->save();

        if ($status_bayar == 'pending') {
            return redirect()->route('kasir.pos.index')->with('success', 'Transaksi Keep berhasil. Menunggu konfirmasi transfer.');
        }

        return redirect()->route('kasir.pos.index')->with('success', 'Transaksi Keep berhasil dilunasi secara tunai.');
    }

    public function konfirmasiTransfer($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->status_bayar = 'lunas';
        $sale->save();

        return back()->with('success', 'Pembayaran transfer telah dikonfirmasi dan lunas!');
    }
}
