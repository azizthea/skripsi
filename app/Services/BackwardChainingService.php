<?php

namespace App\Services;

use App\Models\Evaluasi;
use App\Models\Absensi;

// BackwardChainingService
class BackwardChainingService
{
    /**
     * Mendiagnosis penyebab indisipliner santri (Bertindak seperti Pakar BK).
     * 
     * @param Evaluasi $evaluasi
     * @param string $jenis
     * @return array
     */
    public function diagnose(Evaluasi $evaluasi, string $jenis = 'pengajian'): array
    {
        // 1. Kumpulkan Fakta Mendalam (Deep Fact Gathering)
        // Ambil data absensi sebulan pada periode yang sama
        $absensis = Absensi::where('santri_id', $evaluasi->santri_id)
            ->whereMonth('tanggal', $evaluasi->bulan)
            ->whereYear('tanggal', $evaluasi->tahun)
            ->get();

        $pengajianSubjects = ['Al-Quran', 'Fiqih', 'Tafsir', 'Hadits', 'Akhlak', 'Bahasa Arab', 'Pengajian'];
        $sekolahSubjects = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS', 'PKn', 'Sekolah'];

        // Menghitung jenis ketidakhadiran
        $fakta = [
            'alpa_pengajian'  => $absensis->whereIn('jenis_kegiatan', $pengajianSubjects)->where('status', 'Alpa')->count(),
            'sakit_pengajian' => $absensis->whereIn('jenis_kegiatan', $pengajianSubjects)->where('status', 'Sakit')->count(),
            'izin_pengajian'  => $absensis->whereIn('jenis_kegiatan', $pengajianSubjects)->where('status', 'Izin')->count(),
            
            'alpa_sekolah'  => $absensis->whereIn('jenis_kegiatan', $sekolahSubjects)->where('status', 'Alpa')->count(),
            'sakit_sekolah' => $absensis->whereIn('jenis_kegiatan', $sekolahSubjects)->where('status', 'Sakit')->count(),
            'izin_sekolah'  => $absensis->whereIn('jenis_kegiatan', $sekolahSubjects)->where('status', 'Izin')->count(),
            
            'persentase_pengajian' => $evaluasi->persentase_pengajian,
            'persentase_sekolah'   => $evaluasi->persentase_sekolah,
            'kategori'             => $evaluasi->kategori_disiplin
        ];

        // Hitung total ketidakhadiran
        $totalSakit = $fakta['sakit_pengajian'] + $fakta['sakit_sekolah'];
        $totalIzin  = $fakta['izin_pengajian'] + $fakta['izin_sekolah'];
        $totalAlpa  = $fakta['alpa_pengajian'] + $fakta['alpa_sekolah'];
        
        // Hitung validitas dokumen (Surat Izin / Sakit)
        $totalBukti = $absensis->filter(function($absen) {
            return !empty($absen->bukti_izin);
        })->count();

        // =================================================================
        // BACKWARD CHAINING: Menguji Hipotesis dengan TRACE (User-Friendly Explanation)
        // =================================================================
        
        $diagnosis = [];
        $trace = []; // Menyimpan jejak penalaran (Tracing) yang sudah disederhanakan

        $trace[] = "Melakukan analisis menyeluruh terhadap data absensi...";

        if (in_array($fakta['kategori'], ['Disiplin', 'Tinggi'])) {
            $trace[] = "Persentase kehadiran berada pada kategori Tinggi/Disiplin.";
            $trace[] = "Tidak ditemukan pola ketidakhadiran yang mencurigakan.";
            return [
                'status' => 'success',
                'kesimpulan' => 'Santri sudah memiliki tingkat kedisiplinan yang sangat baik. Tidak terindikasi masalah perilaku.',
                'saran' => 'Pertahankan prestasi dan berikan apresiasi (reward).',
                'trace' => $trace
            ];
        }
        $trace[] = "Persentase kehadiran berada di bawah batas minimal kategori Disiplin.";

        // Pihak yang bertanggung jawab berdasarkan jenis evaluasi
        $pic = ($jenis === 'sekolah') ? 'Guru BK' : 'Pengurus Kesantrian / Wali Kamar';

        // Penjelasan "Gangguan Kesehatan Fisik"
        if ($totalSakit > $totalAlpa && $totalSakit > $totalIzin && $totalSakit >= 3) {
            $trace[] = "Ketidakhadiran lebih banyak disebabkan oleh kondisi Sakit dibandingkan izin maupun tanpa keterangan.";
            
            if ($totalBukti > 0) {
                $trace[] = "Terdapat $totalBukti lampiran bukti (Surat Dokter/Poskestren) yang tervalidasi di sistem.";
                $trace[] = "Berdasarkan hasil analisis, sistem menyimpulkan bahwa ketidakhadiran murni disebabkan oleh masalah kesehatan yang sah.";
                return [
                    'status' => 'info',
                    'kesimpulan' => 'Terindikasi masalah kesehatan fisik (Sah & Tervalidasi).',
                    'bukti' => "Ditemukan $totalSakit kali absen 'Sakit' dengan $totalBukti dokumen pendukung.",
                    'saran' => $pic . ' perlu memberikan maklum/dispensasi dan membantu santri mengejar ketertinggalan materi pelajaran. Tidak perlu ada sanksi.',
                    'trace' => $trace
                ];
            } else {
                $trace[] = "Namun, TIDAK DITEMUKAN adanya surat/bukti dari dokter atau Poskestren yang dilampirkan.";
                $trace[] = "Berdasarkan hasil analisis, sistem mencurigai kemungkinan alasan sakit yang dibuat-buat (mangkir).";
                return [
                    'status' => 'warning',
                    'kesimpulan' => 'Terindikasi masalah kesehatan fisik (Tanpa Bukti Resmi).',
                    'bukti' => "Ditemukan $totalSakit kali absen dengan status 'Sakit', namun 0 dokumen pendukung.",
                    'saran' => $pic . ' perlu segera mengecek ke Poskestren (Pos Kesehatan Pesantren) atau memanggil santri untuk memvalidasi alasan sakitnya.',
                    'trace' => $trace
                ];
            }
        }
        $trace[] = "Tidak ditemukan pola yang menunjukkan bahwa ketidakhadiran disebabkan oleh kondisi kesehatan berulang.";

        // Penjelasan "Kehilangan Minat pada Pendidikan Formal (Sekolah)"
        if ($fakta['persentase_pengajian'] >= 75 && $fakta['persentase_sekolah'] < 75 && $fakta['alpa_sekolah'] > 0) {
            $trace[] = "Ditemukan bahwa kehadiran santri pada program Pengajian masih tergolong baik.";
            $trace[] = "Namun sebaliknya, kehadiran santri di Sekolah tergolong rendah dengan adanya rekam jejak tanpa keterangan (alpa).";
            $trace[] = "Hal ini mengindikasikan santri mengalami penurunan minat khusus pada pendidikan formal.";
            return [
                'status' => 'danger',
                'kesimpulan' => 'Terindikasi kehilangan motivasi/minat pada Pendidikan Formal (Sekolah).',
                'bukti' => "Kehadiran Pengajian baik ({$fakta['persentase_pengajian']}%), namun kehadiran Sekolah rendah ({$fakta['persentase_sekolah']}%) dengan jumlah bolos/Alpa {$fakta['alpa_sekolah']} kali.",
                'saran' => $pic . ' perlu melakukan pendekatan persuasif untuk mengetahui kendala belajar di kelas formal.',
                'trace' => $trace
            ];
        }
        $trace[] = "Tidak ditemukan perbedaan yang mencolok mengenai penurunan minat di lingkungan Sekolah formal.";

        // Penjelasan "Kelelahan Ekstra / Kurang Minat pada Kepesantrenan"
        if ($fakta['persentase_sekolah'] >= 75 && $fakta['persentase_pengajian'] < 75 && $fakta['alpa_pengajian'] > 0) {
            $trace[] = "Ditemukan bahwa kehadiran santri pada program Sekolah formal masih tergolong baik.";
            $trace[] = "Namun sebaliknya, kehadiran santri di Pengajian tergolong rendah dengan adanya rekam jejak tanpa keterangan (alpa).";
            $trace[] = "Hal ini mengindikasikan santri mengalami kelelahan ekstra di asrama atau kurang minat pada pendidikan Diniyah.";
            return [
                'status' => 'danger',
                'kesimpulan' => 'Terindikasi kelelahan ekstra atau kurang minat pada program Kepesantrenan (Diniyah).',
                'bukti' => "Kehadiran Sekolah formal baik ({$fakta['persentase_sekolah']}%), namun sering membolos di waktu Pengajian ({$fakta['alpa_pengajian']} kali Alpa).",
                'saran' => $pic . ' perlu memantau aktivitas santri di asrama, pastikan santri tidak terlalu begadang atau kelelahan.',
                'trace' => $trace
            ];
        }
        $trace[] = "Tidak ditemukan perbedaan yang mencolok mengenai penurunan minat di asrama atau Pengajian.";

        // Penjelasan "Sering Ditarik Keluar oleh Keluarga"
        if ($totalIzin > $totalAlpa && $totalIzin > $totalSakit && $totalIzin >= 3) {
            $trace[] = "Ketidakhadiran lebih banyak disebabkan oleh Izin dibandingkan alasan sakit atau tanpa keterangan.";
            
            if ($totalBukti > 0) {
                $trace[] = "Ditemukan $totalBukti surat perizinan resmi dari wali yang tervalidasi.";
                $trace[] = "Tingginya jumlah perizinan mengindikasikan bahwa santri sering ditarik oleh keluarga/wali secara resmi.";
                return [
                    'status' => 'warning',
                    'kesimpulan' => 'Terindikasi sering izin pulang/keluar oleh keluarga (Resmi).',
                    'bukti' => "Ditemukan $totalIzin kali absen 'Izin' bulan ini didukung surat resmi.",
                    'saran' => $pic . ' perlu mengedukasi wali santri agar tidak terlalu sering menarik anak keluar karena akan mengganggu KBM, meskipun izinnya sah.',
                    'trace' => $trace
                ];
            } else {
                $trace[] = "Tidak ada surat bukti izin resmi yang dilampirkan ke sistem.";
                $trace[] = "Sistem mengindikasikan adanya perizinan sepihak atau alasan 'izin' yang digunakan sebagai kedok.";
                return [
                    'status' => 'danger',
                    'kesimpulan' => 'Terindikasi perizinan tidak resmi (Sering Izin Tanpa Surat).',
                    'bukti' => "Ditemukan $totalIzin kali absen dengan status 'Izin' tanpa dokumen bukti sama sekali.",
                    'saran' => $pic . ' perlu memanggil santri untuk melakukan tabayyun terkait keabsahan izinnya, dan memberikan peringatan disiplin jika terbukti membolos.',
                    'trace' => $trace
                ];
            }
        }
        $trace[] = "Tingkat perizinan tidak menunjukkan dominasi atas ketidakhadiran.";

        // Penjelasan "Indisipliner Kategori Berat (Pembangkangan)"
        // Logika internal CF (TETAP ADA, namun dirahasiakan dalam trace user)
        $cf1 = in_array($fakta['kategori'], ['Kurang Disiplin', 'Rendah']) ? 0.8 : 0.4;
        $cf2 = ($totalAlpa > 0) ? 0.6 : 0.2;
        $cfCombine = $cf1 + ($cf2 * (1 - $cf1));
        
        if ($cfCombine >= 0.92) {
            $persentaseKeyakinan = round($cfCombine * 100);
            $trace[] = "Sistem mendeteksi adanya intensitas ketidakhadiran tanpa keterangan (alpa) yang sangat tinggi.";
            $trace[] = "Ketidakhadiran santri bukan disebabkan oleh sakit, bukan perizinan sah, dan bukan kelelahan biasa.";
            $trace[] = "Tingkat Keyakinan Hasil Keputusan sistem: Sangat Tinggi ({$persentaseKeyakinan}%).";
            $trace[] = "Berdasarkan evaluasi seluruh data, sistem menyimpulkan adanya indikasi pelanggaran kedisiplinan yang disengaja.";
            
            return [
                'status' => 'danger',
                'kesimpulan' => 'Terindikasi pelanggaran kedisiplinan berat (sering membolos sengaja).',
                'bukti' => "Total absensi tanpa keterangan (Alpa) mencapai $totalAlpa kali di bulan ini tanpa justifikasi yang jelas.",
                'saran' => $pic . ' harus segera menjadwalkan konseling/pembinaan intensif dan memanggil orang tua/wali santri.',
                'trace' => $trace
            ];
        }

        // Penjelasan Default / Anomali ringan
        $trace[] = "Tingkat ketidakhadiran tersebar secara acak (kombinasi alpa, sakit, atau izin) tanpa satu alasan dominan tertentu.";
        $trace[] = "Berdasarkan seluruh hasil analisis, sistem menyimpulkan bahwa santri mengalami penurunan kedisiplinan ringan.";
        return [
            'status' => 'info',
            'kesimpulan' => 'Indisipliner ringan atau absensi tersebar (tidak memiliki pola dominan tertentu).',
            'bukti' => "Distribusi absen bulan ini bervariasi: Alpa ($totalAlpa), Sakit ($totalSakit), Izin ($totalIzin).",
            'saran' => $pic . ' cukup memberikan teguran lisan dan musyrif dimohon terus memantau perkembangan bulan depan.',
            'trace' => $trace
        ];
    }
}
