<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infaq extends Model
{
    use HasFactory;

    protected $table = 'infaqs'; // Nama tabel

    protected $fillable = [
        'no_penerimaan',
        'tanggal',
        'waktu',
        'donatur_id',
        'jenis_penerimaan',
        'jumlah',
        'status',
        'snap_token',
        'payment_type',
        'transaction_id',
        'transaction_time',
        'transaction_status'
    ];

    /**
     * Relasi ke model User (petugas).
     */
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    /**
     * Relasi ke model Donatur.
     */
    public function donatur()
    {
        return $this->belongsTo(Donatur::class, 'donatur_id');
    }
}