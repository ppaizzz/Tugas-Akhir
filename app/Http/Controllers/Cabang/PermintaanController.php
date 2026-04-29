<?php

namespace App\Http\Controllers\Cabang;

use App\Http\Controllers\Controller;
use App\Models\StockRequest;
use App\Models\StockRequestDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermintaanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $permintaans = StockRequest::where('cabang_id', $user->cabang_id)->latest()->get();
        return view('kepalaCabang.permintaan.index', compact('permintaans'));
    }

    public function create()
    {
        $barangs = Product::all();
        return view('kepalaCabang.permintaan.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|array',
            'jumlah' => 'required|array',
        ]);

        $user = Auth::user();

        $permintaan = StockRequest::create([
            'cabang_id' => $user->cabang_id,
            'kepala_cabang_id' => $user->id,
            'status' => 'diajukan',
            'catatan' => $request->catatan,
        ]);

        foreach ($request->barang_id as $index => $barang_id) {
            if ($request->jumlah[$index] > 0) {
                StockRequestDetail::create([
                    'permintaan_id' => $permintaan->id,
                    'barang_id' => $barang_id,
                    'jumlah_diminta' => $request->jumlah[$index],
                    'jumlah_dikirim' => 0,
                ]);
            }
        }

        return redirect()->route('kepalaCabang.permintaan.index')->with('success', 'Permintaan barang berhasil diajukan.');
    }

    public function terima($id)
    {
        $permintaan = StockRequest::findOrFail($id);
        $permintaan->status = 'selesai';
        $permintaan->save();

        foreach ($permintaan->details as $detail) {
            $stok = \App\Models\Stok::firstOrCreate(
                ['cabang_id' => $permintaan->cabang_id, 'barang_id' => $detail->barang_id],
                ['jumlah' => 0, 'stok_minimum' => 5]
            );
            $stok->jumlah += $detail->jumlah_dikirim;
            $stok->save();
        }

        return back()->with('success', 'Barang berhasil diterima dan stok diperbarui.');
    }
}
