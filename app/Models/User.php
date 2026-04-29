<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'cabang_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function cabang()
    {
        return $this->belongsTo(Branch::class, 'cabang_id');
    }
}