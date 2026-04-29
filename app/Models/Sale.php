<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'transaksi';

    protected $fillable = ['nomor_nota', 'kasir_id', 'pelanggan_id', 'cabang_id', 'keep_id', 'metode_bayar', 'total', 'status_bayar'];

    public function cabang()
    {
        return $this->belongsTo(Branch::class, 'cabang_id');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }
    
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function details()
    {
        return $this->hasMany(SaleItem::class, 'transaksi_id');
    }
}
