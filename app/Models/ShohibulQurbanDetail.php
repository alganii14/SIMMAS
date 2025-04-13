<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShohibulQurbanDetail extends Model
{
    protected $fillable = [
        'id',
        'sq_id',
        'nama',
        'bin_or_binti',
        'bin_or_binti_value'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function shohibulQurban()
    {
        return $this->belongsTo(ShohibulQurban::class, 'sq_id', 'id');
    }
}
