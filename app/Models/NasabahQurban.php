<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NasabahQurban extends Model
{
    protected $table = 'nasabah_qurban';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nik',
        'nama',
        'hp',
        'alamat',
        'ref_id',
        'target_hewan_id'
    ];

    protected $appends = ['total_tabungan', 'sisa_tabungan'];

    public function targetHewan()
    {
        return $this->belongsTo(HargaHewanQurban::class, 'target_hewan_id');
    }

    public function tabungan()
    {
        return $this->hasMany(TabunganQurban::class, 'nasabah_id');
    }

    public function getTotalTabunganAttribute()
    {
        return $this->tabungan()->sum('jumlah_setoran');
    }

    public function getSisaTabunganAttribute()
    {
        $target = $this->targetHewan ? $this->targetHewan->harga : 0;
        return $target - $this->total_tabungan;
    }
}
