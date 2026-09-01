<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model Absensi
class Absensi extends Model
{
    // (#) Atribut Protected (deklarasi protected $fillable)
    protected $fillable = [
        'santri_id',
        'user_id',
        'jenis_kegiatan',
        'tanggal',
        'status',
        'keterangan',
        'bukti_izin',
    ];

    // (-) Atribut Data Private: Casts
    protected $casts = [
        'tanggal' => 'date',
    ];

    // (+) Method Public: Relasi Santri
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    // (+) Method Public: Relasi User/Guru
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
