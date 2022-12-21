<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beli extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nama_produk',
        'jumlah'
    ];

}
