<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'cabang';

    protected $fillable = ['nama', 'alamat', 'telepon'];

    public function stoks()
    {
        return $this->hasMany(Stok::class, 'cabang_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'cabang_id');
    }
}
