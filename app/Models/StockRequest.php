<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockRequest extends Model
{
    protected $table = 'permintaan_barang';

    protected $fillable = ['cabang_id', 'admin_id', 'kepala_cabang_id', 'status', 'catatan'];

    public function cabang()
    {
        return $this->belongsTo(Branch::class, 'cabang_id');
    }
    
    public function details()
    {
        return $this->hasMany(StockRequestDetail::class, 'permintaan_id');
    }
}
