<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $table = 'transaksi_detail';
    
    public $timestamps = false;

    protected $fillable = ['transaksi_id', 'barang_id', 'jumlah', 'harga_satuan', 'subtotal'];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'transaksi_id');
    }

    public function barang()
    {
        return $this->belongsTo(Product::class, 'barang_id');
    }
}
