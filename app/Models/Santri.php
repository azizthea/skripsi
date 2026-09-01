<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model Santri
class Santri extends Model
{
    // (#) Atribut Protected (Sesuai deklarasi protected $fillable di kode)
    protected $fillable = ['nis', 'nama', 'jenis_kelamin', 'jenjang', 'kelas', 'ruang_pengajian', 'kamar', 'wali_kelas', 'status'];

    // (+) Method Public: Relasi Absensi
    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    // (+) Method Public: Relasi Evaluasi
    public function evaluasis()
    {
        return $this->hasMany(Evaluasi::class);
    }

    // (+) Method Public: Relasi Aktivitas Harian
    public function aktivitasHarians()
    {
        return $this->hasMany(AktivitasHarian::class);
    }

    // (+) Method Public: Relasi Pelanggaran
    public function pelanggarans()
    {
        return $this->hasMany(Pelanggaran::class);
    }

    // (+) Method Public: Relasi Hasil Klasifikasi
    public function hasilKlasifikasis()
    {
        return $this->hasMany(HasilKlasifikasi::class);
    }

    // (+) Method Public: Status Kedisiplinan
    public function getStatusKedisiplinan($periode = null)
    {
        if (!$periode) {
            $periode = date('Y-m');
        }

        $hasil = $this->hasilKlasifikasis()->where('periode', $periode)->first();
        
        return $hasil ? $hasil->kategori_sistem : 'Belum Dievaluasi';
    }
}
