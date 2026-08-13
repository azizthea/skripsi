<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Kelas (KelasModel)
 * 
 * SKALABILITAS: Model ini berfungsi sebagai master data kelas.
 * Pengurus pesantren dapat menambah kelas baru kapan saja melalui 
 * antarmuka admin. Setiap kelas yang ditambah akan otomatis muncul
 * sebagai pilihan dropdown pada form registrasi santri.
 * 
 * Menggunakan nama class KelasModel untuk menghindari konflik
 * dengan reserved word 'class' di PHP.
 */
class KelasModel extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'nama_kelas',
        'jenjang',
    ];

    /**
     * Relasi: Satu Kelas memiliki banyak Santri (HasMany)
     * Foreign Key Constraint menjamin integritas data:
     * Santri hanya bisa merujuk ke kelas yang terdaftar di sistem.
     */
    public function santris()
    {
        return $this->hasMany(Santri::class, 'kelas', 'nama_kelas');
    }
}
