<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermintaanController extends Controller
{
    public function index()
    {
        $permintaans = StockRequest::with('cabang')->latest()->get();
        return view('adminPusat.permintaan.index', compact('permintaans'));
    }

    public function detail($id)
    {
        $permintaan = StockRequest::with('details.barang', 'cabang')->findOrFail($id);
        return view('adminPusat.permintaan.detail', compact('permintaan'));
    }

    public function proses(Request $request, $id)
    {
        $permintaan = StockRequest::findOrFail($id);
        
        if ($request->action == 'siapkan') {
            $permintaan->status = 'disiapkan';
            $permintaan->admin_id = Auth::id();
            $permintaan->save();
            return back()->with('success', 'Status permintaan menjadi disiapkan.');
        } elseif ($request->action == 'kirim') {
            $permintaan->status = 'dikirim';
            if ($request->has('jumlah_dikirim')) {
                foreach ($request->jumlah_dikirim as $detail_id => $jumlah) {
                    $detail = \App\Models\StockRequestDetail::find($detail_id);
                    if ($detail) {
                        $detail->jumlah_dikirim = $jumlah;
                        $detail->save();
                    }
                }
            }
            $permintaan->save();
            return back()->with('success', 'Barang dikirim ke cabang.');
        }
    }
}
