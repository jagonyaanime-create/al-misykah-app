<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiSholat extends Model
{
    protected $table = 'absensi_sholat';

    protected $fillable = [
        'santri_id',
        'tanggal',
        'waktu',
        'status'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }
}