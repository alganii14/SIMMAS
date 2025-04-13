<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'pengeluarans';

    // The attributes that are mass assignable.
    protected $fillable = [
        'no_pengajuan',
        'tanggal',
        'nama_koordinator',
        'koordinator_bidang',
        'jenis_pengeluaran',
        'jumlah',
        'keterangan',
        'user_id',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    /**
     * Get the user that owns the Pengeluaran.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
