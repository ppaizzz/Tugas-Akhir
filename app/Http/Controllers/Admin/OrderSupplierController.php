<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderSupplier;
use App\Models\OrderSupplierDetail;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderSupplierController extends Controller
{
    public function index()
    {
        $orders = OrderSupplier::with('supplier', 'admin', 'details.barang')
            ->latest()
            ->get();

        return view('adminPusat.order-supplier.index', compact('orders'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();

        return view('adminPusat.order-supplier.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:supplier,id',
            'tanggal_order' => 'required|date',
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'required|exists:barang,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'harga_beli' => 'required|array|min:1',
            'harga_beli.*' => 'required|numeric|min:0',
        ], [
            'supplier_id.required' => 'Supplier wajib dipilih.',
            'tanggal_order.required' => 'Tanggal order wajib diisi.',
            'barang_id.required' => 'Minimal 1 barang harus ditambahkan.',
            'barang_id.min' => 'Minimal 1 barang harus ditambahkan.',
        ]);

        DB::beginTransaction();
        try {
            $order = OrderSupplier::create([
                'supplier_id' => $request->supplier_id,
                'admin_id' => Auth::id(),
                'status' => 'menunggu',
                'tanggal_order' => $request->tanggal_order,
            ]);

            foreach ($request->barang_id as $i => $barangId) {
                OrderSupplierDetail::create([
                    'order_id' => $order->id,
                    'barang_id' => $barangId,
                    'jumlah' => $request->jumlah[$i],
                    'harga_beli' => $request->harga_beli[$i],
                ]);
            }

            DB::commit();
            return redirect()->route('adminPusat.order.index')->with('success', 'Order supplier berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal membuat order: ' . $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        $order = OrderSupplier::with('supplier', 'admin', 'details.barang')->findOrFail($id);

        return view('adminPusat.order-supplier.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = OrderSupplier::with('details')->findOrFail($id);
        $newStatus = $request->status;

        if ($newStatus === 'selesai' && $order->status !== 'selesai') {
            DB::beginTransaction();
            try {
                // Tambahkan stok ke gudang pusat (cabang_id = null atau cabang pertama)
                foreach ($order->details as $detail) {
                    // Cari stok di gudang pusat, asumsikan cabang_id terkecil sebagai pusat
                    $stok = Stok::where('barang_id', $detail->barang_id)
                        ->orderBy('cabang_id', 'asc')
                        ->first();

                    if ($stok) {
                        $stok->jumlah += $detail->jumlah;
                        $stok->save();
                    } else {
                        // Buat stok baru jika belum ada
                        Stok::create([
                            'barang_id' => $detail->barang_id,
                            'cabang_id' => 1, // Default cabang pusat
                            'jumlah' => $detail->jumlah,
                            'stok_minimum' => 10,
                        ]);
                    }
                }

                $order->status = 'selesai';
                $order->tanggal_terima = now();
                $order->save();

                DB::commit();
                return back()->with('success', 'Order ditandai selesai dan stok telah ditambahkan!');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Gagal memperbarui status: ' . $e->getMessage()]);
            }
        }

        $order->status = $newStatus;
        if ($newStatus === 'batal') {
            $order->save();
            return back()->with('success', 'Order telah dibatalkan.');
        }

        $order->save();
        return back()->with('success', 'Status order diperbarui menjadi "' . $newStatus . '".');
    }
}
