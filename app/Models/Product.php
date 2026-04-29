<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'barang';

    protected $fillable = ['kode', 'nama', 'kategori', 'harga', 'deskripsi'];

    public function stoks()
    {
        return $this->hasMany(Stok::class, 'barang_id');
    }
}
