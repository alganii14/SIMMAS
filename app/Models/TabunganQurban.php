<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TabunganQurban extends Model
{
    protected $table = 'tabungan_qurban';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nasabah_id',
        'harga_hewan_id',
        'jumlah_setoran',
        'tanggal_setor',
        'keterangan'
    ];

    public function nasabah()
    {
        return $this->belongsTo(NasabahQurban::class, 'nasabah_id');
    }

    public function hargaHewan()
    {
        return $this->belongsTo(HargaHewanQurban::class, 'harga_hewan_id');
    }

    public static function getTotalSaldo()
    {
        return self::sum('jumlah_setoran');
    }
}
