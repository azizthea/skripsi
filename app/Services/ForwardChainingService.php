<?php

namespace App\Services;

use App\Models\Santri;
use App\Models\Absensi;
use App\Models\Evaluasi;

// ForwardChainingService
class ForwardChainingService
{
    // Gather facts (data absensi mentah)
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

    // Calculate percentage
    public function calculatePercentage(array $facts): array
    {
        $persentasePengajian = $facts['total_hari_pengajian'] > 0
            ? round(($facts['total_hadir_pengajian'] / $facts['total_hari_pengajian']) * 100, 2)
            : 0;

        $persentaseSekolah = $facts['total_hari_sekolah'] > 0
            ? round(($facts['total_hadir_sekolah'] / $facts['total_hari_sekolah']) * 100, 2)
            : 0;

        return [
            'persentase_pengajian' => $persentasePengajian,
            'persentase_sekolah'   => $persentaseSekolah,
        ];
    }

    // Inference Engine: Forward Chaining Rules
    public function calculateInference(float $persentasePengajian, float $persentaseSekolah, string $jenis = 'all'): array
    {
        // 1. Ambil Parameter Aturan dari Database
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

        // RULE 2: CUKUP DISIPLIN
        return [
            'kategori' => 'Sedang',
            'triggered_rule' => 'Kehadiran secara keseluruhan berada pada tingkat rata-rata',
        ];
    }

    // Menjalankan Forward Chaining untuk Satu Santri
    public function prosesEvaluasi(int $santriId, int $bulan, int $tahun, string $jenis = 'pengajian'): ?Evaluasi
    {
        $facts = $this->gatherFacts($santriId, $bulan, $tahun);

        $existing = Evaluasi::where('santri_id', $santriId)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        if ($jenis === 'pengajian' && $facts['real_record_pengajian'] <= 0) {
            if ($existing) {
                $existing->update(['total_hadir_pengajian' => 0, 'total_hari_pengajian' => 0, 'persentase_pengajian' => 0]);
                if ($existing->persentase_pengajian == 0 && $existing->persentase_sekolah == 0) $existing->delete();
            }
            throw new \Exception("Data absensi pengajian belum ada.");
        }
        if ($jenis === 'sekolah' && $facts['real_record_sekolah'] <= 0) {
            if ($existing) {
                $existing->update(['total_hadir_sekolah' => 0, 'total_hari_sekolah' => 0, 'persentase_sekolah' => 0]);
                if ($existing->persentase_pengajian == 0 && $existing->persentase_sekolah == 0) $existing->delete();
            }
            throw new \Exception("Data absensi sekolah belum ada.");
        }

        $percentages = $this->calculatePercentage($facts);

        $pPengajian = ($jenis === 'sekolah' && $existing) ? $existing->persentase_pengajian : $percentages['persentase_pengajian'];
        $pSekolah   = ($jenis === 'pengajian' && $existing) ? $existing->persentase_sekolah : $percentages['persentase_sekolah'];

        $ruleResult = $this->calculateInference($pPengajian, $pSekolah, $jenis);

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

    // Menjalankan Forward Chaining Batch
    public function prosesBatch(int $bulan, int $tahun, string $jenis = 'pengajian', ?string $kelas = null, ?string $kamar = null): array
    {
        $query = Santri::where('status', 'aktif');
        
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

        foreach ($santris as $santri) {
            try {
                $this->prosesEvaluasi($santri->id, $bulan, $tahun, $jenis);
                $countSuccess++;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("ProsesEvaluasi Error (Santri ID {$santri->id}): " . $e->getMessage());
                $countIncomplete++;
            }
        }

        return [
            'success' => $countSuccess,
            'incomplete' => $countIncomplete
        ];
    }
}
