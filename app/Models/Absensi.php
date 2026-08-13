<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Absensi
 * 
 * Merepresentasikan data kehadiran harian santri pada kegiatan
 * Pengajian atau Sekolah. Setiap record adalah satu kehadiran
 * satu santri pada satu jenis kegiatan di satu tanggal.
 */
class Absensi extends Model
{
    protected $fillable = [
        'santri_id',
        'user_id',
        'jenis_kegiatan',  // Enum: 'Pengajian', 'Sekolah'
        'tanggal',
        'status',           // Enum: 'Hadir', 'Izin', 'Alpa'
        'keterangan',       // Keterangan khusus (misalnya alasan izin)
        'bukti_izin',       // Path/URL ke file bukti surat izin/dokter
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Relasi: Absensi milik satu Santri
     */
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    /**
     * Relasi: Absensi diinput oleh Guru (User)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
