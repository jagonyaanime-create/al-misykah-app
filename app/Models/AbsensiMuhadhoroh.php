<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiMuhadhoroh extends Model
{
    protected $table = 'absensi_muhadhoroh';

    protected $fillable = [
        'santri_id',
        'tanggal',
        'sesi',
        'status'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }
}
