<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderSupplier extends Model
{
    protected $table = 'order_supplier';

    protected $fillable = ['supplier_id', 'admin_id', 'status', 'tanggal_order', 'tanggal_terima'];

    protected $casts = [
        'tanggal_order' => 'date',
        'tanggal_terima' => 'date',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function details()
    {
        return $this->hasMany(OrderSupplierDetail::class, 'order_id');
    }

    public function getTotalAttribute()
    {
        return $this->details->sum(function ($d) {
            return $d->jumlah * $d->harga_beli;
        });
    }
}
