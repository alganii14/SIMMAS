<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyaluran extends Model
{
    protected $primaryKey = 'no_penyaluran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_penyaluran',
        'tanggal_penyaluran',
        'jam_penyaluran',
        'petugas_penyaluran',
        'jenis_zakat',
        'total_penyaluran',
        'status_penyaluran',
        'keterangan'
    ];

    public function penerimas()
    {
        return $this->hasMany(PenyaluranPenerima::class, 'no_penyaluran', 'no_penyaluran');
    }
}
