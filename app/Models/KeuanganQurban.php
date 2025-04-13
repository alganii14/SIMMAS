<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeuanganQurban extends Model
{
    protected $table = 'keuangan_qurban';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'no_transaksi',
        'tanggal',
        'jenis',
        'jumlah',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2'
    ];

    public static function generateNoTransaksi($jenis)
    {
        $prefix = $jenis === 'Masuk' ? 'KQM' : 'KQK';
        $tanggal = now()->format('dmy');
        $lastRecord = self::where('no_transaksi', 'like', $prefix . $tanggal . '%')
            ->orderBy('no_transaksi', 'desc')
            ->first();

        if ($lastRecord) {
            $lastNumber = (int)substr($lastRecord->no_transaksi, -3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $tanggal . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public static function getSaldo()
    {
        $masuk = self::where('jenis', 'Masuk')->sum('jumlah');
        $keluar = self::where('jenis', 'Keluar')->sum('jumlah');
        return $masuk - $keluar;
    }
}
