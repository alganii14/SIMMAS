<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenyaluranPenerima extends Model
{
    protected $fillable = [
        'no_penyaluran',
        'no_mustahik',
        'jumlah_terima',
        'status_penerima'
    ];

    public function penyaluran()
    {
        return $this->belongsTo(Penyaluran::class, 'no_penyaluran', 'no_penyaluran');
    }

    public function mustahik()
    {
        return $this->belongsTo(Mustahik::class, 'no_mustahik', 'no_mustahik');
    }
}
