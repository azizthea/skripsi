<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model KelasModel
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
