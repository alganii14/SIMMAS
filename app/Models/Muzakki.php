<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class muzakki extends Model
{
    protected $fillable = [
        'no_muzakki',
        'nama_muzakki',
        'telp_muzakki',
        'alamat_muzakki',
        'tanggal_input'
    ];

    protected $casts = [
        'tanggal_input' => 'datetime',
    ];
}
