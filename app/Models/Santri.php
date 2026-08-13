<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Santri
 * 
 * Merepresentasikan data santri di Pondok Pesantren Alfurqoniyah.
 * Memiliki relasi ke tabel absensis, evaluasis, dan model lama
 * (aktivitasHarians, pelanggarans, hasilKlasifikasis) yang tetap
 * dipertahankan untuk backward compatibility.
 */
class Santri extends Model
{
    protected $fillable = ['nis', 'nama', 'jenis_kelamin', 'jenjang', 'kelas', 'ruang_pengajian', 'kamar', 'wali_kelas', 'status'];

    // =====================================================
    // RELASI BARU (Sesuai Spesifikasi Skripsi)
    // =====================================================

    /**
     * Relasi: Santri memiliki banyak data absensi
     */
    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    /**
     * Relasi: Santri memiliki banyak data evaluasi
     */
    public function evaluasis()
    {
        return $this->hasMany(Evaluasi::class);
    }

    // =====================================================
    // RELASI LAMA (Dipertahankan untuk backward compatibility)
    // =====================================================

    public function aktivitasHarians()
    {
        return $this->hasMany(AktivitasHarian::class);
    }

    public function pelanggarans()
    {
        return $this->hasMany(Pelanggaran::class);
    }

    public function hasilKlasifikasis()
    {
        return $this->hasMany(HasilKlasifikasi::class);
    }

    public function getStatusKedisiplinan($periode = null)
    {
        if (!$periode) {
            $periode = date('Y-m');
        }

        $hasil = $this->hasilKlasifikasis()->where('periode', $periode)->first();
        
        return $hasil ? $hasil->kategori_sistem : 'Belum Dievaluasi';
    }
}
