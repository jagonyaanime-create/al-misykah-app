<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $fillable = [
        'santri_id',
        'kategori',
        'keterangan',
        'bulan',
        'tahun',
        'jumlah',
        'tanggal_bayar',
        'bukti_bayar',
        'status'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }
}
