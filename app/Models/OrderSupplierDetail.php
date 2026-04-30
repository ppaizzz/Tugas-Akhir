<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderSupplierDetail extends Model
{
    protected $table = 'order_supplier_detail';

    public $timestamps = false;

    protected $fillable = ['order_id', 'barang_id', 'jumlah', 'harga_beli'];

    public function order()
    {
        return $this->belongsTo(OrderSupplier::class, 'order_id');
    }

    public function barang()
    {
        return $this->belongsTo(Product::class, 'barang_id');
    }

    public function getSubtotalAttribute()
    {
        return $this->jumlah * $this->harga_beli;
    }
}
