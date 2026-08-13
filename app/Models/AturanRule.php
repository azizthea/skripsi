<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AturanRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_rule',
        'prioritas',
        'kondisi_json',
        'hasil_kategori',
        'is_active'
    ];

    protected $casts = [
        'kondisi_json' => 'array',
        'is_active' => 'boolean',
    ];
}
