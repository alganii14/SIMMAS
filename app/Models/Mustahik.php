<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mustahik extends Model
{
    protected $fillable = [
        'no_mustahik',
        'no_kk',
        'nama_mustahik',
        'alamat_mustahik',
        'asnaf',
        'tanggal_input',
        'rt',
        'jumlah_anak'
    ];

    protected $casts = [
        'tanggal_input' => 'datetime',
        'jumlah_anak' => 'integer'
    ];
}
