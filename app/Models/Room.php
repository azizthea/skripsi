<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Kamar (Room)
 * 
 * SKALABILITAS: Model ini berfungsi sebagai master data kamar.
 * Ketika pesantren membangun gedung baru atau menambah kamar,
 * pengurus cukup mendaftarkannya lewat antarmuka admin.
 * Tidak ada modifikasi kode yang diperlukan — sistem otomatis
 * memasukkan kamar baru ke dalam pilihan dropdown.
 */
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
