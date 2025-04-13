<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembagianProduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk',
        'berat',
        'total_bungkus',
        'berat_perproduk'
    ];

    protected $casts = [
        'berat' => 'decimal:2',
        'berat_perproduk' => 'decimal:2',
        'total_bungkus' => 'integer'
    ];
}
