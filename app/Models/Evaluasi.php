<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model Evaluasi
class Evaluasi extends Model
{
    // (#) Atribut Protected (Sesuai deklarasi protected $fillable di kode)
    protected $fillable = [
        'santri_id',
        'bulan',
        'tahun',
        'total_hadir_pengajian',
        'total_hari_pengajian',
        'total_hadir_sekolah',
        'total_hari_sekolah',
        'persentase_pengajian',
        'persentase_sekolah',
        'kategori_disiplin',
        'triggered_rule',
        'is_sent_to_bk',
        'is_sent_to_pengurus',
    ];

    // (+) Method Public: Relasi Santri
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
