<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model Room
class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = [
        'nama_kamar',
        'kapasitas',
    ];

    /**
     * Relasi: Satu Kamar memiliki banyak Santri (HasMany)
     */
    public function santris()
    {
        return $this->hasMany(Santri::class, 'kamar', 'nama_kamar');
    }
}
