<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sholat extends Model
{
    use HasFactory;

    protected $fillable = ['nama_sholat', 'waktu_sholat', 'waktu_iqomah'];
}
