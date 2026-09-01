<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model Pelanggaran
class Pelanggaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'santri_id',
        'tanggal',
        'kategori',
        'keterangan',
        'poin'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
