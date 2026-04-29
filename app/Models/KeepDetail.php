<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeepDetail extends Model
{
    protected $table = 'keep_detail';
    
    public $timestamps = false;

    protected $fillable = ['keep_id', 'barang_id', 'jumlah'];

    public function keepItem()
    {
        return $this->belongsTo(KeepItem::class, 'keep_id');
    }

    public function barang()
    {
        return $this->belongsTo(Product::class, 'barang_id');
    }
}
