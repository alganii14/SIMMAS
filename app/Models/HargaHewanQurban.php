<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NasabahQurban;
use App\Models\TabunganQurban;

class HargaHewanQurban extends Model
{
    protected $table = 'harga_hewan_qurban';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'jenis_hewan',
        'harga',
        'tahun_hijriah',
        'keterangan'
    ];

    public function nasabah()
    {
        return $this->hasMany(NasabahQurban::class, 'target_hewan_id');
    }

    public function tabungan()
    {
        return $this->hasMany(TabunganQurban::class, 'harga_hewan_id');
    }
}
