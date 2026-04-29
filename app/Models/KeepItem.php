<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeepItem extends Model
{
    protected $table = 'keep_barang';

    protected $fillable = ['kasir_id', 'pelanggan_id', 'cabang_id', 'batas_waktu', 'status'];

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
        return $this->hasMany(KeepDetail::class, 'keep_id');
    }
}
