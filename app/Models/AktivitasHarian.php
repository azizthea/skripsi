<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktivitasHarian extends Model
{
    protected $fillable = [
        'santri_id',
        'tanggal',
        'sholat_berjamaah',
        'mengaji',
        'sekolah',
        'jumlah_pelanggaran'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
