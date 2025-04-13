<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShohibulQurban extends Model
{
    protected $fillable = [
        'id',
        'tahun_hijriah',
        'nik',
        'nama',
        'hp',
        'alamat',
        'jenis_hewan',
        'berat',
        'bagian_diminta',
        'tanggal'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function details()
    {
        return $this->hasMany(ShohibulQurbanDetail::class, 'sq_id', 'id');
    }
}
