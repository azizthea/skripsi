<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilKlasifikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'santri_id',
        'periode',
        'skor_numerik',
        'kategori_sistem',
        'kategori_pakar',
        'triggered_rules_json',
        'is_accurate'
    ];

    protected $casts = [
        'triggered_rules_json' => 'array',
        'is_accurate' => 'boolean',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
