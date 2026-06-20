<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;

    protected $table = 'santri';

    protected $fillable = [
        'user_id',
        'nama',
        'nis',
        'foto',
        'status',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'kelas', // ini kelas formal
        'kelas_muhadhoroh',
        'kamar',
        'wali',
        'alamat',
        'no_hp'
    ];

    // app/Models/Santri.php

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'santri_id');
    }

    // TAMBAHKAN INI JUGA:
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'santri_id');
    }
}