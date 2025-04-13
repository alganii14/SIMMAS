<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Petugas extends Model
{
    use HasUuids;

    protected $table = 'petugas';
    protected $fillable = ['nik', 'nama', 'tahun_hijriah', 'status', 'role'];
}
