<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\KeepItem;
use App\Models\KeepDetail;
use App\Models\Stok;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KeepBarangController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $keeps = KeepItem::with('pelanggan', 'details.barang')
            ->where('cabang_id', $user->cabang_id)
            ->latest()
            ->get();
        return view('kasir.keep.index', compact('keeps'));
    }

    public function create()
    {
        $user = Auth::user();
        $stoks = Stok::with('barang')->where('cabang_id', $user->cabang_id)->where('jumlah', '>', 0)->get();
        return view('kasir.keep.create', compact('stoks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'telepon_pelanggan' => 'required',
            'barang_id' => 'required|array',
            'jumlah' => 'required|array',
            'batas_waktu_jam' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();

        $pelanggan = Pelanggan::firstOrCreate(
            ['telepon' => $request->telepon_pelanggan],
            ['nama' => $request->nama_pelanggan, 'is_member' => false]
        );

        $batas_waktu = Carbon::now()->addHours((int)$request->batas_waktu_jam);

        $keep = KeepItem::create([
            'kasir_id' => $user->id,
            'pelanggan_id' => $pelanggan->id,
            'cabang_id' => $user->cabang_id,
            'batas_waktu' => $batas_waktu,
            'status' => 'aktif',
        ]);

        foreach ($request->barang_id as $index => $barang_id) {
            $jumlah = $request->jumlah[$index];
            if ($jumlah > 0) {
                $stok = Stok::where('cabang_id', $user->cabang_id)->where('barang_id', $barang_id)->first();
                if ($stok && $stok->jumlah >= $jumlah) {
                    $stok->jumlah -= $jumlah;
                    $stok->save();

                    KeepDetail::create([
                        'keep_id' => $keep->id,
                        'barang_id' => $barang_id,
                        'jumlah' => $jumlah,
                    ]);
                }
            }
        }

        return redirect()->route('kasir.keep.index')->with('success', 'Barang berhasil di-keep dan stok dikurangi sementara.');
    }
}
