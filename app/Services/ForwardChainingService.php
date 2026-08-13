<?php

namespace App\Services;

use App\Models\Santri;
use App\Models\Absensi;
use App\Models\Evaluasi;

/**
 * =============================================================================
 * ForwardChainingService
 * =============================================================================
 * 
 * Service class yang mengimplementasikan metode Rule-Based System
 * dengan teknik Forward Chaining untuk mengklasifikasikan aktivitas
 * santri di Pondok Pesantren Alfurqoniyah.
 * 
 * FORWARD CHAINING PROCESS:
 * 1. Sistem dimulai dari DATA (fakta) → yaitu data absensi santri
 * 2. Data diolah menjadi PERSENTASE kehadiran (knowledge base)
 * 3. Persentase dievaluasi terhadap ATURAN (rules) secara berurutan
 * 4. Rule pertama yang cocok menghasilkan KESIMPULAN (kategori disiplin)
 * 
 * Ini berbeda dengan Backward Chaining yang dimulai dari hipotesis.
 * Forward Chaining cocok untuk sistem klasifikasi karena kita memulai
 * dari data yang sudah ada (absensi) menuju kesimpulan (kategori).
 * 
 * @author Sistem Analitik Klasifikasi Aktivitas Santri
 * @version 1.0
 */
class ForwardChainingService
{
    /**
     * =========================================================================
     * LANGKAH 1: PENGUMPULAN FAKTA (Fact Gathering)
     * =========================================================================
     * 
     * Mengambil data absensi mentah dari database dan menghitung
     * total hari efektif serta jumlah kehadiran untuk setiap
     * jenis kegiatan (Pengajian dan Sekolah).
     * 
     * @param int $santriId  ID santri yang akan dievaluasi
     * @param int $bulan     Bulan evaluasi (1-12)
     * @param int $tahun     Tahun evaluasi (e.g. 2026)
     * @return array         Data mentah: total_hadir dan total_hari per kegiatan
     */
    public function gatherFacts(int $santriId, int $bulan, int $tahun): array
    {
        // Ambil Hari Efektif dari Setting
        $hariEfektif = \App\Models\Setting::getVal('hari_efektif', 30);

        $pengajianSubjects = ['Al-Quran', 'Fiqih', 'Tafsir', 'Hadits', 'Akhlak', 'Bahasa Arab', 'Pengajian'];
        $sekolahSubjects = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS', 'PKn', 'Sekolah'];

        // Ambil absensi Pengajian
        $absensiPengajian = Absensi::where('santri_id', $santriId)
            ->whereMonth('tanggal', (int)$bulan)
            ->whereYear('tanggal', (int)$tahun)
            ->whereIn('jenis_kegiatan', $pengajianSubjects)
            ->get();

        if ($absensiPengajian->isEmpty()) {
            $absensiPengajian = Absensi::where('santri_id', $santriId)
                ->whereMonth('tanggal', (int)$bulan)
                ->whereYear('tanggal', (int)$tahun)
                ->get();
        }

        $totalHariPengajian = $absensiPengajian->count();
        $totalHadirPengajian = $absensiPengajian->where('status', 'Hadir')->count();

        // Ambil absensi Sekolah
        $absensiSekolah = Absensi::where('santri_id', $santriId)
            ->whereMonth('tanggal', (int)$bulan)
            ->whereYear('tanggal', (int)$tahun)
            ->whereIn('jenis_kegiatan', $sekolahSubjects)
            ->get();

        $totalHariSekolah = $absensiSekolah->count();
        $totalHadirSekolah = $absensiSekolah->where('status', 'Hadir')->count();

        $isComplete = ($totalHariPengajian > 0 || $totalHariSekolah > 0);

        return [
            'total_hadir_pengajian' => $totalHadirPengajian,
            'total_hari_pengajian'  => $hariEfektif > 0 ? $hariEfektif : max($totalHariPengajian, 1),
            'total_hadir_sekolah'   => $totalHadirSekolah,
            'total_hari_sekolah'    => $hariEfektif > 0 ? $hariEfektif : max($totalHariSekolah, 1),
            'real_record_pengajian' => $totalHariPengajian,
            'real_record_sekolah'   => $totalHariSekolah,
            'is_complete'           => $isComplete
        ];
    }

    /**
     * =========================================================================
     * LANGKAH 2: PERHITUNGAN PERSENTASE (Knowledge Processing)
     * =========================================================================
     * 
     * Mengonversi data mentah (fakta) menjadi persentase kehadiran
     * menggunakan rumus:
     * 
     *   Persentase = (Jumlah Hadir / Total Hari Efektif) × 100
     * 
     * Persentase ini menjadi FAKTA TURUNAN (derived fact) yang akan
     * digunakan oleh rule engine di langkah 3.
     * 
     * @param array $facts  Data mentah dari langkah 1 (gatherFacts)
     * @return array        Persentase kehadiran Pengajian dan Sekolah
     */
    public function calculatePercentage(array $facts): array
    {
        // ---------------------------------------------------------------
        // Rumus Persentase Pengajian:
        // Jika total hari efektif > 0, hitung persentase
        // Jika total hari = 0 (belum ada data), persentase = 0
        // ---------------------------------------------------------------
        $persentasePengajian = $facts['total_hari_pengajian'] > 0
            ? round(($facts['total_hadir_pengajian'] / $facts['total_hari_pengajian']) * 100, 2)
            : 0;

        // ---------------------------------------------------------------
        // Rumus Persentase Sekolah:
        // Menggunakan rumus yang sama: (Hadir / Total) × 100
        // ---------------------------------------------------------------
        $persentaseSekolah = $facts['total_hari_sekolah'] > 0
            ? round(($facts['total_hadir_sekolah'] / $facts['total_hari_sekolah']) * 100, 2)
            : 0;

        return [
            'persentase_pengajian' => $persentasePengajian,
            'persentase_sekolah'   => $persentaseSekolah,
        ];
    }

    /**
     * =========================================================================
     * LANGKAH 3: INFERENSI — FORWARD CHAINING RULE EVALUATION
     * =========================================================================
     * 
     * @method calculateInference
     * Ini adalah INTI dari metode Rule-Based System.
     * Fungsi ini bertugas sebagai INFERENCE ENGINE (Mesin Inferensi).
     * 
     * Logika Kerja (Forward Chaining):
     * Sistem memulai dari Kumpulan Fakta (Fact Base) yang sudah dihitung menjadi
     * persentase. Kemudian, sistem akan mencocokkan fakta tersebut dengan
     * Basis Pengetahuan (Knowledge Base / Aturan) di database secara maju (forward).
     * Jika IF (Kondisi) terpenuhi, maka sistem akan mengambil THEN (Kesimpulan).
     * 
     * @param float $persentasePengajian  Fakta: Persentase kehadiran Pengajian
     * @param float $persentaseSekolah    Fakta: Persentase kehadiran Sekolah
     * @return array  Kesimpulan (Kategori disiplin) dan Rule yang terpicu
     */
    public function calculateInference(float $persentasePengajian, float $persentaseSekolah, string $jenis = 'all'): array
    {
        // 1. Ambil Parameter Aturan (Knowledge Base) dari Database (Tabel Settings)
        $tDisiplin = \App\Models\Setting::getVal('fc_tinggi', 90);
        $tCukup    = \App\Models\Setting::getVal('fc_sedang', 75);

        // Isolasi per jenis jika spesifik
        if ($jenis === 'pengajian') {
            $p = $persentasePengajian;
            if ($p >= $tDisiplin) {
                return ['kategori' => 'Tinggi', 'triggered_rule' => 'Kehadiran Pengajian (' . $p . '%) sangat baik dan memenuhi standar (≥' . $tDisiplin . '%)'];
            } elseif ($p < $tCukup) {
                return ['kategori' => 'Rendah', 'triggered_rule' => 'Kehadiran Pengajian (' . $p . '%) di bawah standar pesantren (<' . $tCukup . '%)'];
            } else {
                return ['kategori' => 'Sedang', 'triggered_rule' => 'Kehadiran Pengajian berada pada tingkat rata-rata (' . $tCukup . '% - ' . ($tDisiplin - 1) . '%)'];
            }
        } elseif ($jenis === 'sekolah') {
            $p = $persentaseSekolah;
            if ($p >= $tDisiplin) {
                return ['kategori' => 'Tinggi', 'triggered_rule' => 'Kehadiran Sekolah (' . $p . '%) sangat baik dan memenuhi standar (≥' . $tDisiplin . '%)'];
            } elseif ($p < $tCukup) {
                return ['kategori' => 'Rendah', 'triggered_rule' => 'Kehadiran Sekolah (' . $p . '%) di bawah standar pesantren (<' . $tCukup . '%)'];
            } else {
                return ['kategori' => 'Sedang', 'triggered_rule' => 'Kehadiran Sekolah berada pada tingkat rata-rata (' . $tCukup . '% - ' . ($tDisiplin - 1) . '%)'];
            }
        }

        // RULE 1: DISIPLIN (Persentase >= 90%)
        if ($persentasePengajian >= $tDisiplin && $persentaseSekolah >= $tDisiplin) {
            return [
                'kategori' => 'Tinggi',
                'triggered_rule' => 'Kehadiran secara keseluruhan (' . $persentasePengajian . '% & ' . $persentaseSekolah . '%) sangat baik (≥' . $tDisiplin . '%)',
            ];
        }

        // RULE 3: KURANG DISIPLIN (Persentase < 75%)
        if ($persentasePengajian < $tCukup && $persentaseSekolah < $tCukup) {
            return [
                'kategori' => 'Rendah',
                'triggered_rule' => 'Kehadiran secara keseluruhan (' . $persentasePengajian . '% & ' . $persentaseSekolah . '%) di bawah standar (<' . $tCukup . '%)',
            ];
        }

        // RULE 2: CUKUP DISIPLIN (75% <= Persentase < 90%)
        return [
            'kategori' => 'Sedang',
            'triggered_rule' => 'Kehadiran secara keseluruhan berada pada tingkat rata-rata',
        ];
    }

    /**
     * =========================================================================
     * PROSES UTAMA: Menjalankan Forward Chaining untuk Satu Santri
     * =========================================================================
     * 
     * Menggabungkan ketiga langkah di atas menjadi satu proses utuh:
     * 1. Gather Facts     → mengambil data absensi mentah
     * 2. Calculate         → menghitung persentase kehadiran
     * 3. Evaluate Rules   → menjalankan rule IF-THEN (Forward Chaining)
     * 4. Save Result      → menyimpan hasil ke tabel evaluasis
     * 
     * @param int $santriId  ID santri yang akan dievaluasi
     * @param int $bulan     Bulan evaluasi (1-12)
     * @param int $tahun     Tahun evaluasi
     * @return Evaluasi      Record evaluasi yang disimpan
     */
    public function prosesEvaluasi(int $santriId, int $bulan, int $tahun, string $jenis = 'pengajian'): ?Evaluasi
    {
        // LANGKAH 1: Kumpulkan fakta dari data absensi
        $facts = $this->gatherFacts($santriId, $bulan, $tahun);

        // Ambil data evaluasi yang sudah ada (jika ada)
        $existing = Evaluasi::where('santri_id', $santriId)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        // Validasi: Jika data belum lengkap di departemen terkait
        if ($jenis === 'pengajian' && $facts['real_record_pengajian'] <= 0) {
            // Bersihkan data lama jika ada
            if ($existing) {
                $existing->update(['total_hadir_pengajian' => 0, 'total_hari_pengajian' => 0, 'persentase_pengajian' => 0]);
                if ($existing->persentase_pengajian == 0 && $existing->persentase_sekolah == 0) $existing->delete();
            }
            throw new \Exception("Data absensi pengajian belum ada.");
        }
        if ($jenis === 'sekolah' && $facts['real_record_sekolah'] <= 0) {
            // Bersihkan data lama jika ada
            if ($existing) {
                $existing->update(['total_hadir_sekolah' => 0, 'total_hari_sekolah' => 0, 'persentase_sekolah' => 0]);
                if ($existing->persentase_pengajian == 0 && $existing->persentase_sekolah == 0) $existing->delete();
            }
            throw new \Exception("Data absensi sekolah belum ada.");
        }

        // LANGKAH 2: Hitung persentase kehadiran dari fakta yang baru ditarik
        $percentages = $this->calculatePercentage($facts);

        // Gabungkan persentase baru dengan yang lama
        $pPengajian = ($jenis === 'sekolah' && $existing) ? $existing->persentase_pengajian : $percentages['persentase_pengajian'];
        $pSekolah   = ($jenis === 'pengajian' && $existing) ? $existing->persentase_sekolah : $percentages['persentase_sekolah'];

        // LANGKAH 3: Evaluasi rules Forward Chaining menggunakan Inference Engine
        $ruleResult = $this->calculateInference($pPengajian, $pSekolah, $jenis);

        // LANGKAH 4: Persiapkan data yang akan di-update (Hanya update milik masing-masing departemen)
        $updateData = [
            'kategori_disiplin' => $ruleResult['kategori'],
            'triggered_rule'    => $ruleResult['triggered_rule'],
        ];

        if ($jenis === 'pengajian' || $jenis === 'all') {
            $updateData['total_hadir_pengajian'] = $facts['total_hadir_pengajian'];
            $updateData['total_hari_pengajian']  = $facts['total_hari_pengajian'];
            $updateData['persentase_pengajian']  = $percentages['persentase_pengajian'];
        }

        if ($jenis === 'sekolah' || $jenis === 'all') {
            $updateData['total_hadir_sekolah']   = $facts['total_hadir_sekolah'];
            $updateData['total_hari_sekolah']    = $facts['total_hari_sekolah'];
            $updateData['persentase_sekolah']    = $percentages['persentase_sekolah'];
        }

        // Simpan hasil evaluasi ke database
        $evaluasi = Evaluasi::updateOrCreate(
            [
                'santri_id' => $santriId,
                'bulan'     => $bulan,
                'tahun'     => $tahun,
            ],
            $updateData
        );

        return $evaluasi;
    }

    /**
     * =========================================================================
     * PROSES BATCH: Menjalankan Forward Chaining untuk SEMUA Santri Aktif
     * =========================================================================
     * 
     * Dipanggil ketika user menekan tombol "Proses Evaluasi".
     * Melakukan loop terhadap semua santri aktif dan menjalankan
     * Forward Chaining satu per satu.
     * 
     * @param int $bulan  Bulan evaluasi
     * @param int $tahun  Tahun evaluasi
     * @return array      Jumlah santri yang berhasil diproses dan yang gagal/belum lengkap
     */
    public function prosesBatch(int $bulan, int $tahun, string $jenis = 'pengajian', ?string $kelas = null, ?string $kamar = null): array
    {
        // Ambil semua santri yang berstatus aktif
        $query = Santri::where('status', 'aktif');
        
        // Filter by kelas or kamar if provided
        if ($kelas) {
            $kelasTrim = trim($kelas);
            $query->where(function ($q) use ($kelasTrim) {
                $q->where('kelas', $kelasTrim)
                  ->orWhere(\Illuminate\Support\Facades\DB::raw('TRIM(kelas)'), $kelasTrim);
            });
        }
        
        if ($kamar) {
            $kamarTrim = trim($kamar);
            $query->where(function ($q) use ($kamarTrim) {
                $q->where('ruang_pengajian', $kamarTrim)
                  ->orWhere('kamar', $kamarTrim)
                  ->orWhere(\Illuminate\Support\Facades\DB::raw('TRIM(ruang_pengajian)'), $kamarTrim);
            });
        }
        
        $santris = $query->get();

        $countSuccess = 0;
        $countIncomplete = 0;

        // Proses evaluasi untuk setiap santri secara berurutan
        foreach ($santris as $santri) {
            try {
                $this->prosesEvaluasi($santri->id, $bulan, $tahun, $jenis);
                $countSuccess++;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("ProsesEvaluasi Error (Santri ID {$santri->id}): " . $e->getMessage());
                $countIncomplete++;
            }
        }

        // Mengembalikan statistik proses
        return [
            'success' => $countSuccess,
            'incomplete' => $countIncomplete
        ];
    }
}
