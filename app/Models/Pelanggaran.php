<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $table = 'pelanggaran';
    protected $fillable = [
        'santri_id',
        'jenis',
        'keterangan',
        'tanggal',
        'poin'
    ];

    public function santri()
    {
        // Pelanggaran 'belongsTo' (milik) Santri
        return $this->belongsTo(Santri::class, 'santri_id');
    }
}
