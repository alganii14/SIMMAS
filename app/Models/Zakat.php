<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class zakat extends Model
{
    protected $fillable = [
        'no_zakat',
        'tanggal_zakat',
        'jam_zakat',
        'no_muzakki',
        'jenis_zakat',
        'jumlah_zakat',
        'jenis_bayar',
        'petugas_penerima',
        'berat_beras',
    ];

    protected $casts = [
        'tanggal_zakat' => 'date',
    ];

    // Relasi dengan model Muzakki
    public function muzakki()
    {
        return $this->belongsTo(Muzakki::class, 'no_muzakki', 'no_muzakki');
    }
}
