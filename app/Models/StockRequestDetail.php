<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockRequestDetail extends Model
{
    protected $table = 'permintaan_detail';
    
    public $timestamps = false;

    protected $fillable = ['permintaan_id', 'barang_id', 'jumlah_diminta', 'jumlah_dikirim'];

    public function permintaan()
    {
        return $this->belongsTo(StockRequest::class, 'permintaan_id');
    }

    public function barang()
    {
        return $this->belongsTo(Product::class, 'barang_id');
    }
}
