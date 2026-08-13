<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Evaluasi
 * 
 * Merepresentasikan hasil evaluasi klasifikasi kedisiplinan santri
 * untuk satu periode (bulan/tahun). Menyimpan persentase kehadiran
 * dan kategori disiplin yang dihasilkan oleh Forward Chaining.
 */
class Evaluasi extends Model
{
    protected $fillable = [
        'santri_id',
        'bulan',
        'tahun',
        // Audit trail: data mentah
        'total_hadir_pengajian',
        'total_hari_pengajian',
        'total_hadir_sekolah',
        'total_hari_sekolah',
        // Hasil perhitungan
        'persentase_pengajian',
        'persentase_sekolah',
        // Hasil klasifikasi
        'kategori_disiplin',    // Enum: 'Tinggi', 'Sedang', 'Rendah'
        'triggered_rule',       // Nama rule yang terpicu
        // Tracking EWS
        'is_sent_to_bk',
        'is_sent_to_pengurus',
    ];

    /**
     * Relasi: Evaluasi milik satu Santri
     */
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
