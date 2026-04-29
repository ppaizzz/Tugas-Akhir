<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $table = 'stok';

    protected $fillable = ['barang_id', 'cabang_id', 'jumlah', 'stok_minimum'];

    public function barang()
    {
        return $this->belongsTo(Product::class, 'barang_id');
    }

    public function cabang()
    {
        return $this->belongsTo(Branch::class, 'cabang_id');
    }
}
