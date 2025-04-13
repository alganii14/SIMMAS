<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kajian extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_kajian',
        'deskripsi_kajian',
        'tanggal_kajian',
        'foto_kajian',
        'foto_ustad',
        'nama_ustad',
    ];
}
