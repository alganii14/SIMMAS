<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donatur extends Model
{
    // Menentukan nama tabel jika berbeda dari nama model
    protected $table = 'donaturs';

    // Kolom yang dapat diisi secara mass-assignment
    protected $fillable = [
        'no_donatur',
        'nama',
        'no_telepon',
        'pekerjaan',
        'alamat',
        'email',
        'anonim',
        'pesan_doa', // Tambahkan kolom pesan_doa
    ];

    // Kolom yang dilindungi dari mass-assignment (jika ada)
    protected $guarded = [
        'id',
    ];

    // Menentukan apakah timestamps digunakan
    public $timestamps = true;
    
    /**
     * Relasi dengan infaq.
     */
    public function infaqs()
    {
        return $this->hasMany(Infaq::class, 'donatur_id');
    }
}