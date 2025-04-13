<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PenerimaQurban extends Model
{
    use HasUuids;

    protected $table = 'penerima_qurban';
    
    protected $fillable = [
        'nik',
        'nama',
        'tahun_hijriah',
        'status',
        'alamat',
        'rt',
        'rw',
        'role'
    ];
}
