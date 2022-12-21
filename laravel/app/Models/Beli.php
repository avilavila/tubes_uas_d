<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beli extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_produk',
        'jumlah'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'id_user');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class,'id_produk');
    }
}
