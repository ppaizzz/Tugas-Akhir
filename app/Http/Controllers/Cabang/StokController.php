<?php

namespace App\Http\Controllers\Cabang;

use App\Http\Controllers\Controller;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StokController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stoks = Stok::with('barang')->where('cabang_id', $user->cabang_id)->get();
        return view('kepalaCabang.stok.index', compact('stoks'));
    }

    public function update(Request $request, $id)
    {
        $stok = Stok::findOrFail($id);
        $stok->jumlah = $request->jumlah;
        $stok->save();
        return back()->with('success', 'Stok berhasil diperbarui.');
    }
}
