<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Product::all();
        return view('adminPusat.barang.index', compact('barangs'));
    }

    public function store(Request $request)
    {
        Product::create($request->all());
        return back()->with('success', 'Barang berhasil ditambahkan.');
    }
}
